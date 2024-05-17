<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title><?= isset($title) ? $title : NAMA_WEB ?></title>
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
    <div class="account-pages my-5 pt-sm-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden card-effect">
                        <div class="bg-primary bg-soft">
                            <div class="row" style="border-bottom: 2px solid #20b2aa;">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <p class="h3 text-primary py-3">Verify your email</p>
                                        <!-- <h4 class="text-primary">Verify your email</h4> -->
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="<?= base_url() ?>assets/images/LOGO_ARI/logo_ari_green.svg" alt="" width="100%" height="60" class="mb-4">
                                    <!-- <img src="<?= base_url() ?>assets/images/LOGO_ARI/new_logo/ARI_Loketech.svg" alt="" width="100%" height="70" class="mb-4"> -->
                                </div>
                            </div>
                        </div>
                        <div class="card-body py-0">
                            <div class="auth-logo">
                                <a href="javascript:void(0);" class="auth-logo-dark">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <i class="bx bx-home text-primary font-size-24"></i>
                                        </span>
                                    </div>
                                </a>
                            </div>

                            <div class="p-2 pt-0">
                                <?php if ($this->session->flashdata('error_forgot')) : ?>
                                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                                        <strong><?= $this->session->flashdata('error_forgot'); ?></strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php elseif ($this->session->flashdata('success_forgot')) : ?>
                                    <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                                        <strong><?= $this->session->flashdata('success_forgot'); ?></strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php elseif (validation_errors()) : ?>
                                    <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                                        <strong><?= validation_errors() ?></strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>

                                <?php
                                $uri = $this->uri->segment(3);
                                if (isset($uri)) {
                                    $data = explode("-", $uri);
                                    $lang = $data[0];
                                    $id = $data[1];
                                    $code = $data[2];
                                    $email = $data[3];
                                    // $data_user->token
                                }                                
                                ?>
                                <div class="content-expired d-none">
                                    <img src="<?= base_url('assets/images/error-img.png') ?>" alt="" class="img-fluid">
                                    <p class="text-danger text-center mt-2">The link has expired, or you have changed your password.</p>
                                </div>
                                <form id="form_change_password" action="<?= base_url('auth/forgot_password/') . $uri ?>" method="post" class="mb-4">
                                    <div class="mb-3">
                                        <label for="layout_pin">Please enter digit code</label>
                                        <div id="layout_pin" class="mb-1">
                                            <span id="icons">
                                                <i id="pin_success" class="bx bxs-check-circle font-size-24 align-middle text-primary ms-2 d-none"></i>
                                                <i id="pin_error" class="bx bxs-error-circle font-size-24 align-middle text-danger ms-2 d-none"></i>
                                            </span>
                                        </div>
                                        <small id="error_pin" class="text-danger"></small>
                                    </div>

                                    <div class="mb-3 input_password d-none">
                                        <label for="forgot_pass">Password</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control" name="forgot_pass" id="forgot_pass" value="<?= set_value('forgot_pass') ?>" autocomplete="off">
                                            <button type="button" class="btn btn-outline-secondary" id="forgot-password-addon">
                                                <i class="mdi mdi-eye-outline"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mb-3 input_password d-none">
                                        <label for="confirm_forgot_pass">Confirm Password</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control" name="confirm_password" id="confirm_forgot_pass" value="<?= set_value('confirm_password') ?>" autocomplete="off">
                                            <button type="button" class="btn btn-outline-secondary" id="confirm-password-addon">
                                                <i class="mdi mdi-eye-outline"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <input type="hidden" class="form-control" name="hide_id_md5" id="hide_id_md5" value="<?= empty($id) ? 'none' : $id ?>" readonly>
                                        <input type="hidden" class="form-control" name="hide_email" id="hide_email" value="<?= empty($email) ? 'none' : $email ?>" readonly>
                                        <input type="hidden" class="form-control" name="hide_code" id="hide_code" value="<?= empty($code) ? 'none' : $code ?>" readonly>
                                        <input type="hidden" class="form-control" name="hide_code_done" id="hide_code_done" readonly>
                                    </div>

                                    <div class="text-center mt-3">
                                        <button type="submit" class="btn btn-outline-primary w-lg">Submit</button>
                                    </div>
                                </form>
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

    <!-- Sweet Alerts js -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css">
    <script src="<?= base_url() ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- two-step-verification js -->
    <!-- <script src="<?= base_url() ?>assets/js/pages/two-step-verification.init.js"></script> -->
    <!-- App js -->
    <!-- <script src="<?= base_url() ?>assets/js/app.js"></script> -->

    <!-- include jQuery Pinlogin plugin -->
    <script src="<?= base_url() ?>pinLogin/dist/jquery.pinlogin.min.js"></script>
    <link href="<?= base_url() ?>pinLogin/src/jquery.pinlogin.css" rel="stylesheet" type="text/css" />

    <script>
        $(document).ready(function() {
            $("#forgot-password-addon").on('click', () => {
                $("#forgot-password-addon>i").toggleClass("mdi-eye-outline mdi-eye-off-outline");
                var type = $("#forgot-password-addon>i").hasClass("mdi-eye-off-outline") ? "text" : "password";
                $("#forgot_pass").attr("type", type);
            });

            $("#confirm-password-addon").on('click', () => {
                $("#confirm-password-addon>i").toggleClass("mdi-eye-outline mdi-eye-off-outline");
                var type = $("#confirm-password-addon>i").hasClass("mdi-eye-off-outline") ? "text" : "password";
                $("#confirm_forgot_pass").attr("type", type);
            });

            const code = '<?= $code ?>';
            console.log("code : ", code);
            var pincode = $("#layout_pin").pinlogin({
                // placeholder:, '*' // default: '•'
                fields: 6,
                hideinput: false, // default: 'true'
                autofocus: false, // default: 'true'
                reset: false,
                complete: function(pin) {
                    swicth_layout(true);
                    switch_icons((code == pincode._values.join("")));
                    $("#hide_code_done").val(pincode._values.join(""));
                    $("#error_pin").text((code == pincode._values.join("")) ? null : 'The digit code you entered is incorrect');
                    console.log(pin);
                },
                input: function(event, field, nr) {
                    // console.log("input e : ", event);
                    console.log("input pincode : ", pincode);
                    console.log("input field : ", field);
                    console.log("input value : ", pincode._values.join(""));
                    console.log("input nr : ", nr);
                    console.log("===================");
                    switch_icons((code == pincode._values.join("")));
                    $("#error_pin").text((code == pincode._values.join("")) ? null : 'The digit code you entered is incorrect');
                },
                invalid: function(field, nr) {
                    swicth_layout(false, "Invalid input, Please enter only digit number");
                    console.log("invalid field : ", $(field).val());
                    $("#hide_code_done").val(null);
                },
                keydown: function(event, field, nr) {
                    console.log("keydown event : ", event.keyCode);
                    console.log("keydown field : ", field);
                    console.log("keydown pincode : ", pincode);
                    // console.log("===================");

                    // function to check the detection
                    var key = event.which || event.keyCode; // Detecting keyCode

                    // Detecting Ctrl
                    var ctrl = event.ctrlKey ? event.ctrlKey : ((key === 17) ?
                        true : false);

                    var listOfElements = $(".pinlogin-field");
                    // If key pressed is V and if ctrl is true.
                    if (key == 86 && ctrl) {
                        // print in console.
                        console.log("Ctrl+V is pressed. ", field[0].value);

                        $(field).on("paste", function(ev) {
                            ev.preventDefault();
                            var clipboardData = ev.clipboardData || ev.originalEvent.clipboardData || window.clipboardData;
                            var pastedData = clipboardData.getData('text/plain');
                            for (var i = 0; i < listOfElements.length; i++) {
                                nr = i;
                                var data = function() {
                                    return pastedData[i];
                                }
                                $(listOfElements[i]).val(data);
                                $(listOfElements[i]).removeAttr('readonly');


                                if (i == (listOfElements.length - 1)) {
                                    $(listOfElements[listOfElements.length - 1]).select();
                                    // $(listOfElements[listOfElements.length-1]).focus();
                                    $(listOfElements[5]).val(data);
                                    swicth_layout(true);
                                    // $("#hide_code_done").val(pincode._values.join(""));
                                    $("#hide_code_done").val(pastedData);
                                }
                                pincode._values[i] = pastedData[i];
                            }
                            console.log("pastedData : ", pastedData);
                            switch_icons((code == pastedData));
                            $("#error_pin").text((code == pastedData) ? null : 'The digit code you entered is incorrect');
                        });

                    }
                    console.log("===================");
                }
                // 162345
            });

            var save_pin = '<?= set_value('layout_pin_pinlogin_0') . set_value('layout_pin_pinlogin_1') . set_value('layout_pin_pinlogin_2') .
                                set_value('layout_pin_pinlogin_3') . set_value('layout_pin_pinlogin_4') . set_value('layout_pin_pinlogin_5') ?>';

            if (save_pin != 0 || save_pin != '') {
                var aa = Array.from(String(save_pin));
                for (let i = 0; i < $(pincode._container).children().length; i++) {
                    const element = $(pincode._container).children()[i];
                    const pin = aa[i];
                    $(element).val(pin);
                    $(element).removeAttr('readonly');
                    swicth_layout(true);
                    switch_icons((code == save_pin));

                    $("#hide_code_done").val(save_pin);
                    $("#error_pin").text((code == save_pin) ? null : 'The digit code you entered is incorrect');
                }
            }

            // $(field).attr('id');
            console.log("pincode : ", pincode);
            console.log("save_pin : ", save_pin);
            $(pincode._container).append($("#icons"));
            console.log("container Pin: ", pincode._container);
        });

        function swicth_layout(is_show, txt_error = null) {
            if (is_show) {
                // show layout
                switch_icons(true);
                $("#error_pin").text(null);
                $(".input_password").removeClass("d-none");
            } else if (txt_error != null) {
                switch_icons(false);
                // $("#error_pin").text("Invalid input, Please enter only digit number");
                $("#error_pin").text(txt_error);
            } else {
                // hidden layout
                // $("#pin_success").addClass("d-none"); // hide icon check
                // $("#pin_error").removeClass("d-none"); // show icon error
                switch_icons(false);
                $(".input_password").addClass("d-none");
            }
        }

        function switch_icons(is_success) {
            if (is_success) {
                // show icon check
                $("#pin_success").removeClass("d-none"); // show icon check
                $("#pin_error").addClass("d-none"); // show icon error
            } else {
                // show icon error
                $("#pin_success").addClass("d-none"); // show icon check
                $("#pin_error").removeClass("d-none"); // show icon error
            }
        }

        const update_success = '<?= $this->session->flashdata('update_password_success') ?>';
        const update_failed = '<?= $this->session->flashdata('update_password_failed') ?>';

        if (update_success) {
            alertAutoClose(update_success, 8000, 'success', '<?= base_url('login') ?>');
        }
        if (update_failed) {
            alertAutoClose(update_failed, 8000, 'error', '<?= base_url('login') ?>');
        }

        function alertAutoClose(judul, milidetik, type, actions) {
            <?php $data_lang = $this->session->userdata('data_lang') ?>
            if (judul != "") {
                console.log("Judul : ", judul);
                // console.log("Cek Judul 1 : ", is_html(judul));
                console.log("Cek Judul 1 : ", isHTML(judul));
                console.log("Cek Judul 2 : ", isHTML('<div class="alert">Hello</div>'));
                Swal.fire({
                    title: isHTML(judul) ? $(judul).text() : judul,
                    text: '',
                    // html: 'I will close in <strong></strong> seconds.',
                    // imageUrl: '<?= base_url('assets/images/LOGO_ARI/logo_ari_green.svg') ?>',
                    // // imageWidth: 400,
                    // imageHeight: 60,
                    // imageAlt: 'Custom image',
                    icon: type,
                    allowOutsideClick: false,
                    showCancelButton: true,
                    showDenyButton: false,
                    showConfirmButton: false,
                    focusCancel: false,
                    focusDeny: false,
                    focusConfirm: false,
                    timer: milidetik,
                    timerProgressBar: true,
                    // didOpen: () => {
                    //     // Swal.showLoading();
                    //     const b = Swal.getHtmlContainer().querySelector('strong')
                    //     timerInterval = setInterval(() => {
                    //         // b.textContent = Swal.getTimerLeft(); // miliseconds
                    //         b.textContent = (Swal.getTimerLeft() / 1000).toFixed(0); // seconds
                    //     }, 100);
                    // },
                    // willClose: () => {
                    //     clearInterval(timerInterval)
                    // },
                    cancelButtonColor: "rgb(173 181 189 / 75%)", // grey color
                    confirmButtonColor: 'rgb(32 178 170 / 75%)', // primary color
                    cancelButtonText: "<?= $data_lang['close'] ?>",
                    confirmButtonText: "<?= $data_lang['close'] ?>",
                    focusConfirm: false,
                }).then(function(result) {
                    if (actions != 'no actions') {
                        window.location = actions;
                    }
                });
            }
        }

        function isHTML(testString) {
            var htmlRegex = new RegExp("<([A-Za-z][A-Za-z0-9]*)\b[^>]*>(.*?)</\1>");
            // var htmlRegex = new RegExp("/<\/?[a-z][\s\S]*>/i");
            // return htmlRegex.test(testString);
            return /<\/?[a-z][\s\S]*>/i.test(testString);
        };

        function ctrl(event) {
            (function($) {
                $.fn.jqueryPincodeAutotab = function() {
                    var listOfElements = $(this);

                    return this.each(function(index, value) {
                        $(value).on("keydown", function(event) {
                            var move = 0;
                            switch (event.keyCode) {
                                //number 0
                                case 48:
                                case 96:
                                    $(this).val("0");
                                    move = 1;
                                    event.preventDefault();
                                    break;

                                    //number 1
                                case 49:
                                case 97:
                                    $(this).val("1");
                                    move = 1;
                                    event.preventDefault();
                                    break;

                                    //number 2
                                case 50:
                                case 98:
                                    $(this).val("2");
                                    move = 1;
                                    event.preventDefault();
                                    break;

                                    //number 3
                                case 51:
                                case 99:
                                    $(this).val("3");
                                    move = 1;
                                    event.preventDefault();
                                    break;

                                    //number 4
                                case 52:
                                case 100:
                                    $(this).val("4");
                                    move = 1;
                                    event.preventDefault();
                                    break;

                                    //number 5
                                case 53:
                                case 101:
                                    $(this).val("5");
                                    move = 1;
                                    event.preventDefault();
                                    break;

                                    //number 6
                                case 54:
                                case 102:
                                    $(this).val("6");
                                    move = 1;
                                    event.preventDefault();
                                    break;

                                    //number 7
                                case 55:
                                case 103:
                                    $(this).val("7");
                                    move = 1;
                                    event.preventDefault();
                                    break;

                                    //number 8
                                case 56:
                                case 104:
                                    $(this).val("8");
                                    move = 1;
                                    event.preventDefault();
                                    break;

                                    //number 9
                                case 57:
                                case 105:
                                    $(this).val("9");
                                    move = 1;
                                    event.preventDefault();
                                    break;

                                case 8: //backspace
                                case 46: //delete
                                    $(this).val("");
                                    move = -1;
                                    event.preventDefault();
                                    break;

                                case 9: //tab
                                    if (event.shiftKey) {
                                        move = -1;
                                    } else {
                                        move = 1;
                                    }
                                    event.preventDefault();
                                    break;

                                case 86: //v
                                    if (!(event.ctrlKey || event.metaKey)) {
                                        event.preventDefault();
                                    }
                                    break;
                                case 16: //shift
                                case 17: //ctrl
                                case 91: //command in mac
                                    break;
                                case 229: //android device on chrome always returns 229 keycode
                                    var androidKeyCode = $(this).val();
                                    if ($.isNumeric(androidKeyCode)) {
                                        move = 1;
                                    }
                                    break;
                                default:
                                    event.preventDefault();
                            }

                            for (var i = 0; i < listOfElements.length; i++) {
                                var prevElement;
                                var nextElement;
                                if (i - 1 >= 0) {
                                    prevElement = listOfElements[i - 1];
                                }
                                if (i + 1 <= listOfElements.length) {
                                    nextElement = listOfElements[i + 1];
                                }
                                if (listOfElements[i] == this) {
                                    switch (move) {
                                        case 1:
                                            if (nextElement) {
                                                $(nextElement).select();
                                                $(nextElement).focus();
                                            }
                                            break;
                                        case -1:
                                            if (prevElement) {
                                                $(prevElement).select();
                                                $(prevElement).focus();
                                            }
                                            break;
                                    }
                                }
                            }
                        });

                        $(value).on("paste", function(event) {
                            event.preventDefault();
                            var clipboardData = event.clipboardData || event.originalEvent.clipboardData || window.clipboardData;
                            var pastedData = clipboardData.getData('text/plain');
                            for (var i = 0; i < listOfElements.length; i++) {
                                var data = function() {
                                    return pastedData[i];
                                }
                                $(listOfElements[i]).val(data);
                            }
                        });
                    });
                };
            }(jQuery));
        }
    </script>

</body>

</html>