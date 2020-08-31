@extends('master')


@section('main-content')
<div class="bg-gray">
    <div class="mainContent">
        <h1>Categories</h1>
        <div class="categoryGrid">
            @foreach($categories as $category)
            <div class="categoryBox" onclick="window.location.href='{{url('shop/' . $category->catURL)}}'">
                <img src="{{asset('images/' . $category->catImage)}}">
                <div class="categoryContent">
                    <h2>{{$category->catName}}</h2>
                    {{$category->catDescription}}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
