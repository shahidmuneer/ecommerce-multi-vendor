<?php

namespace App\Http\Controllers\customer;
use Illuminate\Database\Eloquent\Builder;
class dashboardController extends \App\Http\Controllers\Controller
{

    
    public function customerDashboard(){
        $orders=\App\Models\Order::with([
                        "user",
                        "status",
                        "statusHistory",
                        "carrier",
                        "shippingAddress",
                        "billingAddress",
                        "billingCompanyInfo",
                        "currency",
                        "products",
                        "products.images",
                        ])
            ->whereHas("status",function(Builder $query){
                $query->where("name","!=","Done")
                        ->orWhere("name","!=","Cancelled");
        })
                        ->paginate(10);
// dd($orders);
        return view("customer.dashboard")
                    ->with(["orders"=>$orders]);
    }
    public function pastOrders(){
        $orders=\App\Models\Order::with([
            "user",
            "status",
            "statusHistory",
            "carrier",
            "shippingAddress",
            "billingAddress",
            "billingCompanyInfo",
            "currency",
            "products",
            "products.images",
            ])
            ->whereHas("status",function(Builder $query){
                    $query->where("name","=","Done");
            })->paginate(10);
            return view("customer.dashboard")
                    ->with(["orders"=>$orders]);
    }
    public function logout(){
        \Auth::logout();
        return redirect('/login');
    }
}
