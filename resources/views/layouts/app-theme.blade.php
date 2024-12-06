<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

@include('layouts.includes.theme-header');

@stack('styles')
<script>
    const PATH_ROOT = '{{ asset('admin') }}';
</script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.11/dist/sweetalert2.min.css"> --}}

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        @include('layouts.includes.header')
        <!-- ========== App Menu ========== -->

        @include('layouts.includes.side-bar')
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            @include('layouts.includes.footer')
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    {{-- @include('layouts.includes.theme-setting') --}}

    <!-- JAVASCRIPT -->
    @include('layouts.includes.theme-footer')

    @stack('scripts')
    <script src="{{ asset('admin/assets/js/pages/password-addon.init.js') }}"></script>
    <script src="{{ asset('admin/assets/js/voucher.js') }}"></script>
    <script src="{{ asset('admin/assets/js/combo.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.11/dist/sweetalert2.min.js"></script> --}}

</body>

</html>
