@extends('admin.layouts.melamart')


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
            <div id="actionBtn" class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Products</h1>
                <div>
                    @if (!request()->is('product/*'))
                    <a href="/product/add" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add Item</a>
                    @endif @yield('links')
                </div>


            </div>

            <!-- Content Row -->
            <div class="row productHeader">

                <!-- Earnings (Monthly) Card Example -->
                <div id="products-link-1" class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">All Products
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$countProducts}}</div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div id="products-link-2" class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Live Products
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$countLive}}</div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div id="products-link-3" class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Paused Products
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$countPaused}}</div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <div id="products-link-4" class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Out of stock
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$countNoStock}}</div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="max-height: 40px; min-height: 40px;">
                @if (session('success'))
                <div class="alert alert-success" style="padding: .2rem;" role="alert">
                    &#8226; {{ session('success') }}
                </div>
                @endif
            </div>
            <!-- Content Row -->
            @yield('edit')
            @yield('all')
            @yield('add')
            @yield('view')
            @yield('live')
            @yield('paused')
            @yield('nostock')
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