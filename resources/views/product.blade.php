@extends('master')


@section('main-content')
<div class="bg-gray">
    <div class="mainContent" style="height: 100%">
        <div class="productGrid">
            <div class="productBox">
                <div class="productImages">
                    <div class="mainImage">
                        @if (isset($inCart))
                        <span class="inCart">IN CART</span>
                        @endif
                        <a href="{{url('images/' . $product[0]->displayImage)}}"
                            data-lightbox="{{$products[0]->productName}}">
                            <img src="{{asset('images/'.$product[0]->displayImage)}}">
                        </a>
                    </div>
                    <div class="subImages">
                        @foreach($product as $item)
                        @if ($item->fileName != null)
                        <a href="{{url('images/' . $item->fileName)}}" data-lightbox="{{$products[0]->productName}}">
                            <img src="{{asset('images/'.$item->fileName)}}"
                                data-lightbox="{{$products[0]->productName}}">
                        </a>
                        @endif
                        @endforeach

                    </div>
                </div>
                <div class="productData">
                    <h1>{{$product[0]->productName}}</h1>
                    <div id="price">Price: <span style="color: rgb(139, 20, 20);">£{{$product[0]->price}}</span></div>
                    {{$product[0]->description}}

                    <h3 style="margin-top: 30px;">More like this</h3>

                    <div class="productList" id="additionalProducts">
                        @php
                        $count = 0
                        @endphp
                        @foreach ($products as $additionalProduct)
                        @if ($additionalProduct->id != $product[0]->id && $count !=2)
                        @php
                        $count++
                        @endphp
                        <div class="productItem">
                            <div class="imageWrapper">
                                @foreach (Session::get("cart") as $item)
                                @if ($item->id == $additionalProduct->id)
                                <span class="inCart">IN CART</span>
                                @endif
                                @endforeach
                                <img src="{{asset('images/'.$additionalProduct->displayImage)}}" class="productImage">
                            </div>
                            <h3>{{$additionalProduct->productName}}</h3>
                            <div class="productDescription">
                                {{$additionalProduct->description}}</div>
                            <p></p>
                            <strong>£{{$additionalProduct->price}}</strong>
                            <div class="productButtons">
                                <a href="{{url('shop/' . $additionalProduct->catURL . '/' . $additionalProduct->url)}}">More
                                    information</a>
                                <p></p>
                                <span onclick="addToCart('{{$additionalProduct->id}}')">Add to cart</span>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="productSidebar">

                <div class="sidebarContainer">
                    <label>Qty</label>
                    <br>
                    @if (isset($inCart))
                    <input type="number" name="quantity" id="quantity" min="1" value="{{$inCart->quantity}}">
                    @else
                    <input type="number" name="quantity" id="quantity" min="1" value="1">
                    @endif

                    <br>
                    <label>Price</label>
                    <br>
                    <span style="font-size: 1.1em"> £{{$product[0]->price}}
                    </span>
                    <div class="priceButtons">
                        @if (isset($inCart))
                        <input type="button" value="Update cart"
                            onclick="addToCart({{$product[0]->id}}, document.querySelector('#quantity').value)">
                        @else
                        <input type="button" value="Add to cart"
                            onclick="addToCart({{$product[0]->id}}, document.querySelector('#quantity').value)">
                        @endif
                        <input type="button" value="Buy now"
                            onclick="addToCart({{$product[0]->id}}, document.querySelector('#quantity').value, true)">
                    </div>
                </div>
                <div class="sidebarContainer">
                    <strong>Dimensions:</strong>
                    <br>
                    {{$product[0]->dimensions}}
                    <p></p>

                    <strong>Weight:</strong>
                    <br>
                    {{$product[0]->weight}}
                    <p></p>
                    <strong>Delivery Time:</strong>
                    <br>
                    {{$product[0]->deliveryTime}}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
