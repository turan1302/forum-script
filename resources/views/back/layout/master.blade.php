<!DOCTYPE html>
<html lang="en">

<head>
    @include('back.layout.head')
    @include('back.layout.include_style')
    @yield('css')
</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    @include('back.layout.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            @include('back.layout.topbar')

            <!-- Begin Page Content -->
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        @include('back.layout.footer')
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

@include('back.layout.logout_modal')

@include('back.layout.include_script')

<!-- ALERT -->
@include('back.layout.alert')

@yield('js')

</body>

</html>
