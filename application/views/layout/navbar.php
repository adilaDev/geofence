<?php
$data_user = $this->session->userdata("data_login");
$id_user = "";
$email = "";
$first_name = "";
$last_name = "";
$username = "";
$foto = "";
$sp_foto = "";
$lang = $this->session->userdata('language');
$data_lang = $this->session->userdata('data_lang');

if (isset($data_user)) {
    $id_user = $data_user['id'];
    $email = $data_user['email'];
    $first_name  = $data_user['first_name'];
    $last_name  = $data_user['last_name'];
    $username  = $data_user['username'];
    // $foto = base_url() . $data_user['photo_profil'];
    $foto = $data_user['photo_profil'];
    $sp_foto = explode("/", $foto);
}

function isEmailExists($check_email) {
    $list_gmap_style = array(
        'fadil@mail.com',
        'rizky@asiaresearchinstitute.com',
    );
    return in_array($check_email, $list_gmap_style);
}
// Contoh penggunaan
// $emailToCheck = 'fadil@mail.com';
// isEmailExists($email);

?>

<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="<?= (isset($data_user) && !empty($data_user)) ? base_url('home') : base_url('client') ?>" class="logo logo-dark">
                    <span class="logo-sm d-block d-md-none">
                        <!-- <img src="<?= base_url() ?>assets/images/logo.svg" alt="" height="22"> -->
                        <img src="<?= base_url() ?>assets/images/LOGO_ARI/logo_ari_green.svg" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <!-- <img src="<?= base_url() ?>assets/images/logo-dark.png" alt="" height="17"> -->
                        <img src="<?= base_url() ?>assets/images/LOGO_ARI/logo_ari_green.svg" alt="" height="30">
                    </span>
                </a>

                <a href="<?= (isset($data_user) && !empty($data_user)) ? base_url('home') : base_url('client') ?>" class="logo logo-light">
                    <span class="logo-sm">
                        <!-- <img src="<?= base_url() ?>assets/images/logo-light.svg" alt="" height="22"> -->
                        <img src="<?= base_url() ?>assets/images/LOGO_ARI/logo_ari_green.svg" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <!-- <img src="<?= base_url() ?>assets/images/logo-light.png" alt="" height="19"> -->
                        <img src="<?= base_url() ?>assets/images/LOGO_ARI/logo_ari_white.svg" alt="" height="22">
                    </span>
                </a>
            </div>

            <a href="<?= (isset($data_user) && !empty($data_user)) ? base_url('home') : base_url('client')?>">
                <span class="d-block d-sm-none ms-3">
                    <img src="<?= base_url() ?>assets/images/LOGO_ARI/logo_ari_green.svg" alt="" height="22">
                </span>
            </a>
            <!-- <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button> -->
        </div>

        <div class="d-flex">
            <div class="dropdown d-inline-block d-none">
                <button type="button" class="btn header-item dropdown-toggle waves-effect waves-light" title="Tableau" onclick="window.location = '<?= base_url('tableau') ?>'">
                    <img src="<?=base_url('assets/images/tableau/tableau-icon.svg')?>" alt="Tableau" width="100%" height="20px">
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <?php if(isset($data_user) && !empty($data_user)) : ?>
                <button type="button" class="btn header-item dropdown-toggle waves-effect waves-light" id="btnHome" title="<?= !empty($this->lang->line('home')) ? $this->lang->line('home') : 'Home' ?>" onclick="window.location = '<?= base_url('home') ?>'">
                    <i class='bx bx-home font-size-22 align-middle'></i>
                </button>
                <?php else : ?>
                    <button type="button" class="btn header-item dropdown-toggle waves-effect waves-light" id="btnHome" title="<?= !empty($this->lang->line('home')) ? $this->lang->line('home') : 'Home' ?>" onclick="window.location = '<?= base_url('client') ?>'">
                        <i class='bx bx-home font-size-22 align-middle'></i>
                    </button>
                <?php endif; ?>
            </div>

            <!-- <script>
                var home = document.getElementById("btnHome");
                home.removeAttribute("onclick"); // hapus dulu attribute onclick

                home.addEventListener('click', function (e){
                    var currentUrl = window.location;
                    var splitUrl = currentUrl.pathname.split("/");
                    let uri1 = splitUrl[1]; // gunakan ini jika di cpanel
                    let uri2 = splitUrl[2]; // gunakan ini jika di localhost
                    console.log("home click ", currentUrl);
                    console.log("splitUrl ", splitUrl);
                    console.log("uri1 ", uri1, " uri2: ", uri2);

                    if (uri2 == 'home' || uri2 == 'client' || uri2 == 'monitoring') {
                        window.location = '<?= base_url('home') ?>';
                    } else {
                        e.preventDefault();
                    }
                })
            </script> -->
            
            <div class="dropdown d-inline-block">
                <script src="https://kit.fontawesome.com/367278d2a4.js"></script>
                <button class="btn header-item dropdown-toggle waves-effect waves-light btn-collap d-none" type="button" title="Drawing tools" data-bs-toggle="collapse" data-bs-target=".drawing_tools_collapsed" aria-expanded="false" aria-controls="drawing_tools_collapsed">
                    <i id="icon_collapse" class="font-size-16 align-middle fa-regular fa-pen-nib"></i>
                </button>
                <script>
                    // $(document).ready(function() {
                    //     findTools();
                    // });

                    $(".btn-collap").on('click', findTools);
                    // var $btn_collap = $(".btn-collap").removeClass("d-none").addClass("mapboxgl-gl-draw_ctrl-draw-btn");
                    // $(".mapboxgl-ctrl-bottom-right > .mapboxgl-ctrl-group:nth-child(2)").before($btn_collap);

                    function findTools(){
                        // let collapsed = "drawing_tools_collapsed collapse";
                        // // let collapsed = "drawing_tools_collapsed";
                        // let toolsAll = $(".mapboxgl-ctrl-bottom-right>.mapboxgl-ctrl.mapboxgl-ctrl-group");
                        // let toolsWithoutSearch = $(".mapboxgl-ctrl-bottom-right>.mapboxgl-ctrl.mapboxgl-ctrl-group:not(#layout-search,.btn-collap)");
                        // let toolbar = $(".mapboxgl-ctrl-bottom-right>.mapboxgl-ctrl.mapboxgl-ctrl-group:not(#layout-search, :nth-child(2), :nth-child(3))");

                        // let toggleIconF6Pro = "fa-regular fa-pen-nib";
                        // let toggleIconShow = "fa-pen-nib";
                        // let toggleIconHide = "fa-pen-nib-slash";

                        // let icon = $("#icon_collapse");
                        // if (icon.hasClass(toggleIconF6Pro)) {
                        //     icon.addClass(toggleIconHide);
                        //     icon.removeClass(toggleIconShow);
                        // } else {
                        //     icon.addClass(toggleIconShow);
                        //     icon.removeClass(toggleIconHide);
                        // }

                        // if (!toolbar.hasClass(collapsed)) {
                        //     toolbar.addClass(collapsed);
                        // }

                        // console.log("toolsAll: ", toolsAll);
                        // // console.log("toolsWithoutSearch: ", toolsWithoutSearch);
                        // console.log("icon: ", icon);
                    }
                </script>
            </div>

            <!-- change style map -->
            <div class="dropdown d-inline-block">
                <div class="btn-group">
                    <button type="button" class="btn header-item dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false" title="<?= !empty($this->lang->line('style_map')) ? $this->lang->line('style_map') : 'Style map' ?>">
                        <i class='bx bx-layer font-size-22 align-middle'></i>
                    </button>
                    <div class="dropdown-menu" id="menuStyles">
                        <a class="dropdown-item item_style bg-secondary bg-soft" href="javascript:void(0);" id="default" onclick="style_map(this)"><?= !empty($this->lang->line('streets')) ? $this->lang->line('streets') : 'Streets' ?></a>
                        <a class="dropdown-item item_style" href="javascript:void(0);" id="satellite-v9" onclick="style_map(this)"><?= !empty($this->lang->line('satellite')) ? $this->lang->line('satellite') : 'Satellite' ?></a>
                        <a class="dropdown-item item_style" href="javascript:void(0);" id="satellite-streets-v12" onclick="style_map(this)"><?= !empty($this->lang->line('satellite')) ? $this->lang->line('satellite').' Streets' : 'Satellite Streets' ?></a>
                        <a class="dropdown-item item_style" href="javascript:void(0);" id="dark-v10" onclick="style_map(this)"><?= !empty($this->lang->line('dark')) ? $this->lang->line('dark') : 'Dark' ?></a>
                        <a class="dropdown-item item_style" href="javascript:void(0);" id="light-v10" onclick="style_map(this)"><?= !empty($this->lang->line('light')) ? $this->lang->line('light') : 'Light' ?></a>
                        <?php if (isEmailExists($email)) : ?>
                            <div class="list_gmap_style">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item item_style gmap_style" href="javascript:void(0);" data-url="https://mt0.google.com/vt/lyrs=m&x={x}&y={y}&z={z}" id="gmap-streets" onclick="gmapStyle('street', this)">
                                    <img src="<?= base_url() ?>assets/images/icon-gmap.png" alt="icon-gmap" width="20px" height="20px">
                                    <?= !empty($this->lang->line('streets')) ? 'Gmap '.$this->lang->line('streets') : 'Gmap Streets' ?>
                                </a>
                                <a class="dropdown-item item_style gmap_style" href="javascript:void(0);" data-url="https://mt0.google.com/vt/lyrs=s&x={x}&y={y}&z={z}" id="gmap-satellite" onclick="gmapStyle('satelit', this)">
                                    <img src="<?= base_url() ?>assets/images/icon-gmap.png" alt="icon-gmap" width="20px" height="20px">
                                    <?= !empty($this->lang->line('satellite')) ? 'Gmap '.$this->lang->line('satellite') : 'Gmap Satellite' ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="dropdown d-none d-inline-block<?= $this->uri->segment(1) == 'map' ? '' : ' d-none' ?>">
                <button class="btn header-item waves-effect" id="undoDraw" type="button" title="Undo" onclick="undo()">
                    <i class="bx bx-undo font-size-22"></i>
                </button>
            </div>

            <div class="dropdown d-none d-inline-block<?= $this->uri->segment(1) == 'map' ? '' : ' d-none' ?>">
                <button class="btn header-item waves-effect" id="redoDraw" type="button" title="Redo" onclick="redo()">
                    <i class="bx bx-redo font-size-22"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block d-none">
                <button class="btn header-item waves-effect" id="canvasDataTable" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                    <i class="bx bx-dots-vertical-rounded font-size-22"></i>
                </button>
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
            <div class="dropdown d-inline-block <?= (isset($data_user) && !empty($data_user)) ? "" : "d-none" ?>">
            <!-- <div class="dropdown d-inline-block"> -->
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
                    <a class="dropdown-item" href="<?=base_url('profile')?>"><i class="bx bx-user font-size-16 align-middle me-1"></i>
                        <span key="t-profile"><?= !empty($this->lang->line('my_account')) ? $this->lang->line('my_account') : 'Profile'; ?></span></a>
                    <a class="dropdown-item" href="<?=base_url('profile/changepassword')?>"><i class="bx bx-lock font-size-16 align-middle me-1"></i>
                        <span key="t-profile"><?= !empty($this->lang->line('change_password')) ? $this->lang->line('change_password') : 'Change Password'; ?></span></a>
                    <a class="dropdown-item text-danger" href="<?=base_url('auth/logout')?>" id="btn-logout">
                        <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                        <span key="t-logout"><?= !empty($this->lang->line('logout')) ? $this->lang->line('logout') : 'Logout'; ?></span>
                    </a>
                </div>
            </div>

            <div class="dropdown d-inline-block d-none">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="bx bx-cog bx-spin"></i>
                </button>
            </div>

        </div>
    </div>
</header>

<div class="topnav d-none">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html##" id="topnav-dashboard" role="button">
                            <i class="bx bx-home-circle me-2"></i><span key="t-dashboards">Dashboards</span>
                            <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-dashboard">

                            <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#index.html" class="dropdown-item" key="t-default">Default</a>
                            <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#dashboard-saas.html" class="dropdown-item" key="t-saas">Saas</a>
                            <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#dashboard-crypto.html" class="dropdown-item" key="t-crypto">Crypto</a>
                            <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#dashboard-blog.html" class="dropdown-item" key="t-blog">Blog</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html##" id="topnav-uielement" role="button">
                            <i class="bx bx-tone me-2"></i>
                            <span key="t-ui-elements"> UI Elements</span>
                            <div class="arrow-down"></div>
                        </a>

                        <div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-xl" aria-labelledby="topnav-uielement">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div>
                                        <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ui-alerts.html" class="dropdown-item" key="t-alerts">Alerts</a>
                                        <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ui-buttons.html" class="dropdown-item" key="t-buttons">Buttons</a>
                                        <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ui-cards.html" class="dropdown-item" key="t-cards">Cards</a>
                                        <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ui-carousel.html" class="dropdown-item" key="t-carousel">Carousel</a>
                                        <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ui-dropdowns.html" class="dropdown-item" key="t-dropdowns">Dropdowns</a>
                                        <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ui-grid.html" class="dropdown-item" key="t-grid">Grid</a>
                                        <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ui-images.html" class="dropdown-item" key="t-images">Images</a>
                                        <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ui-lightbox.html" class="dropdown-item" key="t-lightbox">Lightbox</a>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div>
                                        <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ui-modals.html" class="dropdown-item" key="t-modals">Modals</a>
                                        <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ui-offcanvas.html" class="dropdown-item" key="t-offcanvas">Offcanvas</a>
                                        <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ui-rangeslider.html" class="dropdown-item" key="t-range-slider">Range Slider</a>
                                        <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ui-session-timeout.html" class="dropdown-item" key="t-session-timeout">Session Timeout</a>
                                        <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ui-progressbars.html" class="dropdown-item" key="t-progress-bars">Progress Bars</a>
                                        <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ui-placeholders.html" class="dropdown-item" key="t-placeholders">Placeholders</a>
                                        <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ui-sweet-alert.html" class="dropdown-item" key="t-sweet-alert">Sweet-Alert</a>
                                        <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ui-tabs-accordions.html" class="dropdown-item" key="t-tabs-accordions">Tabs & Accordions</a>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div>
                                        <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ui-typography.html" class="dropdown-item" key="t-typography">Typography</a>
                                        <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ui-toasts.html" class="dropdown-item" key="t-toasts">Toasts</a>
                                        <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ui-video.html" class="dropdown-item" key="t-video">Video</a>
                                        <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ui-general.html" class="dropdown-item" key="t-general">General</a>
                                        <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ui-colors.html" class="dropdown-item" key="t-colors">Colors</a>
                                        <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ui-rating.html" class="dropdown-item" key="t-rating">Rating</a>
                                        <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ui-notifications.html" class="dropdown-item" key="t-notifications">Notifications</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html##" id="topnav-pages" role="button">
                            <i class="bx bx-customize me-2"></i><span key="t-apps">Apps</span>
                            <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-pages">

                            <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#calendar.html" class="dropdown-item" key="t-calendar">Calendar</a>
                            <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#chat.html" class="dropdown-item" key="t-chat">Chat</a>
                            <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#apps-filemanager.html" class="dropdown-item" key="t-file-manager">File Manager</a>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html##" id="topnav-email" role="button">
                                    <span key="t-email">Email</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-email">
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#email-inbox.html" class="dropdown-item" key="t-inbox">Inbox</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#email-read.html" class="dropdown-item" key="t-read-email">Read Email</a>

                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html##" id="topnav-blog" role="button">
                                            <span key="t-email-templates">Templates</span>
                                            <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-blog">
                                            <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#email-template-basic.html" class="dropdown-item" key="t-basic-action">Basic Action</a>
                                            <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#email-template-alert.html" class="dropdown-item" key="t-alert-email">Alert Email</a>
                                            <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#email-template-billing.html" class="dropdown-item" key="t-bill-email">Billing Email</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html##" id="topnav-ecommerce" role="button">
                                    <span key="t-ecommerce">Ecommerce</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-ecommerce">
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ecommerce-products.html" class="dropdown-item" key="t-products">Products</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ecommerce-product-detail.html" class="dropdown-item" key="t-product-detail">Product Detail</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ecommerce-orders.html" class="dropdown-item" key="t-orders">Orders</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ecommerce-customers.html" class="dropdown-item" key="t-customers">Customers</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ecommerce-cart.html" class="dropdown-item" key="t-cart">Cart</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ecommerce-checkout.html" class="dropdown-item" key="t-checkout">Checkout</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ecommerce-shops.html" class="dropdown-item" key="t-shops">Shops</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#ecommerce-add-product.html" class="dropdown-item" key="t-add-product">Add Product</a>
                                </div>
                            </div>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html##" id="topnav-crypto" role="button">
                                    <span key="t-crypto">Crypto</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-crypto">
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#crypto-wallet.html" class="dropdown-item" key="t-wallet">Wallet</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#crypto-buy-sell.html" class="dropdown-item" key="t-buy">Buy/Sell</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#crypto-exchange.html" class="dropdown-item" key="t-exchange">Exchange</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#crypto-lending.html" class="dropdown-item" key="t-lending">Lending</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#crypto-orders.html" class="dropdown-item" key="t-orders">Orders</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#crypto-kyc-application.html" class="dropdown-item" key="t-kyc">KYC Application</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#crypto-ico-landing.html" class="dropdown-item" key="t-ico">ICO Landing</a>
                                </div>
                            </div>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html##" id="topnav-project" role="button">
                                    <span key="t-projects">Projects</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-project">
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#projects-grid.html" class="dropdown-item" key="t-p-grid">Projects Grid</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#projects-list.html" class="dropdown-item" key="t-p-list">Projects List</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#projects-overview.html" class="dropdown-item" key="t-p-overview">Project Overview</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#projects-create.html" class="dropdown-item" key="t-create-new">Create New</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html##" id="topnav-task" role="button">
                                    <span key="t-tasks">Tasks</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-task">
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#tasks-list.html" class="dropdown-item" key="t-task-list">Task List</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#tasks-kanban.html" class="dropdown-item" key="t-kanban-board">Kanban Board</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#tasks-create.html" class="dropdown-item" key="t-create-task">Create Task</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html##" id="topnav-contact" role="button">
                                    <span key="t-contacts">Contacts</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-contact">
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#contacts-grid.html" class="dropdown-item" key="t-user-grid">User Grid</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#contacts-list.html" class="dropdown-item" key="t-user-list">User List</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#contacts-profile.html" class="dropdown-item" key="t-profile">Profile</a>
                                </div>
                            </div>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html##" id="topnav-blog" role="button">
                                    <span key="t-blog">Blog</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-blog">
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#blog-list.html" class="dropdown-item" key="t-blog-list">Blog List</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#blog-grid.html" class="dropdown-item" key="t-blog-grid">Blog Grid</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#blog-details.html" class="dropdown-item" key="t-blog-details">Blog Details</a>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html##" id="topnav-components" role="button">
                            <i class="bx bx-collection me-2"></i><span key="t-components">Components</span>
                            <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-components">
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html##" id="topnav-form" role="button">
                                    <span key="t-forms">Forms</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-form">
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#form-elements.html" class="dropdown-item" key="t-form-elements">Form Elements</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#form-layouts.html" class="dropdown-item" key="t-form-layouts">Form Layouts</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#form-validation.html" class="dropdown-item" key="t-form-validation">Form Validation</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#form-advanced.html" class="dropdown-item" key="t-form-advanced">Form Advanced</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#form-editors.html" class="dropdown-item" key="t-form-editors">Form Editors</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#form-uploads.html" class="dropdown-item" key="t-form-upload">Form File Upload</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#form-xeditable.html" class="dropdown-item" key="t-form-xeditable">Form Xeditable</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#form-repeater.html" class="dropdown-item" key="t-form-repeater">Form Repeater</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#form-wizard.html" class="dropdown-item" key="t-form-wizard">Form Wizard</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#form-mask.html" class="dropdown-item" key="t-form-mask">Form Mask</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html##" id="topnav-table" role="button">
                                    <span key="t-tables">Tables</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-table">
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#tables-basic.html" class="dropdown-item" key="t-basic-tables">Basic Tables</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#tables-datatable.html" class="dropdown-item" key="t-data-tables">Data Tables</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#tables-responsive.html" class="dropdown-item" key="t-responsive-table">Responsive Table</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#tables-editable.html" class="dropdown-item" key="t-editable-table">Editable Table</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html##" id="topnav-charts" role="button">
                                    <span key="t-charts">Charts</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-charts">
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#charts-apex.html" class="dropdown-item" key="t-apex-charts">Apex charts</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#charts-echart.html" class="dropdown-item" key="t-e-charts">E charts</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#charts-chartjs.html" class="dropdown-item" key="t-chartjs-charts">Chartjs Charts</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#charts-flot.html" class="dropdown-item" key="t-flot-charts">Flot Charts</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#charts-tui.html" class="dropdown-item" key="t-ui-charts">Toast UI Charts</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#charts-knob.html" class="dropdown-item" key="t-knob-charts">Jquery Knob Charts</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#charts-sparkline.html" class="dropdown-item" key="t-sparkline-charts">Sparkline Charts</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html##" id="topnav-icons" role="button">
                                    <span key="t-icons">Icons</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-icons">
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#icons-boxicons.html" class="dropdown-item" key="t-boxicons">Boxicons</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#icons-materialdesign.html" class="dropdown-item" key="t-material-design">Material Design</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#icons-dripicons.html" class="dropdown-item" key="t-dripicons">Dripicons</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#icons-fontawesome.html" class="dropdown-item" key="t-font-awesome">Font awesome</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html##" id="topnav-map" role="button">
                                    <span key="t-maps">Maps</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-map">
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#maps-google.html" class="dropdown-item" key="t-g-maps">Google Maps</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#maps-vector.html" class="dropdown-item" key="t-v-maps">Vector Maps</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#maps-leaflet.html" class="dropdown-item" key="t-l-maps">Leaflet Maps</a>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html##" id="topnav-more" role="button">
                            <i class="bx bx-file me-2"></i><span key="t-extra-pages">Extra pages</span>
                            <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-more">
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html##" id="topnav-invoice" role="button">
                                    <span key="t-invoices">Invoices</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-invoice">
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#invoices-list.html" class="dropdown-item" key="t-invoice-list">Invoice List</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#invoices-detail.html" class="dropdown-item" key="t-invoice-detail">Invoice Detail</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html##" id="topnav-auth" role="button">
                                    <span key="t-authentication">Authentication</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-auth">
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#auth-login.html" class="dropdown-item" key="t-login">Login</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#auth-login-2.html" class="dropdown-item" key="t-login-2">Login 2</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#auth-register.html" class="dropdown-item" key="t-register">Register</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#auth-register-2.html" class="dropdown-item" key="t-register-2">Register 2</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#auth-recoverpw.html" class="dropdown-item" key="t-recover-password">Recover Password</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#auth-recoverpw-2.html" class="dropdown-item" key="t-recover-password-2">Recover Password 2</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#auth-lock-screen.html" class="dropdown-item" key="t-lock-screen">Lock Screen</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#auth-lock-screen-2.html" class="dropdown-item" key="t-lock-screen-2">Lock Screen 2</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#auth-confirm-mail.html" class="dropdown-item" key="t-confirm-mail">Confirm Mail</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#auth-confirm-mail-2.html" class="dropdown-item" key="t-confirm-mail-2">Confirm Mail 2</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#auth-email-verification.html" class="dropdown-item" key="t-email-verification">Email verification</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#auth-email-verification-2.html" class="dropdown-item" key="t-email-verification-2">Email verification 2</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#auth-two-step-verification.html" class="dropdown-item" key="t-two-step-verification">Two step verification</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#auth-two-step-verification-2.html" class="dropdown-item" key="t-two-step-verification-2">Two step verification 2</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html##" id="topnav-utility" role="button">
                                    <span key="t-utility">Utility</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-utility">
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#pages-starter.html" class="dropdown-item" key="t-starter-page">Starter Page</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#pages-maintenance.html" class="dropdown-item" key="t-maintenance">Maintenance</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#pages-comingsoon.html" class="dropdown-item" key="t-coming-soon">Coming Soon</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#pages-timeline.html" class="dropdown-item" key="t-timeline">Timeline</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#pages-faqs.html" class="dropdown-item" key="t-faqs">FAQs</a>
                                    <a target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#pages-pricing.html" class="dropdown-item" key="t-pricing">Pricing</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#pages-404.html" class="dropdown-item" key="t-error-404">Error 404</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#pages-500.html" class="dropdown-item" key="t-error-500">Error 500</a>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html##" id="topnav-layout" role="button">
                            <i class="bx bx-layout me-2"></i><span key="t-layouts">Layouts</span>
                            <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-layout">
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html##" id="topnav-layout-verti" role="button">
                                    <span key="t-vertical">Vertical</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-layout-verti">
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#layouts-light-sidebar.html" class="dropdown-item" key="t-light-sidebar">Light Sidebar</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#layouts-compact-sidebar.html" class="dropdown-item" key="t-compact-sidebar">Compact Sidebar</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#layouts-icon-sidebar.html" class="dropdown-item" key="t-icon-sidebar">Icon Sidebar</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#layouts-boxed.html" class="dropdown-item" key="t-boxed-width">Boxed Width</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#layouts-preloader.html" class="dropdown-item" key="t-preloader">Preloader</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#layouts-colored-sidebar.html" class="dropdown-item" key="t-colored-sidebar">Colored Sidebar</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#layouts-scrollable.html" class="dropdown-item" key="t-scrollable">Scrollable</a>
                                </div>
                            </div>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html##" id="topnav-layout-hori" role="button">
                                    <span key="t-horizontal">Horizontal</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-layout-hori">
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#layouts-horizontal.html" class="dropdown-item" key="t-horizontal">Horizontal</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#layouts-hori-topbar-light.html" class="dropdown-item" key="t-topbar-light">Topbar light</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#layouts-hori-boxed-width.html" class="dropdown-item" key="t-boxed-width">Boxed width</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#layouts-hori-preloader.html" class="dropdown-item" key="t-preloader">Preloader</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#layouts-hori-colored-header.html" class="dropdown-item" key="t-colored-topbar">Colored Header</a>
                                    <a target="_blank" target="_blank" href="<?= base_url() ?>template/Ajax/layouts-hori-preloader.html#layouts-hori-scrollable.html" class="dropdown-item" key="t-scrollable">Scrollable</a>
                                </div>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>
        </nav>
    </div>
</div>