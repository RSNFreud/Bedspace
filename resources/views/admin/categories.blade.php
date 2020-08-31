@extends('admin.master')

@section('content')
<div class="alignCenter">
    <div class="productGrid">
        <a href="{{url('admin/categories/add-category')}}">
            <div class="button newProduct"><i class="fa fa-plus"></i> Add Category</div>
        </a>
        <div class="box">
            <div class="searchBarTop">
                <input type="text" class="searchBar" placeholder="Search for a product"
                    oninput="filterItem(this.value, {{json_encode($categories)}}, 'categories')" />
                <i class="fa fa-search"></i>
            </div>
            <div class="productsList">
                @if ($categories->count() == 0) There are no categories to display! @endif
                @foreach ($categories as $category)
                <div class="productItemGrid">
                    <img src="{{asset('images/'. $category["catImage"])}}" alt="">
                    <div class="productData">
                        <span class="description">
                            <strong>{{$category["catName"]}}</strong>
                            <p></p>
                            {{$category["catDescription"]}}
                        </span>
                        <div class="productButtons">
                            <a class="button" href="{{url('/admin/categories/' . $category["catURL"] . '/edit')}}">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <span class="button" onclick="removeCategory('{{$category['catURL']}}')"> <i
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
    function removeCategory(category) {
        let modal = $('.confirmBackground');
        $('confirmText').html('Are you sure you want to delete ' + category +
            '? This is permanent and CANNOT be undone!');
        $('#remove').attr('data-id', category);
        modal.css("display", "flex");
        setTimeout(() => {
            modal.css("opacity", "1");
        }, 200);
    }

    $('#remove').click(function (e) {
        e.preventDefault();
        let modal = $('.confirmBackground');
        let categoryID = $('#remove').attr('data-id');
        console.log('Product:' + categoryID);
        $.ajax({
            method: "DELETE",
            url: `${baseURL}/admin/categories/${categoryID}`,
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
