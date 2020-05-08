@extends('admin.orders.index')
@section('title')
<title>New Orders</title>
@endsection


@section('links')
@if ($status != 'shipped')
<a class="pause d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" href="" data-toggle="modal" data-target="#shippedModal">Shipped</a>
@endif
@if ($status != 'delivered')
<a class="pause d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" href="" data-toggle="modal" data-target="#deliveredModal">Delivered</a>
@endif
@if ($status != 'returned')
<a class="pause d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" href="" data-toggle="modal" data-target="#returnedModal">Returned</a>
@endif
@endsection



<!-- Content Wrapper -->
@section('view')
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

<div class="modal fade" id="shippedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Set order status to shipped?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="" onclick="event.preventDefault();
                                document.getElementById('shipped').submit();">
                    Yes</a>
                <form id="shipped" action="/order/shipped" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="text" name="reference" hidden value="{{$reference}}">
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deliveredModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Set order status to delivered?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="" onclick="event.preventDefault();
                                document.getElementById('delivered').submit();">
                    Yes</a>
                <form id="delivered" action="/order/delivered" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="text" name="reference" hidden value="{{$reference}}">
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="returnedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Set order status to returned?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="" onclick="event.preventDefault();
                                document.getElementById('returned').submit();">
                    Yes</a>
                <form id="returned" action="/order/returned" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="text" name="reference" hidden value="{{$reference}}">
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <span class="subHeading">Name:</span> {{$user->firstname}} {{$user->lastname}}<br>
                <span class="subHeading">Email :</span> {{$user->email}}<br>
                <span class="subHeading">Total Transactions:</span> {{$no_Items}} <br>
                <span class="subHeading">Total spend:</span> <span>&#8358;</span>{{$orderTotal}}<br>
                <hr>

                <span class="subHeading">delivery address:</span> {{$address}}<br>
            </h6>

        </div>
        @include('admin.helpers.orders.table')
    </div>

</div>
@endsection