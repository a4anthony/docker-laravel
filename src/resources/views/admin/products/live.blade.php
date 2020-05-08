@extends('admin.products.index')
@section('title')
<title>Live Products</title>
@endsection
<!-- Content Wrapper -->
@section('live')
<div class="container-fluid">


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Live Products</h6>
        </div>
        @include('admin.helpers.products.table')
    </div>

</div>
@endsection