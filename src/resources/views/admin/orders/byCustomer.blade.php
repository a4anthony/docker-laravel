@extends('admin.orders.index')
@section('title')
<title>New Orders</title>
@endsection
<!-- Content Wrapper -->
@section('byCustomer')
<style>
    .orderHeader {
        display: none;
    }

    .subHeading {
        text-transform: uppercase;
        font-size: .7rem;
        font-weight: 400;
    }
</style>
<div class="container-fluid">


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <span class="subHeading">Name:</span> {{$user->firstname}} {{$user->lastname}}<br>
                <span class="subHeading">Email :</span> {{$user->email}}<br>
                <span class="subHeading">Total Transactions:</span> {{$totalOrders}}<br>
                <span class="subHeading">Total spend:</span> <span>&#8358;</span>{{$allTimeTotal}}<br>
            </h6>
        </div>
        @include('admin.helpers.orders.table')
    </div>

</div>
@endsection