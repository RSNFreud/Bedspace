@extends('admin.master')

@section('content')
<div class="alignCenter">
    <div class="newProductGrid">
        <div class="box">
            <h3>Edit Product</h3>
            <form action="{{url('admin/products/' . $productData->url)}}" enctype="multipart/form-data" method="POST"
                novalidate=true autocomplete="off" id="newProduct">
                @csrf()
                @method('PUT')
                <div class="formGrid">
                    <div class="formData">
                        <div class="splitColumn">
                            <span>
                                <label for="itemName">Item Name:</label>
                                <input type="text" name="itemName" value="{{$productData->productName}}">
                                @foreach ($errors->get('itemName') as $message)
                                <span class="formError">{{$message}}</span>
                                @endforeach
                            </span>
                            <span>
                                <label for="price">Price:</label>
                                <input type="text" name="price" value="{{$productData->price}}">
                                @foreach ($errors->get('price') as $message)
                                <span class="formError">{{$message}}</span>
                                @endforeach
                            </span>
                        </div>
                        <span>
                            <label for="featuredImage">Featured Image:</label>
                            <input type="file" name="featuredImage" accept="image/*" multiple>
                            @foreach ($errors->get('featuredImage') as $message)
                            <span class="formError">{{$message}}</span>
                            @endforeach
                        </span>
                        <span style="width: 100%">
                            <label for="itemDescription">Item Description:</label>
                            <textarea name="itemDescription" rows="10">{{$productData->description}}</textarea>
                            @foreach ($errors->get('itemDescription') as $message)
                            <span class="formError">{{$message}}</span>
                            @endforeach
                        </span>
                        <div class="splitColumn">
                            <span>
                                <label for="category">Category:</label>

                                <select name="category">
                                    <option value="">Select a category...</option>
                                    @foreach($categories as $category)
                                    <option value="{{$category->catName}}"
                                        {{$productData->category==$category->catName ? 'selected' : ''}}>
                                        {{$category->catName}}
                                    </option>
                                    @endforeach
                                </select>
                                @foreach ($errors->get('category') as $message)
                                <span class="formError">{{$message}}</span>
                                @endforeach
                            </span>
                            <span>
                                <label for="dimensions">Dimensions:</label>
                                <input type="text" name="dimensions" value="{{$productData->dimensions}}">
                                @foreach ($errors->get('dimensions') as $message)
                                <span class="formError">{{$message}}</span>
                                @endforeach
                            </span>
                        </div>
                        <div class="splitColumn">
                            <span>
                                <label for="weight">Weight:</label>
                                <input type="text" name="weight" value="{{$productData->weight}}">
                                @foreach ($errors->get('weight') as $message)
                                <span class="formError">{{$message}}</span>
                                @endforeach
                            </span>
                            <span>
                                <label for="deliveryTime">Delivery Time:</label>
                                <input type="text" name="deliveryTime" value="{{$productData->deliveryTime}}">
                                @foreach ($errors->get('deliveryTime') as $message)
                                <span class="formError">{{$message}}</span>
                                @endforeach
                            </span>
                        </div>
                        <div id="productButtons">
                            <input type="submit" value="Update Product">
                            <input type="button" value="Cancel" class="buttonOutline"
                                onclick="window.location.href = '{{url('admin/products')}}'">
                        </div>
                    </div>
                    <div class="formImages">
                        <div class="dropzoneImage">
                            Click here to upload product images
                        </div>
                        <div id="uploadedImages" class="dropzone-previews"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    let previewTemplate =
        `<div class="fileItem">
                            <img data-dz-thumbnail>
                            <span><i class="fa fa-trash" data-dz-remove></i></span>
                        </div>`;
    $(document).ready(function () {
        $('#newProduct').dropzone({
            url: "{{url('api/addImage')}}",
            method: "post",
            maxFilesize: 12,
            dictRemoveFileConfirmation: 'Are you sure you want to delete this?',
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            // autoProcessQueue: false,
            clickable: document.querySelector(".dropzoneImage"),
            uploadMultiple: true,
            parallelUploads: 100,
            maxFiles: 100,
            previewTemplate: previewTemplate,
            previewsContainer: document.querySelector('#uploadedImages'),
            init: function () {
                myDropzone = this;
                let images ='{{$productImages}}';
                images = JSON.parse(images.replace(/&quot;/g, '"'));
                if (images.length != 0) {
                    images.forEach(image => {
                        let mockFile = {
                            name: image.name,
                            size: image.size
                        };
                        let callback = null; // Optional callback when it's done
                        let crossOrigin = null; // Added to the `img` tag for crossOrigin handling
                        let resizeThumbnail = false; // Tells Dropzone whether it should resize the image first

                        this.displayExistingFile(mockFile, image.url, callback, crossOrigin, resizeThumbnail);
                        this.files.push(mockFile);
                    })
                }

                let uploadError;
                this.on("removedfile", function (file, error) {
                    if (uploadError) return uploadError = "";
                    $.ajax({
                        url: "{{url('api/removeImage')}}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content')
                        },
                        method: 'POST',
                        data: file.name
                    })
                })

                this.on("addedfile", function (file, error) {
                    if (this.files.length) {
                        var _i, _len;
                        for (_i = 0, _len = this.files.length; _i < _len -1; _i++) { // -1 to exclude current file
                            if (this.files[_i].name === file.name && this.files[_i].size === file.size) {
                                uploadError = 'Duplicate file';
                                this.removeFile(file);
                                alert(file.name + " has already been added!");
                            }
                        }
                    }
                })

                this.on("error", function (file, error) {
                    uploadError = error;
                    this.removeFile(file);
                })
                this.on("errormultiple", function (files, response) {
                    uploadError = response;
                    this.removeFile(files);
                });
                let removeFile;
                Dropzone.confirm = function(question, fnAccepted, fnRejected) {
                    let modal = $('.confirmBackground');
                    modal.css("display", "flex");
                    setTimeout(() => {
                        modal.css("opacity", "1");
                    }, 200);
                    removeFile = fnAccepted;
                }

                $('#remove').click(function() {
                    let modal = $('.confirmBackground');
                    if (removeFile) {
                        removeFile();
                    }
                    modal.css("opacity", "0");
                    setTimeout(() => {
                        modal.css("display", "none");
                    }, 500);
                });
                $('#cancel').click(function() {
                    let modal = $('.confirmBackground');
                    modal.css("opacity", "0");
                    setTimeout(() => {
                        modal.css("display", "none");
                    }, 500);
                });
            }
        })
    })
    $('form').submit(function (e) {
        if (myDropzone.getQueuedFiles().length != 0) {
            e.preventDefault();
            e.stopPropagation();
            myDropzone.processQueue();
        }
    })

</script> @endsection
