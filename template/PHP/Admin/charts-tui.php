<?php include 'layouts/session.php'; ?>
<?php include 'layouts/head-main.php'; ?>

<head>
    <title>Toast UI Charts | Skote - Admin & Dashboard Template</title>
    <?php include 'layouts/head.php'; ?>

    <!-- tui charts Css -->
    <link href="assets/libs/tui-chart/tui-chart.min.css" rel="stylesheet" type="text/css" />

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
                            <h4 class="mb-sm-0 font-size-18">Toast UI charts</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Charts</a></li>
                                    <li class="breadcrumb-item active">Toast UI charts</li>
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
                                <h4 class="card-title mb-4">Bar charts</h4>

                                <div id="bar-charts" dir="ltr"></div>

                            </div>
                        </div>
                    </div> <!-- end col -->

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Column charts</h4>

                                <div id="column-charts" dir="ltr"></div>

                            </div>
                        </div>
                    </div> <!-- end col -->

                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Line charts</h4>

                                <div id="line-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Area charts</h4>

                                <div id="area-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Bubble charts</h4>

                                <div id="bubble-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Scatter charts</h4>

                                <div id="scatter-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Pie charts</h4>

                                <div id="pie-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Donut pie charts</h4>

                                <div id="donut-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

                <div class="row">

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Heatmap charts</h4>

                                <div id="heatmap-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Treemap charts</h4>

                                <div id="treemap-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Map charts</h4>

                                <div id="map-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Boxplot charts</h4>

                                <div id="boxplot-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                </div>
                <!-- end row -->
                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Bullet charts</h4>

                                <div id="bullet-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Radial charts</h4>

                                <div id="radial-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>

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

<!-- tui charts plugins -->
<script src="assets/libs/tui-chart/tui-chart-all.min.js"></script>

<!-- tui charts map -->
<script src="assets/libs/tui-chart/maps/usa.js"></script>

<!-- tui charts plugins -->
<script src="assets/js/pages/tui-charts.init.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>

</body>

</html>