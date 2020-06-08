@extends('layouts.master')
@section('title')
    Shoping Cart
@endsection
@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Shopping Cart</h2>
                        <div class="breadcrumb__option">
                            <a href="/">Home</a>
                            <span>Shopping Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th class="shoping__product">Products</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td class="shoping__cart__item">
                                        <img src="/uploads/products/{{$product->image}}" alt="">
                                        <h5>{{$product->name}}</h5>
                                    </td>
                                    <td class="shoping__cart__price">
                                    <span class="symbol">$</span>
                                    <span class="price {{$product->__raw_id}}-price">{{$product->price}}</span>
                                    </td>
                                    <td class="shoping__cart__quantity">
                                        <div class="quantity">
                                            <div class="pro-qty">
                                                <input type="text" 
                                                name="{{$product->__raw_id}}"
                                                id="{{$product->__raw_id}}" value="{{$product->qty}}">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="shoping__cart__total">
                                        <span class="symbol">$</span>
                                        <span class="price {{$product->__raw_id}}-total">
                                            {{$product->qty*$product->price}}
                                        </span>
                                    </td>
                                    <td class="shoping__cart__item__close">
                                    <form method="POST" action="/remove-from-cart/{{$product->__raw_id}}">
                                        {{csrf_field()}}    
                                     <button class="btn btn-warning">  
                                          <span style="color:white;" class="icon_close"></span>
                                     </button>
                                    </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="/shop" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                      
                        <button class="primary-btn cart-btn update-cart cart-btn-right">
                            <span class="icon_loading" style="display:none;"></span>
                            Upadate Cart</button>
                        
                    </div>
                </div>
                <div class="col-lg-6">
                    {{-- <div class="shoping__continue">
                        <div class="shoping__discount">
                            <h5>Discount Codes</h5>
                            <form action="#">
                                <input type="text" placeholder="Enter your coupon code">
                                <button type="submit" class="site-btn">APPLY COUPON</button>
                            </form>
                        </div>
                    </div> --}}
                </div>
                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <h5>Cart Total</h5>
                        <ul>
                            <li>Subtotal 
                                <span class="sub-total"> 
                                    <span class="symbol">$</span>
                                <span class="price">
                                    {{\ShoppingCart::totalPrice()}}
                                </span>
                            </span>
                            </li>
                            <li>Total <span class="grand-total total"> <span class="symbol">$</span>
                                <span class="price">
                                    {{\ShoppingCart::totalPrice()}}
                                </span>
                            </span></li>
                        </ul>
                        <a href="/checkout" class="primary-btn">PROCEED TO CHECKOUT</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shoping Cart Section End -->
<script>
    $(document).ready(function(){
        $("body .update-cart").on("click",function(e){  
            var data=[];
        $(".shoping__cart__table :input[type=text]").each(function(key,item){

    data.push({value:item.value,id:item.name});
        });
            $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
                    });

                    $(".update-cart .icon_loading").fadeIn();
            $.ajax({
                url:"/update-cart",
                data:{array:JSON.stringify(data)},
                method:"POST",
                success:function(response){
                    //    location.reload();
                    $(".update-cart .icon_loading").fadeOut();

                },
                error:function(error){
                   alert("error updating cart");
                }
            })
        });
      
      
        
    })
    function updateTotal(quantity){
            var total;
            var grandTotal=0;
            
            $(".shoping__cart__table :input[type=text]").each(function(key,item){
              total=parseFloat($("."+item.name+"-price").text())*item.value;
              $("."+item.name+"-total").html(total);
                grandTotal+=total;
            })
       $(".sub-total .price").html(parseFloat(grandTotal).toFixed(2));
       $(".grand-total .price").html(parseFloat(grandTotal).toFixed(2));
    //    var total=$(".shoping__cart__total .price").text();
    //    console.log(price);
        }
</script>
@endsection