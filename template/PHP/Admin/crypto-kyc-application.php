<?php include 'layouts/session.php'; ?>
<?php include 'layouts/head-main.php'; ?>

<head>
    <title>KYC Application | Skote - Admin & Dashboard Template</title>
    <?php include 'layouts/head.php'; ?>
    <!-- Plugins css -->
    <link href="assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" />
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
                            <h4 class="mb-sm-0 font-size-18">KYC Application</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Crypto</a></li>
                                    <li class="breadcrumb-item active">KYC Application</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row justify-content-center mt-lg-5">
                    <div class="col-xl-5 col-sm-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-10">
                                            <h4 class="mt-4 fw-semibold">KYC Verification</h4>
                                            <p class="text-muted mt-3">Itaque earum rerum hic tenetur a sapiente delectus ut aut reiciendis perferendis asperiores repellat.</p>

                                            <div class="mt-4">
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verificationModal">
                                                    Click here for Verification
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row justify-content-center mt-5 mb-2">
                                        <div class="col-sm-6 col-8">
                                            <div>
                                                <img src="assets/images/verification-img.png" alt="" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="verificationModal" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Verify your Account</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <div id="kyc-verify-wizard">
                                                    <!-- Personal Info -->
                                                    <h3>Personal Info</h3>
                                                    <section>
                                                        <form>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label for="kycfirstname-input" class="form-label">First name</label>
                                                                        <input type="text" class="form-control" id="kycfirstname-input" placeholder="Enter First name">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label for="kyclastname-input" class="form-label">Last name</label>
                                                                        <input type="text" class="form-control" id="kyclastname-input" placeholder="Enter Last name">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label for="kycphoneno-input" class="form-label">Phone</label>
                                                                        <input type="text" class="form-control" id="kycphoneno-input" placeholder="Enter Phone number">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label for="kycbirthdate-input" class="form-label">Date of birth</label>
                                                                        <input type="text" class="form-control" id="kycbirthdate-input" placeholder="Enter Date of birth">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="mb-3">
                                                                        <label for="kycselectcity-input" class="form-label">City</label>
                                                                        <select class="form-select" id="kycselectcity-input">
                                                                            <option value="SF" selected>San Francisco</option>
                                                                            <option value="LA">Los Angeles</option>
                                                                            <option value="SD">San Diego</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </section>

                                                    <!-- Confirm email -->
                                                    <h3>Confirm email</h3>
                                                    <section>
                                                        <form>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label for="basicpill-pancard-input">PAN Card</label>
                                                                        <input type="text" class="form-control" id="basicpill-pancard-input" placeholder="PAN Card No.">
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label for="basicpill-vatno-input">VAT/TIN No.</label>
                                                                        <input type="text" class="form-control" id="basicpill-vatno-input" placeholder="VAT/TIN No">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label for="basicpill-cstno-input">CST No.</label>
                                                                        <input type="text" class="form-control" id="basicpill-cstno-input" placeholder="CST No.">
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label for="basicpill-servicetax-input">Service Tax No.</label>
                                                                        <input type="text" class="form-control" id="basicpill-servicetax-input" placeholder="Service Tax No.">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label for="basicpill-companyuin-input">Company UIN</label>
                                                                        <input type="text" class="form-control" id="basicpill-companyuin-input" placeholder="Company UIN">
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label for="basicpill-declaration-input">Declaration</label>
                                                                        <input type="text" class="form-control" id="basicpill-Declaration-input" placeholder="Declaration">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </section>

                                                    <!-- Document Verification -->
                                                    <h3>Document Verification</h3>
                                                    <section>
                                                        <div>
                                                            <h5 class="font-size-14 mb-3">Upload document file for a verification</h5>
                                                            <div class="kyc-doc-verification mb-3">
                                                                <form action="#" class="dropzone">
                                                                    <div class="fallback">
                                                                        <input name="file" type="file" multiple="multiple">
                                                                    </div>
                                                                    <div class="dz-message needsclick">
                                                                        <div class="mb-3">
                                                                            <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                                                                        </div>

                                                                        <h4>Drop files here or click to upload.</h4>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </section>

                                                </div>
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

<!-- jquery step -->
<script src="assets/libs/jquery-steps/build/jquery.steps.min.js"></script>

<!-- dropzone js -->
<script src="assets/libs/dropzone/min/dropzone.min.js"></script>

<!-- init js -->
<script src="assets/js/pages/crypto-kyc-app.init.js"></script>

<script src="assets/js/app.js"></script>

</body>

</html>