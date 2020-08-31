@extends('admin.master')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<div class="alignCenter">
    <div class="newCategoryGrid">
        <div class="box">
            <h3>New Page</h3>
            <form action="{{url('admin/pages')}}" enctype="multipart/form-data" method="POST" novalidate=true
                autocomplete="off">
                @csrf()
                <div class="formData">
                    <span style="width: 100%">
                        <label for="pageTitle">Page Title:</label>
                        <input type="text" name="pageTitle" value="{{old('pageTitle')}}">
                        @foreach ($errors->get('pageTitle') as $message)
                        <span class="formError">{{$message}}</span>
                        @endforeach
                    </span>
                    <span style="width: 100%; margin-top: 10px">
                        <textarea name="pageContent" id="summernote" rows="10">{{old('pageContent')}}</textarea>
                        @foreach ($errors->get('pageContent') as $message)
                        <span class="formError">{{$message}}</span>
                        @endforeach
                    </span>

                    <div id="productButtons">
                        <input type="submit" value="Add Page">
                        <input type="button" value="Cancel" class="buttonOutline"
                            onclick="window.location.href = '{{url('admin/pages')}}'">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#summernote').summernote({
        tabsize: 2,
        height: 120,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
        });
    })
</script>
@endsection
