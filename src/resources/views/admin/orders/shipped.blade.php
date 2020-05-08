@extends('admin.orders.index')
@section('title')
<title>Shipped Orders</title>
@endsection
<!-- Content Wrapper -->
@section('shipped')
<div class="container-fluid">


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Shipped</h6>
        </div>
        @include('admin.helpers.orders.table')
    </div>

</div>
@endsection