<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title><?= isset($title) ? $title : 'Home' ?> | <?= NAMA_WEB_ASLI ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="<?= NAMA_WEB_ASLI ?>" name="author" />
    
    <!-- App favicon -->
    <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url() ?>assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?= base_url() ?>assets/favicon/site.webmanifest">
    <link rel="mask-icon" href="<?= base_url() ?>assets/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="<?= base_url() ?>assets/favicon/favicon.ico">
    <meta name="apple-mobile-web-app-title" content="Location Technology">
    <meta name="application-name" content="Location Technology">
    <meta name="msapplication-TileColor" content="#00aba9">
    <meta name="msapplication-config" content="<?= base_url() ?>assets/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <!-- Bootstrap Css -->
    <link media="screen" rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/bootstrap.min.css" id="bootstrap-style" />
    <!-- App Css-->
    <link media="screen" rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/app.min.css" id="app-style" />
    <link media="screen" rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/main.css" />
    <!-- Custom Css-->
    <link media="screen" rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/custom.css" />
    <script src="<?= base_url() ?>assets/libs/jquery/jquery.min.js"></script>
    <!-- <script src="<?= base_url() ?>assets/libs/simplebar/simplebar.min.js"></script> -->

    <script type="text/javascript">
        function getDeviceType(){
            const ua = navigator.userAgent;
            if (/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i.test(ua)) {
                return "tablet";
            }
            if (/Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Kindle|Silk-Accelerated|(hpw|web)OS|Opera M(obi|ini)/.test(ua)) {
                return "mobile";
            }
            return "desktop";
        }
    </script>

</head>

<body data-sidebar="dark" class="sidebar-enable">
    <!-- sidebar-enable or vertical-collpsed -->

    <!-- Begin page -->
    <div id="layout-wrapper">