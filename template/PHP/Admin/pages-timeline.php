<?php include 'layouts/session.php'; ?>
<?php include 'layouts/head-main.php'; ?>

<head>
    <title>Timeline | Skote - Admin & Dashboard Template</title>
    <?php include 'layouts/head.php'; ?>

    <!-- owl.carousel css -->
    <link rel="stylesheet" href="assets/libs/owl.carousel/assets/owl.carousel.min.css">

    <link rel="stylesheet" href="assets/libs/owl.carousel/assets/owl.theme.default.min.css">

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
                            <h4 class="mb-sm-0 font-size-18">Timeline</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Utility</a></li>
                                    <li class="breadcrumb-item active">Timeline</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Horizontal Timeline</h4>

                                <div class="hori-timeline">
                                    <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                        <div class="item event-list">
                                            <div>
                                                <div class="event-date">
                                                    <div class="text-primary mb-1">12 September</div>
                                                    <h5 class="mb-4">First event</h5>
                                                </div>
                                                <div class="event-down-icon">
                                                    <i class="bx bx-down-arrow-circle h1 text-primary down-arrow-icon"></i>
                                                </div>

                                                <div class="mt-3 px-3">
                                                    <p class="text-muted">It will be as simple as occidental in fact it will be Cambridge</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="item event-list">
                                            <div>
                                                <div class="event-date">
                                                    <div class="text-primary mb-1">06 October</div>
                                                    <h5 class="mb-4">Second event</h5>
                                                </div>
                                                <div class="event-down-icon">
                                                    <i class="bx bx-down-arrow-circle h1 text-primary down-arrow-icon"></i>
                                                </div>

                                                <div class="mt-3 px-3">
                                                    <p class="text-muted">To an English person, it will seem like simplified English existence.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="item event-list active">
                                            <div>
                                                <div class="event-date">
                                                    <div class="text-primary mb-1">25 October</div>
                                                    <h5 class="mb-4">Third event</h5>
                                                </div>
                                                <div class="event-down-icon">
                                                    <i class="bx bx-down-arrow-circle h1 text-primary down-arrow-icon"></i>
                                                </div>

                                                <div class="mt-3 px-3">
                                                    <p class="text-muted">For science, music, sport, etc, Europe uses the same vocabulary.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="item event-list">
                                            <div>
                                                <div class="event-date">
                                                    <div class="text-primary mb-1">04 November</div>
                                                    <h5 class="mb-4">Fourth event</h5>
                                                </div>
                                                <div class="event-down-icon">
                                                    <i class="bx bx-down-arrow-circle h1 text-primary down-arrow-icon"></i>
                                                </div>

                                                <div class="mt-3 px-3">
                                                    <p class="text-muted">New common language will be more simple than existing.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="item event-list">
                                            <div>
                                                <div class="event-date">
                                                    <div class="text-primary mb-1">19 November</div>
                                                    <h5 class="mb-4">Sixth event</h5>
                                                </div>
                                                <div class="event-down-icon">
                                                    <i class="bx bx-down-arrow-circle h1 text-primary down-arrow-icon"></i>
                                                </div>

                                                <div class="mt-3 px-3">
                                                    <p class="text-muted">It will be as simple as occidental in fact it will be Cambridge</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="item event-list">
                                            <div>
                                                <div class="event-date">
                                                    <div class="text-primary mb-1">21 December</div>
                                                    <h5 class="mb-4">Seventh event</h5>
                                                </div>
                                                <div class="event-down-icon">
                                                    <i class="bx bx-down-arrow-circle h1 text-primary down-arrow-icon"></i>
                                                </div>

                                                <div class="mt-3 px-3">
                                                    <p class="text-muted">To an English person, it will seem like simplified English existence.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card -->
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-5">Vertical Timeline</h4>
                                <div class="">
                                    <ul class="verti-timeline list-unstyled">
                                        <li class="event-list">
                                            <div class="event-timeline-dot">
                                                <i class="bx bx-right-arrow-circle"></i>
                                            </div>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <i class="bx bx-copy-alt h2 text-primary"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div>
                                                        <h5>Ordered</h5>
                                                        <p class="text-muted">New common language will be more simple and regular than the existing.</p>

                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="event-list">
                                            <div class="event-timeline-dot">
                                                <i class="bx bx-right-arrow-circle"></i>
                                            </div>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <i class="bx bx-package h2 text-primary"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div>
                                                        <h5>Packed</h5>
                                                        <p class="text-muted">To achieve this, it would be necessary to have uniform grammar.</p>

                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="event-list active">
                                            <div class="event-timeline-dot">
                                                <i class="bx bx-right-arrow-circle bx-fade-right"></i>
                                            </div>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <i class="bx bx-car h2 text-primary"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div>
                                                        <h5>Shipped</h5>
                                                        <p class="text-muted">It will be as simple as Occidental in fact, it will be Occidental..</p>

                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="event-list">
                                            <div class="event-timeline-dot">
                                                <i class="bx bx-right-arrow-circle"></i>
                                            </div>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <i class="bx bx-badge-check h2 text-primary"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div>
                                                        <h5>Delivered</h5>
                                                        <p class="text-muted">To an English person, it will seem like simplified English.</p>

                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
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
<!-- Right-bar -->

<!-- JAVASCRIPT -->
<?php include 'layouts/vendor-scripts.php'; ?>

<!-- owl.carousel js -->
<script src="assets/libs/owl.carousel/owl.carousel.min.js"></script>

<!-- timeline init js -->
<script src="assets/js/pages/timeline.init.js"></script>

<script src="assets/js/app.js"></script>

</body>

</html>