<?php include 'layouts/session.php'; ?>
<?php include 'layouts/head-main.php'; ?>

<head>
    <title>Orders | Skote - Admin & Dashboard Template</title>
    <?php include 'layouts/head.php'; ?>
    <!-- select2 css -->
    <link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

    <!-- bootstrap-datepicker css -->
    <link href="assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
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
                            <h4 class="mb-sm-0 font-size-18">Orders</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Crypto</a></li>
                                    <li class="breadcrumb-item active">Orders</li>
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
                                <h4 class="card-title mb-3">Orders</h4>

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#all-order" role="tab">
                                            All Orders
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#processing" role="tab">
                                            Processing
                                        </a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content p-3">
                                    <div class="tab-pane active" id="all-order" role="tabpanel">
                                        <form>
                                            <div class="row">

                                                <div class="col-xl col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Date :</label>
                                                        <input type="text" class="form-control" id="orderid-input" placeholder="Select date" data-date-format="dd M, yyyy" data-date-orientation="bottom auto" data-provide="datepicker" data-date-autoclose="true">
                                                    </div>
                                                </div>

                                                <div class="col-xl col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Coin :</label>
                                                        <select class="form-control select2-search-disable">
                                                            <option value="BTC" selected>Bitcoin</option>
                                                            <option value="ETH">Ethereum</option>
                                                            <option value="LTC">litecoin</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-xl col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Type :</label>
                                                        <select class="form-control select2-search-disable">
                                                            <option value="BU" selected>Buy</option>
                                                            <option value="SE">Sell</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-xl col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Status :</label>
                                                        <select class="form-control select2-search-disable">
                                                            <option value="CO" selected>Completed</option>
                                                            <option value="PE">Pending</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-xl col-sm-6 align-self-end">
                                                    <div class="mb-3">
                                                        <button type="button" class="btn btn-primary w-md">Add Order</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        <div class="table-responsive mt-2">
                                            <table class="table table-hover datatable dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Date</th>
                                                        <th scope="col">Type</th>
                                                        <th scope="col">Coin</th>
                                                        <th scope="col">Value</th>
                                                        <th scope="col">Value in USD</th>
                                                        <th scope="col">Status</th>
                                                    </tr>

                                                </thead>

                                                <tbody>
                                                    <tr>
                                                        <td>03 Mar, 2020</td>
                                                        <td>Buy</td>
                                                        <td>Bitcoin</td>
                                                        <td>1.00952 BTC</td>
                                                        <td>$ 9067.62</td>
                                                        <td>
                                                            <span class="badge bg-success font-size-10">Completed</span>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>04 Mar, 2020</td>
                                                        <td>Sell</td>
                                                        <td>Ethereum</td>
                                                        <td>0.00413 ETH</td>
                                                        <td>$ 2123.01</td>
                                                        <td>
                                                            <span class="badge bg-success font-size-10">Completed</span>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>04 Mar, 2020</td>
                                                        <td>Buy</td>
                                                        <td>Bitcoin</td>
                                                        <td>0.00321 BTC</td>
                                                        <td>$ 1802.62</td>
                                                        <td>
                                                            <span class="badge bg-warning font-size-10">Pending</span>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>05 Mar, 2020</td>
                                                        <td>Buy</td>
                                                        <td>Litecoin</td>
                                                        <td>0.00224 LTC</td>
                                                        <td>$ 1773.01</td>
                                                        <td>
                                                            <span class="badge bg-success font-size-10">Completed</span>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>06 Mar, 2020</td>
                                                        <td>Buy</td>
                                                        <td>Ethereum</td>
                                                        <td>1.04321 ETH</td>
                                                        <td>$ 9423.73</td>
                                                        <td>
                                                            <span class="badge bg-danger font-size-10">Failed</span>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>07 Mar, 2020</td>
                                                        <td>Sell</td>
                                                        <td>Bitcoin</td>
                                                        <td>0.00413 ETH</td>
                                                        <td>$ 2123.01</td>
                                                        <td>
                                                            <span class="badge bg-success font-size-10">Completed</span>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>07 Mar, 2020</td>
                                                        <td>Buy</td>
                                                        <td>Bitcoin</td>
                                                        <td>1.00952 BTC</td>
                                                        <td>$ 9067.62</td>
                                                        <td>
                                                            <span class="badge bg-warning font-size-10">Pending</span>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>08 Mar, 2020</td>
                                                        <td>Sell</td>
                                                        <td>Ethereum</td>
                                                        <td>0.00413 ETH</td>
                                                        <td>$ 2123.01</td>
                                                        <td>
                                                            <span class="badge bg-success font-size-10">Completed</span>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>09 Mar, 2020</td>
                                                        <td>Sell</td>
                                                        <td>Litecoin</td>
                                                        <td>1.00952 LTC</td>
                                                        <td>$ 9067.62</td>
                                                        <td>
                                                            <span class="badge bg-success font-size-10">Completed</span>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>10 Mar, 2020</td>
                                                        <td>Buy</td>
                                                        <td>Ethereum</td>
                                                        <td>0.00413 ETH</td>
                                                        <td>$ 2123.01</td>
                                                        <td>
                                                            <span class="badge bg-warning font-size-10">Pending</span>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>11 Mar, 2020</td>
                                                        <td>Buy</td>
                                                        <td>Ethereum</td>
                                                        <td>1.04321 ETH</td>
                                                        <td>$ 9423.73</td>
                                                        <td>
                                                            <span class="badge bg-success font-size-10">Completed</span>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>12 Mar, 2020</td>
                                                        <td>Sell</td>
                                                        <td>Bitcoin</td>
                                                        <td>0.00413 ETH</td>
                                                        <td>$ 2123.01</td>
                                                        <td>
                                                            <span class="badge bg-success font-size-10">Completed</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="processing" role="tabpanel">
                                        <div>
                                            <div class="table-responsive mt-4">
                                                <table class="table table-hover datatable dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Date</th>
                                                            <th scope="col">Type</th>
                                                            <th scope="col">Coin</th>
                                                            <th scope="col">Value</th>
                                                            <th scope="col">Value in USD</th>
                                                            <th scope="col">Status</th>
                                                        </tr>

                                                    </thead>

                                                    <tbody>
                                                        <tr>
                                                            <td>03 Mar, 2020</td>
                                                            <td>Buy</td>
                                                            <td>Bitcoin</td>
                                                            <td>1.00952 BTC</td>
                                                            <td>$ 9067.62</td>
                                                            <td>
                                                                <span class="badge bg-success font-size-10">Completed</span>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>04 Mar, 2020</td>
                                                            <td>Sell</td>
                                                            <td>Ethereum</td>
                                                            <td>0.00413 ETH</td>
                                                            <td>$ 2123.01</td>
                                                            <td>
                                                                <span class="badge bg-success font-size-10">Completed</span>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>04 Mar, 2020</td>
                                                            <td>Buy</td>
                                                            <td>Bitcoin</td>
                                                            <td>0.00321 BTC</td>
                                                            <td>$ 1802.62</td>
                                                            <td>
                                                                <span class="badge bg-warning font-size-10">Pending</span>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>05 Mar, 2020</td>
                                                            <td>Buy</td>
                                                            <td>Litecoin</td>
                                                            <td>0.00224 LTC</td>
                                                            <td>$ 1773.01</td>
                                                            <td>
                                                                <span class="badge bg-success font-size-10">Completed</span>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>06 Mar, 2020</td>
                                                            <td>Buy</td>
                                                            <td>Ethereum</td>
                                                            <td>1.04321 ETH</td>
                                                            <td>$ 9423.73</td>
                                                            <td>
                                                                <span class="badge bg-danger font-size-10">Failed</span>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>07 Mar, 2020</td>
                                                            <td>Sell</td>
                                                            <td>Bitcoin</td>
                                                            <td>0.00413 ETH</td>
                                                            <td>$ 2123.01</td>
                                                            <td>
                                                                <span class="badge bg-success font-size-10">Completed</span>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>07 Mar, 2020</td>
                                                            <td>Buy</td>
                                                            <td>Bitcoin</td>
                                                            <td>1.00952 BTC</td>
                                                            <td>$ 9067.62</td>
                                                            <td>
                                                                <span class="badge bg-warning font-size-10">Pending</span>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>08 Mar, 2020</td>
                                                            <td>Sell</td>
                                                            <td>Ethereum</td>
                                                            <td>0.00413 ETH</td>
                                                            <td>$ 2123.01</td>
                                                            <td>
                                                                <span class="badge bg-success font-size-10">Completed</span>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>09 Mar, 2020</td>
                                                            <td>Sell</td>
                                                            <td>Litecoin</td>
                                                            <td>1.00952 LTC</td>
                                                            <td>$ 9067.62</td>
                                                            <td>
                                                                <span class="badge bg-success font-size-10">Completed</span>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>10 Mar, 2020</td>
                                                            <td>Buy</td>
                                                            <td>Ethereum</td>
                                                            <td>0.00413 ETH</td>
                                                            <td>$ 2123.01</td>
                                                            <td>
                                                                <span class="badge bg-warning font-size-10">Pending</span>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>11 Mar, 2020</td>
                                                            <td>Buy</td>
                                                            <td>Ethereum</td>
                                                            <td>1.04321 ETH</td>
                                                            <td>$ 9423.73</td>
                                                            <td>
                                                                <span class="badge bg-success font-size-10">Completed</span>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>12 Mar, 2020</td>
                                                            <td>Sell</td>
                                                            <td>Bitcoin</td>
                                                            <td>0.00413 ETH</td>
                                                            <td>$ 2123.01</td>
                                                            <td>
                                                                <span class="badge bg-success font-size-10">Completed</span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
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
<!-- Right-bar -->

<!-- JAVASCRIPT -->
<?php include 'layouts/vendor-scripts.php'; ?>

<!-- select2 -->
<script src="assets/libs/select2/js/select2.min.js"></script>
<!-- bootstrap-datepicker js -->
<script src="assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<!-- Required datatable js -->
<script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

<!-- Responsive examples -->
<script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

<!-- init js -->
<script src="assets/js/pages/crypto-orders.init.js"></script>

<script src="assets/js/app.js"></script>

</body>

</html>