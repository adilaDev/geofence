<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Email Verification | Skote - Admin & Dashboard Template</title>
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

        .card-effect {
            box-shadow: 0px 10px 15px rgb(135 135 135 / 25%) !important;
            border-radius: 10px;
        }

        .bg-gradient90 {
            background-image: linear-gradient(90deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0)) !important;
        }

        a {
            color: var(--custom-primary-color);
        }

        a:hover,
        .nav-link:hover {
            color: var(--custom-primary-hover);
        }

        .btn.btn-primary:focus,
        .btn.btn-outline-primary:focus {
            box-shadow: 0 0 0 0.15rem rgb(32 178 169 / 50%);
        }
    </style>
</head>

<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card card-effect">

                        <div class="card-body">

                            <?php
                            $lang = $this->session->userdata("language");
                            $uri_lang = explode("_", $this->uri->segment(3));
                            if ($lang != $uri_lang[count($uri_lang) - 1]) {
                                $lang = $uri_lang[count($uri_lang) - 1];
                            }

                            if (isset($data['data_user'])) {
                                $token = $data['data_user']->token;
                            }
                            ?>
                            <div class="p-2">
                                <?php if (!isset($data['data_user'])) : ?>
                                    <div class="text-center">
                                        <div class="avatar-md mx-auto">
                                            <div class="avatar-title rounded-circle bg-danger">
                                                <i class="bx bx-error align-middle" style="font-size: xxx-large;"></i>
                                            </div>
                                        </div>
                                        <div class="p-2 mt-4">
                                            <h4><?= ($lang == 'jp') ? '検証エラー' : 'Verification Error' ?></h4>
                                            <p><?= ($lang == 'jp') ? '予期せぬエラーが発生した' : 'An unexpected error occurred' ?></p>
                                            <div class="mt-4">
                                                <a href="<?= base_url() ?>" class="btn btn-outline-danger w-md"><?= ($lang == 'jp') ? '家に帰る' : 'Back to home' ?></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php elseif ($token == 'Verify expired') : ?>
                                    <div class="text-center">
                                        <div class="avatar-md mx-auto">
                                            <div class="avatar-title rounded-circle bg-warning" style="background-color: rgb(241 180 76 / 65%)!important;">
                                                <img src="<?= base_url() ?>assets/images/LOGO_ARI/logo_ari_black.svg" alt="" height="30" class="auth-logo-dark mx-auto">
                                            </div>
                                        </div>
                                        <div class="p-2 mt-4">
                                            <h4><?= ($lang == 'jp') ? 'おめでとう' : 'Failed to verify' ?></h4>
                                            <p class="text-muted mb-0"><?= ($lang == 'jp') ? 'リンクの有効期限が切れているか、おそらくあなたのアカウントは確認されています' : 'The link has expired or maybe your account has been verified' ?></p>
                                            <div class="mt-3">
                                                <a href="<?= base_url() ?>" class="btn btn-outline-warning w-md"><?= ($lang == 'jp') ? '家に帰る' : 'Back to home' ?></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div class="text-center">
                                        <div class="avatar-md mx-auto">
                                            <div class="avatar-title rounded-circle bg-primary">
                                                <img src="<?= base_url() ?>assets/images/LOGO_ARI/logo_ari_white.svg" alt="" height="30" class="auth-logo-dark mx-auto">
                                            </div>
                                        </div>
                                        <div class="p-2 mt-4">
                                            <h4><?= ($lang == 'jp') ? 'おめでとう' : 'Congratulations' ?></h4>
                                            <p><?= ($lang == 'jp') ? 'あなたのアカウントは' : 'Your account has been' ?> <span class="fw-semibold"><?= ($lang == 'jp') ? '正常に検証されました' : 'successfully verified' ?></span></p>
                                            <div class="mt-4">
                                                <a href="<?= base_url() ?>" class="btn btn-outline-primary w-md"><?= ($lang == 'jp') ? '家に帰る' : 'Back to home' ?></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                    <div class="text-center">
                        <p>©
                            <script>
                                document.write(new Date().getFullYear())
                            </script> <?= NAMA_WEB ?>. <?= ($lang == 'jp') ? 'によって開発された' : 'Developed by' ?> <img src="<?= base_url() ?>assets/images/LOGO_ARI/logo_ari_green.svg" alt="" height="10px">
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="<?= base_url() ?>assets/libs/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/node-waves/waves.min.js"></script>

    <!-- App js -->
    <script src="<?= base_url() ?>assets/js/app.js"></script>
</body>

</html>