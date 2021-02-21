<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title> DAARUL CILMI - Barashada Diinta Islaamka</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Barashada Diinta Islaamka" name="description" />
    <meta content="Drongo Technology" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="/assets/images/favicon.ico">

    <!-- Bootstrap Css -->
    <link href="/assets/css/bootstrap.min.css"  rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="/assets/css/app.min.css"  rel="stylesheet" type="text/css" />

    @yield('links')

</head>

<body data-layout="detached" data-topbar="colored">

    <div class="container-fluid">
        <!-- Begin page -->
        <div id="layout-wrapper">

            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="container-fluid">
                        <div class="float-right">

                            <div class="dropdown d-inline-block d-lg-none ml-2">
                                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-magnify"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0" aria-labelledby="page-header-search-dropdown">

                                    <form class="p-3">
                                        <div class="form-group m-0">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="dropdown d-none d-sm-inline-block">
                                <button type="button" class="btn header-item waves-effect" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="" src="/assets/images/flags/us.jpg" alt="Header Language" height="16">
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <img src="/assets/images/flags/spain.jpg" alt="user-image" class="mr-1" height="12"> <span class="align-middle">Spanish</span>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <img src="/assets/images/flags/germany.jpg" alt="user-image" class="mr-1" height="12"> <span class="align-middle">German</span>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <img src="/assets/images/flags/italy.jpg" alt="user-image" class="mr-1" height="12"> <span class="align-middle">Italian</span>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <img src="/assets/images/flags/russia.jpg" alt="user-image" class="mr-1" height="12"> <span class="align-middle">Russian</span>
                                    </a>
                                </div>
                            </div>

                            <div class="dropdown d-none d-lg-inline-block ml-1">
                                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                                    <i class="mdi mdi-fullscreen"></i>
                                </button>
                            </div>

                            <div class="dropdown d-inline-block">
                                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-bell-outline"></i>
                                    <span class="badge badge-danger badge-pill">3</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0" aria-labelledby="page-header-notifications-dropdown">
                                    <div class="p-3">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h6 class="m-0"> Notifications </h6>
                                            </div>
                                            <div class="col-auto">
                                                <a href="#!" class="small"> View All</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-simplebar style="max-height: 230px;">
                                        <a href="" class="text-reset notification-item">
                                            <div class="media">
                                                <div class="avatar-xs mr-3">
                                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                        <i class="bx bx-cart"></i>
                                                    </span>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="mt-0 mb-1">Your order is placed</h6>
                                                    <div class="font-size-12 text-muted">
                                                        <p class="mb-1">If several languages coalesce the grammar</p>
                                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="" class="text-reset notification-item">
                                            <div class="media">
                                                <img src="/assets/images/users/avatar-3.jpg" class="mr-3 rounded-circle avatar-xs" alt="user-pic">
                                                <div class="media-body">
                                                    <h6 class="mt-0 mb-1">James Lemire</h6>
                                                    <div class="font-size-12 text-muted">
                                                        <p class="mb-1">It will seem like simplified English.</p>
                                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hours ago</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="" class="text-reset notification-item">
                                            <div class="media">
                                                <div class="avatar-xs mr-3">
                                                    <span class="avatar-title bg-success rounded-circle font-size-16">
                                                        <i class="bx bx-badge-check"></i>
                                                    </span>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="mt-0 mb-1">Your item is shipped</h6>
                                                    <div class="font-size-12 text-muted">
                                                        <p class="mb-1">If several languages coalesce the grammar</p>
                                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                        <a href="" class="text-reset notification-item">
                                            <div class="media">
                                                <img src="/assets/images/users/avatar-4.jpg" class="mr-3 rounded-circle avatar-xs" alt="user-pic">
                                                <div class="media-body">
                                                    <h6 class="mt-0 mb-1">Salena Layfield</h6>
                                                    <div class="font-size-12 text-muted">
                                                        <p class="mb-1">As a skeptical Cambridge friend of mine occidental.</p>
                                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hours ago</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="p-2 border-top">
                                        <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="javascript:void(0)">
                                            <i class="mdi mdi-arrow-right-circle mr-1"></i> View More..
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown d-inline-block">
                                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="rounded-circle header-profile-user" src="/assets/images/users/avatar-2.jpg" alt="Header Avatar">
                                    <span class="d-none d-xl-inline-block ml-1">{{Auth::user()->name}}</span>
                                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <!-- item-->
                                    <a class="dropdown-item" href="#"><i class="bx bx-user font-size-16 align-middle mr-1"></i> Profile</a>
                                    <a class="dropdown-item" href="#"><i class="bx bx-wallet font-size-16 align-middle mr-1"></i> My Wallet</a>
                                    <a class="dropdown-item d-block" href="#"><span class="badge badge-success float-right">11</span><i class="bx bx-wrench font-size-16 align-middle mr-1"></i> Settings</a>
                                    <a class="dropdown-item" href="#"><i class="bx bx-lock-open font-size-16 align-middle mr-1"></i> Lock screen</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                                       <i class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i> 
                                       Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>

                            <div class="dropdown d-inline-block">
                                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                                    <i class="mdi mdi-settings-outline"></i>
                                </button>
                            </div>

                        </div>
                        <div>
                            <!-- LOGO -->
                            <div class="navbar-brand-box">
                                <a href="/" class="logo logo-dark">
                                    <span class="logo-sm">
                                        <img src="/assets/images/daarul_arqam_translucent.png" alt="" height="70">
                                    </span>
                                    <span class="logo-lg">
                                        <img src="/assets/images/daarul_arqam_translucent.png" alt="" height="70">
                                    </span>
                                </a>

                                <a href="/" class="logo logo-light">
                                    <span class="logo-sm">
                                        <img src="/assets/images/daarul_arqam_translucent.png" alt="" height="70">
                                    </span>
                                    <span class="logo-lg">
                                        <img src="/assets/images/daarul_arqam_translucent.png" alt="" height="70">
                                    </span>
                                </a>
                            </div>

                            <button type="button" class="btn btn-sm px-3 font-size-16 header-item toggle-btn waves-effect" id="vertical-menu-btn">
                                <i class="fa fa-fw fa-bars"></i>
                            </button>

                            <!-- App Search-->
                            <form class="app-search d-none d-lg-inline-block">
                                <div class="position-relative">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <span class="bx bx-search-alt"></span>
                                </div>
                            </form>

                            
                        </div>

                    </div>
                </div>
            </header> <!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div class="h-100">

        <div class="user-wid text-center py-4">
            <div class="user-img">
                <img src="/assets/images/users/avatar-2.jpg" alt="" class="avatar-md mx-auto rounded-circle">
            </div>

            <div class="mt-3">

                <a href="#" class="text-dark font-weight-medium font-size-16">{{Auth::user()->name}}</a>
                <p class="text-body mt-1 mb-0 font-size-13">{{Auth::user()->email}}</p>

            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-user"></i>
                        <span>Sheekhs</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="/sheekh/new">Sheekh Cusub</a></li>
                        <li><a href="/sheekh/list">Sheekh list</a></li>
                    </ul>
                </li>


                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-file"></i>
                        <span>Buugaagta</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="/books/new">Buug cusub</a></li>
                        <li><a href="/books/list">Liiska buugaagta</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-pen"></i>
                        <span>Casharada</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="/books/list">Cashar cusub</a></li>
                        <li><a href="/casharada/list">Liiska Casharada</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-file-audio"></i>
                        <span>Muxaadaro</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="/muxaadaro/new">Muxaadaro cusub</a></li>
                        <li><a href="/muxaadaro/list">Liiska Muxaadarooyinka</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-vials"></i>
                        <span>Categories</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="/books/category">New Category</a></li>
                        <li><a href="/books/category">List categories</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-list"></i>
                        <span>Trending</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="/trend">New Trend</a></li>
                        <li><a href="/trend/list">List Trends</a></li>
                    </ul>
                </li>




            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="page-title mb-0 font-size-18">
                                    @yield('pageTitle')
                                </h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">@yield('parentPage')</a></li>
                                        <li class="breadcrumb-item active">@yield('pageTitle')</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div id="appId">
                        @yield('content')
                    </div>
                    
                    <!-- end page title -->

                </div>
                <!-- End Page-content -->

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> © Drongo Technology.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-right d-none d-sm-block">
                                    Product of Drongo Technology
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

    </div>
    <!-- end container-fluid -->

    <!-- Right Sidebar -->
    <div class="right-bar">
        <div data-simplebar class="h-100">
            <div class="rightbar-title px-3 py-4">
                <a href="javascript:void(0);" class="right-bar-toggle float-right">
                    <i class="mdi mdi-close noti-icon"></i>
                </a>
                <h5 class="m-0">Settings</h5>
            </div>

            <!-- Settings -->
            <hr class="mt-0" />
            <h6 class="text-center mb-0">Choose Layouts</h6>

            <div class="p-4">
                <div class="mb-2">
                    <img src="/assets/images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt="">
                </div>
                <div class="custom-control custom-switch mb-3">
                    <input type="checkbox" class="custom-control-input theme-choice" id="light-mode-switch" checked />
                    <label class="custom-control-label" for="light-mode-switch">Light Mode</label>
                </div>

                <div class="mb-2">
                    <img src="/assets/images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt="">
                </div>
                <div class="custom-control custom-switch mb-3">
                    <input type="checkbox" class="custom-control-input theme-choice" id="dark-mode-switch" data-bsStyle="/assets/css/bootstrap-dark.min.css" data-appStyle="/assets/css/app-dark.min.css" />
                    <label class="custom-control-label" for="dark-mode-switch">Dark Mode</label>
                </div>

                <div class="mb-2">
                    <img src="/assets/images/layouts/layout-3.jpg" class="img-fluid img-thumbnail" alt="">
                </div>
                <div class="custom-control custom-switch mb-5">
                    <input type="checkbox" class="custom-control-input theme-choice" id="rtl-mode-switch" data-appStyle="/assets/css/app-rtl.min.css" />
                    <label class="custom-control-label" for="rtl-mode-switch">RTL Mode</label>
                </div>

            </div>

        </div>
        <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="/assets/libs/jquery/jquery.min.js"></script>
    <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/assets/libs/node-waves/waves.min.js"></script>

    @yield('scripts')
    <!-- App js -->
    <script src="/assets/js/app.js"></script>

</body>

</html>