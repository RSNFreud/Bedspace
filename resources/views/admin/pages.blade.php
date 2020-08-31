@extends('admin.master')

@section('content')
<div class="alignCenter">
    <div class="productGrid">
        <a href="{{url('admin/pages/add-page')}}">
            <div class="button newProduct"><i class="fa fa-plus"></i> Add Page</div>
        </a>
        <div class="box">
            <div class="searchBarTop">
                <input type="text" class="searchBar" placeholder="Search for a page"
                    oninput="filterItem(this.value, {{json_encode($pages)}}, 'pages')" />
                <i class="fa fa-search"></i>
            </div>
            <div class="productsList">
                @if ($pages->count() == 0) There are no pages to display! @endif
                @foreach ($pages as $page)
                <div class="pageItemGrid">
                    <span class="description">
                        <strong>{{$page["navName"]}}</strong>
                        <a href=" {{url($page["navURL"])}}"> {{url($page["navURL"])}}</a>
                        <p></p>
                        {{$page["navContent"]}}
                    </span>
                    <div class="productButtons">
                        <a class="button" href="{{url('/admin/pages/' . $page["navURL"] . '/edit')}}">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <span class="button" onclick="removePage('{{$page['navURL']}}')"> <i class="fa fa-times"></i>
                            Delete</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

<script>
    function removePage(category) {
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
        let pageID = $('#remove').attr('data-id');
        $.ajax({
            method: "DELETE",
            url: `${baseURL}/admin/pages/${pageID}`,
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
