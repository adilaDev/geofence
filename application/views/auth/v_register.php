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
                    <div class="card overflow-hidden card-effect">
                        <div class="bg-primary bg-soft">
                            <div class="row" style="border-bottom: 2px solid #20b2aa;">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">
                                            <?= ($lang == 'en') ? $data_lang['free_register'] : $data_lang['free_register'] ?>
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="<?= base_url() ?>assets/images/profile-img.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0 pb-0">
                            <div>
                                <a href="javascript:void(0);">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <!-- <i class="bx bx-home text-primary font-size-24"></i> -->
                                            <img src="<?= base_url() ?>assets/images/LOGO_ARI/logo_ari_green.svg" alt="" width="auto" height="22">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <?= validation_errors('<div class="error">', '</div>'); ?>
                                <form id="form_register" class="form-row" action="<?= base_url('auth/cek_register_with_cpanel') ?>" method="POST">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="first_name" class="form-label">
                                                    <?= ($lang == 'en') ? $data_lang['first_name'] : $data_lang['first_name'] ?>
                                                </label>
                                                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="<?= $data_lang['enter_first_name'] ?>" required>
                                                <div class="invalid-feedback">
                                                    <!-- Please Enter First Name -->
                                                    <?= $data_lang['enter_first_name'] ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="last_name" class="form-label">
                                                    <?= $data_lang['last_name'] ?>
                                                </label>
                                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="<?= $data_lang['enter_last_name'] ?>" required>
                                                <div class="invalid-feedback">
                                                    <!-- Please Enter Last Name -->
                                                    <?= $data_lang['enter_last_name'] ?>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END First & Last Name -->

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="username" class="form-label">
                                                    <?= $data_lang['username'] ?>
                                                </label>
                                                <input type="text" class="form-control" name="username" id="username" placeholder="<?= $data_lang['enter_username'] ?>" required>
                                                <div class="invalid-feedback">
                                                    <!-- Please Enter Username -->
                                                    <?= $data_lang['enter_username'] ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="company" class="form-label">
                                                    <?= $data_lang['company'] ?>
                                                </label>
                                                <input type="text" class="form-control" name="company" id="company" placeholder="<?= $data_lang['company'] ?>" required>
                                                <div class="invalid-feedback">
                                                    <!-- Please Enter Email -->
                                                    <?= $data_lang['company'] ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="useremail" class="form-label">
                                                    <?= $data_lang['email'] ?>
                                                </label>
                                                <input type="email" class="form-control" name="email" id="useremail" placeholder="<?= $data_lang['enter_email'] ?>" required>
                                                <div class="invalid-feedback">
                                                    <!-- Please Enter Email -->
                                                    <?= $data_lang['enter_email'] ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="userpassword" class="form-label">
                                                    <?= $data_lang['password'] ?>
                                                </label>
                                                <div class="input-group auth-pass-inputgroup">
                                                    <input type="password" class="form-control" name="password" id="userpassword" maxlength="20" minlength="8" oninput="validasiPassword(this, 'validasi_new')" placeholder="<?= $data_lang['enter_password'] ?>" required>
                                                    <div class="invalid-feedback">
                                                        <!-- Please Enter Password -->
                                                        <?= $data_lang['enter_password'] ?>
                                                    </div>
                                                    <button class="btn btn-outline-secondary" type="button" id="toggle-new"><i class="mdi mdi-eye-outline label-icon"></i></button>
                                                </div>
                                                <small id="validasi_new" class="text-danger"><?=form_error('new_password', '', '')?></small>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-2">
                                            <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">
                                                <?= $data_lang['register'] ?></button>
                                        </div>
                                    </div>
                                    <!-- END Row -->
                                </form>
                            </div>

                    <div class="mt-2 mb-0">
                        <div id="all_validation" class="alert alert-warning" role="alert">
                            <div class="card-title"><?= !empty($this->lang->line('password_contain')) ? $this->lang->line('password_contain') : 'The password must contain at least'; ?></div>
                            <ul class="ps-0 mb-0" style="list-style: none; font-weight: bold;">
                                <li id="valid1"><i class="far fa-check-circle me-2 font-size-16 align-middle"></i><?= !empty($this->lang->line('password_length')) ? $this->lang->line('password_length') : 'Password length is between 8 to 20 characters.'; ?></li>
                                <li id="valid2"><i class="far fa-check-circle me-2 font-size-16 align-middle"></i><?= !empty($this->lang->line('minimum_uppercase')) ? $this->lang->line('minimum_uppercase') : 'Minimum 1 Uppercase letter.'; ?></li>
                                <li id="valid3"><i class="far fa-check-circle me-2 font-size-16 align-middle"></i><?= !empty($this->lang->line('minimum_lowercase')) ? $this->lang->line('minimum_lowercase') : 'Minimum 1 Lowercase letter.'; ?></li>
                                <li id="valid4"><i class="far fa-check-circle me-2 font-size-16 align-middle"></i><?= !empty($this->lang->line('minimum_digit')) ? $this->lang->line('minimum_digit') : 'Minimum 1 Numeric digit and.'; ?></li>
                                <li id="valid5"><i class="far fa-check-circle me-2 font-size-16 align-middle"></i><?= !empty($this->lang->line('minimum_symbol')) ? $this->lang->line('minimum_symbol') : 'Minimum 1 symbol.'; ?></li>
                            </ul>
                        </div>
                    </div>
                        </div>

                        <div class="card-footer bg-white border border-2 border-bottom-0 border-end-0 border-start-0">
                            <div class="text-center">
                                <p class="mb-2">
                                    <?= $data_lang['already_account'] ?>
                                    <a href="<?= base_url() ?>login" class="fw-medium text-primary">
                                        <?= $data_lang['login'] ?>
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
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/metismenu/metismenu.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/node-waves/waves.min.js"></script>

    <!-- Sweet Alert-->
    <link href="<?= base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- Sweet Alerts js -->
    <script src="<?= base_url() ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>


    <!-- validation init -->
    <script src="<?= base_url() ?>assets/js/pages/validation.init.js"></script>

    <!-- App js -->
    <script src="<?= base_url() ?>assets/js/app.js"></script>

    <script>
        var userpassword = $("#userpassword");
        const regexPanjang = /^.{8,20}$/, // 8 hingga 20 karakter
        regexHurufKapital = /[A-Z]/, // Setidaknya 1 huruf kapital
        regexHurufKecil = /[a-z]/, // Setidaknya 1 huruf kecil
        regexAngka = /[0-9]/, // Setidaknya 1 angka
        regexSimbol = /[!@#$%^&*()_+{}\[\]:;<>,.?~\\-]/; // Setidaknya 1 simbol
        
        let invalid_pass = "<?= !empty($this->lang->line('password_invalid')) ? $this->lang->line('password_invalid') : 'Password is invalid, please check the password criteria.'; ?>";
        let invalid_new_pass = "<?= !empty($this->lang->line('new_password_invalid')) ? $this->lang->line('new_password_invalid') : 'New Password is invalid, please check the password criteria.'; ?>";
        let invalid_confirm_pass = "<?= !empty($this->lang->line('confirm_password_invalid')) ? $this->lang->line('confirm_password_invalid') : 'The Confirm Password field does not match the New Password field.'; ?>";

        document.getElementById("form_register").addEventListener('submit', checkPassword);

        $(document).ready(function() {
            $("#toggle-new").on('click', function () {
                if ($(this).siblings('input').length > 0) {
                    $(this).siblings('input').attr('type') == "password" ? $(this).siblings('input').attr('type', 'input') : $(this).siblings('input').attr('type', 'password');
                }
            });

            setTimeout(() => {
                // $('input').val(null);
                $("input").each((i, e) => {
                    $(e).val(null);
                });
            }, 500);
            console.log("all input: ", $('input'));
            console.log("all preloader: ", $('#preloader'));
        });

        function validasiPassword(input, id_error) {
            var id_pass = input.id,
            pass_new = $("#new_password").val(),
            pass_confirm = $("#confirm_password").val();

            const password = input.value;
            
            const show_hide_ui_valid = function (){
                const all_validation = $("#all_validation"),
                valid1 = $("#valid1"),
                valid2 = $("#valid2"),
                valid3 = $("#valid3"),
                valid4 = $("#valid4"),
                valid5 = $("#valid5");
                if (password == "" && password.length == 0) {
                    valid1.removeClass();
                    valid2.removeClass();
                    valid3.removeClass();
                    valid4.removeClass();
                    valid5.removeClass();
                } else {
                    
                    // valid 1
                    if(regexPanjang.test(password)) {
                        valid1.removeClass("text-danger"); valid1.addClass("text-primary");
                    } else {
                        valid1.removeClass("text-primary"); valid1.addClass("text-danger");
                    }
                    
                    // valid 2
                    if(regexHurufKapital.test(password)) {
                        valid2.removeClass("text-danger"); valid2.addClass("text-primary");
                    } else {
                        valid2.removeClass("text-primary"); valid2.addClass("text-danger");
                    }
                    
                    // valid 3
                    if(regexHurufKecil.test(password)) {
                        valid3.removeClass("text-danger"); valid3.addClass("text-primary");
                    } else {
                        valid3.removeClass("text-primary"); valid3.addClass("text-danger");
                    }
                    
                    // valid 4
                    if(regexAngka.test(password)) {
                        valid4.removeClass("text-danger"); valid4.addClass("text-primary");
                    } else {
                        valid4.removeClass("text-primary"); valid4.addClass("text-danger");
                    }
                    
                    // valid 5
                    if(regexSimbol.test(password)) {
                        valid5.removeClass("text-danger"); valid5.addClass("text-primary"); 
                    } else {
                        valid5.removeClass("text-primary"); valid5.addClass("text-danger");
                    }
                }
            };
            show_hide_ui_valid();

            if (password != "" && password.length != 0) {
                if (id_pass != "old_password") {
                    if (regexPanjang.test(password) && regexHurufKapital.test(password) && regexHurufKecil.test(password) && regexAngka.test(password) && regexSimbol.test(password)) {
                        document.getElementById(id_error).innerText = ""; // Password valid
                        // check apakah new password dan confirm password sama atau tidak
                        if (id_pass == 'confirm_password') {
                            if (pass_new == pass_confirm) {
                                document.getElementById(id_error).innerText = ""; // Password valid
                            } else {
                                // document.getElementById(id_error).innerText = "The Confirm Password field does not match the New Password field."; // Password valid
                                document.getElementById(id_error).innerText = invalid_confirm_pass; // Password valid
                            }
                        }
                    } else {
                        // document.getElementById(id_error).innerText = "Password is invalid, please check the password criteria.";
                        document.getElementById(id_error).innerText = invalid_pass;
                    }
                }
            } else {
                document.getElementById(id_error).innerText = "";
            }
        }
    
        function checkPassword(e){
            var user_password = document.getElementById("userpassword").value;
            let new_valid = ((regexPanjang.test(user_password) && regexHurufKapital.test(user_password) && regexHurufKecil.test(user_password) && regexAngka.test(user_password) && regexSimbol.test(user_password)));
            
            const valid = {
                "new_password": {
                    "value": user_password,
                    "valid" : new_valid
                },
            }
            console.log("validasi: ", valid);

            // jika sama validasi lagi 
            if (new_valid) {
                // jika semua sudah true kirim dan simpan perubahan
                $("#form_register").submit();
            } else {
                e.preventDefault();
                if (!new_valid) {
                    // document.getElementById("validasi_new").innerText = "Password is invalid, please check the password criteria.";
                    document.getElementById("validasi_new").innerText = invalid_new_pass;
                }
            }
        }
    </script>
    <script>
        const login_failed = '<?= $this->session->flashdata('login_failed'); ?>';
        const register_success = '<?= $this->session->flashdata('register_success'); ?>';
        const register_failed = '<?= $this->session->flashdata('register_failed'); ?>';
        console.log("login_failed : ", login_failed);
        console.log("register_success : ", register_success);

        window.onload = () => {
            if (login_failed) {
                autocloseSweetAlert(login_failed, 5000, "error");
            }
            if (register_failed) {
                autocloseSweetAlert(register_failed, 5000, "error");
            }
            if (register_success) {
                autocloseSweetAlert(register_success, 5000, "success");
            }
        }

        function autocloseSweetAlert(judul, milidetik, actions) {

            Swal.fire({
                title: judul,
                html: 'I will close in <strong></strong> seconds.',
                icon: actions,
                allowOutsideClick: false,
                showCancelButton: false,
                showDenyButton: false,
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
                cancelButtonText: "<?= $data_lang['close'] ?>",
                confirmButtonText: "<?= $data_lang['close'] ?>",
                focusConfirm: false,
            }).then(function(result) {
                // window.location = '<?= base_url('register') ?>';
                // window.location = actions;
            });
        }
    </script>

</body>

</html>