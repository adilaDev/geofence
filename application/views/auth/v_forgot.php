<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title><?= isset($title) ? $title : "Location Technology" ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url() ?>assets/images/LOGO_ARI/logo_ari_green.svg">

    <!-- Bootstrap Css -->
    <link href="<?= base_url() ?>assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url() ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url() ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    <style>
        :root {
            --custom-primary-color: lightseagreen;
            --custom-primary-light-color: #5ee0d9;
            /* --custom-primary-dark-color: #4839eb; */
            --custom-primary-dark-color: #5046bd;
            --custom-primary-hover: #0c847d;
            --custom-primary-gradient-color: linear-gradient(47deg, #7367f0, lightseagreen);
            --white: #ffffff;
            --black: #000000;
            /* effect blur */
            --color-effect-blur: #878787;
            --color-effect-rgb-5: rgb(135 135 135 / 5%);
            --color-effect-rgb-15: rgb(135 135 135 / 15%);
            --color-effect-rgb-25: rgb(135 135 135 / 25%);
            --color-effect-rgb-35: rgb(135 135 135 / 35%);
            --color-effect-rgb-45: rgb(135 135 135 / 45%);
            --color-effect-rgb-55: rgb(135 135 135 / 55%);
            --color-effect-rgb-65: rgb(135 135 135 / 65%);
            --color-effect-rgb-75: rgb(135 135 135 / 75%);
        }

        .bg-primary {
            background-color: #20b2aa !important;
        }

        .bg-primary.bg-soft {
            background-color: rgb(32 178 170 / 25%) !important;
        }

        .btn.btn-primary {
            background-color: var(--custom-primary-color) !important;
            border-color: var(--custom-primary-color) !important;
        }

        .btn.btn-primary:hover {
            background-color: var(--custom-primary-hover) !important;
            border-color: #0c847d !important;
        }

        .btn.btn-outline-primary {
            color: var(--custom-primary-color) !important;
            border-color: var(--custom-primary-color) !important;
        }

        .btn.btn-outline-primary:hover {
            color: var(--white) !important;
            background-color: var(--custom-primary-color) !important;
            border-color: var(--custom-primary-color) !important;
        }

        .btn.btn-light-primary {
            background-color: var(--custom-primary-light-color) !important;
        }

        .btn.btn-dark-primary {
            background-color: var(--custom-primary-dark-color) !important;
        }

        .btn.btn-gradient-primary {
            background-image: var(--custom-primary-gradient-color) !important;
            color: var(--white) !important;
        }

        .text-primary {
            color: var(--custom-primary-color) !important;
        }

        .nav-tabs-custom .nav-item .nav-link.active {
            color: var(--custom-primary-color) !important;
        }

        .bg-primary {
            background-color: var(--custom-primary-color) !important;
        }

        .nav-tabs-custom .nav-item .nav-link::after {
            background: var(--custom-primary-color) !important;
        }

        .form-check-input:checked {
            background-color: var(--custom-primary-color) !important;
            border-color: var(--custom-primary-color) !important;
        }

        .card-effect {
            box-shadow: 0px 10px 15px rgb(135 135 135 / 25%) !important;
            border-radius: 10px;
        }

        .bg-gradient90 {
            background-image: linear-gradient(90deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0)) !important;
        }

        .carousel-control-next-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath d='M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
            background-size: 20px;
            background-color: rgb(0 0 0 / 50%);
            border-radius: 50%;
        }

        .carousel-control-prev-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath d='M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z'/%3e%3c/svg%3e");
            background-size: 20px;
            background-color: rgb(0 0 0 / 50%);
            border-radius: 50%;
        }

        body[data-layout-size=boxed] {
            background-color: #fefefe !important;
        }

        .topnav,
        .checkout-tabs .nav-pills .nav-link.active,
        .chase-dot:before,
        body[data-layout=horizontal][data-topbar=colored] #page-topbar {
            background-color: var(--custom-primary-color) !important;
        }

        a {
            color: var(--custom-primary-color);
        }

        a:hover,
        .nav-link:hover {
            color: var(--custom-primary-hover);
        }

        .topnav .navbar-nav .nav-item .nav-link.active,
        .topnav .navbar-nav .nav-link:focus,
        .topnav .navbar-nav .nav-link:hover {
            color: var(--white);
        }

        .btn.btn-primary:focus,
        .btn.btn-outline-primary:focus {
            box-shadow: 0 0 0 0.15rem rgb(32 178 169 / 50%);
        }

        .checkout-tabs .nav-pills .nav-link.active:hover {
            background-color: var(--custom-primary-hover) !important;
        }

        .avatar-md {
            height: 3.5rem;
            width: 3.5rem;
            border: 2px solid;
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <?php
    $lang = $this->session->userdata('language');
    $data_lang = $this->session->userdata('data_lang');
    ?>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden card-effect">
                        <div class="bg-primary bg-soft">
                            <div class="row" style="border-bottom: 2px solid #20b2aa;">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary"><?= isset($data_lang['reset_password']) ? $data_lang['reset_password'] : 'Reset Password' ?></h5>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="<?= base_url() ?>assets/images/profile-img.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <a href="javascript:void(0);">
                                    <div class="avatar-md profile-user-wid mb-3">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <!-- <i class="bx bx-home text-primary font-size-24"></i> -->
                                            <img src="<?= base_url() ?>assets/images/LOGO_ARI/logo_ari_green.svg" alt="" width="auto" height="22">
                                        </span>
                                    </div>
                                </a>
                            </div>

                            <div class="pt-0 p-2">
                                <div class="alert alert-success text-center mb-3" role="alert">
                                    <?= isset($data_lang['enter_your_email']) ? $data_lang['enter_your_email'] : 'Enter your Email and instructions will be sent to you!' ?>
                                </div>
                                <div class="alert alert-<?= (form_error('useremail')) ? 'danger' : 'info' ?> alert-dismissible fade <?= (form_error('useremail')) ? 'show' : 'd-none' ?> mb-3" role="alert">
                                    <?= form_error('useremail', '<strong><i class="bx bx-error-alt font-size-20 align-middle me-1"></i>', '</strong>') ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                                <?php if($this->session->flashdata('error_forgot')) : ?>
                                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                                        <strong><?= $this->session->flashdata('error_forgot'); ?></strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>

                                <?php if($this->session->flashdata('forgot_error')) : ?>
                                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                                        <strong><?= $this->session->flashdata('forgot_error'); ?></strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>
                                    
                                <?php if($this->session->flashdata('success_forgot')) : ?>
                                    <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                                        <strong><?= $this->session->flashdata('success_forgot'); ?></strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>

                                <form class="form-horizontal" action="<?= base_url('auth/check_forgot') ?>" method="POST">

                                    <div class="<?= (form_error('useremail')) ? 'mb-2' : 'mb-3' ?>">
                                        <label for="useremail" class="form-label"><?= isset($data_lang['email']) ? $data_lang['email'] : 'Email' ?></label>
                                        <input type="email" class="form-control" name="useremail" id="useremail" placeholder="<?= isset($data_lang['enter_email']) ? $data_lang['enter_email'] : 'Enter email' ?>">
                                    </div>
                                    <?= form_error('useremail', '<p class="text-danger">', '</p>') ?>

                                    <div class="text-end">
                                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit"><?= isset($data_lang['btn_reset']) ? $data_lang['btn_reset'] : 'Reset' ?></button>
                                    </div>

                                </form>
                            </div>

                        </div>
                        <div class="card-footer bg-white border border-2 border-bottom-0 border-end-0 border-start-0">
                            <div class="text-center">
                                <p class="mb-2">
                                    <!-- Remember It ? -->
                                    <?= $data_lang['remember'] ?>
                                    <a href="<?= base_url() ?>login" class="fw-medium text-primary">
                                        <?= $data_lang['sign_in_here'] ?>
                                    </a>
                                </p>
                                <!-- Footer -->
                                <p class="mb-0">©
                                    <script>
                                        document.write(new Date().getFullYear())
                                    </script>
                                    <b class="text-primary"><?= NAMA_WEB ?></b> Developed by
                                    <img src="<?= base_url() ?>assets/images/LOGO_ARI/logo_ari_green.svg" alt="logo" width="auto" height="12">
                                </p>
                                <!-- End Footer -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="<?= base_url() ?>assets/libs/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/metismenu/metismenu.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/node-waves/waves.min.js"></script>

    <!-- App js -->
    <script src="<?= base_url() ?>assets/js/app.js"></script>
</body>

</html>