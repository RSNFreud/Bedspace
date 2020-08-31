@extends('admin.master')

@section('content')
<div class="alignCenter">
    <div class="productGrid">
        <a href="{{url('admin/products/add-product')}}">
            <div class="button newProduct"><i class="fa fa-plus"></i> Add Product</div>
        </a>
        <div class="box">
            <div class="searchBarTop">
                <input type="text" class="searchBar" placeholder="Search for a product"
                    oninput="filterItem(this.value, {{json_encode($products)}})" />
                <i class="fa fa-search"></i>
            </div>
            <div class="productsList">
                @if ($products->count() == 0) There are no products to display! @endif
                @foreach ($products as $product)
                <div class="productItemGrid">
                    <img src="{{asset('images/'. $product["displayImage"])}}" alt="">
                    <div class="productData">
                        <span class="description">
                            <strong>{{$product["productName"]}}</strong>
                            <p></p>
                            {{$product["description"]}}
                        </span>
                        <div class="productButtons">
                            <a class="button" href="{{url('/admin/products/' . $product["url"] . '/edit')}}">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <span class="button" onclick="removeProduct('{{$product['url']}}')"> <i
                                    class="fa fa-times"></i> Delete</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

<script>
    function removeProduct(product) {
        let modal = $('.confirmBackground');
        $('confirmText').html('Are you sure you want to delete ' + product +
            '? This is permanent and CANNOT be undone!');
        $('#remove').attr('data-id', product);
        modal.css("display", "flex");
        setTimeout(() => {
            modal.css("opacity", "1");
        }, 200);
    }

    $('#remove').click(function (e) {
        e.preventDefault();
        let modal = $('.confirmBackground');
        let productID = $('#remove').attr('data-id');
        console.log('Product:' + productID);
        $.ajax({
            method: "DELETE",
            url: `${baseURL}/admin/products/${productID}`,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                )
            },
            success: function (res) {
                window.location.reload();
            }
        })
    });
    $('#cancel').click(function () {
        let modal = $('.confirmBackground');
        modal.css("opacity", "0");
        setTimeout(() => {
            modal.css("display", "none");
        }, 500);
    });

</script>

@endsection
