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

    <!-- Sweet Alert-->
    <link href="<?= base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

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

        .bg-primary.bg-soft-50 {
            background-color: rgb(32 178 170 / 50%) !important;
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
        
        .facebook {
            background-color: #556ee6 !important;
        }

        .facebook:hover {
            background-color: #2b44bc !important;
        }

        .google:hover {
            background-color: #e8e9ec !important;
        }

        .line_or {
            display: flex;
            flex-direction: row;
        }

        .line_or::before {
            content: "";
            flex: 1 1;
            border-bottom: 2px solid #ced4da;
            margin: auto 10px auto 0px;
        }

        .line_or::after {
            content: "";
            flex: 1 1;
            border-bottom: 2px solid #ced4da;
            margin: auto 0px auto 10px;
        }
    </style>

</head>

<body>

    <?php
    $lang = $this->session->userdata('language');
    $data_lang = $this->session->userdata('data_lang');
    ?>

    <!-- Loader -->
    <div id="preloader" style="background-color: rgba(0, 0, 0, 0.6) !important;">
        <div id="status" style="width: auto; height: auto; padding: 20px; border-radius: 12px; left: 48%; background-color: rgb(37, 37, 37);">
            <div class="spinner-chase">
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
            </div>
        </div>
    </div>

    <div class="account-pages pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row" style="border-bottom: 2px solid #20b2aa;">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">
                                            <?= (!empty($this->lang->line('welcome_back'))) ? $this->lang->line('welcome_back') : "Welcome Back" ?>
                                        </h5>
                                        <p>
                                            <?= (!empty($this->lang->line('login_continue'))) ? $this->lang->line('login_continue') : "Signin to continue" ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="<?= base_url() ?>assets/images/profile-img.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="auth-logo">

                                <a href="javascript:void(0);" class="auth-logo-dark">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <!-- <i class="bx bx-home text-primary font-size-24"></i> -->
                                            <img src="<?= base_url() ?>assets/images/LOGO_ARI/logo_ari_green.svg" alt="" width="auto" height="22">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <div class="mb-3"><?= $this->session->flashdata('message_login'); ?></div>
                                <form action="<?= base_url('auth/cek_login') ?>" method="post">

                                    <div class="div-email mb-3">
                                        <label for="email" class="form-label">
                                            <?= ($lang == 'en') ? $data_lang['email'] : $data_lang['email'] ?>
                                        </label>
                                        <input type="email" id="email" name="email" class="form-control" value="<?= set_value('email') ?>" placeholder="Enter Email">
                                        <div class="invalid-feedback invalid-email" style="display: block;"><?= form_error('email') ?></div>
                                    </div>

                                    <!-- <div class="<?= form_error('password') ? "div-password mb-5" : "div-password" ?>"> -->
                                    <div class="mb-3">
                                        <div class="float-end">
                                            <a href="<?= base_url() ?>forgot" class="text-muted">
                                                <?= ($lang == 'en') ? $data_lang['forgot_password'] : $data_lang['forgot_password'] ?>?
                                            </a>
                                        </div>
                                        <label class="form-label">
                                            <?= ($lang == 'en') ? $data_lang['password'] : $data_lang['password'] ?>
                                        </label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" id="password" name="password" class="form-control"  value="<?= set_value('password') ?>" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon">
                                            <button class="btn btn-light" type="button" id="password-addon"><i class="mdi mdi-eye-outline label-icon"></i></button>
                                        </div>
                                        <div class="invalid-feedback invalid-password" style="display: block;"><?= form_error('password') ?></div>
                                    </div>
                                    <!-- </div> -->
                                    
                                    <div class="col-12 my-2 d-none">
                                        <h-captcha id="signupCaptcha" site-key="781559eb-513a-4bae-8d29-d4af340e3624" theme="light" size="normal" tabindex="0"></h-captcha>
                                        <input type="hidden" id="captcha_login" name="captcha_login">
                                        <div class="invalid-feedback invalid-password" style="display: block;"><?= form_error('captcha_login') ?></div>
                                    </div>

                                    <div class="mt-3 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">
                                            <?= ($lang == 'en') ? $data_lang['btn_login'] : $data_lang['btn_login'] ?>
                                        </button>
                                    </div>

                                </form>
                                
                            </div>

                        </div>
                        <div class="card-footer bg-white border border-2 border-bottom-0 border-end-0 border-start-0">
                            <div class="text-center">
                                <p class="mb-2">
                                    Don't have an account? <a href="<?= base_url('register') ?>" class="fw-medium text-primary">Register</a>
                                </p>
                                <div>
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
    </div>
    <!-- end account-pages -->

    <!-- JAVASCRIPT -->
    <script src="<?= base_url() ?>assets/libs/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/metismenu/metismenu.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/node-waves/waves.min.js"></script>

    <!-- App js -->
    <script src="<?= base_url() ?>assets/js/app.js"></script>
    
    <!-- Sweet Alert-->
    <link href="<?= base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- Sweet Alerts js -->
    <script src="<?= base_url() ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- Script success -->
    <script>
        const alert_sukses = '<?= ($this->session->flashdata('login_success') == '') ? '' : 'Login Successfull' ?>';
        const alert_quote = '<?= $this->session->flashdata('login_failed') ?>';
        const alert_gagal = '<?= $this->session->flashdata('gagal') ?>';
        const lang = '<?= $this->session->userdata('language'); ?>';
        
        $(window).on('load', function() {
            if (alert_sukses == 'Login Successfull') {
                autocloseSweetAlert(alert_sukses, 'success', 1000, '<?= base_url('home') ?>');
                // Swal.fire({
                //     title: alert_sukses,
                //     icon: "success",
                //     allowOutsideClick: false,
                //     showCancelButton: false,
                //     cancelButtonColor: "rgb(173 181 189 / 75%)", // grey color
                //     cancelButtonText: "<?= $data_lang['close'] ?>",
                //     confirmButtonColor: 'rgb(32 178 170 / 75%)', // primary
                //     // confirmButtonColor: '#f27473', // danger
                //     showConfirmButton: true,
                //     confirmButtonText: "<?= $data_lang['close'] ?>",
                //     closeOnConfirm: false

                // }).then(function(isConfirm) {
                //     if (isConfirm.value) {
                //         window.location = '<?= base_url($this->session->flashdata('after_login')) ?>';
                //     }
                // });
            }

            if (alert_quote) {
                Swal.fire({
                    title: alert_quote,
                    // text: msg_alert,
                    icon: "error",
                    allowOutsideClick: false,
                    showCancelButton: false,
                    cancelButtonColor: "rgb(173 181 189 / 75%)", // grey color
                    cancelButtonText: "<?= $data_lang['close'] ?>",
                    // confirmButtonColor: 'rgb(32 178 170 / 75%)', // primary
                    confirmButtonColor: '#f27473', // danger
                    showConfirmButton: true,
                    confirmButtonText: "<?= $data_lang['close'] ?>",
                    closeOnConfirm: false

                }).then(function(isConfirm) {
                    // if (isConfirm.value) {
                    //     window.location = '<?= base_url() ?>history';
                    // }
                });
            }

            if (alert_gagal) {
                Swal.fire({
                    title: alert_gagal,
                    // text: msg_alert,
                    icon: "error",
                    allowOutsideClick: false,
                    showCancelButton: false,
                    cancelButtonColor: "rgb(173 181 189 / 75%)", // grey color
                    cancelButtonText: "<?= $data_lang['close'] ?>",
                    confirmButtonColor: '#f27473', // danger
                    showConfirmButton: true,
                    confirmButtonText: "<?= $data_lang['close'] ?>",
                    closeOnConfirm: false

                }).then(function(isConfirm) {
                    // if (isConfirm.value) {
                    //     window.location = '<?= base_url() ?>history';
                    // }
                });
            }

        });

        
        function autocloseSweetAlert(judul, type, milidetik, actions) {
            Swal.fire({
                title: judul,
                html: 'I will close in <strong></strong> seconds.',
                icon: type,
                allowOutsideClick: false,
                showCancelButton: false,
                showDenyButton: false,
                showConfirmButton: false,
                timer: milidetik,
                timerProgressBar: true,
                didOpen: () => {
                    // Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('strong')
                    timerInterval = setInterval(() => {
                        // b.textContent = Swal.getTimerLeft(); // miliseconds
                        b.textContent = (Swal.getTimerLeft() / 1000).toFixed(0); // seconds
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval)
                },
                cancelButtonColor: "rgb(173 181 189 / 75%)", // grey color
                confirmButtonColor: 'rgb(32 178 170 / 75%)', // primary color
                cancelButtonText: "Close",
                confirmButtonText: "OK",
                focusConfirm: false,
            }).then(function(result) {
                // window.location = '<?= base_url('product/cart') ?>';
                window.location = actions;
            });
        }

    </script>
    
</body>

</html>