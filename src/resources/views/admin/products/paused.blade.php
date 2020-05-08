@extends('admin.products.index')

@section('title')
<title>Paused Products</title>
@endsection
<!-- Content Wrapper -->
@section('paused')
<div class="container-fluid">


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Paused Products</h6>
        </div>
        @include('admin.helpers.products.table')
    </div>
</div>
@endsection