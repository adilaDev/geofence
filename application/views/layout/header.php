<!doctype html>
<?php $lang = $this->session->userdata('language'); $my_lang = isset($lang) ? $lang : 'en'; ?>
<html lang="<?= ($my_lang == 'jp') ? 'ja' : 'en' ?>">

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
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/bootstrap.min.css" id="bootstrap-style" />
    <!-- App Css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/app.min.css" id="app-style" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/main.css" />
    <!-- Custom Css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/custom.css" />
    <script src="<?= base_url() ?>assets/libs/jquery/jquery.min.js"></script>

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
        
        function get_device() {
            let ua = navigator.userAgent.toLowerCase();
            if (ua.toLowerCase().indexOf("iphone") >= 0)  { return "iphone";  }
            if (ua.toLowerCase().indexOf("ipod") >= 0)    { return "iphone";  }
            if (ua.toLowerCase().indexOf("ipad") >= 0)    { return "iphone";  }
            if (ua.toLowerCase().indexOf("android") >= 0) { return "android"; }
            return "pc";
        }
    </script>
</head>

<body data-topbar="light" data-layout="horizontal" data-layout-size="boxed">
    
    <style type="text/css">
        .page-item.active .page-link {
            background-color: #20b2aa !important;
            border-color: #20b2aa !important;
        }
        div.dataTables_wrapper div.dataTables_paginate ul.pagination {
            margin: 10px 0 !important;
        }
        .mfp-close {
            color: #ffffff!important;
            cursor: pointer !important;
        }
        .user-chat-nav .dropdown .nav-btn#send {
            height: 35px !important;
            width: 35px !important;
        }
        @media (max-width: 575.98px){
            .chat-conversation .conversation-list .dropdown .dropdown-toggle {
                display: block !important;
            }
        }

        .hide-txtfile{
            width: 100% !important; max-width: 790px !important; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important;
        }

        .hide-text{
            width: 100% !important; max-width: 105px !important; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important;
        }
        
        @media (max-width: 652px){
            .hide-text{
                max-width: 430px !important;
            }
            .hide-txtfile{
                max-width: 430px !important;
            }
        }
        @media (max-width: 576px){
            .hide-text{
                max-width: 80px !important;
            }
            .hide-txtfile{
                max-width: 80px !important;
            }
        }
        tbody, td, tfoot, th, thead, tr {
            border-width: 1px;
        }
        .topnav .navbar-nav .nav-link{
            color: rgba(255,255,255,.6) !important;
        }
        .topnav .navbar-nav .nav-item .nav-link.active, .topnav .navbar-nav .nav-link:focus, .topnav .navbar-nav .nav-link:hover {
            color: var(--white) !important;
        }
        .dropzone .dz-preview .dz-error-message{ top: 145px !important; }
        .dropzone .dz-preview .dz-success-mark svg{ background: #20b2aa; border-radius: 50%;}
        .dropzone .dz-preview .dz-error-mark svg{ background: #b22424; border-radius: 50%;}
        .pace .pace-activity { box-shadow: inset 0 0 0 2px #20b2aa, inset 0 0 0 7.5px #fff !important; }
        .pace .pace-progress{ background: #20b2aa !important; color: #20b2aa !important;}
        /* .pace{top: 100px !important;} */
        grammarly-extension{display: none !important;}
        textarea{resize: none; overflow:hidden; width: 100% !important;}
        /* #chat-input {padding-right: 15px !important; border-radius: 5px !important;} */
        #chat-input {padding-right: 40px !important; border-radius: 5px !important;}
        #send i::before{font-size: large !important;}
        .inputfile {width: 0.1px;height: 0.1px;opacity: 1;overflow: hidden;position: absolute;z-index: -1;}
        .inputfile + label {text-overflow: ellipsis;white-space: nowrap;cursor: pointer;display: inline-block;}
        .chat-conversation .conversation-list .ctext-wrap .conversation-name,
        .chat-conversation .last-chat .conversation-list:before {/* color: #20b2aa !important; */color: #000000 !important;}
        .chat-conversation .conversation-list .ctext-wrap {background-color: rgb(32 178 170 / 10%) !important;}
        .chat-conversation .sender_msg_container .conversation-list .ctext-wrap {/* background-color: rgb(96 96 96 / 10%) !important; */background-color: rgb(239 242 247 / 100%) !important;}
    </style>

    <!-- Loader -->
    <!-- <div id="preloader">
        <div id="status">
            <div class="spinner-chase">
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
            </div>
        </div>
    </div> -->

    <!-- Begin page -->
    <div id="layout-wrapper">