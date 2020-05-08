@extends('admin.products.index')
@section('title')
<title>Edit Products</title>
@endsection

@section('scripts')
<script src="{{asset('admin/js/imgUpload.js')}}?<?php echo date('imgUpload.js'); ?>"></script>

<script>
    var imgLimit = <?php echo json_encode($imgLimit); ?>;
</script>
@endsection
<!-- Content Wrapper -->
@section('edit')
<style>
    .productHeader {
        display: none;
    }

    .productDiv h6 {
        text-transform: uppercase;
        font-size: .7rem;
    }

    .productDiv p {
        color: #333;
    }

    .image_preview img {
        width: 5rem;
    }
</style>
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Product</h6>
            @if($errors->has('*'))
            @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
            @endforeach
            @endif
        </div>
        <form id="editForm" action="/product/edit" method="POST" enctype="multipart/form-data">
            <div class="row productDiv" style="padding: 2rem;">
                @csrf
                @method('PUT')
                <input type="number" name="id" hidden value="{{$product->id}}">
                <div class="col-6">
                    <div class="form-group">
                        <h6>Main Category</h6>
                        <select name="main_category" id="main_category" class="form-control @error('main_category') is-invalid @enderror">
                            <option value="">-- Select Main Category --</option>
                            @foreach ($allCategories as $category)
                            <option value="{{$category->id}}" @if($errors->has('*')) @if(old('main_category') == $category->id) {{ 'selected' }} @endif @else @if($product->main_category_id == $category->id) {{'selected'}} @endif @endif>{{$category->name}}</option>
                            @endforeach
                        </select>
                        @error('main_category')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <h6>Sub Category</h6>
                        <select name="sub_category" id="sub_category" class="form-control @error('sub_category') is-invalid @enderror" disabled>
                            <option value="">-- Select Sub Category --</option>

                            @foreach ($product->mainCategory->subCategory as $subCategory)
                            <option value="{{$subCategory->id}}" @if($errors->has('*')) @if(old('sub_category')==$subCategory->id) {{ 'selected' }} @endif @else @if($product->sub_category_id == $subCategory->id) {{'selected'}} @endif @endif>{{$subCategory->name}}</option>
                            @endforeach

                        </select>
                        @error('sub_category')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <hr>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <h6>Title</h6>
                        <input type="text" name="title" value="{{old('title', $product->title)}}" class="form-control @error('title') is-invalid @enderror">
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <hr>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <h6>Brief description</h6>
                        <textarea name="brief_description" class="form-control @error('brief_description',) is-invalid @enderror" id="CodeBlock">{{old('brief_description',$product->brief_description)}}</textarea>
                        @error('brief_description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <hr>
                </div>
                <!--
                <div class="col-12">
                    <div class="form-group">
                        <h6>specifications</h6>
                        <textarea class="form-control @error('specification') is-invalid @enderror" name="specification" id="CodeBlock1">{{old('specification',$product->specifications)}}</textarea>
                        @error('specification')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <hr>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <h6>features</h6>
                        <textarea class="form-control @error('features') is-invalid @enderror" name="features" id="CodeBlock2">{{old('features',$product->features)}}</textarea>
                        @error('features')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <hr>
                </div>
                -->
                <div class="col-12">
                    <h6>Images</h6>
                    <input type="file" id="image" name="image[]" multiple class="form-control @error('image') is-invalid @enderror" />
                    <input name="image" class="form-control @error('image') is-invalid @enderror" hidden />
                    @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <div class="row">
                        @foreach ($product->images as $image)
                        @php
                        $key = $loop->iteration;
                        @endphp


                        <div id="img{{$key}}" class="col-3 text-center" style="border-radius: .5rem;">
                            <div style=" border: 1px solid gainsboro; border-radius: .5rem; padding: .5rem;">
                                <img src="{{env('APP_URL')}}{{$image->image_link}}" alt="" style="width: 100%;">
                            </div>
                            <div style="position: absolute; top: 8px; right: 20px;">
                                <a href="javascript:void(0);" id="delImg{{$key}}" onMouseOver="this.style.color='red'" style="color: grey;"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>


                        @endforeach
                    </div>
                </div>
                <div class="col-12">
                    <hr>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <h6>Barcode</h6>
                        <input type="text" name="barcode" value="{{old('barcode',$product->barcode)}}" class="form-control @error('barcode') is-invalid @enderror">
                        @error('barcode')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                </div>
                <div class="col-6">
                    <div class="form-group">
                        <h6>Brand</h6>
                        <input type="text" name="brand" value="{{old('brand',$product->brand)}}" class="form-control @error('brand') is-invalid @enderror">
                        @error('brand')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <h6>initial price (<span>&#8358;</span>)</h6>
                        <input type="number" name="initial_price" id="initial_price" value="{{old('initial_price',$product->initial_price)}}" class="form-control @error('initial_price') is-invalid @enderror">
                        @error('initial_price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <h6>Discount (%)</h6>
                        <input type="number" name="discount" id="discount" value="{{old('discount',$product->discount)}}" class="form-control @error('discount') is-invalid @enderror">
                        @error('discount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <h6>Quantity</h6>
                        <input type="number" name="quantity" value="{{old('quantity',$product->quantity)}}" class="form-control @error('quantity') is-invalid @enderror">
                        @error('quantity')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <h6>Total (<span>&#8358;</span>)</h6>
                        <input type="number" name="total_price" id="total_price" value="{{old('total_price',$product->total_price)}}" class="form-control @error('total_price') is-invalid @enderror" readonly>
                        @error('total_price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <h6>Returns</h6>
                        <select name="returns" id="returns" class="form-control @error('returns') is-invalid @enderror">
                            <option value="">-- Select Main Category --</option>
                            <option value="no returns" @if($errors->has('*')) @if(old('returns') == 'no returns') {{ 'selected' }} @endif @else @if($product->returns == 'no returns') {{'selected'}} @endif @endif>No returns</option>
                            <option value="7 days" @if($errors->has('*')) @if(old('returns') == '7 days') {{ 'selected' }} @endif @else @if($product->returns == '7 days') {{'selected'}} @endif @endif>7 days</option>
                        </select>
                        @error('returns')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <h6>delivery</h6>
                        <select name="delivery" id="delivery" class="form-control @error('delivery') is-invalid @enderror">
                            <option value="">-- Select Main Category --</option>
                            <option value="24 - 48 hours" @if($errors->has('*')) @if(old('delivery') == '24 - 48 hours') {{ 'selected' }} @endif @else @if($product->delivery == '24 - 48 hours') {{'selected'}} @endif @endif>24 to 48 hours</option>
                        </select>
                        @error('delivery')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <input type="text" hidden value="" name="delImages" id="delImages">
            <button id="editFormSubmit" type="submit" hidden onclick="event.preventDefault();">submit</button>
        </form>

    </div>

</div>

<!-- Page Heading -->
<div id="actionBtn" class="" style="margin-bottom: 5rem; margin-right: 2rem;">
    <div style="float:right;">
        <a href="" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" onclick="event.preventDefault();
          document.getElementById('editFormSubmit').click();"> Submit</a>
    </div>
</div>

@foreach ($product->images as $image)
@php
$key = $loop->iteration;
@endphp
<form action="/delete/image" id="formdelImg{{$key}}" method="POST">
    @csrf
    @method('DELETE')

    <input type="text" name="image_link" hidden value="{{$image->image_link}}">
    <input type="number" name="product_id" hidden value="{{$product->id}}">
</form>
@endforeach
<script src="https://cdn.ckeditor.com/ckeditor5/17.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#CodeBlock'))
        .catch(error => {
            console.error(error);
        });
</script>
<script>
    ClassicEditor
        .create(document.querySelector('#CodeBlock1'))
        .catch(error => {
            console.error(error);
        });
</script>
<script>
    ClassicEditor
        .create(document.querySelector('#CodeBlock2'))
        .catch(error => {
            console.error(error);
        });
</script>
<script>
    $(document).ready(function() {

        var image = <?php echo json_encode($product->images); ?>;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        console.log(image);
        var valueArray = [];
        $.each(image, function(index, value) {
            var key = index + 1;


            $('#delImg' + key).on('click', function() {
                console.log(key);
                valueArray.push(value.image_link);
                console.log(valueArray);
                $('#img' + key).addClass('d-none');
            });
        });


        $('#editFormSubmit').on('click', function() {
            var x = valueArray.toString();
            $('#delImages').val(x);
            $('#editForm').submit();
            console.log(x);
        });

        var main_category = <?php echo json_encode($product->mainCategory); ?>;
        var sub_category = <?php echo json_encode($product->subCategory); ?>;
        var returns = <?php echo json_encode($product->return); ?>;
        var delivery = <?php echo json_encode($product->delivery); ?>;
        console.log(main_category.name);
        console.log($('#sub_category').val());
        //$('#main_category').val(main_category.id);
        // $('#sub_category').append("<option value='" + sub_category.id + "' selected>" + sub_category.name + "</option>");
        $('#sub_category').prop('disabled', false);
        if ($('#sub_category').val() == null) {
            console.log('ewweew');

        }
        //  sessionStorage.setItem('mainCategory', $('#main_category').val());
        //  sessionStorage.setItem('subCategory', $('#sub_category').val());
        //sessionStorage.setItem('delivery', $('#delivery').val());
        // sessionStorage.setItem('returns', $('#returns').val());

    });
</script>

@endsection