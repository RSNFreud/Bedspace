@extends('admin.master')

@section('content')
<div class="alignCenter">
    <div class="newCategoryGrid">
        <div class="box">
            <h3>Edit Category</h3>
            <form action="{{url('admin/categories/' . $categoryData->catURL)}}" enctype="multipart/form-data"
                method="POST" novalidate=true autocomplete="off">
                @csrf()
                @method('PUT')
                <div class="formData">
                    <span style="width: 100%">
                        <label for="catName">Category Name:</label>
                        <input type="text" name="catName" value="{{$categoryData->catName}}">
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
                        <textarea name="catDescription" rows="10">{{$categoryData->catDescription}}</textarea>
                        @foreach ($errors->get('catDescription') as $message)
                        <span class="formError">{{$message}}</span>
                        @endforeach
                    </span>

                    <div id="productButtons">
                        <input type="submit" value="Update Category">
                        <input type="button" value="Cancel" class="buttonOutline"
                            onclick="window.location.href = '{{url('admin/categories')}}'">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
