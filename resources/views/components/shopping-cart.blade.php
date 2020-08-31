<div class="modalDropdown" id="shoppingModal" onclick="event.stopPropagation()">
    <div class="modalTitle">
        <span>Shopping Cart ({{Session::get("cart")->count()}})</span><i class="fa fa-times"
            onclick="(closeCart())"></i>
    </div>
    <div class="modalText">
        @if (Session::get("cart")->count() > 0) @foreach (Session::get("cart") as $item)
        <div class="cartGrid">
            <img src="{{asset('images/'.$item->displayImage)}}" alt="" />
            <div class="cartData">
                <div class="cartTop">
                    <span>{{$item->productName}}</span>
                    <i class="fa fa-trash" onclick="deleteItem('{{$item->id}}')"
                        {{ Popper::arrow()->pop('Delete item') }}></i>
                </div>
                £{{$item->price}}
                <p></p>
                <strong>Qty:</strong> {{$item->quantity ?? '1'}}
            </div>
        </div>
        @endforeach
        <div class="buttonRow">
            <input type="button" value="View Cart" onclick="window.location.href = '{{url('cart')}}'" />
            @if (!Session::has("user_id"))
            <input type="button" value="Checkout" disabled
                {{ Popper::arrow()->pop('Please sigin or register before you can submit your order!') }} />
            @else
            <input type="button" value="Checkout" onclick="window.location.href = '{{url('shop/checkout')}}'" />

            @endif
        </div>

        @else There are no items in your cart! @endif
    </div>
</div>
