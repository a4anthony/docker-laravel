@extends('admin.messages.index')
@section('title')
<title>Unread Messages</title>
@endsection
<!-- Content Wrapper -->
@section('all')
<div class="container-fluid">


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Messages</h6>
        </div>
        @include('admin.helpers.messages.table')
    </div>

</div>
@endsection