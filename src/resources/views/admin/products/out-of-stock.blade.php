@extends('admin.products.index')
@section('title')
<title>Out of stock Products</title>
@endsection
<!-- Content Wrapper -->
@section('nostock')
<div class="container-fluid">


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Out of stock</h6>
        </div>
        @include('admin.helpers.products.table')
    </div>
</div>
@endsection