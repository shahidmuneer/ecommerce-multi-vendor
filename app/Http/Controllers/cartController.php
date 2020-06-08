<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use \App\Http\Requests\OrderRequestPublic;
class cartController extends controller
{

        public function addToCart($id,\Request $requst){
            
            $product=\App\Models\Product::find($id);
            // dd($product);
            \ShoppingCart::add($product->id,$product->name,1,$product->price);
            return redirect()->back();
            // dd(\ShoppingCart::all());
        }
        public function cart(){
            $products=\ShoppingCart::all();
             return view("pages.shopingcart")
                    ->with(["products"=>$products]);
        }
        public function removeFromCart($id){
            // $cart=\ShoppingCart::search(["id"=>$id]);
            // $item=$cart->first();
            $rawId=$id;
            \ShoppingCart::remove($rawId);
            return redirect()->back();
        }
        public function updateCart(Request $request){
            $items=$request->array??[];
            if(!is_array($items)){
                $items=json_decode($items);
            }
            // return response()->json(["message"=>$items[0]->id,"status"=>200]); 
            foreach($items as $item){
                \ShoppingCart::update($item->id,$item->value);
            }
            return response()->json(["message"=>"cart updated","status"=>200]);
        }
        public function checkout(){
           
            $products=\ShoppingCart::all();
            
            return view("pages.checkout")
                ->with(["products"=>$products]);
        }
        public function order(OrderRequestPublic $request){
            
            $request->merge(["password"=>\Hash::make($request->password)]);            
            $user = \App\User::create(['first_name'=>$request->first_name,
                                 'email'=>$request->email, 'password'=>$request->password]);
            auth()->login($user);
           
            $address=\App\Models\Address::create([
                                        "user_id"=>$user->id,
                                        "name"=>$request->first_name." ".$request->last_name,
                                        "address1"=>$request->address1,
                                        "address2"=>$request->address2,
                                        "country"=>$request->country,
                                        "city"=>$request->city,
                                        "postal_code"=>$request->postal_code,
                                        "address1"=>$request->address1,
                                        "mobile_phone"=>$request->mobile_phone,
                                        "comments"=>$request->note,
                                        ]);

                $order=\App\Models\Order::insert([
                                    "user_id"=>$user->id,
                                    "status_id"=>1,
                                    "carrier_id"=>1,
                                    "shipping_address_id"=>$address->id,
                                    "billing_address_id"=>1,
                                    "billing_company_id"=>1,
                                    "currency_id"=>1,
                                    "comment"=>$request->note,
                                    "shipping_no"=>1,
                                    "invoice_no"=>1,
                                    "invoice_date"=>\Carbon\Carbon::now(),
                                    "delivery_date"=>\Carbon\Carbon::now()->addDays(15),
                                    "total_discount"=>$request->discount??0,
                                    "total_discount_tax"=>0,
                                    "total_shipping"=>\ShoppingCart::countRows(),
                                    "total"=>\ShoppingCart::total(),
                                    "total_tax"=>$request->total_tax??0
                ]);
                $items=\ShoppingCart::all();
                $order_id=\DB::getPdo()->lastInsertId();
                foreach($items as $item){
                                \App\Models\OrderProduct::create([
                                        "product_id"=>$item->id,
                                        "order_id"=>$order_id,
                                        "name"=>$item->name,
                                        "price"=>$item->price,
                                        "quantity"=>$item->qty
                                ]);
                }
                \ShoppingCart::destroy();
                
                return redirect()->to("/customer/dashboard")->withErrors(["success","Your order have been received"]);
                                    
        }
}
