@extends('master')


@section('main-content')

<img src="{{asset('images/promoImage.png')}}" alt="" class="bannerImage">

<div class="mainContent">
    <h1>{{$category}}</h1>
    <div class="productList">
        @foreach ($products as $product)
        <div class="productItem">
            <div class="imageWrapper">
                @foreach (Session::get("cart") as $item)
                @if ($item->id == $product->id)
                <span class="inCart">IN CART</span>
                @endif
                @endforeach
                <img src="{{asset('images/'.$product->displayImage)}}" class="productImage"></div>
            <h3>{{$product->productName}}</h3>
            <div class="productDescription">
                {{$product->description}}</div>
            <p></p>
            <strong>£{{$product->price}}</strong>
            <div class="productButtons">
                <a href="{{url('shop/' . $product->catURL . '/' .$product->url)}}">More information</a>
                <p></p>

                <span onclick="addToCart('{{$product->id}}')">Add to cart</span>


            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
