<?php

namespace App\Http\Controllers;

class homeController extends controller
{

    
    public function home(){

        $categories=\App\Models\Category::take(5)
                    ->select("categories.id","categories.name",
                    "categories.parent_id",
                    "categories.image",
                    \DB::raw("count(b.id) as sub_cat_count"))
                    ->leftJoin(\DB::raw("categories b"),"categories.id","=","b.parent_id")
                    ->whereNull("categories.parent_id")
                    ->groupBy("categories.id")
                    ->get();
        // dd($categories);
        return view('welcome')
                ->with(["categories"=>$categories]);
    }
    public function subCategory($name,$id){
        $categories=\App\Models\Category::take(5)
        ->select("categories.id","categories.name",
        "categories.parent_id",
        "categories.image",
        \DB::raw("count(b.id) as sub_cat_count"))
        ->leftJoin(\DB::raw("categories b"),"categories.id","=","b.parent_id")
        ->where("categories.parent_id","=",$id)
        ->groupBy("categories.id")
        ->get();
// dd($categories);
return view('welcome')
    ->with(["categories"=>$categories,
            "name"=>$name,
            "id"=>$id]);
    }

    public function shopSubCategory($name,$id,\Request $request){
        $products=\App\Models\Product::with(["attributes",
        "categories","tax","images",
        "specificPrice"]);
        if(!empty($request->keywrod))
        {
            $products->where("name","LIKE","%".$request->name."%");
        }
        if(!empty($id))
        {
            $products->where("id","=",$id);
        }
        $products=$products->paginate(2);
        
        return view("shop")->with(["products"=>$products]);
    }
    public function shop(\Request $request){
        $products=\App\Models\Product::with(["attributes",
        "categories","tax","images",
        "specificPrice"]);
        if(!empty($request->keywrod))
        {
            $products->where("name","LIKE","%".$request->name."%");
        }
     
        $products=$products->paginate(2);
    
        return view("shop")->with(["products"=>$products]);
    }
   
}
