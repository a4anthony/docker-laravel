<!DOCTYPE html>
<html lang="en">

<head>
    @yield('title')

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/png" href="{{asset('images/favicon.png')}}">

    <!-- Custom fonts for this template-->
    <link href="{{asset('admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('admin/css/app.css')}}?<?php echo date('app.css'); ?>" rel="stylesheet">
    <link href="{{asset('admin/css/sb-admin-2.min.css')}}?<?php echo date('sb-admin-2.min.css'); ?>" rel="stylesheet">
    <link href="{{asset('admin/css/custom.css')}}?<?php echo date('custom.css'); ?>" rel="stylesheet">
    <link href="{{asset('admin/uploader/css/jquery.filer.css')}}?<?php echo date('jquery.filer.css'); ?>" rel="stylesheet">
    <link href="{{asset('admin/uploader/css/themes/jquery.filer-dragdropbox-theme.css')}}?<?php echo date('jquery.filer-dragdropbox-theme.css'); ?>" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="{{asset('admin/vendor/datatables/dataTables.bootstrap4.min.css')}}?<?php echo date('dataTables.bootstrap4.min.css'); ?>" rel="stylesheet">
    <script src="{{asset('admin/js/jquery.js')}}?<?php echo date('jquery.js'); ?>"></script>
    <!-- Global chart variable -->
    <script>
        var amm1 = <?php echo json_encode($amm); ?>;
        // console.log(amm1);
    </script>
    @yield('scripts')

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard" style="background: white; color: #152538;">
                <div class="sidebar-brand-icon rotate-n-15">
                    <img src="{{asset('admin/img/logo_sq.png')}}" style="width: 2rem;" alt="">
                </div>
                <div class="sidebar-brand-text mx-3">Admin Panel</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="/dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">



            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategory" aria-expanded="true" aria-controls="collapseCategory">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Categories</span>
                </a>
                <div id="collapseCategory" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Categories:</h6>
                        <a class="collapse-item" href="/categories/all">All</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Products</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Products:</h6>
                        <a class="collapse-item" href="/products/all">All</a>
                        <a class="collapse-item" href="/products/live">Live</a>
                        <a class="collapse-item" href="/products/paused">Paused</a>
                        <a class="collapse-item" href="/products/out-of-stock">Out of stock</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Orders:</h6>
                        <a class="collapse-item" href="/orders/new">New</a>
                        <a class="collapse-item" href="/orders/shipped">Shipped</a>
                        <a class="collapse-item" href="/orders/delivered">Delivered</a>
                        <a class="collapse-item" href="/orders/returned">Returned</a>
                    </div>
                </div>
            </li>
            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTransactions" aria-expanded="true" aria-controls="collapseTransactions">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span>Transactions</span>
                </a>
                <div id="collapseTransactions" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Transactions:</h6>
                        <a class="collapse-item" href="/transactions">Transaction Report</a>
                    </div>
                </div>
            </li>
            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCustomers" aria-expanded="true" aria-controls="collapseCustomers">
                    <i class="fas fa-user-friends"></i>
                    <span>Customers</span>
                </a>
                <div id="collapseCustomers" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Customers:</h6>
                        <a class="collapse-item" href="/customers">All Customers</a>
                    </div>
                </div>
            </li>
            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMessages" aria-expanded="true" aria-controls="collapseMessages">
                    <i class="fas fa-envelope"></i>
                    <span>Messages</span>
                </a>
                <div id="collapseMessages" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Messages:</h6>
                        <a class="collapse-item" href="/messages/all">All</a>
                        <a class="collapse-item" href="/messages/read">Read</a>
                        <a class="collapse-item" href="/messages/unread">Unread</a>
                    </div>
                </div>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        @yield('content')
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        Logout</a>
                    <form id="logout-form" action="{{ route('logout.admin') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}?<?php echo date('bootstrap.bundle.min.js'); ?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('admin/vendor/jquery-easing/jquery.easing.min.js')}}?<?php echo date('jquery.easing.min.js'); ?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('admin/js/sb-admin-2.min.js')}}?<?php echo date('sb-admin-2.min.js'); ?>"></script>

    <!-- Page level plugins -->
    <script src="{{asset('admin/vendor/chart.js/Chart.min.js')}}?<?php echo date('Chart.min.js'); ?>"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('admin/js/demo/chart-area-demo.js')}}?<?php echo date('chart-area-demo.js'); ?>"></script>
    <script src="{{asset('admin/js/demo/chart-pie-demo.js')}}?<?php echo date('chart-pie-demo.js'); ?>"></script>
    <script src="{{asset('admin/js/demo/datatables-demo.js')}}?<?php echo date('datatables-demo.js'); ?>"></script>


    <!-- Page level plugins -->
    <script src="{{asset('admin/vendor/datatables/jquery.dataTables.min.js')}}?<?php echo date('jquery.dataTables.min.js'); ?>"></script>
    <script src="{{asset('admin/vendor/datatables/dataTables.bootstrap4.min.js')}}?<?php echo date('dataTables.bootstrap4.min.js'); ?>"></script>
    <script src="{{asset('admin/uploader/js/jquery.filer.min.js')}}?<?php echo date('jquery.filer.min.js'); ?>"></script>



</body>

</html>