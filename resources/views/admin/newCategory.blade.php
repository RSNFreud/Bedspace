@extends('admin.master')

@section('content')
<div class="alignCenter">
    <div class="newCategoryGrid">
        <div class="box">
            <h3>New Category</h3>
            <form action="{{url('admin/categories')}}" enctype="multipart/form-data" method="POST" novalidate=true
                autocomplete="off">
                @csrf()
                <div class="formData">
                    <span style="width: 100%">
                        <label for="catName">Category Name:</label>
                        <input type="text" name="catName" value="{{old('catName')}}">
                        @foreach ($errors->get('catName') as $message)
                        <span class="formError">{{$message}}</span>
                        @endforeach
                    </span>
                    <span>
                        <label for="featuredImage">Featured Image:</label>
                        <input type="file" name="featuredImage" accept="image/*" multiple>
                        @foreach ($errors->get('featuredImage') as $message)
                        <span class="formError">{{$message}}</span>
                        @endforeach
                    </span>
                    <span style="width: 100%">
                        <label for="catDescription">Category Description:</label>
                        <textarea name="catDescription" rows="10">{{old('catDescription')}}</textarea>
                        @foreach ($errors->get('catDescription') as $message)
                        <span class="formError">{{$message}}</span>
                        @endforeach
                    </span>

                    <div id="productButtons">
                        <input type="submit" value="Add Category">
                        <input type="button" value="Cancel" class="buttonOutline"
                            onclick="window.location.href = '{{url('admin/categories')}}'">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
