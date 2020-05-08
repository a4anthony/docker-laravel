@extends('admin.orders.index')
@section('title')
<title>New Orders</title>
@endsection
<!-- Content Wrapper -->
@section('new')
<div class="container-fluid">


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">New</h6>
        </div>
        @include('admin.helpers.orders.table')
    </div>

</div>
@endsection