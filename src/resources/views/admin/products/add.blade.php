@extends('admin.products.index')
@section('title')
<title>Add Product</title>
@endsection
@section('scripts')
<script src="{{asset('admin/js/imgUpload.js')}}?<?php echo date('imgUpload.js'); ?>"></script>

<script>
    var imgLimit = 4;
    var check = sessionStorage.getItem('check');
    if (check == null) {
        sessionStorage.clear()
    }
    sessionStorage.setItem('check', 1);
</script>
@endsection
<!-- Content Wrapper -->
@section('add')
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
            <h6 class="m-0 font-weight-bold text-primary">Add Product</h6>
        </div>
        <form action="/product/add" method="POST" enctype="multipart/form-data">
            <div class="row productDiv" style="padding: 2rem;">
                @csrf
                <div class="col-6">
                    <div class="form-group">
                        <h6>Main Category</h6>
                        <select name="main_category" id="main_category" class="form-control @error('main_category') is-invalid @enderror">
                            <option value="">-- Select Main Category --</option>
                            @foreach ($allCategories as $category)
                            <option value="{{$category->id}}" @if(old('main_category')==$category->id) {{ 'selected' }} @endif>{{$category->name}}</option>
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
                        <input type="text" name="title" value="{{old('title')}}" class="form-control @error('title') is-invalid @enderror">
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
                        <textarea name="brief_description" class="form-control @error('brief_description') is-invalid @enderror" id="CodeBlock">{{old('brief_description')}}</textarea>
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
                        <textarea class="form-control @error('specification') is-invalid @enderror" name="specification" id="CodeBlock1">{{old('specification')}}</textarea>
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
                        <textarea class="form-control @error('features') is-invalid @enderror" name="features" id="CodeBlock2">{{old('features')}}</textarea>
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
                </div>
                <div class="col-12">
                    <hr>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <h6>Barcode</h6>
                        <input type="text" name="barcode" value="{{old('barcode')}}" class="form-control @error('barcode') is-invalid @enderror">
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
                        <input type="text" name="brand" value="{{old('brand')}}" class="form-control @error('brand') is-invalid @enderror">
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
                        <input type="text" name="initial_price" id="initial_price" value="{{old('initial_price')}}" class="form-control @error('initial_price') is-invalid @enderror">
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
                        <input type="number" name="discount" id="discount" value="{{old('discount')}}" class="form-control @error('discount') is-invalid @enderror">
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
                        <input type="number" name="quantity" value="{{old('quantity')}}" class="form-control @error('quantity') is-invalid @enderror">
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
                        <input type="number" name="total_price" id="total_price" value="{{old('total_price')}}" class="form-control @error('total_price') is-invalid @enderror" readonly>
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
                            <option value="no returns" @if(old('returns')=='no returns' ) {{ 'selected' }} @endif>No returns</option>
                            <option value="7 days" @if(old('returns')=='7 days' ) {{ 'selected' }} @endif>7 days</option>
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
                            <option value="24 - 48 hours" @if(old('delivery')=='24 - 48 hours' ) {{ 'selected' }} @endif>24 to 48 hours</option>
                        </select>
                        @error('delivery')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <button id="addFormSubmit" type="submit" hidden></button>
        </form>

    </div>

</div>

<div id="actionBtn" class="" style="margin-bottom: 5rem; margin-right: 2rem;">
    <div style="float:right;">
        <a href="" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" onclick="event.preventDefault();
          document.getElementById('addFormSubmit').click();"> Add Item</a>
    </div>
</div>
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

        var old_subCategory = <?php echo json_encode(old('sub_category')); ?>;
        if ($('#main_category').val() != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "/subcategory/" + $('#main_category').val(),
                method: 'GET',
                success: function(data) {
                    $('#sub_category').prop('disabled', false);
                    $('#sub_category').html(data.html);



                    $('#sub_category > option').each(function() {
                        if (old_subCategory == $(this).val()) {
                            $('#sub_category').val($(this).val());
                        }
                    });
                }
            });

        }
    });
</script>

@endsection