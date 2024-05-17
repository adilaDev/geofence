<?php include 'layouts/session.php'; ?>
<?php include 'layouts/head-main.php'; ?>

<head>
    <title>Apex Charts | Skote - Admin & Dashboard Template</title>
    <?php include 'layouts/head.php'; ?>
    <?php include 'layouts/head-style.php'; ?>
</head>

<?php include 'layouts/body.php'; ?>

<!-- Begin page -->
<div id="layout-wrapper">

    <?php include 'layouts/menu.php'; ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Apex charts</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Charts</a></li>
                                    <li class="breadcrumb-item active">Apex charts</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Line with Data Labels</h4>

                                <div id="line_chart_datalabel" class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                        <!--end card-->
                    </div>

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Dashed Line</h4>

                                <div id="line_chart_dashed" class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                        <!--end card-->
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Spline Area</h4>

                                <div id="spline_area" class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                        <!--end card-->
                    </div>

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Column Chart</h4>

                                <div id="column_chart" class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                        <!--end card-->
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Column with Data Labels</h4>

                                <div id="column_chart_datalabel" class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                        <!--end card-->
                    </div>
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Bar Chart</h4>

                                <div id="bar_chart" class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                        <!--end card-->
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Line, Column & Area Chart</h4>

                                <div id="mixed_chart" class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                        <!--end card-->
                    </div>
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Radial Chart</h4>

                                <div id="radial_chart" class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                        <!--end card-->

                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Pie Chart</h4>

                                <div id="pie_chart" class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Donut Chart</h4>

                                <div id="donut_chart" class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <?php include 'layouts/footer.php'; ?>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!-- Right Sidebar -->
<?php include 'layouts/right-sidebar.php'; ?>
<!-- /Right-bar -->

<!-- JAVASCRIPT -->

<?php include 'layouts/vendor-scripts.php'; ?>

<!-- apexcharts -->
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>

<!-- apexcharts init -->
<script src="assets/js/pages/apexcharts.init.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>

</body>

</html>