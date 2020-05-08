@extends('admin.layouts.melamart')
@section('title')
<title>Customers</title>
@endsection
<!-- Content Wrapper -->
@section('content')
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        @include('admin.helpers.navbar')
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Customers</h1>
            </div>


            <!-- Content Row -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">All</h6>
                </div>
                @include('admin.helpers.customers.table')
            </div>
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <!-- Footer -->
    @include('admin.helpers.footer')
    <!-- End of Footer -->

</div>
@endsection
<!-- End of Content Wrapper -->