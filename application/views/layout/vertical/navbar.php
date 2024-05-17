<?php
$data_user = $this->session->userdata("data_login");
$first_name = "";
$last_name = "";
$username = "";
$foto = "";
$sp_foto = "";
$lang = $this->session->userdata('language');
$data_lang = $this->session->userdata('data_lang');

if (isset($data_user)) {
    $first_name  = $data_user['first_name'];
    $last_name  = $data_user['last_name'];
    $username  = $data_user['username'];
    // $foto = base_url() . $data_user['photo_profil'];
    $foto = $data_user['photo_profil'];
    $sp_foto = explode("/", $foto);
}
?>
<style>
    .header-profile-user{
        width: 40px !important;
        height: 40px !important;
        /* height: 100% !important; */
    }
</style>
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="<?= base_url() ?>home" class="logo logo-light">
                            <span class="custom_logo logo-md d-lg-none d-sm-block">
                                <div class="d-flex justify-content-center">
                                    <img src="<?= base_url() ?>assets/images/LOGO_ARI/logo_ari_white.svg" alt="" class="mt-2" width="45" height="45">
                                    <!--<img src="https://ltinternal.asiaresearchinstitute.com/assets/images/LOGO_ARI/logo_ari_white.svg" class="d-flex justify-content-center mt-2" width="50px" height="50px">-->
                                </div>
                            </span>
                            <span class="logo-lg">
                                <img loading="lazy" src="<?= base_url() ?>assets/images/LOGO_ARI/logo_ari_white.png" alt="logo" height="50">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>

                    <!-- App Search-->
                    <!-- <form class="app-search d-none d-lg-block">
                        <div class="position-relative">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="bx bx-search-alt"></span>
                        </div>
                    </form> -->
                </div>

                <div class="d-flex">

                    <div class="dropdown d-inline-block d-lg-none ms-2">
                        <button type="button" class="btn header-item noti-icon waves-effect"
                            id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-search-dropdown">

                            <form class="p-3">
                                <div class="form-group m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search ..."
                                            aria-label="Recipient's username">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit"><i
                                                    class="mdi mdi-magnify"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Change Language -->
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php if ($lang == 'en') : ?>
                                <img id="header-lang-img" src="<?= base_url() ?>assets/images/flags/us.jpg" alt="Header Language" height="20" class="card-effect" style="border: 2px solid; border-radius: unset;">
                            <?php else : ?>
                                <img id="header-lang-img" src="<?= base_url() ?>assets/images/flags/japan.png" alt="Header Language" height="20" class="card-effect" style="border: 2px solid; border-radius: unset;">
                            <?php endif; ?>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">

                            <!-- language en -->
                            <a href="<?= site_url('lang/translate/en') ?>" onclick="changeLang('us')" class="dropdown-item notify-item language <?= ($lang == 'en') ? 'active' : '' ?>" data-lang="eng">
                                <img src="<?= base_url() ?>assets/images/flags/us.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">English</span>
                            </a>
                            <!-- language jp -->
                            <a href="<?= site_url('lang/translate/jp') ?>" onclick="changeLang('ja')" class="dropdown-item notify-item language <?= ($lang == 'jp') ? 'active' : '' ?>" data-lang="ja">
                                <img src="<?= base_url() ?>assets/images/flags/japan.png" alt="user-image" class="me-1" height="12"> <span class="align-middle">Japan</span>
                            </a>

                        </div>
                    </div>

                    <!-- Profile User -->
                    <div class="dropdown d-inline-block d-none <?= (isset($data_user) && !empty($data_user)) ? "" : "d-none" ?>">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <!-- <img loading="lazy" class="rounded-circle header-profile-user" src="<?= $foto ?>" alt="Header Avatar"> -->
                            <?php $name = '';
                            if (empty($last_name)) {
                                $name = empty($first_name) ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $first_name[0];
                            } else {
                                // $name = $first_name[0] . $last_name[0];
                                $name = (empty($first_name) && empty($last_name)) ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $first_name[0] . $last_name[0];
                            }
                            ?>
                            <?php if ($foto == null || empty($foto)) : ?>
                                <!-- Jika tidak ada foto yg diupload user -->
                                <b class="header-profile-user rounded-circle bg-transparent border border-primary border-2 text-primary bg-primary bg-soft px-1 custom-avatar"><?= $name ?></b>
                            <?php elseif(strpos($foto, 'http://') !== false || strpos($foto, 'https://') !== false) : ?>
                                <!-- Jika ada foto yg di ambil dari google account -->
                                <img loading="lazy" class="rounded-circle header-profile-user" src="<?= $foto ?>" alt="<?= $name ?>">
                            <?php else : ?>
                                <!-- Jika ada foto yg di upload user -->
                                <img loading="lazy" class="rounded-circle header-profile-user" src="<?= base_url() . $foto ?>" alt="<?= $name ?>">
                            <?php endif; ?>
                            <span class="d-none d-xl-inline-block ms-1" key="t-henry"><?= $first_name ?></span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item" target="_blank" href="<?=base_url('profile')?>"><i class="bx bx-user font-size-16 align-middle me-1"></i>
                                <span key="t-profile"><?= !empty($this->lang->line('my_account')) ? $this->lang->line('my_account') : 'Profile'; ?></span></a>
                            <a class="dropdown-item text-danger" href="<?=base_url('auth/logout')?>" id="btn-logout">
                                <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                                <span key="t-logout"><?= !empty($this->lang->line('logout')) ? $this->lang->line('logout') : 'Logout'; ?></span>
                            </a>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                            <i class="bx bx-cog bx-spin"></i>
                        </button>
                    </div>

                </div>
            </div>
        </header>
        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title" key="t-menu">Menu</li>
        
                        <li>
                            <a target="_blank" href="<?= base_url() ?>template/Ajax/#javascript: void(0);" class="waves-effect">
                                <i class="bx bx-home-circle"></i><span class="badge rounded-pill bg-info float-end">04</span>
                                <span key="t-dashboards">Dashboards</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#index.html" key="t-default">Default</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#dashboard-saas.html" key="t-saas">Saas</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#dashboard-crypto.html" key="t-crypto">Crypto</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#dashboard-blog.html" key="t-blog">Blog</a></li>
                            </ul>
                        </li>
        
                        <li>
                            <a target="_blank" href="<?= base_url() ?>template/Ajax/#javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-layout"></i>
                                <span key="t-layouts">Layouts</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/#javascript: void(0);" class="has-arrow" key="t-vertical">Vertical</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#layouts-light-sidebar.html" key="t-light-sidebar">Light Sidebar</a></li>
                                        <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#layouts-compact-sidebar.html" key="t-compact-sidebar">Compact Sidebar</a></li>
                                        <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#layouts-icon-sidebar.html" key="t-icon-sidebar">Icon Sidebar</a></li>
                                        <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#layouts-boxed.html" key="t-boxed-width">Boxed Width</a></li>
                                        <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#layouts-preloader.html" key="t-preloader">Preloader</a></li>
                                        <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#layouts-colored-sidebar.html" key="t-colored-sidebar">Colored Sidebar</a></li>
                                        <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#layouts-scrollable.html" key="t-scrollable">Scrollable</a></li>
                                    </ul>
                                </li>
        
                                <li>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/#javascript: void(0);" class="has-arrow" key="t-horizontal">Horizontal</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#layouts-horizontal.html" key="t-horizontal">Horizontal</a></li>
                                        <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#layouts-hori-topbar-light.html" key="t-topbar-light">Topbar light</a></li>
                                        <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#layouts-hori-boxed-width.html" key="t-boxed-width">Boxed width</a></li>
                                        <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#layouts-hori-preloader.html" key="t-preloader">Preloader</a></li>
                                        <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#layouts-hori-colored-header.html" key="t-colored-topbar">Colored Header</a></li>
                                        <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#layouts-hori-scrollable.html" key="t-scrollable">Scrollable</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
        
                        <li class="menu-title" key="t-apps">Apps</li>
        
                        <li>
                            <a target="_blank" href="<?= base_url() ?>template/Ajax/#calendar.html" class="waves-effect">
                                <i class="bx bx-calendar"></i>
                                <span key="t-chat">Calendar</span>
                            </a>
                        </li>
        
                        <li>
                            <a target="_blank" href="<?= base_url() ?>template/Ajax/#chat.html" class="waves-effect">
                                <i class="bx bx-chat"></i>
                                <span key="t-chat">Chat</span>
                            </a>
                        </li>
        
                        <li>
                            <a target="_blank" href="<?= base_url() ?>template/Ajax/#apps-filemanager.html" class="waves-effect">
                                <i class="bx bx-file"></i>
                                <span class="badge rounded-pill bg-success float-end" key="t-new">New</span>
                                <span key="t-file-manager">File Manager</span>
                            </a>
                        </li>
        
                        <li>
                            <a target="_blank" href="<?= base_url() ?>template/Ajax/#javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-store"></i>
                                <span key="t-ecommerce">Ecommerce</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ecommerce-products.html" key="t-products">Products</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ecommerce-product-detail.html" key="t-product-detail">Product Detail</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ecommerce-orders.html" key="t-orders">Orders</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ecommerce-customers.html" key="t-customers">Customers</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ecommerce-cart.html" key="t-cart">Cart</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ecommerce-checkout.html" key="t-checkout">Checkout</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ecommerce-shops.html" key="t-shops">Shops</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ecommerce-add-product.html" key="t-add-product">Add Product</a></li>
                            </ul>
                        </li>
        
                        <li>
                            <a target="_blank" href="<?= base_url() ?>template/Ajax/#javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-bitcoin"></i>
                                <span key="t-crypto">Crypto</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#crypto-wallet.html" key="t-wallet">Wallet</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#crypto-buy-sell.html" key="t-buy">Buy/Sell</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#crypto-exchange.html" key="t-exchange">Exchange</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#crypto-lending.html" key="t-lending">Lending</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#crypto-orders.html" key="t-orders">Orders</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#crypto-kyc-application.html" key="t-kyc">KYC Application</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#crypto-ico-landing.html" key="t-ico" target="_blank">ICO Landing</a></li>
                            </ul>
                        </li>
        
                        <li>
                            <a target="_blank" href="<?= base_url() ?>template/Ajax/#javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-envelope"></i>
                                <span key="t-email">Email</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#email-inbox.html" key="t-inbox">Inbox</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#email-read.html" key="t-read-email">Read Email</a></li>
                                <li>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/#javascript: void(0);">
                                        <span class="badge rounded-pill badge-soft-success float-end" key="t-new">New</span>
                                        <span key="t-email-templates">Templates</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#email-template-basic.html" key="t-basic-action">Basic Action</a></li>
                                        <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#email-template-alert.html" key="t-alert-email">Alert Email</a></li>
                                        <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#email-template-billing.html" key="t-bill-email">Billing Email</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
        
                        <li>
                            <a target="_blank" href="<?= base_url() ?>template/Ajax/#javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-receipt"></i>
                                <span key="t-invoices">Invoices</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#invoices-list.html" key="t-invoice-list">Invoice List</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#invoices-detail.html" key="t-invoice-detail">Invoice Detail</a></li>
                            </ul>
                        </li>
        
                        <li>
                            <a target="_blank" href="<?= base_url() ?>template/Ajax/#javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-briefcase-alt-2"></i>
                                <span key="t-projects">Projects</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#projects-grid.html" key="t-p-grid">Projects Grid</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#projects-list.html" key="t-p-list">Projects List</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#projects-overview.html" key="t-p-overview">Project Overview</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#projects-create.html" key="t-create-new">Create New</a></li>
                            </ul>
                        </li>
        
                        <li>
                            <a target="_blank" href="<?= base_url() ?>template/Ajax/#javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-task"></i>
                                <span key="t-tasks">Tasks</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#tasks-list.html" key="t-task-list">Task List</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#tasks-kanban.html" key="t-kanban-board">Kanban Board</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#tasks-create.html" key="t-create-task">Create Task</a></li>
                            </ul>
                        </li>
        
                        <li>
                            <a target="_blank" href="<?= base_url() ?>template/Ajax/#javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bxs-user-detail"></i>
                                <span key="t-contacts">Contacts</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#contacts-grid.html" key="t-user-grid">Users Grid</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#contacts-list.html" key="t-user-list">Users List</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#contacts-profile.html" key="t-profile">Profile</a></li>
                            </ul>
                        </li>
        
                        <li>
                            <a target="_blank" href="<?= base_url() ?>template/Ajax/#javascript: void(0);" class="waves-effect">
                                <span class="badge rounded-pill bg-success float-end" key="t-new">New</span>
                                <i class="bx bx-detail"></i>
                                <span key="t-blog">Blog</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#blog-list.html" key="t-blog-list">Blog List</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#blog-grid.html" key="t-blog-grid">Blog Grid</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#blog-details.html" key="t-blog-details">Blog Details</a></li>
                            </ul>
                        </li>
        
                        <li class="menu-title" key="t-pages">Pages</li>
        
                        <li>
                            <a target="_blank" href="<?= base_url() ?>template/Ajax/#javascript: void(0);" class="waves-effect">
                                <span class="badge rounded-pill bg-success float-end" key="t-new">New</span>
                                <i class="bx bx-user-circle"></i>
                                <span key="t-authentication">Authentication</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#auth-login.html" key="t-login">Login</a></li>
                                <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#auth-login-2.html" key="t-login-2">Login 2</a></li>
                                <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#auth-register.html" key="t-register">Register</a></li>
                                <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#auth-register-2.html" key="t-register-2">Register 2</a></li>
                                <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#auth-recoverpw.html" key="t-recover-password">Recover Password</a></li>
                                <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#auth-recoverpw-2.html" key="t-recover-password-2">Recover Password 2</a></li>
                                <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#auth-lock-screen.html" key="t-lock-screen">Lock Screen</a></li>
                                <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#auth-lock-screen-2.html" key="t-lock-screen-2">Lock Screen 2</a></li>
                                <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#auth-confirm-mail.html" key="t-confirm-mail">Confirm Email</a></li>
                                <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#auth-confirm-mail-2.html" key="t-confirm-mail-2">Confirm Email 2</a></li>
                                <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#auth-email-verification.html" key="t-email-verification">Email verification</a></li>
                                <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#auth-email-verification-2.html" key="t-email-verification-2">Email Verification 2</a></li>
                                <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#auth-two-step-verification.html" key="t-two-step-verification">Two Step Verification</a></li>
                                <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#auth-two-step-verification-2.html" key="t-two-step-verification-2">Two Step Verification 2</a></li>
                            </ul>
                        </li>
        
                        <li>
                            <a target="_blank" href="<?= base_url() ?>template/Ajax/#javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-file"></i>
                                <span key="t-utility">Utility</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#pages-starter.html" key="t-starter-page">Starter Page</a></li>
                                <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#pages-maintenance.html" key="t-maintenance">Maintenance</a></li>
                                <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#pages-comingsoon.html" key="t-coming-soon">Coming Soon</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#pages-timeline.html" key="t-timeline">Timeline</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#pages-faqs.html" key="t-faqs">FAQs</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#pages-pricing.html" key="t-pricing">Pricing</a></li>
                                <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#pages-404.html" key="t-error-404">Error 404</a></li>
                                <li><a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/#pages-500.html" key="t-error-500">Error 500</a></li>
                            </ul>
                        </li>
        
                        <li class="menu-title" key="t-components">Components</li>
        
                        <li>
                            <a target="_blank" href="<?= base_url() ?>template/Ajax/#javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-tone"></i>
                                <span key="t-ui-elements">UI Elements</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ui-alerts.html" key="t-alerts">Alerts</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ui-buttons.html" key="t-buttons">Buttons</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ui-cards.html" key="t-cards">Cards</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ui-carousel.html" key="t-carousel">Carousel</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ui-dropdowns.html" key="t-dropdowns">Dropdowns</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ui-grid.html" key="t-grid">Grid</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ui-images.html" key="t-images">Images</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ui-lightbox.html" key="t-lightbox">Lightbox</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ui-modals.html" key="t-modals">Modals</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ui-offcanvas.html" key="t-offcanvas">Offcanvas</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ui-rangeslider.html" key="t-range-slider">Range Slider</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ui-session-timeout.html" key="t-session-timeout">Session Timeout</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ui-progressbars.html" key="t-progress-bars">Progress Bars</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ui-placeholders.html" key="t-placeholders">Placeholders</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ui-sweet-alert.html" key="t-sweet-alert">Sweet-Alert</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ui-tabs-accordions.html" key="t-tabs-accordions">Tabs & Accordions</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ui-typography.html" key="t-typography">Typography</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ui-toasts.html" key="t-toasts">Toasts</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ui-video.html" key="t-video">Video</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ui-general.html" key="t-general">General</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ui-colors.html" key="t-colors">Colors</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ui-rating.html" key="t-rating">Rating</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#ui-notifications.html" key="t-notifications">Notifications</a></li>
                            </ul>
                        </li>
        
                        <li>
                            <a target="_blank" href="<?= base_url() ?>template/Ajax/#javascript: void(0);" class="waves-effect">
                                <i class="bx bxs-eraser"></i>
                                <span class="badge rounded-pill bg-danger float-end">10</span>
                                <span key="t-forms">Forms</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#form-elements.html" key="t-form-elements">Form Elements</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#form-layouts.html" key="t-form-layouts">Form Layouts</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#form-validation.html" key="t-form-validation">Form Validation</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#form-advanced.html" key="t-form-advanced">Form Advanced</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#form-editors.html" key="t-form-editors">Form Editors</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#form-uploads.html" key="t-form-upload">Form File Upload</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#form-xeditable.html" key="t-form-xeditable">Form Xeditable</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#form-repeater.html" key="t-form-repeater">Form Repeater</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#form-wizard.html" key="t-form-wizard">Form Wizard</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#form-mask.html" key="t-form-mask">Form Mask</a></li>
                            </ul>
                        </li>
        
                        <li>
                            <a target="_blank" href="<?= base_url() ?>template/Ajax/#javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-list-ul"></i>
                                <span key="t-tables">Tables</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#tables-basic.html" key="t-basic-tables">Basic Tables</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#tables-datatable.html" key="t-data-tables">Data Tables</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#tables-responsive.html" key="t-responsive-table">Responsive Table</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#tables-editable.html" key="t-editable-table">Editable Table</a></li>
                            </ul>
                        </li>
        
                        <li>
                            <a target="_blank" href="<?= base_url() ?>template/Ajax/#javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bxs-bar-chart-alt-2"></i>
                                <span key="t-charts">Charts</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#charts-apex.html" key="t-apex-charts">Apex Charts</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#charts-echart.html" key="t-e-charts">E Charts</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#charts-chartjs.html" key="t-chartjs-charts">Chartjs Charts</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#charts-flot.html" key="t-flot-charts">Flot Charts</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#charts-tui.html" key="t-ui-charts">Toast UI Charts</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#charts-knob.html" key="t-knob-charts">Jquery Knob Charts</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#charts-sparkline.html" key="t-sparkline-charts">Sparkline Charts</a></li>
                            </ul>
                        </li>
        
                        <li>
                            <a target="_blank" href="<?= base_url() ?>template/Ajax/#javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-aperture"></i>
                                <span key="t-icons">Icons</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#icons-boxicons.html" key="t-boxicons">Boxicons</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#icons-materialdesign.html" key="t-material-design">Material Design</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#icons-dripicons.html" key="t-dripicons">Dripicons</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#icons-fontawesome.html" key="t-font-awesome">Font Awesome</a></li>
                            </ul>
                        </li>
        
                        <li>
                            <a target="_blank" href="<?= base_url() ?>template/Ajax/#javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-map"></i>
                                <span key="t-maps">Maps</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#maps-google.html" key="t-g-maps">Google Maps</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#maps-vector.html" key="t-v-maps">Vector Maps</a></li>
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#maps-leaflet.html" key="t-l-maps">Leaflet Maps</a></li>
                            </ul>
                        </li>
        
                        <li>
                            <a target="_blank" href="<?= base_url() ?>template/Ajax/#javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-share-alt"></i>
                                <span key="t-multi-level">Multi Level</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#javascript: void(0);" key="t-level-1-1">Level 1.1</a></li>
                                <li>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/#javascript: void(0);" class="has-arrow" key="t-level-1-2">Level 1.2</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#javascript: void(0);" key="t-level-2-1">Level 2.1</a></li>
                                        <li><a target="_blank" href="<?= base_url() ?>template/Ajax/#javascript: void(0);" key="t-level-2-2">Level 2.2</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
        
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->
        
        <script>
            $("#vertical-menu-btn").on("click", () => {
                // if ($("body").attr('class') == 'vertical-collpsed') {
                //     $(".custom_logo").addClass('d-lg-none d-sm-block');
                // } else {
                //     $(".custom_logo").removeClass('d-lg-none d-sm-block');
                // }
                $(".custom_logo").toggleClass('d-lg-none d-sm-block');
            });
            
            window.onresize = function() {
                $browser = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
                // if (!$browser && !$(".custom_logo").hasClass("d-lg-none d-sm-block")) {
                //     $(".custom_logo").addClass("d-lg-none d-sm-block")
                // }
                
                if (!$browser && $("body").attr('class') == '') {
                    $("body").attr('class', 'sidebar-enable');
                    $(".custom_logo").addClass('d-lg-none d-sm-block');
                } else {
                    if ($("body").attr('class') == 'vertical-collpsed') {
                        $(".custom_logo").removeClass('d-lg-none d-sm-block');
                    } else {
                        $(".custom_logo").addClass('d-lg-none d-sm-block');
                    }
                }
            }

            window.onload = function (){
                var device = getDeviceType();
                var body = $("body").attr('class');
                
                if (body == 'vertical-collpsed') {
                    $(".custom_logo").toggleClass('d-lg-none d-sm-block');
                }
                
                console.log("device: ", device, body);
            }
        </script>