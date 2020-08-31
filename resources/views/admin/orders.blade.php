@extends('admin.master')

@section('content')
<div class="alignCenter">
    <div class="orderGrid">
        <h2>Orders</h2>
        @if (count($orders) == 0) There are no orders to display! @endif
        @foreach ($orders as $order)
        <div class="orderList">
            <div class="orderTop">
                <span>
                    <strong>{{$order["userDetails"]["fullName"]}}</strong>
                    <p></p>
                    {{$order["userDetails"]["address"]}}
                </span>
                <span>
                    <strong>
                        Total:
                    </strong>
                    £{{$order["price"]}}
                    <p></p>
                    {{$order["date"]}}
                </span>
            </div>
            <div class="productsOrdered">
                @foreach($order["orderData"] as $data)
                <div class="orderItem">
                    <div class="flex">
                        <strong>
                            {{$data['productName']}} ({{$data['quantity']}})
                        </strong>
                        £{{$data['price']}}
                    </div>
                    <div id="description">
                        {{$data['description']}}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
