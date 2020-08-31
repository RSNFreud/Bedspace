@extends('master')


@section('main-content')
<div class="bg-gray">
    @if (!Session::has("user_id"))
    <div class="signInBanner">Please <a><span style="cursor: pointer" onclick="openLogin(event)">signin</span></a> or <a
            href="register?redirect=cart">register</a>
        before you can submit your
        order!</div>
    @endif
    <div class="checkoutMainContent">
        <div class="checkoutGrid">
            <div class="checkoutBox">
                <h2>My Basket</h2>
                <p></p>
                @if ($cart->count() > 0)
                <div class="checkoutProductsGrid">
                    @foreach ($cart as $item)
                    <div class="checkoutProductGrid">
                        <img src="{{asset('images/'.$item->displayImage)}}" alt="">
                        <div class="checkoutData">
                            <span><a href="{{url($item->category)}}"></a><strong>{{$item->productName}}</strong></span>
                            <span style="justify-self: flex-end"><strong>
                                    £{{number_format($item->price * $item->quantity, 2)}}</strong></span>
                            <div style="margin-top: 10px" class="checkoutBottom">
                                <div class="checkoutDescription">
                                    {{$item->description}}
                                </div>
                                <p style="margin-top: 10px"></p>
                                <div class="checkoutQty">
                                    <span>
                                        <strong>Quantity:</strong>
                                        <input type="number" oninput="addToCart({{$item->id}}, this.value)"
                                            value="{{$item->quantity}}">
                                    </span>
                                    <i class="fa fa-trash" onclick="deleteItem({{$item->id}})"
                                        {{Popper::pop('Delete item')}}></i></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                There are no items in your cart!
                @endif
            </div>
            <div class="checkoutSidebar">
                <div class="checkoutBox">
                    <strong>Coupon Code?</strong>
                    <div class="couponGrid">
                        <input type="text" name="coupon" id="coupon">
                        <input type="button" value="Go">
                    </div>
                </div>
                <div class="checkoutBox" id="subTotal">
                    <strong>Subtotal:</strong> £{{number_format($totalPrice,2)}}
                    <p></p>
                    <strong>VAT:</strong> £{{number_format ( $totalPrice * 0.20, 2 )}}
                    <p></p>
                    <strong>Delivery:</strong> £{{number_format($deliveryCharge,2)}}
                    <p></p>
                    <strong>Total:</strong> £{{number_format($totalPrice + $deliveryCharge + $totalPrice * 0.20, 2)}}
                    <p></p>

                    <input type="button" value="Checkout" onclick="window.location.href = '{{url('shop/checkout')}}'"
                        {{!Session::has("user_id")?'disabled':''}} {{$cart->count() == 0 ? 'disabled' : ''}}>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
