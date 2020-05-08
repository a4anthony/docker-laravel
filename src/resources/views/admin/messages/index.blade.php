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
                <h1 class="h3 mb-0 text-gray-800">Messages</h1>
                <div>
                    @yield('links')
                </div>
            </div>

            <!-- Content Row -->
            <div class="row message_header">

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Read Messages
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$readMessages}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Unread Mesages
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$unreadMessages}}</div>
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
            @yield('all')
            @yield('read')
            @yield('unread')
            @yield('view')
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