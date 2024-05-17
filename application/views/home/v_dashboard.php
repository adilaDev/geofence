<?php
$data_user = $this->session->userdata("data_login");
$first_name = "";
$last_name = "";
$username = "";
$id_user = "";
$id_level = "";
$lang = $this->session->userdata('language');
$data_lang = $this->session->userdata('data_lang');

if (isset($data_user)) {
    $first_name  = $data_user['first_name'];
    $last_name  = $data_user['last_name'];
    $username  = $data_user['username'];
    $id_user  = $data_user['id'];
    $id_level  = $data_user['id_level'];
}
?>
<div class="main-content">
    <div class="page-content m-0 pb-0">
        <div class="container-fluid">

            <div class="row row-cols-2 my-2">
                <div class="card-title"><?= !empty($this->lang->line('list_drawing_map')) ? $this->lang->line('list_drawing_map') : 'List Drawing Map' ?></div>
                <?php if ($id_level == '1') : ?>                
                    <div class="text-end"><a href="home/monitoring" class="btn btn-outline-dark btn-sm waves-effect waves-light"><?= !empty($this->lang->line('monitoring_users')) ? $this->lang->line('monitoring_users') : 'Monitoring Users'; ?></a></div>
                <?php endif; ?>
            </div>
            <div class="row mb-0">
                <div class="col-12 col-md-7 mb-0">
                    <div class="card card-effect">
                        <div class="card-body pb-2">

                            <div class="mb-3">
                                <a href="<?=base_url('map')?>" class="btn btn-outline-primary btn-sm waves-effect waves-light me-2">
                                    <i class="fas fa-map-marked-alt font-size-16 align-middle me-2"></i><?= !empty($this->lang->line('create_polygon')) ? $this->lang->line('create_polygon') : 'Create Polygons' ?>
                                </a>
                                <button type="button" onclick="window.location='<?=base_url('home/import/')?>'" class="btn btn-outline-dark btn-sm waves-effect waves-light me-2">
                                    <i class="fas fa-file-import font-size-16 align-middle me-2"></i><?= !empty($this->lang->line('import_file')) ? $this->lang->line('import_file') : 'Import Files'; ?>
                                </button>
                                <button type="submit" onclick="deleteAll()" class="btn btn-outline-danger btn-sm waves-effect waves-light me-2" <?= (is_array($list_all_geo) && count($list_all_geo) == 0) ? 'disabled' : '' ?>>
                                    <i class="fas fa-trash font-size-16 align-middle me-2"></i><?= !empty($this->lang->line('delete_all')) ? $this->lang->line('delete_all') : ''; 'Delete All' ?>
                                </button>
                                <button type="submit" onclick="window.location='<?=base_url('map/downloadAll')?>'" class="btn btn-outline-info btn-sm waves-effect waves-light me-2" <?= (is_array($list_all_geo) && count($list_all_geo) == 0) ? 'disabled' : '' ?>>
                                    <i class="fas fa-file-archive font-size-16 align-middle me-2"></i><?= !empty($this->lang->line('download_all')) ? $this->lang->line('download_all') : ''; 'Download All' ?>
                                    <!-- <i class="mdi mdi-folder-download font-size-16 align-middle me-2"></i>Download All -->
                                </button>
                                
                                <!-- <button class="btn btn-transparent btn-sm waves-effect waves-light p-1 mapboxgl-ctrl mapboxgl-ctrl-group btn-collap" type="button" title="Drawing tools" data-bs-toggle="collapse" data-bs-target=".drawing_tools_collapsed" aria-expanded="false" aria-controls="collapseExample">
                                    <i id="icon_collapse" class="font-size-16 align-middle fa-regular fa-pen-nib"></i>
                                </button>
                                <div class="drawing_tools_collapsed" id="collapseExample">
                                    <div class="card border shadow-none card-body text-muted mb-0">
                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                    </div>
                                </div> -->
                            </div>

                            <?php 
                                function convert_ymdhi($originalDate, $format = "d-M-Y H:i"){
                                    if (!empty($originalDate) && isset($originalDate)) {
                                        $newDate = date($format, strtotime($originalDate));
                                        return $newDate;
                                    }
                                }
                            ?>

                            <div class="table-responsive">
                                <table id="dashboard" class="table table-sm table-bordered table-striped border-secondary w-100" style="border-collapse: collapse !important;">
                                <!-- <table id="dashboard" class="table table-sm table-striped border-secondary w-100"> -->
                                    <thead class="text-center">
                                        <tr class="align-middle">
                                            <td><?= !empty($this->lang->line('no')) ? $this->lang->line('no') : 'No'; ?></td>
                                            <td><?= !empty($this->lang->line('filename')) ? $this->lang->line('filename') : 'Filename'; ?></td>
                                            <td><?= !empty($this->lang->line('output')) ? $this->lang->line('output') : 'Output'; ?></td>
                                            <td><?= !empty($this->lang->line('updated')) ? $this->lang->line('updated') : 'Updated'; ?></td>
                                            <td><?= !empty($this->lang->line('action')) ? $this->lang->line('action') : 'Action'; ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach ($list_all_geo as $item) : ?>
                                            <tr class="align-middle">
                                                <td><?= $no++ ?></td>
                                                <td><?= $item->polygon_name ?></td>
                                                <td>
                                                    <a href="<?= $item->link ?>" download class="btn btn-primary btn-sm waves-effect waves-light d-none">
                                                        <?= !empty($this->lang->line('download')) ? $this->lang->line('download') : ''; 'Download' ?>
                                                    </a>

                                                    <div class="btn-group dropend">
                                                        <button type="button" id="btnDownload<?=$no?>" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i id="iloader<?=$no?>" class="bx bx-loader-alt bx-spin font-size-16 align-middle me-2 d-none"></i><?= !empty($this->lang->line('download')) ? $this->lang->line('download') : ''; 'Download' ?> <i class="bx bx-chevron-right font-size-16 align-middle me-0"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item pe-0" href="<?= $item->link ?>" download>GeoJSON</a>
                                                            <a class="dropdown-item pe-0" href="javascript:void(0);" onclick="convertAndDownloadCSV('<?= $item->link?>', '<?= $item->polygon_name?>', '<?=$no?>')">CSV</a>
                                                            <a class="dropdown-item pe-0" href="javascript:void(0);" onclick="createAndDownloadWKT('<?= $item->link?>', '<?= $item->polygon_name?>', '<?=$no?>')">WKT</a>
                                                            <a class="dropdown-item pe-0" href="javascript:void(0);" onclick="convertToSHP('<?= $item->link?>', '<?= $item->polygon_name?>', '<?=$no?>')">SHP</a>
                                                        </div>
                                                    </div>
                                                    <!-- <a href="<?= $item->link ?>" download class="btn btn-primary btn-sm waves-effect waves-light me-1 mb-2">
                                                        <i class="bx bxs-file-json font-size-13 align-middle"></i> 
                                                    </a>
                                                    <a onclick="convertAndDownloadCSV('<?= $item->link?>', '<?= $item->polygon_name?>')" class="btn btn-primary btn-sm waves-effect waves-light me-1 mb-2">
                                                        <i class="fas fa-file-csv font-size-13 align-middle"></i> 
                                                    </a>
                                                    <a onclick="createAndDownloadWKT('<?= $item->link?>', '<?= $item->polygon_name?>')" class="btn btn-primary btn-sm waves-effect waves-light me-1 mb-2">
                                                        <i class="far fa-file-code font-size-13 align-middle"></i> 
                                                    </a> -->
                                                </td>
                                                <td><?= convert_ymdhi($item->last_update, "d-m-Y H:i") ?></td>
                                                <td>
                                                    <button type="button" onclick="showFeatures('<?= $item->id_drawing ?>')" class="btn btn-outline-info btn-sm waves-effect waves-light me-1 mb-lg-1 mb-2">
                                                        <i class="bx bx-map-alt align-middle font-size-14"></i> <?= !empty($this->lang->line('view')) ? $this->lang->line('view') : 'View'; ?>
                                                    </button>
                                                    <button type="button" onclick="window.location='<?= base_url('map/edit/'.$item->polygon_name) ?>'" class="btn btn-outline-warning btn-sm waves-effect waves-light me-1 mb-lg-1 mb-2">
                                                        <i class="bx bx-pen align-middle font-size-14"></i> <?= !empty($this->lang->line('edit')) ? $this->lang->line('edit') : 'Edit'; ?>
                                                    </button>
                                                    <button type="button" onclick="deleteId('<?= $item->id_drawing ?>', '<?=$item->polygon_name?>')" class="btn btn-outline-danger btn-sm waves-effect waves-light me-1 mb-lg-1 mb-2">
                                                        <i class="bx bx-trash align-middle font-size-14"></i> <?= !empty($this->lang->line('delete')) ? $this->lang->line('delete') : 'Delete'; ?>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-md-5 mb-0">
                    <div id="my_map" class="card-effect" style="width: 100%; height: 400px;"></div>
                    
                    <div class="btn-group dropstart mapboxgl-ctrl mapboxgl-ctrl-group d-none" id="layout-search">
                        <button type="button" id="search-dropdown" class="waves-effect waves-light mapboxgl-gl-draw_ctrl-draw-btn m-0 pt-1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-search font-size-18"></i>
                        </button>
                        <div class="dropdown-menu dropdown-mega-menu-lg dropdown-menu-end p-0" aria-labelledby="search-dropdown">
                            <!-- <form class="p-0"> -->
                                <div class="form-group m-0">
                                    <div class="input-group">
                                        <input type="search" oninput="initPlacesSearch()" class="form-control" id="searchInput" style="height: 30px;" placeholder="Search..."
                                            aria-label="Recipient's username">
                                    </div>
                                </div>
                            <!-- </form> -->
                        </div>
                    </div>
                </div>
            </div> <!-- ./row -->

        </div> <!-- ./container-fluid -->
    </div> <!-- ./page-content -->
</div> <!-- ./main-content -->

<div class="d-none mapboxgl-ctrl mapboxgl-ctrl-group" id="deleteFeature">
    <button type="button" onclick="deleteAllFeature()" id="btnDeleteFeature" title="Delete all polygon" class="mapboxgl-gl-draw_ctrl-draw-btn waves-effect waves-light">
        <i class="fas fa-trash font-size-16 align-middle"></i>
    </button>
</div>

<div class="d-none mapboxgl-ctrl mapboxgl-ctrl-group" id="previewFeature">
    <button type="button" class="mapboxgl-gl-draw_ctrl-draw-btn waves-effect waves-light" id="btnModalPreview" data-bs-toggle="offcanvas" data-bs-target="#previewPolygon" aria-controls="previewPolygon" title="<?= !empty($this->lang->line('polygon_layer')) ? $this->lang->line('polygon_layer') : 'Polygon Layer'; ?>">
        <i class="fas fa-map-marked-alt font-size-18 align-middle" aria-hidden="true"></i>
    </button>
</div>

<div class="offcanvas offcanvas-start w-50" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="previewPolygon" aria-labelledby="previewPolygonLabel" style="visibility: hidden;" aria-hidden="true">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="previewPolygonLabel"><?= !empty($this->lang->line('polygon_layer')) ? $this->lang->line('polygon_layer') : 'Polygon Layer'; ?></h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="table-responsive">
            <div id="layout-not-found" class="text-center">
                <img src="<?=base_url()?>assets/images/no-data.png" alt="error image" width="auto" height="300">
                <div class="mt-0">
                    <strong class="text-danger font-size-18"><?= !empty($this->lang->line('data_not_found')) ? $this->lang->line('data_not_found') : 'Data Not Found'; ?></strong>
                </div>
            </div>
            <table id="preview-tbl" class="table table-sm table-hover table-bordered border border-dark w-100" style="border-collapse: collapse !important;">
            </table>
        </div>
    </div>
</div>

<!-- DataTables -->
<link href="<?=base_url()?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<!-- Required datatable js -->
<script src="<?=base_url()?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

<!-- dataTables responsive -->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap.min.css">
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<!-- bootstrap responsive -->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap.min.css">
<script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap.min.js"></script>

<!-- jQuery dataTables ColResize -->
<!-- <link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> -->
<link href="https://cdn.jsdelivr.net/npm/datatables.net-colresize-unofficial@latest/jquery.dataTables.colResize.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.jsdelivr.net/npm/datatables.net-colresize-unofficial@latest/jquery.dataTables.colResize.js"></script>

<script type="text/javascript">
    const tb = $("#dashboard");
    let lang = '<?= $lang ?>';
    // https://datatables.net/reference/option/language
    // https://datatables.net/plug-ins/i18n/
    const url_cdn_en = '//cdn.datatables.net/plug-ins/2.0.1/i18n/en-GB.json';
    const url_cdn_ja = '//cdn.datatables.net/plug-ins/2.0.1/i18n/ja.json';
    const url_lang_en = '<?= base_url() ?>assets/lang/datatable/cdn/en-GB.json?v=<?= time() ?>';
    const url_lang_ja = '<?= base_url() ?>assets/lang/datatable/ja.json?v=<?= time() ?>';
    let table = null, tbPreview = null;

    $(document).ready(function() {
        loadDataTable();
    });
    
    window.onresize = () => {
        fixBugDataTable();
    }

    function loadDataTable(){
        var optColResize = optionsColResize();
        table = tb.DataTable({
            language: {
                url: (lang == 'en') ? url_lang_en : url_lang_ja,
            },
            scrollX: true,
            // scrollY: '56vh',
            scrollY: '32vh',
            // ordering: false,
            scrollCollapse: true,
            fixedHeader: true,
            fixedColumns: true,
            responsive: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            autoWidth: false, 
            columnDefs: [
                { width: '1%', targets: 0 },
                { width: '20%', targets: 1 },
                { width: '15%', targets: 2 },
                { width: '15%', targets: 3 },
                { width: '70%', targets: 4 },
            ],
            // colResize: optColResize
        });
        // var tbColResize = new $.fn.dataTable.ColResize(table, options);

        // console.log("tbColResize: ", tbColResize, "\noptions: ", options, "\ntable: ", table.colResize);
        // Available methods:
        // table.colResize.enable();  // enable plugin (i.e. when options was isEnabled: false)
        // table.colResize.disable(); // remove all events
        // table.colResize.reset();   // reset column.sWidth values
        // table.colResize.save();    // save the current state (defaults to localstorage)
        // table.colResize.restore(); // restore the state from storage (defaults to localstorage)
    }

    function fixBugDataTable(){
        if(table != null && table.columns.adjust().columns().length != 0){
            table.columns.adjust().draw(); // perbaiki table head tidak responsive ketika tombol hide sidebar diklik
        }
        if(tbPreview != null && tbPreview.columns.adjust().columns().length != 0){
            tbPreview.columns.adjust().draw(); // perbaiki table head tidak responsive ketika tombol hide sidebar diklik
        }
    }
    function optionsColResize(){
        // https://github.com/dhobi/datatables.colResize
        colResize = {
            isEnabled: true,
            saveState: true, // false
            hoverClass: 'dt-colresizable-hover',
            hasBoundCheck: true,
            minBoundClass: 'dt-colresizable-bound-min',
            maxBoundClass: 'dt-colresizable-bound-max',
            isResizable: function (column) {
                // return true;
                return column.idx !== 2;
            },
            // onResizeStart: function (column, columns) {
            // },
            onResize: function (column) {
                // console.log("onResize: ", column);
            },
            onResizeEnd: function (column, columns) {
                console.log("onResizeEnd: ", column, columns);
            },
            stateSaveCallback: function (settings, data) {
                let stateStorageName = window.location.pathname + "/colResizeStateData";
                localStorage.setItem(stateStorageName, JSON.stringify(data));
            },
            stateLoadCallback: function (settings) {
                let stateStorageName = window.location.pathname + "/colResizeStateData",
                data = localStorage.getItem(stateStorageName);
                return data != null ? JSON.parse(data) : null;
            }
            // getMinWidthOf: function ($thNode) {
            // },
            // stateSaveCallback: function (settings, data) {
            // },
            // stateLoadCallback: function (settings) {
            // }
        }
        return colResize;
    }
</script>

<!-- mapbox gl -->
<link href="<?= base_url() ?>assets/libs/mapbox/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">
<script src="<?= base_url() ?>assets/libs/mapbox/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>

<!-- Load the `mapbox-gl-geocoder` plugin. -->
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css">
<script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-language/v1.0.0/mapbox-gl-language.js'></script>

<!-- load turf -->
<script src="https://unpkg.com/@turf/turf@6/turf.min.js"></script>

<!-- https://github.com/mapbox/wellknown -->
<!-- Load WKT https://www.jsdelivr.com/package/npm/wellknown | https://cdn.jsdelivr.net/npm/wellknown@0.5.0/wellknown.min.js -->
<script src="<?=base_url()?>assets/js/wellknown.js"></script>

<!-- Load SHP https://github.com/mapbox/shp-write/tree/master -->
<!-- https://github.com/mbloch/mapshaper -->

<!-- <script src="https://unpkg.com/@mapbox/shp-write@latest/shpwrite.js"></script> -->
<!-- <script src="<?=base_url()?>assets/js/shpwrite.js"></script> -->
<script src="<?=base_url()?>assets/js/shpwriteModif.js?v=time<?=time()?>"></script>

<script src="https://d3js.org/d3.v7.min.js"></script>

<!-- Sweet Alerts -->
<link href="<?=base_url()?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<script src="<?=base_url()?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

<!-- Google Map Place API -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCuP573ebN6ZJTbs3IGcW2G-zgiBH4pp0Q&libraries=places&callback=initPlacesSearch"></script>


<script type="text/javascript">
    // const viewJapan = [140.34, 38.28]; // format lng, lat
    const viewJapan = [106.82717644101359, -6.175421942384241]; // format lng, lat in monas
    // const viewJapan = [-68.137343, 45.137451]; // starting position in US
    const TOKEN_MAP = '<?= token_mapbox ?>';
    const MAIN_STYLE = '<?= ($lang == 'jp') ? style_japan : 'mapbox://styles/mapbox/streets-v11' ?>';
    const STYLE_MAPBOX = 'mapbox://styles/mapbox/';
    const item_style = sessionStorage.getItem('mb_style');
    const get_style_map = (item_style == null || item_style == 'null' || item_style == '' || item_style == undefined) ? MAIN_STYLE : item_style;
    const GMAP_STREET = "https://mt0.google.com/vt/lyrs=m&x={x}&y={y}&z={z}";
    const GMAP_SATELIT = "https://mt0.google.com/vt/lyrs=s&x={x}&y={y}&z={z}";
    const id_user = <?= $id_user ?>;

    let _my_device = get_device();
    var featureCollection = {
        "type": "FeatureCollection",
        // "crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:OGC:1.3:CRS84" } },
        "features": []
    }, 
    current_polygon_name = "",
    _list_all_polygon = {};
    var repeater_html = null;
    var tables = null;
    const allDataFc = <?= json_encode($list_all_geo) ?>;
    let getDataFc = [];
    let getFeatureCollection = "", current_id = "";
    
    // Create a new marker.
    const marker = new mapboxgl.Marker({
        color: "#20b2aa",
        draggable: false
    });
    
    // $("#searchInput").on('input', (e) => {
    //     var val = $(e.target).val();
    //     if (val == "") {
    //         marker.remove();
    //     }
    //     // console.log("searchInput: ", val, marker);
    // });
    $("#searchInput").on('input', initPlacesSearch);

    var input = document.getElementById('searchInput');
    
    function initPlacesSearch() {
        var searchBox = new google.maps.places.SearchBox(input);
        // var searchBox = new google.maps.places.Autocomplete(input);
        var val = $(input).val();
        if (val == "") {
            marker.remove();
        }
        
        searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();
            
            if (places.length === 0) {
                return;
            }

            // Dapatkan koordinat dari tempat yang dipilih
            var place = places;
            var location = places[0].geometry.location;
            var latitude = location.lat();
            var longitude = location.lng();

            // Lakukan apa pun yang Anda inginkan dengan koordinat ini
            console.log('place:', place);
            console.log('Latitude:', latitude);
            console.log('Longitude:', longitude);
            addMarkerGeolocation(place[0]);
        });
    }

    function addMarkerGeolocation(place) {
        const location = place.geometry.location;
        const viewport = place.geometry.viewport;
        
        var lokasi = [location.lng(), location.lat()];
        // var bbox_viewport = [viewport.Bb, viewport.Va];
        var bbox_viewport = [viewport.La, viewport.eb];
        
        console.log("Lokasi: ", lokasi);
        console.log("bbox: ", bbox_viewport);
        // marker_gmap.remove();
        // marker_gmap.setLngLat(lokasi).addTo(map);
        
        marker.remove();
        // Create a new marker.
        marker.setLngLat(lokasi).addTo(map);

        map.flyTo({
            center: lokasi,
            // zoom: 12
            zoom: 18
        });
    }

    function underscore(str){
        return str.replace(/ /g, "_");
    }

    function callAjax(url, type, dataPost){
        return $.ajax({
            type: type,
            url: url,
            data: dataPost,
            // dataType: "dataType",
            // success: function (response) {
                
            // }
        });
    }

    function deleteId(id, polygonName){
        var urlDelete = "<?= base_url('home/deleteId/') ?>"+polygonName;
        
        Swal.fire({
            icon: 'warning',
            // title: 'Are you sure delete data ['+polygonName+']',
            title: '<?= !empty($this->lang->line('are_you_sure_delete_data')) ? $this->lang->line('are_you_sure_delete_data') : "Are you sure delete data "; ?> ['+polygonName+']?',
            // confirmButtonText: "Yes, I want to create a new",
            // cancelButtonText: "No, I want to stay here",
            confirmButtonText: "<?= !empty($this->lang->line('ok')) ? $this->lang->line('ok') : 'OK'; ?>",
            cancelButtonText: "<?= !empty($this->lang->line('cancel')) ? $this->lang->line('cancel') : 'Cancel'; ?>",
            confirmButtonColor: "#20b2aa",
            // cancelButtonColor: "#f46a6a",
            showCancelButton: true,
            allowOutsideClick: false,
        }).then((e) => {
            if (e.isConfirmed) {
                callAjax(urlDelete, 'get').done((result) => {
                    Swal.fire({
                        icon: 'success',
                        title: '<?= !empty($this->lang->line('success_delete_data')) ? $this->lang->line('success_delete_data') : 'Successfully delete data'; ?> ['+polygonName+']',
                        confirmButtonColor: "#20b2aa",
                        showCancelButton: false
                    }).then(() => {
                        window.location = window.location.href;
                    });
                }).fail((err) => {
                    
                    Swal.fire({
                        icon: 'error',
                        title: '<?= !empty($this->lang->line('failed_delete_data')) ? $this->lang->line('failed_delete_data') : 'Failed to delete data'; ?> ['+polygonName+']',
                        confirmButtonColor: "#20b2aa",
                        showCancelButton: false
                    });
                });
            }
        });
    }

    function deleteAll(){
        var urlDelete = "<?= base_url('home/deleteAll') ?>";
        Swal.fire({
            icon: 'warning',
            title: '<?= !empty($this->lang->line('are_you_sure_delete_all')) ? $this->lang->line('are_you_sure_delete_all') : "Are you sure delete all data?" ?>',
            // confirmButtonText: "Yes, I want to create a new",
            // cancelButtonText: "No, I want to stay here",
            confirmButtonText: "<?= !empty($this->lang->line('ok')) ? $this->lang->line('ok') : 'OK'; ?>",
            cancelButtonText: "<?= !empty($this->lang->line('cancel')) ? $this->lang->line('cancel') : 'Cancel'; ?>",
            confirmButtonColor: "#20b2aa",
            // cancelButtonColor: "#f46a6a",
            showCancelButton: true,
            allowOutsideClick: false,
        }).then((e) => {
            if (e.isConfirmed) {
                callAjax(urlDelete, 'get').done((result) => {
                    Swal.fire({
                        icon: 'success',
                        title: '<?= !empty($this->lang->line('success_delete_all')) ? $this->lang->line('success_delete_all') : 'Successfully deleted all data'; ?>',
                        confirmButtonColor: "#20b2aa",
                        showCancelButton: false
                    }).then(() => {
                        window.location = window.location.href;
                    });
                }).fail((err) => {
                    
                    Swal.fire({
                        icon: 'error',
                        title: '<?= !empty($this->lang->line('failed_delete_all')) ? $this->lang->line('failed_delete_all') : 'Failed to delete all data'; ?>',
                        confirmButtonColor: "#20b2aa",
                        showCancelButton: false
                    });
                });
            }
        });
    }
</script>

<script type="text/javascript">
    // ======================================
    // start load Map
    // ======================================
	mapboxgl.accessToken = TOKEN_MAP;
    const map = new mapboxgl.Map({
        container: 'my_map', // container ID
        // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
        // style: 'mapbox://styles/mapbox/dark-v11', // style URL
        // style: (item_style != null || item_style != undefined) ? item_style : 'mapbox://styles/mapbox/dark-v11', // style URL
        style: get_style_map, // style URL
        center: viewJapan, // starting position
        // zoom: 5, // starting zoom
        zoom: 1, // starting zoom
        attributionControl: false
    });
    
    const map_language = new MapboxLanguage({
        defaultLanguage: '<?= ($lang == 'jp') ? 'ja' : 'en' ?>'
    });
    map.addControl(map_language);

    map.addControl(new mapboxgl.AttributionControl({
        customAttribution: `© <?= NAMA_WEB ?>. Design & Developed by <a href="https://asiaresearchinstitute.com/" target="_blank" rel="noopener noreferrer"><img src="<?= base_url() ?>assets/images/LOGO_ARI/logo_ari_green.svg" alt="" width="auto" height="13"></a>`
    }));
    map.addControl(new mapboxgl.NavigationControl(),'bottom-right');
    map.addControl(new mapboxgl.FullscreenControl(),'bottom-right');
    
    var $btn_search = $("#layout-search").removeClass("d-none").addClass("mapboxgl-gl-draw_ctrl-draw-btn");
    $(".mapboxgl-ctrl-bottom-right > .mapboxgl-ctrl-group:nth-child(1)").before($btn_search);

    var $previewFeature = $("#previewFeature").removeClass("d-none").addClass("mapboxgl-gl-draw_ctrl-draw-btn");
    $(".mapboxgl-ctrl-bottom-right > .mapboxgl-ctrl-group:nth-child(3)").after($previewFeature);

    var $deleteFeature = $("#deleteFeature").removeClass("d-none").addClass("mapboxgl-gl-draw_ctrl-draw-btn");
    $(".mapboxgl-ctrl-bottom-right > .mapboxgl-ctrl-group:nth-child(4)").after($deleteFeature);

    const popup = new mapboxgl.Popup({anchor: 'left', closeOnClick: true, closeButton: true, maxWidth: '300px'});

    map.on('style.load', (e) => {
        console.log("map load: ", e);
        // setCameraMap();
        // addFeatureCollection(getFeatureCollection);
        if (current_id != "") {
            showFeatures(current_id);
        }
        // findTools();
    });

    let gmapSourceStreet = 'source-streets-google-map';
    let gmapLayerStreet = 'layer-streets-gmap';

    let gmapSourceSatelit = 'source-satelit-google-map';
    let gmapLayerSatelit = 'layer-satelit-gmap';

    function gmapStyle(type_style = 'street', e){
        var is_style_street_active = 'visible'; // default active street
        var is_style_satelit_active = 'none'; // default active street

        if(type_style == 'street'){
            is_style_satelit_active = 'none';
            is_style_street_active = 'visible';
        }
        if(type_style == 'satelit'){
            is_style_satelit_active = 'visible';
            is_style_street_active = 'none';
        }

        // style_map
        if (!map.getSource(gmapSourceStreet) && !map.getLayer(gmapLayerStreet)) {
            map.addSource(gmapSourceStreet, {
                type: 'raster',
                // tiles: ['https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}'],
                // tiles: [tile_url],
                tiles: [GMAP_STREET],
                tileSize: 256,
            });

            if (!map.getLayer(gmapLayerStreet)) {
                map.addLayer({
                    id: gmapLayerStreet,
                    type: 'raster',
                    source: gmapSourceStreet,
                    minzoom: 0,
                    maxzoom: 22,
                    visibility: is_style_street_active, // visible | none
                });
            }
        } else {
            // map.removeSource(gmapSourceStreet);
            // map.removeLayer(gmapLayerStreet);
        }

        
        if (!map.getSource(gmapSourceSatelit) && !map.getLayer(gmapLayerSatelit)) {
            map.addSource(gmapSourceSatelit, {
                type: 'raster',
                // tiles: ['https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}'],
                // tiles: [tile_url],
                tiles: [GMAP_SATELIT],
                tileSize: 256,
            });

            if (!map.getLayer(gmapLayerSatelit)) {
                map.addLayer({
                    id: gmapLayerSatelit,
                    type: 'raster',
                    source: gmapSourceSatelit,
                    minzoom: 0,
                    maxzoom: 22,
                    visibility: is_style_satelit_active, // visible | none
                });
            }
        } else {
            // map.removeSource(gmapSourceSatelit);
            // map.removeLayer(gmapLayerSatelit);
        }

        map.setLayoutProperty(gmapLayerStreet, 'visibility', is_style_street_active);
        map.setLayoutProperty(gmapLayerSatelit, 'visibility', is_style_satelit_active);
        
        set_active_style(e);
        
        console.log("gmapSourceStreet: ", map.getSource(gmapSourceStreet));
        console.log("gmapSourceSatelit: ", map.getSource(gmapSourceSatelit));
        console.log("gmapLayer1: ", map.getLayer(gmapLayerStreet));
        console.log("gmapLayer2: ", map.getLayer(gmapLayerSatelit));
        console.log("gmapLayer3: ", e);
    }

    // $(".btn-collap").on('click', findTools);
    // // var $btn_collap = $(".btn-collap").removeClass("d-none").addClass("mapboxgl-gl-draw_ctrl-draw-btn");
    // // $(".mapboxgl-ctrl-bottom-right > .mapboxgl-ctrl-group:nth-child(2)").before($btn_collap);

    // function findTools(){
    //     let collapsed = "drawing_tools_collapsed collapse";
    //     // let collapsed = "drawing_tools_collapsed";
    //     let toolsAll = $(".mapboxgl-ctrl-bottom-right>.mapboxgl-ctrl.mapboxgl-ctrl-group");
    //     let toolsWithoutSearch = $(".mapboxgl-ctrl-bottom-right>.mapboxgl-ctrl.mapboxgl-ctrl-group:not(#layout-search,.btn-collap)");

    //     let toggleIconF6Pro = "fa-regular fa-pen-nib";
    //     let toggleIconShow = "fa-pen-nib";
    //     let toggleIconHide = "fa-pen-nib-slash";

    //     let icon = $("#icon_collapse");
    //     if (icon.hasClass(toggleIconF6Pro)) {
    //         icon.addClass(toggleIconHide);
    //         icon.removeClass(toggleIconShow);
    //     } else {
    //         icon.addClass(toggleIconShow);
    //         icon.removeClass(toggleIconHide);
    //     }

    //     if (!toolsWithoutSearch.hasClass(collapsed)) {
    //         toolsWithoutSearch.addClass(collapsed);
    //     }

    //     // console.log("toolsAll: ", toolsAll);
    //     // // console.log("toolsWithoutSearch: ", toolsWithoutSearch);
    //     // console.log("icon: ", icon);
    // }

    var inter = setInterval(() => {
        var improve_map = $(".mapboxgl-control-container > .mapboxgl-ctrl-bottom-right > .mapboxgl-ctrl-attrib > .mapboxgl-ctrl-attrib-inner").children(".mapbox-improve-map");
        // console.log("improve map: ", improve_map);
        if (improve_map.length != 0) {
            improve_map.remove();
            clearInterval(inter);
            findTools();
        }
    }, 500);

    function deleteAllFeature(){
        // hapus semua source & layer, sebelum ditambahkan supaya tdk bertumpuk
        var getFeat = removeAllSourceLayer();
        var check = isObjectEmpty(getFeat);
        if (check) {
            autocloseSweetAlert('Nothing polygon is shown, please click the button view on the table', 'info', 5000);
        }
        // Cek apakah tabel DataTable sudah ada
        if ($.fn.DataTable.isDataTable('#preview-tbl')) {
            // Jika sudah ada, hapus tabel DataTable yang sudah ada
            $('#preview-tbl').DataTable().destroy();
            $('#preview-tbl').empty();
            $("#layout-not-found").removeClass("d-none");
        }
        console.log("deleteAll: ", check, getFeat);
    }

    function showFeatures(id){
        // hapus semua source & layer, sebelum ditambahkan supaya tdk bertumpuk
        removeAllSourceLayer();
        for (let i = 0; i < allDataFc.length; i++) {
            const dataFc = allDataFc[i];
            if (id == dataFc.id_drawing) {
                current_id = id;
                console.log(id, " = ", dataFc.id_drawing, " => ", (id == dataFc.id_drawing));
                getDataFc = dataFc;
                getFeatureCollection = JSON.parse(dataFc.feature_collection);
            }
        }

        if (getDataFc.length != 0) {
            // scroll to bottom
            window.scrollTo(0, document.body.scrollHeight);
            setCameraMap();
            addFeatureCollection(getDataFc.polygon_name, getFeatureCollection);
        }

        // console.log("allDataFc: ", allDataFc);
        // console.log("showFeature: ", id);
        // console.log("getDataFc: ", getDataFc);
        // console.log("getFeatureCollection: ", getFeatureCollection);
    }

    // Fungsi untuk membuat sumber dan lapisan polygon atau line secara dinamis
    function addFeatureCollection(polygon_name, featureCollection) {
        featureCollection.features.forEach(function (feature) {
            var featureId = feature.id;
            var geometryType = feature.geometry.type;
            var dataSource = {
                type: 'Feature',
                properties: feature.properties,
                geometry: feature.geometry
            };

            // console.log("addFeatureCollection: ", featureId, 
            // "\ngeometryType : ", geometryType, 
            // "\ndataSource: ", dataSource);
            
            const sourceId = 'source-'+featureId;
            const layerIdFill = featureId + '-fill';
            const layerIdOutline = featureId + '-outline';
            const layerIdLine = featureId + '-line';
            
            // Hapus lapisan jika sudah ada
            if (map.getLayer(layerIdFill)) {
                map.removeLayer(layerIdFill);
            }
            if (map.getLayer(layerIdOutline)) {
                map.removeLayer(layerIdOutline);
            }
            if (map.getLayer(layerIdLine)) {
                map.removeLayer(layerIdLine);
            }

            // Hapus sumber dan lapisan jika sudah ada
            if (map.getSource(sourceId)) {
                map.removeSource(sourceId);
            }

            // Buat sumber GeoJSON untuk fitur
            map.addSource(sourceId, {
                type: 'geojson',
                data: dataSource
            });

            if (geometryType === 'Polygon' || geometryType === 'MultiPolygon') {
                // Tambahkan lapisan fill untuk Polygon
                var fillLayerStyle = {
                    'id': layerIdFill,
                    'type': 'fill',
                    'source': sourceId,
                    'layout': {},
                    'paint': {
                    'fill-color': '#0080FF',
                    'fill-opacity': 0.3
                    }
                };
                map.addLayer(fillLayerStyle);

                // Tambahkan lapisan outline untuk Polygon
                var outlineLayerStyle = {
                    'id': layerIdOutline,
                    'type': 'line',
                    'source': sourceId,
                    'layout': {},
                    'paint': {
                    'line-color': '#0080FF',
                    'line-width': 3
                    }
                };
                map.addLayer(outlineLayerStyle);
            }

            // Tambahkan lapisan line untuk LineString
            if (geometryType === 'LineString' || geometryType === 'MultiLineString') {
                var lineLayerStyle = {
                    'id': layerIdLine,
                    'type': 'line',
                    'source': sourceId,
                    'layout': {},
                    'paint': {
                    'line-color': '#0080FF',
                    'line-width': 3
                    }
                };
                map.addLayer(lineLayerStyle);
            }

            
            // Tambahkan event handler untuk menampilkan informasi saat diklik
            var featureIdClick = (geometryType === 'Polygon' || geometryType === 'MultiPolygon') ? layerIdFill : layerIdLine;
            map.on('click', featureIdClick, function (e) {
                // popup.remove();
                var properties = e.features[0].properties;
                var info = '<h3>'+polygon_name+'</h3><ul class="mb-0 ps-3 list-unstyled" style="max-height: 200px; overflow: auto;">';
                for (var key in properties) {
                    info += '<li><strong>' + key + ':</strong> ' + properties[key] + '</li>';
                }
                info += '</ul>';

                var center = getCenterPoint(e.features[0]);
                // Tampilkan informasi pada elemen HTML dengan ID 'info'
                if (e.features[0]._geometry.type == 'Polygon') {
                    popup.setLngLat(center)
                    .setHTML(info)
                    .addTo(map);
                } else {
                    popup.setLngLat(e.lngLat)
                    .setHTML(info)
                    .addTo(map);
                }
                console.log("feature: ", e.features[0]._geometry.type);
            });

            map.on('mouseenter', featureIdClick, () => {
                map.getCanvas().style.cursor = 'pointer';
            });
            
            map.on('mouseleave', featureIdClick, () => {
                map.getCanvas().style.cursor = '';
            });
        });

        var convertDT = geoJSONToDataTable(featureCollection.features);
        console.log("convertDT: ", convertDT);
        dynamicDataTable(convertDT);
    }

    function setCameraMap(){
        var bbox = turf.bbox(getFeatureCollection);
        // console.log("bbox: ", bbox);

        // Hitung lebar dan tinggi bounding box
        var bboxWidth = bbox[2] - bbox[0];
        var bboxHeight = bbox[3] - bbox[1];

        // Tentukan persentase padding (misalnya, 10% dari lebar dan tinggi)
        var paddingPercentage = 0.5;
        var paddingX = bboxWidth * paddingPercentage;
        var paddingY = bboxHeight * paddingPercentage;
        map.fitBounds(bbox, {padding: 120 });
        // map.fitBounds(bbox, {padding: {top: 0, bottom: 0, left: paddingX, right: paddingX } });
        // map.fitBounds(bbox, { padding: { top: paddingY, bottom: paddingY, left: paddingX, right: paddingX } });

    }

    function getCenterPoint(features){
        var geomet = features.geometry;

        // Dapatkan koordinat pusat poligon
        var centerCoord = turf.centerOfMass(geomet).geometry.coordinates;
        // console.log("centerCoord: ", centerCoord);
        return centerCoord;
    }

    // Dapatkan daftar semua sumber
    function getAllSources() {
        return map.getStyle().sources;
    }

    function removeAllSourceLayer() {
        var getAllSource = getAllSources();
        const sourceData = Object.fromEntries(
            Object.entries(getAllSource).filter(([key]) => key.startsWith("source-"))
        );
        var keys = Object.keys(sourceData);

        for (let i = 0; i < keys.length; i++) {
            const sourceId = keys[i];
            const keySplit = sourceId.split('-');
            const key = keySplit[keySplit.length-1];
            const layerIdFill = key+"-fill";
            const layerIdOutline = key+"-outline";
            const layerIdLine = key+"-line";
            
            // Hapus lapisan jika sudah ada
            if (map.getLayer(layerIdFill)) {
                map.removeLayer(layerIdFill);
            }
            if (map.getLayer(layerIdOutline)) {
                map.removeLayer(layerIdOutline);
            }
            if (map.getLayer(layerIdLine)) {
                map.removeLayer(layerIdLine);
            }

            // Hapus sumber dan lapisan jika sudah ada
            if (map.getSource(sourceId)) {
                map.removeSource(sourceId);
            }
        }

        // console.log("getAllSource: ", getAllSource);
        // console.log("sourceData: ", sourceData);
        // console.log("sourceDatakeys: ", keys);
        return sourceData;
    }

    function isObjectEmpty(obj) {
        return Object.entries(obj).length === 0;
    }

    // ===============================================
    // Hightlight Layer Polygon
    // ===============================================
    function dynamicDataTable(dataArray){
        var optColResize = optionsColResize();
        // Cek apakah tabel DataTable sudah ada
        if ($.fn.DataTable.isDataTable('#preview-tbl')) {
            // Jika sudah ada, hapus tabel DataTable yang sudah ada
            $('#preview-tbl').DataTable().destroy();
            $('#preview-tbl').empty();
        }

        tbPreview = $('#preview-tbl').DataTable({
            columns: dataArray.columns,
            data: dataArray.data,
            language: {
                url: (lang == 'en') ? url_lang_en : url_lang_ja,
            },
            scrollX: true,
            scrollY: '60vh',
            // scrollY: true,
            scrollCollapse: true,
            fixedHeader: true,
            fixedColumns: true,
            responsive: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            autoWidth: false,
        });
        $("#layout-not-found").addClass("d-none");
    }

    function geoJSONToDataTable(features) {
        var dataTable = [];
        var dataColumns = [];

        features.forEach(function(feature) {
            var row = {};
            var properties = feature.properties;
            var geometry = feature.geometry;

            // ======================================
            // fungsi mengambil key secara otomatis
            // ======================================
            // Add action
            // row['action'] = '<button type="button" class="btn btn-outline-primary btn-sm waves-effect waves-light">Go to map</button>';
            row[''] = '<button type="button" class="d-none btn btn-outline-primary btn-sm waves-effect waves-light">Go to map</button>';
            row['polygon_id'] = feature.id || '';
            row['coordinates'] = JSON.stringify(geometry.coordinates) || '';

            // Loop through each property and add it to the row
            Object.keys(properties).forEach(function(key) {
                row[key] = properties[key];
            });
            
            // Add geometry properties
            row['geometry_type'] = geometry.type || '';
            // row['coordinates'] = JSON.stringify(geometry.coordinates) || '';
            // ======================================

            dataTable.push(row);
            // Check if each column exists, if not, add it with a NULL value
            Object.keys(dataTable[0]).forEach(function(key) {
                if (!(key in row)) {
                    row[key] = 'NULL';
                }
            });
        });
        
        Object.keys(dataTable[0]).forEach((key, v) => {
            // tambahkan ke list untuk inisialisai nama kolom
            var title = formatPropertyName(key);
            // dataColumns.push({'data': key, "title": title});
            var geoImg = { 
                data: 'coordinates',
                title: 'Polygon',
                render: function(data, type, row, i) {
                    if (type === 'display') {
                        // var coordinates = JSON.parse(data);
                        var id_poly = row.polygon_id;
                        var canvas = document.createElement('canvas');
                        var divPolygon = document.createElement('div');
                        divPolygon.id = "polygon-"+id_poly;
                        divPolygon.setAttribute('onclick', 'zoomPolygon("'+id_poly+'")');
                        divPolygon.setAttribute('style', 'cursor: pointer;');
                        canvas.appendChild(divPolygon);
                        var fc = {
                            type: "FeatureCollection",
                            features: [features[i.row]],
                        }
                        // renderGeoJSONImage(false, fc, canvas);
                        renderPolygonImageById(id_poly, divPolygon);
                        console.log("features: ", features, fc);
                        console.log("row: ", i, row);
                        console.log("canvas: ", canvas);
                        console.log("========================");
                        // return $(canvas).html();
                        return canvas.innerHTML;
                    }
                    return '';
                }
            }
            // dataColumns.push({'data': key, 'title': key});
            if (key == 'coordinates') {
                dataColumns.push(geoImg);
            } else {
                dataColumns.push({'data': key, 'title': key});
            }
            
        })
        var result = {"data": dataTable, 'columns': dataColumns};
        return result;
    }
    
    function zoomPolygon(id){
        let blinkInterval = null;
        var idlayer = 'highlight-layer-polygon-'+id;
        var idsource = 'highlight-source-polygon-'+id;
        
        if (map.getSource(idsource) && map.getLayer(idlayer) && blinkInterval != null){
            // Hapus sumber dan lapisan sorotan sebelum menambahkannya kembali
            map.removeLayer(idlayer);
            map.removeSource(idsource);
            clearInterval(blinkInterval);
            console.log("duplicate");
            return zoomPolygon(id);
        } else {

            // var getFeature = draw.get(id);
            var getFeature = filterById(getFeatureCollection.features, id);
            var feat = {
                features: getFeature,
                type: "FeatureCollection"
            }
            console.log("zoomPolygon: ", getFeature, '\nfeatures: ', feat);
            var bbox = turf.bbox(feat);
            map.fitBounds(bbox, {padding: 100 });

            map.addSource(idsource, {
                'type': 'geojson',
                'data': feat
            });
    
            // Tambahkan lapisan untuk menyorot poligon
            map.addLayer({
                'id': idlayer,
                'type': 'fill',
                'source': idsource,
                'layout': {},
                'paint': {
                    'fill-color': '#f00', // Warna sorotan (merah)
                    'fill-opacity': 0.5 // Opasitas sorotan
                }
            });
            
            // Animasi kedip-kedip
            blinkInterval = setInterval(function() {
                const layers = map.getStyle().layers;
                if (layers.some(layer => layer.id === idlayer)) {
                    const currentOpacity = map.getPaintProperty(idlayer, 'fill-opacity');
                    const newOpacity = currentOpacity === 0 ? 0.5 : 0;
                    map.setPaintProperty(idlayer, 'fill-opacity', newOpacity);
                }
            }, 500); // Kedip setiap 0.5 detik
    
            setTimeout(function() {
                // Hapus lapisan sorotan setelah 5 detik
                map.removeLayer(idlayer);
                map.removeSource(idsource);
                // Hentikan animasi kedip-kedip setelah 5 detik
                clearInterval(blinkInterval);
            }, 3000);
        }
    }

    function filterById(data, targetId) {
        return data.filter(item => item.id === targetId);
    }

    function renderPolygonImageById(polygonId, containerId) {
        // https://www.jafaraziz.com/blog/transform-geojson-to-png-with-d3-js/
        // https://www.w3.org/TR/SVG/shapes.html#InterfaceSVGCircleElement
        // https://d3-graph-gallery.com/graph/shape.html
        // https://observablehq.com/@harrylove/draw-a-circle-with-d3

        // Menggunakan Mapbox untuk mengambil gambar poligon berdasarkan ID poligon
        var filterPolygon = filterById(getFeatureCollection.features, polygonId); // koordinat poligon yang sesuai dari Mapbox
        var geoJSON = {
            "type": "FeatureCollection",
            "features": filterPolygon
        }
        var polygonCoordinates = filterPolygon[0].geometry.coordinates; // koordinat poligon yang sesuai dari Mapbox
        var width = 150; // Atur lebar gambar
        var height = 150; // Atur tinggi gambar
        var colors = ["#63e6be", "#38d9a9", "#20c997", "#12b886"];
        var type = (filterPolygon[0].properties.isCircle) ? 'circle' : filterPolygon[0].geometry.type;

        console.log("renderPolygon: ", polygonId, geoJSON);

        // Hapus konten sebelumnya jika ada
        $(containerId).empty();
        // Create SVG container
        var svg = d3.select(containerId)
                    .append("svg")
                    .attr("width", width)
                    .attr("height", height);

        // Create projection and path generator
        var projection = d3.geoMercator().fitSize([width, height], geoJSON);
        var path = d3.geoPath().projection(projection);

        if (type == 'Polygon' || type == 'MultiPolygon') {
            // Render polygon
            svg.selectAll("path")
                .data(geoJSON.features)
                .enter()
                .append("path")
                .attr("d", path)
                // .attr("fill", function(d, i) {
                //     return colors[i % 4];
                // })
                // .attr("fill", '#4ea1f4')
                .attr("fill", '#0080ff')
                // .attr("fill", '#5da9f4')
            .style("fill-opacity", 0.4)
            .style("stroke-width", "3px")
            .attr("stroke", "#0080ff");
        } else if (type == 'circle'){
            svg.selectAll("circle")
            .data(geoJSON.features)
            .enter()
            .append("circle")
            // .attr("cx", function(d) { return projection(d.geometry.coordinates)[0]; })
            // .attr("cy", function(d) { return projection(d.geometry.coordinates)[1]; })
            // .attr("r", filterPolygon[0].properties.radiusInKm) // Atur radius titik
            .attr("cx", '50%')
            .attr("cy", '50%')
            .attr("r", 50) // Atur radius titik
            .style("fill", "#0080ff") // Atur warna titik
            .style("fill-opacity", 0.4) // Atur opasitas titik
            .style("stroke-width", "3px")
            .attr("stroke", "#0080ff");

        } else {
            // Render line polygon
            svg.selectAll("path")
                .data(geoJSON.features)
                .enter()
                .append("path")
                .attr("d", path)
                .attr("fill", 'none')
            .style("stroke-width", "3px")
            .attr("stroke", "#0080ff");
        }
    }

    function formatPropertyName(name) {
        return name.replace(/_/g, ' ').replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
    }
    // ===============================================

    function style_map(e){
        // console.clear();
        const style_id = e.id;
        var getStyle = (style_id == 'default') ? MAIN_STYLE : STYLE_MAPBOX+style_id;
        set_active_style(e);
        
        // if (style_id == 'default') {
        //     // map.setStyle(MAIN_STYLE);
        //     getStyle = MAIN_STYLE;
        // } else {
        //     // map.setStyle(STYLE_MAPBOX + style_id);
        //     getStyle = STYLE_MAPBOX+style_id;
        // }
        map.setStyle(getStyle);
        sessionStorage.setItem('mb_style', getStyle);
        console.log("style_map: ", getStyle, style_id);
        
        // // hapus semua source dan layer terlebih dahulu
        // removeAllSourceLayer();
        // // kemudian gambar ulang polygon atau line nya
        // addFeatureCollection(getFeatureCollection);

    }
    
    const set_active_style = (e_active) => {
        const class_active = 'bg-secondary bg-soft';
        const all_item = document.querySelectorAll('.item_style');
        all_item.forEach((el) => {
            $(el).removeClass(class_active);
        });
        $(e_active).addClass(class_active);
    }

    function load_style(){
        var sp_style = get_style_map.split("/");
        var is_mapbox = sp_style[3];
        var get_id = '';
        var menu_styles = $("#menuStyles");

        if (is_mapbox == 'mapbox') {
            // style from mapbox
            get_id = $("#"+sp_style[sp_style.length-1]);
        } else {
            // default
            get_id = $("#default");
        }
        set_active_style(get_id[0]);
        var load = {
            "sp_style": sp_style,
            "is_mapbox": is_mapbox,
            "get_id": get_id,
        }
        console.log("load_style: ", load);
    }
    load_style();

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
            // window.location = actions;
        });
    }
</script>

<!-- load library DBF -->
<script src="https://unpkg.com/dbf@latest/dbf.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/shpjs@5.0.0/lib/index.min.js"></script> -->
<!-- <script type="module"> 
    import shpjs from 'https://cdn.jsdelivr.net/npm/shpjs@5.0.0/+esm'
    console.log("shpjs: ", shpjs);
    const geojson = await shpjs("<?= base_url()?>db/mygeodata.zip");
    console.log("geojson: ", geojson);
</script> -->
<script src="https://cdn.jsdelivr.net/npm/shapefile@0.6.6/dist/shapefile.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/@timedata/geojson2shp-utf8@0.3.2/index.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/shpjs@1.2.5"></script>

<script>
    const win = window;
    console.log("window: ", win);
    
    // Contoh data GeoJSON
    // const geojsonData = {
    //     "type": "Feature",
    //     "properties": {
    //         "name": "Example Feature",
    //         "filename": "ABC Geometry",
    //     },
    //     "geometry": {
    //         "type": "Point",
    //         "coordinates": [125.6, 10.1]
    //     }
    // };

    let geojsonData = {
        type: "FeatureCollection",
        features: [
            {
                type: "Feature",
                geometry: {
                    type: "Point",
                    coordinates: [0, 0],
                },
                properties: {
                    name: "Foo",
                },
            },
            {
                type: "Feature",
                geometry: {
                    type: "Point",
                    coordinates: [0, 10],
                },
                properties: {
                    name: "Bar",
                },
            },
        ],
    };

    let geojsonData2 = {
        type: "FeatureCollection",
        features:[
            {
                "id": "d0a257ba7f2515b0e022dcc0699e8fe1",
                "type": "Feature",
                "properties": {
                    "formatted_address": "Gg. O No.26, RT.8/RW.13, Ulujami, Kec. Tebet, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12830, Indonesia",
                    "street_number": "26",
                    "route": "Gang O",
                    "administrative_area_level_7": "RT 08",
                    "administrative_area_level_6": "RW 13",
                    "administrative_area_level_4": "Ulujami",
                    "administrative_area_level_3": "Kecamatan Tebet",
                    "administrative_area_level_2": "Kota Jakarta Selatan",
                    "administrative_area_level_1": "Daerah Khusus Ibukota Jakarta",
                    "country": "Indonesia",
                    "postal_code": "12830",
                    "latitude": "-6.2398514",
                    "longitude": "106.8594255",
                    "center": "106.85942625147993,-6.239793784485869",
                    "filename": "My_House"
                },
                "geometry": {
                    "coordinates": [
                        [
                            [
                                [
                                    106.85936850971314,
                                    -6.23965188620889
                                ],
                                [
                                    106.85937060220095,
                                    -6.23973873003338
                                ],
                                [
                                    106.8594101492397,
                                    -6.23973873003338
                                ],
                                [
                                    106.85941092347001,
                                    -6.239649451336135
                                ],
                                [
                                    106.85937830724907,
                                    -6.239649451336135
                                ],
                                [
                                    106.85936850971314,
                                    -6.23965188620889
                                ]
                            ]
                        ],
                        [
                            [
                                [
                                    106.85937370377673,
                                    -6.239790941618807
                                ],
                                [
                                    106.85941809592134,
                                    -6.239793284478807
                                ],
                                [
                                    106.85941715861684,
                                    -6.239749181497393
                                ],
                                [
                                    106.8593738037692,
                                    -6.239749647641697
                                ],
                                [
                                    106.85937370377673,
                                    -6.239790941618807
                                ]
                            ]
                        ],
                        [
                            [
                                [
                                    106.85941668093034,
                                    -6.239725744041891
                                ],
                                [
                                    106.85947785237744,
                                    -6.239725744041891
                                ],
                                [
                                    106.85947954845187,
                                    -6.239649451336135
                                ],
                                [
                                    106.85941881280175,
                                    -6.239649451336135
                                ],
                                [
                                    106.85941668093034,
                                    -6.239725744041891
                                ]
                            ]
                        ],
                        [
                            [
                                [
                                    106.85942046128741,
                                    -6.239740658728873
                                ],
                                [
                                    106.85942184510084,
                                    -6.239793482347209
                                ],
                                [
                                    106.85947628260664,
                                    -6.239796355365755
                                ],
                                [
                                    106.85947753109853,
                                    -6.2397401957875385
                                ],
                                [
                                    106.85942046128741,
                                    -6.239740658728873
                                ]
                            ]
                        ]
                    ],
                    "type": "MultiPolygon"
                }
            }
        ]
    };
    
    geojsonData = geojsonData2;

    // shpwriteModif
    // var istype = isType(gjType);
    // console.log("isType: ", istype);
    
    // Jalankan fungsi setelah wellknown.js dimuat
    function initialize() {
        console.log("geojsonData: ", geojsonData);

        if (typeof wellknown === 'function') {
            // Mengonversi GeoJSON ke WKT dan langsung mencetaknya
            // var wkt = wellknown.stringify(geojsonData);
            
            // STEP 1. bisa menggunakan cara ini untuk mendapatkan semua feature pada Geojson
            var wkt = convertToWKT();
            console.log("Output WKT: ", wkt);

            // STEP 2. atau menggunakan cara ini untuk mendapatkan feature tertentu pada Geojson
            // var features = geojsonData.features;
            // features.forEach((feature) => {
            //     var wkt = convertToWKT(feature);
            //     console.log("Output WKT: ", wkt);
            // });

        } else {
            alert("Function 'WKT' not found")
            console.error("Fungsi 'wellknown' tidak tersedia.");
        }
        // var csv = convertToCSV();
        // console.log("csv key: ", csv);
        // convertAndDownloadCSV();

        try {
            if (window.shpwrite != undefined) {
                // Mengonversi GeoJSON ke WKT dan langsung mencetaknya
                // var wkt = wellknown.stringify(geojsonData);
                // var xhp = convertToSHP(geojsonData);
                // console.log("xhp:", xhp);
            } else {
                alert("Function 'SHP' not found")
                console.error("Fungsi 'shp-write' tidak tersedia.");
            }
            
        } catch (err) {
            console.log("SHP error: ", err);
        }

    }

    // Menunggu hingga semua selesai dimuat
    // document.addEventListener("DOMContentLoaded", initialize);

    function showLoadingBtn(id){
        if (!id) {
            return null;
        }
        var btnDwd = $('#btnDownload'+id);
        var showLoading = $("#iloader"+id);
        showLoading.removeClass("d-none");
        btnDwd.attr("disabled", 'disabled');
    }

    function hideLoadingBtn(id){
        if (!id) {
            return null;
        }
        var btnDwd = $('#btnDownload'+id);
        var showLoading = $("#iloader"+id);
        setTimeout(() => {
            btnDwd.removeAttr("disabled");
            showLoading.addClass("d-none");
        }, 3000);
    }

    function detectAndReplaceJapanese(text) {
        // Regex untuk mengidentifikasi karakter Jepang
        const japaneseRegex = /[\u3040-\u309F\u30A0-\u30FF\u4E00-\u9FAF]/;

        // Mengubah setiap karakter Jepang menjadi "-"
        // const replacedText = text.split('').map(char => {
        //     if (japaneseRegex.test(char)) {
        //         return '-';
        //     } else {
        //         return char;
        //     }
        // }).join('');

        // Mengubah setiap karakter Jepang menjadi "-"
        let isFirstJapaneseChar = true;
        const replacedText = text.split('').map(char => {
            if (japaneseRegex.test(char)) {
                if (isFirstJapaneseChar) {
                    isFirstJapaneseChar = false;
                    return '-';
                } else {
                    return '';
                }
            } else {
                return char;
            }
        }).join('');

        return replacedText;
        // // Contoh penggunaan
        // const japaneseText = "これは日本語のテキストです。";
        // const replacedText = detectAndReplaceJapanese(japaneseText);
        // console.log("replacedText: ", replacedText);
    }

    // ==========================================================
    // START FUNCTION CONVERT GEOJSON TO SHP & DOWNLOAD FILE SHP
    // ==========================================================
    
    var name = '<?= $id_user.'_'.$first_name.''.$last_name ?>';
    console.log("name: ", name);
    function convertToSHP(geoJSONURL = "", filenameSHP = "SHP_file", id){
        // var btnDwd = $('#btnDownload'+id);
        // var showLoading = $("#iloader"+id);
        // console.log(id, " download: ", btnDwd, ' showLoading: ', showLoading);
        // showLoading.removeClass("d-none");
        // btnDwd.attr("disabled", 'disabled');
        showLoadingBtn(id);

        if (geoJSONURL == "") {
            return null;
        }

        const renameFile = detectAndReplaceJapanese(filenameSHP);
        console.log("replacedText: ", renameFile);

        var name = '<?= $id_user.'_'.$first_name.''.$last_name ?>';
        var file = filenameSHP;

        const url_API = `https://geofence-api.asiaresearchinstitute.com/?name=${name}&file=${file}`;
        // Mengkodekan URL dengan encodeURIComponent
        var encodedUrl = `https://geofence-api.asiaresearchinstitute.com/?name=${name}&file=${encodeURIComponent(file)}`;
        var decodeUrl = decodeURIComponent(encodedUrl);
        var encodedURL2 = encodeURI(url_API);

        // Mencetak URL yang sudah dikodekan
        console.log("file: ", file,
            "\nurl_API: ", url_API, 
            "\nencodedUrl: ", encodedUrl, 
            "\nencodedURL2: ", encodedURL2, 
            "\ndecodeUrl: ", decodeUrl
        );

        $.ajax({
            url: `https://geofence-api.asiaresearchinstitute.com/?name=${name}&file=${encodeURIComponent(file)}`,
            // url: 'https://geofence-api.asiaresearchinstitute.com/',
            type: 'GET',
            // data: {
            //     'name': name,
            //     'file': encodeURIComponent(file),
            // },
            dataType: 'json',
            success: function(data) {
                console.log(data); // Mencetak data ke konsol browser
                // Lakukan sesuatu dengan data di sini, seperti menampilkan ke halaman HTML
                console.log("response: ", data);

                if (data.status == 'success') {
                    const link = document.createElement("a");
                    link.href = data.zip_file;
                    link.download = renameFile+".zip"; // Ubah nama file sesuai kebutuhan
                    link.click();
                } else {
                    // alert(data.message)
                    
                    Swal.fire({
                        icon: 'warning',
                        title: data.message,
                        // confirmButtonText: "Yes, I want to create a new",
                        // cancelButtonText: "No, I want to stay here",
                        confirmButtonText: "<?= !empty($this->lang->line('ok')) ? $this->lang->line('ok') : 'OK'; ?>",
                        cancelButtonText: "<?= !empty($this->lang->line('cancel')) ? $this->lang->line('cancel') : 'Cancel'; ?>",
                        confirmButtonColor: "#20b2aa",
                        // cancelButtonColor: "#f46a6a",
                        showCancelButton: false,
                        allowOutsideClick: false,
                    }).then(() => {
                        hideLoadingBtn(id);
                    })
                }
                hideLoadingBtn(id);
            },
            error: function(error) {
                hideLoadingBtn(id);
                console.error('Error:', error);
                var json = error.responseJSON;
                var msg = json.message;
                
                var codeStatus = error.status;
                var validCode = (codeStatus == 400) ? 'Bad Request' : 'Internal Server Error';
                Swal.fire({
                    icon: 'error',
                    title: validCode,
                    text: msg,
                    // confirmButtonText: "Yes, I want to create a new",
                    // cancelButtonText: "No, I want to stay here",
                    confirmButtonText: "<?= !empty($this->lang->line('ok')) ? $this->lang->line('ok') : 'OK'; ?>",
                    cancelButtonText: "<?= !empty($this->lang->line('cancel')) ? $this->lang->line('cancel') : 'Cancel'; ?>",
                    confirmButtonColor: "#20b2aa",
                    // cancelButtonColor: "#f46a6a",
                    showCancelButton: false,
                    allowOutsideClick: false,
                }).then(() => {
                    hideLoadingBtn(id);
                })
            }
        });

        // let date = new Date();
        // let time = date.getTime();

        // // kirim permintaan error
        // $.ajax({
        //     url: `https://geofence-api.asiaresearchinstitute.com/?x=${name}&y=${encodeURIComponent(file)}&time=${time}`,
        //     type: 'GET',
        //     dataType: 'json',
        //     error: function(error) {
        //         console.log("ER1: ", error);
        //         var json = error.responseJSON;
        //         var msg = json.message;
                
        //         var codeStatus = error.status;
        //         var validCode = (codeStatus == 400) ? 'Bad Request' : 'Internal Server Error';
        //         Swal.fire({
        //             icon: 'error',
        //             title: validCode,
        //             text: msg,
        //             // confirmButtonText: "Yes, I want to create a new",
        //             // cancelButtonText: "No, I want to stay here",
        //             confirmButtonText: "<?= !empty($this->lang->line('ok')) ? $this->lang->line('ok') : 'OK'; ?>",
        //             cancelButtonText: "<?= !empty($this->lang->line('cancel')) ? $this->lang->line('cancel') : 'Cancel'; ?>",
        //             confirmButtonColor: "#20b2aa",
        //             // cancelButtonColor: "#f46a6a",
        //             showCancelButton: true,
        //             allowOutsideClick: false,
        //         })

        //         // kirim permintaan error
        //         $.ajax({
        //             url: `https://geofence-api.asiaresearchinstitute.com/`,
        //             type: 'GET',
        //             dataType: 'json',
        //             error: function(error) {
        //                 console.log("ER2: ", error);
        //                 var json = error.responseJSON;
        //                 var msg = json.message;
                        
        //                 var codeStatus = error.status;
        //                 var validCode = (codeStatus == 400) ? 'Bad Request' : 'Internal Server Error';
        //                 Swal.fire({
        //                     icon: 'error',
        //                     title: validCode,
        //                     text: msg,
        //                     // confirmButtonText: "Yes, I want to create a new",
        //                     // cancelButtonText: "No, I want to stay here",
        //                     confirmButtonText: "<?= !empty($this->lang->line('ok')) ? $this->lang->line('ok') : 'OK'; ?>",
        //                     cancelButtonText: "<?= !empty($this->lang->line('cancel')) ? $this->lang->line('cancel') : 'Cancel'; ?>",
        //                     confirmButtonColor: "#20b2aa",
        //                     // cancelButtonColor: "#f46a6a",
        //                     showCancelButton: true,
        //                     allowOutsideClick: false,
        //                 })

        //                 // kirim permintaan error
        //                 $.ajax({
        //                     url: `https://geofence-api.asiaresearchinstitute.com/?name=&file=`,
        //                     type: 'GET',
        //                     dataType: 'json',
        //                     error: function(error) {
        //                         console.log("ER3: ", error);
        //                         var json = error.responseJSON;
        //                         var msg = json.message;
                                
        //                         var codeStatus = error.status;
        //                         var validCode = (codeStatus == 400) ? 'Bad Request' : 'Internal Server Error';
        //                         Swal.fire({
        //                             icon: 'error',
        //                             title: validCode,
        //                             text: msg,
        //                             // confirmButtonText: "Yes, I want to create a new",
        //                             // cancelButtonText: "No, I want to stay here",
        //                             confirmButtonText: "<?= !empty($this->lang->line('ok')) ? $this->lang->line('ok') : 'OK'; ?>",
        //                             cancelButtonText: "<?= !empty($this->lang->line('cancel')) ? $this->lang->line('cancel') : 'Cancel'; ?>",
        //                             confirmButtonColor: "#20b2aa",
        //                             // cancelButtonColor: "#f46a6a",
        //                             showCancelButton: true,
        //                             allowOutsideClick: false,
        //                         })
        //                     }
        //                 });
        //             }
        //         });
        //     }
        // });

        // convertToDBF();

        // // convert GeoJSON to SHP
        // const options = {
        //     // folder: "shapefile",
        //     filename: renameFile,
        //     outputType: "blob",
        //     compression: "DEFLATE",
        //     encoding: 'utf-8', // Atau ganti dengan encoding yang sesuai
        //     types: {
        //         point: "points_"+renameFile,
        //         polygon: "polygons_"+renameFile,
        //         polyline: "lines_"+renameFile,
        //     },
        // };

        // loadGeoJSONFromURL(geoJSONURL, (error, newGeojsonData) => {
        //     if (error) {
        //         console.error("Error loading GeoJSON from URL:", error);
        //     } else {
        //         // Lakukan apa yang Anda inginkan dengan data GeoJSON di sini
        //         console.log("OLD GeoJSON data:", geojsonData);
        //         console.log("NEW set geojson: ", newGeojsonData);
        //         // removeFilenameInGeoJSON(newGeojsonData);

        //         geojsonData = newGeojsonData;
                
        //         const zipData = shpwrite.zip(
        //             geojsonData,
        //             options
        //         );
        //         console.log("shpwrite: ", shpwrite);
        //         console.log("zipData: ", zipData);
        //         hideLoadingBtn(id);
        //         // shpwrite.download(geojsonData, options);

        //         // zipData.then(function(content) {
        //         //     // Inisialisasi unduhan file
        //         //     console.log("then: ", content);
        //         //     const blob = new Blob([content]);
        //         //     const link = document.createElement("a");
        //         //     link.href = window.URL.createObjectURL(blob);
        //         //     // link.download = filenameSHP+".zip"; // Ubah nama file sesuai kebutuhan
        //         //     link.download = renameFile+".zip"; // Ubah nama file sesuai kebutuhan
        //         //     link.click();
                    
        //         //     // btnDwd.removeAttr("disabled");
        //         //     // showLoading.addClass("d-none");
        //         //     hideLoadingBtn(id);
                    
        //         // }).catch(function(error) {
        //         //     hideLoadingBtn(id);
        //         //     // btnDwd.removeAttr("disabled");
        //         //     // showLoading.addClass("d-none");
        //         //     console.error("Error creating SHP file:", error);
        //         // });
        //     }
        // });
        
        // a GeoJSON bridge for features
        // const zipData = shpwrite.zip(geojsonData.features);
    }

    function removeFilenameInGeoJSON(geojson){
        // Menghapus properti "filename" dari setiap fitur
        geojson.features.forEach(feature => {
            delete feature.properties.filename;
        });
        return geojson;
    }

    function toBuffer(ab) {
        // var buffer = Buffer.alloc(ab.byteLength); // Menggunakan Buffer.alloc untuk membuat buffer yang lebih aman
        // var view = new Uint8Array(ab);
        // for (var i = 0; i < buffer.length; ++i) {
        //     buffer[i] = view[i];
        // }
        // return buffer;

        var buffer = new Uint8Array(ab);
        return buffer;
    }

    function convertToDBF(){
        var dbf = window.dbf;
        var buf = dbf.structure([
            {foo:'bar',noo:10},
            {foo:'louie'}
        ]);
        console.log("dbf: ", dbf);
        console.log("buf: ", buf);
        var b = toBuffer(buf.buffer);
        console.log("toBuffer: ", b);

        var ft = {
            "features": [{
                            "id": "64647ef5cde421b4aad6c48a98c09397",
                            "type": "Feature",
                            "properties": {
                                "formatted_address": "Jl. Taman Mini Indonesia Indah No.10, RW.2, Ceger, Kec. Cipayung, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13820, Indonesia",
                                "street_number": "10",
                                "route": "Jalan Taman Mini Indonesia Indah",
                                "administrative_area_level_4": "Ceger",
                                "administrative_area_level_3": "Kecamatan Cipayung",
                                "administrative_area_level_2": "Kota Jakarta Timur",
                                "administrative_area_level_1": "Daerah Khusus Ibukota Jakarta",
                                "country": "Indonesia",
                                "postal_code": "13820",
                                "latitude": "-6.300490099999999",
                                "longitude": "106.8962514",
                                "center": "106.89697537241648,-6.30152253471465",
                                "provinsi": "Sulawesi"
                            },
                            "geometry": {
                                "coordinates": [
                                    [
                                        [
                                            106.89732390329948,
                                            -6.301164173387647
                                        ],
                                        [
                                            106.89725939055734,
                                            -6.301228296385915
                                        ],
                                        [
                                            106.89702553186879,
                                            -6.301180204138163
                                        ],
                                        [
                                            106.89694892298922,
                                            -6.301180204138163
                                        ],
                                        [
                                            106.89687634615433,
                                            -6.301232304073096
                                        ],
                                        [
                                            106.89684005773688,
                                            -6.30131245780936
                                        ],
                                        [
                                            106.89682097162546,
                                            -6.301387064041094
                                        ],
                                        [
                                            106.89679221024139,
                                            -6.30145666471666
                                        ],
                                        [
                                            106.89677776344092,
                                            -6.301542864842759
                                        ],
                                        [
                                            106.89676344885731,
                                            -6.301617041894858
                                        ],
                                        [
                                            106.89682063698632,
                                            -6.301719036633443
                                        ],
                                        [
                                            106.89680780136581,
                                            -6.301857502888126
                                        ],
                                        [
                                            106.89682392955132,
                                            -6.301877541299476
                                        ],
                                        [
                                            106.89688844229346,
                                            -6.301889564345814
                                        ],
                                        [
                                            106.89693682685004,
                                            -6.3018054030160044
                                        ],
                                        [
                                            106.89692876275728,
                                            -6.301637080315388
                                        ],
                                        [
                                            106.89695698708198,
                                            -6.3015729573668295
                                        ],
                                        [
                                            106.89697714731221,
                                            -6.3015729573668295
                                        ],
                                        [
                                            106.89699327549778,
                                            -6.301597003473518
                                        ],
                                        [
                                            106.89700133959059,
                                            -6.301685172520806
                                        ],
                                        [
                                            106.89705778823986,
                                            -6.301749295454712
                                        ],
                                        [
                                            106.89706585233262,
                                            -6.301789372284844
                                        ],
                                        [
                                            106.89711020484287,
                                            -6.301793379967677
                                        ],
                                        [
                                            106.89711423688925,
                                            -6.301761318504077
                                        ],
                                        [
                                            106.89717068553705,
                                            -6.301733264722557
                                        ],
                                        [
                                            106.89717471758331,
                                            -6.301697195571677
                                        ],
                                        [
                                            106.8971263330285,
                                            -6.301657118734383
                                        ],
                                        [
                                            106.897122300982,
                                            -6.301613034210632
                                        ],
                                        [
                                            106.89706632408627,
                                            -6.301560869286277
                                        ],
                                        [
                                            106.89704666141085,
                                            -6.301540303802092
                                        ],
                                        [
                                            106.89703393687535,
                                            -6.3015073251179246
                                        ],
                                        [
                                            106.8970415688338,
                                            -6.301490135851765
                                        ],
                                        [
                                            106.89707252879742,
                                            -6.301479622090568
                                        ],
                                        [
                                            106.89709739359684,
                                            -6.301454738917727
                                        ],
                                        [
                                            106.8971319717966,
                                            -6.301440889702803
                                        ],
                                        [
                                            106.89717476325086,
                                            -6.301413191273042
                                        ],
                                        [
                                            106.89721386049331,
                                            -6.301409292519963
                                        ],
                                        [
                                            106.89722079863549,
                                            -6.301398179804238
                                        ],
                                        [
                                            106.89722008498433,
                                            -6.301373981809558
                                        ],
                                        [
                                            106.8971930063924,
                                            -6.301369093241782
                                        ],
                                        [
                                            106.89717353991728,
                                            -6.301380004781279
                                        ],
                                        [
                                            106.89712923307417,
                                            -6.301392664496028
                                        ],
                                        [
                                            106.89705786747635,
                                            -6.301413599682164
                                        ],
                                        [
                                            106.89697311526584,
                                            -6.301454432933895
                                        ],
                                        [
                                            106.89691955434068,
                                            -6.301404870678184
                                        ],
                                        [
                                            106.89690762552203,
                                            -6.30133600500173
                                        ],
                                        [
                                            106.89693815194954,
                                            -6.3012916012083195
                                        ],
                                        [
                                            106.89699492177925,
                                            -6.3012614255138715
                                        ],
                                        [
                                            106.89710913072236,
                                            -6.301272713560522
                                        ],
                                        [
                                            106.89730300358605,
                                            -6.301279092597696
                                        ],
                                        [
                                            106.89737228785441,
                                            -6.301252342508505
                                        ],
                                        [
                                            106.89740051217916,
                                            -6.301180204138163
                                        ],
                                        [
                                            106.89738841603992,
                                            -6.301116081133131
                                        ],
                                        [
                                            106.89734809557615,
                                            -6.301116081133131
                                        ],
                                        [
                                            106.89732390329948,
                                            -6.301164173387647
                                        ],
                                        [
                                            106.89732390329948,
                                            -6.301164173387647
                                        ]
                                    ]
                                ],
                                "type": "Polygon"
                            }
                        }],
            "type": "FeatureCollection" 
        }
        var points = [
            [
                [
                    106.89732390329948,
                    -6.301164173387647
                ],
                [
                    106.89725939055734,
                    -6.301228296385915
                ],
                [
                    106.89702553186879,
                    -6.301180204138163
                ],
                [
                    106.89694892298922,
                    -6.301180204138163
                ],
                [
                    106.89687634615433,
                    -6.301232304073096
                ],
                [
                    106.89684005773688,
                    -6.30131245780936
                ],
                [
                    106.89682097162546,
                    -6.301387064041094
                ],
                [
                    106.89679221024139,
                    -6.30145666471666
                ],
                [
                    106.89677776344092,
                    -6.301542864842759
                ],
                [
                    106.89676344885731,
                    -6.301617041894858
                ],
                [
                    106.89682063698632,
                    -6.301719036633443
                ],
                [
                    106.89680780136581,
                    -6.301857502888126
                ],
                [
                    106.89682392955132,
                    -6.301877541299476
                ],
                [
                    106.89688844229346,
                    -6.301889564345814
                ],
                [
                    106.89693682685004,
                    -6.3018054030160044
                ],
                [
                    106.89692876275728,
                    -6.301637080315388
                ],
                [
                    106.89695698708198,
                    -6.3015729573668295
                ],
                [
                    106.89697714731221,
                    -6.3015729573668295
                ],
                [
                    106.89699327549778,
                    -6.301597003473518
                ],
                [
                    106.89700133959059,
                    -6.301685172520806
                ],
                [
                    106.89705778823986,
                    -6.301749295454712
                ],
                [
                    106.89706585233262,
                    -6.301789372284844
                ],
                [
                    106.89711020484287,
                    -6.301793379967677
                ],
                [
                    106.89711423688925,
                    -6.301761318504077
                ],
                [
                    106.89717068553705,
                    -6.301733264722557
                ],
                [
                    106.89717471758331,
                    -6.301697195571677
                ],
                [
                    106.8971263330285,
                    -6.301657118734383
                ],
                [
                    106.897122300982,
                    -6.301613034210632
                ],
                [
                    106.89706632408627,
                    -6.301560869286277
                ],
                [
                    106.89704666141085,
                    -6.301540303802092
                ],
                [
                    106.89703393687535,
                    -6.3015073251179246
                ],
                [
                    106.8970415688338,
                    -6.301490135851765
                ],
                [
                    106.89707252879742,
                    -6.301479622090568
                ],
                [
                    106.89709739359684,
                    -6.301454738917727
                ],
                [
                    106.8971319717966,
                    -6.301440889702803
                ],
                [
                    106.89717476325086,
                    -6.301413191273042
                ],
                [
                    106.89721386049331,
                    -6.301409292519963
                ],
                [
                    106.89722079863549,
                    -6.301398179804238
                ],
                [
                    106.89722008498433,
                    -6.301373981809558
                ],
                [
                    106.8971930063924,
                    -6.301369093241782
                ],
                [
                    106.89717353991728,
                    -6.301380004781279
                ],
                [
                    106.89712923307417,
                    -6.301392664496028
                ],
                [
                    106.89705786747635,
                    -6.301413599682164
                ],
                [
                    106.89697311526584,
                    -6.301454432933895
                ],
                [
                    106.89691955434068,
                    -6.301404870678184
                ],
                [
                    106.89690762552203,
                    -6.30133600500173
                ],
                [
                    106.89693815194954,
                    -6.3012916012083195
                ],
                [
                    106.89699492177925,
                    -6.3012614255138715
                ],
                [
                    106.89710913072236,
                    -6.301272713560522
                ],
                [
                    106.89730300358605,
                    -6.301279092597696
                ],
                [
                    106.89737228785441,
                    -6.301252342508505
                ],
                [
                    106.89740051217916,
                    -6.301180204138163
                ],
                [
                    106.89738841603992,
                    -6.301116081133131
                ],
                [
                    106.89734809557615,
                    -6.301116081133131
                ],
                [
                    106.89732390329948,
                    -6.301164173387647
                ],
                [
                    106.89732390329948,
                    -6.301164173387647
                ]
            ]
        ];
        shpwrite.write(
            // feature data
            ft.features,
            // geometry type
            'POLYGON',
            // geometries
            points,
            finish);
        function finish(err, file){
            console.log("finish:", file, "\nerr", err);
            var changeBuffer = {
                "dbf": toBuffer(file.dbf.buffer),
                "prj": file.prj,
                "shp": toBuffer(file.shp.buffer),
                "shx": toBuffer(file.shx.buffer),
            };
            var dataPost = {
                // "data_file": JSON.stringify(file),
                "data_file": JSON.stringify(changeBuffer)
            };
            console.log("changeBuffer: ", changeBuffer);
            console.log("dataPost: ", dataPost);

            callAjax('<?=base_url()?>home/convert', 'POST', dataPost).
            done((respon) => {
                console.log("respon: ", respon);
            }).fail((err) => {
                console.log("Error: ", err);
            })
        }

        // var urlAPI1 = `https://geofence-api.asiaresearchinstitute.com/2_DemoAccount/3_polygon`;
        var urlAPI1 = `https://geofence-api.asiaresearchinstitute.com/`;
        var urlAPI2 = `http://127.0.0.1:5000/2_DemoAccount/3_polygon`;
        var urlAPI = urlAPI1;
        var dataGet = {
            'name' : '2_DemoAccount',
            'file': '3_polygon'
        }

        $.ajax({
            url: 'https://geofence-api.asiaresearchinstitute.com/?name=2_DemoAccount&file=3_polygon',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log(data); // Mencetak data ke konsol browser
                // Lakukan sesuatu dengan data di sini, seperti menampilkan ke halaman HTML
                console.log("response: ", data);
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });

        // // URL ke file GeoJSON
        // const geojsonUrl = 'upload/files/2_DemoAccount/Indonesian_drawing_by_アフマド.geojson';

        // // Fungsi untuk mengonversi GeoJSON menjadi Shapefile dan membaca file Shapefile dan DBF
        // function convertAndReadShapefile(geojsonUrl) {
        //     // Membaca file Shapefile
        //     var shp = 'db/Indonesian_drawing_by/polygons_Indonesian_drawing_by_-.shp';
        //     shapefile.openShp(shp)
        //         .then(source => source.read()
        //             .then(function log(result) {
        //                 if (result.done) return;
        //                 console.log(result.value); // Data geometri dari file Shapefile
        //                 return source.read().then(log);
        //             })
        //         )
        //         .catch(error => console.error(error.stack));

        //     var dbfFile = 'db/Indonesian_drawing_by/polygons_Indonesian_drawing_by_-.dbf';
        //     shapefile.openDbf(dbfFile)
        //         .then(source => source.read()
        //             .then(function log(result) {
        //                 if (result.done) return;
        //                 console.log(result.value); // Data geometri dari file Shapefile
        //                 return source.read().then(log);
        //             })
        //         )
        //         .catch(error => console.error(error.stack));

        //     // fetch(geojsonUrl)
        //     //     .then(response => response.json())
        //     //     .then(geojsonData => {
        //     //         // Mengonversi GeoJSON menjadi Shapefile
        //     //         shpwrite.write(geojsonData)
        //     //             .then(shp => {
        //     //                 // Membaca file Shapefile
        //     //                 shapefile.open(shp)
        //     //                     .then(source => source.read()
        //     //                         .then(function log(result) {
        //     //                             if (result.done) return;
        //     //                             console.log(result.value); // Data geometri dari file Shapefile
        //     //                             return source.read().then(log);
        //     //                         })
        //     //                     )
        //     //                     .catch(error => console.error(error.stack));
        //     //             })
        //     //             .catch(error => console.error(error.stack));
        //     //     })
        //     // .catch(error => console.error(error));
        // }

        // // Memanggil fungsi untuk membaca file Shapefile dan DBF
        // convertAndReadShapefile(geojsonUrl);
    }
    // setTimeout(() => {
    //     convertToDBF();
    // }, 5000);
    // Menunggu hingga semua selesai dimuat
    document.addEventListener("DOMContentLoaded", convertToDBF);
    // ==========================================================
    // END FUNCTION CONVERT GEOJSON TO SHP & DOWNLOAD FILE SHP
    // ==========================================================

    // ==========================================================
    // START FUNCTION CONVERT GEOJSON TO WKT & DOWNLOAD FILE WKT
    // ==========================================================
    function convertToWKT(feature = null){
        // turf
        if (feature === null) {
            // console.clear();
            // STEP 1. bisa menggunakan cara ini untuk mendapatkan semua feature pada Geojson
            var features = geojsonData.features;
            var listWkt = [];

            features.forEach((feature, index, listAll) => {
                // console.log("index: ", index, "\nfeature: ", feature, "\nlistAll: ", listAll);
                // convert GeoJSON to WKT
                var wkt = wellknown.stringify(feature);
                // listWkt.push({"wkt": wkt, "feature": feature});
                listWkt.push(wkt);
            });
            // console.log("Output WKT: ", listWkt);
            // return listWkt;
            // var joinWkt = listWkt.join("\n");
            var joinWkt = `GEOMETRYCOLLECTION(${listWkt.join(",")})`;
            // var oftype = geojsonData.features.filter(function (f) {
            //     var t = f.geometry.type;
            //     console.log("f: ", f, '\nt: ', t);
            //     return f.geometry.type === t;
            // });
            // console.log("ofType: ", oftype);
            return joinWkt;
        } else {
            // STEP 2. bisa menggunakan cara ini untuk mendapatkan feature tertentu pada Geojson
            // convert GeoJSON to WKT
            var wkt = wellknown.stringify(feature);
            return wkt;
        }
        
    }
    function downloadWKT(data, filename, id) {
        var blob = new Blob([data], { type: "text/plain" });
        var link = document.createElement("a");
        link.href = window.URL.createObjectURL(blob);
        link.download = filename + ".wkt";
        link.click();
        hideLoadingBtn(id);
    }

    function createAndDownloadWKT(geoJSONURL = '', filename = 'WKT_Data', id){
        showLoadingBtn(id);
        if (geoJSONURL == "") {
            return null;
        }
        
        var url = geoJSONURL;
        loadGeoJSONFromURL(geoJSONURL, (error, newGeojsonData) => {
            if (error) {
                console.error("Error loading GeoJSON from URL:", error);
            } else {
                // Lakukan apa yang Anda inginkan dengan data GeoJSON di sini
                console.log("OLD GeoJSON data:", geojsonData);
                console.log("NEW set geojson: ", newGeojsonData);

                geojsonData = newGeojsonData;
                var wktData = convertToWKT();
                console.log("result WKT: ", wktData);
                
                downloadWKT(wktData, filename, id);

                // wktData.forEach((v, i, a) => {
                //     var getCSV = v.csv;
                //     var featProp = v.feature.properties;
                //     var getFilename = (featProp.filename == undefined || featProp.filename == null) ? "GeoJSON_Data" : featProp.filename;
                //     getFilename = filename;

                //     downloadCSV(getCSV, getFilename);
                //     console.log("Still processing the download, please wait...");
                // });
            }
        });
    }
    // ==========================================================
    // END FUNCTION CONVERT GEOJSON TO WKT & DOWNLOAD FILE WKT
    // ==========================================================
    
    // ==========================================================
    // START FUNCTION CONVERT GEOJSON TO CSV & DOWNLOAD FILE CSV
    // ==========================================================
    function convertToCSV(isFeature = null){
        // convert GeoJSON to CSV
        if (!geojsonData || !geojsonData.features || geojsonData.features.length === 0) {
            console.error("GeoJSON data is empty or invalid.");
            return null;
        }

        var listCsvData = [];
        var maxProperties = 0;

        // // Header CSV
        // var header = Object.keys(geojsonData.features[0].properties);
        // listCsvData.push(header.join(";"));

        // Menghitung jumlah maksimum properti dari semua fitur
        geojsonData.features.forEach(function(feature) {
            var propertiesCount = Object.keys(feature.properties).length;
            if (propertiesCount > maxProperties) {
                maxProperties = propertiesCount;
            }
        });

        // Header CSV dari fitur dengan jumlah properti terbanyak
        var header = [], listAllCSV = {"header": [], "row": []};
        var idColumn = "unique_id"; // Nama kolom ID
        // header.push(idColumn); // Menambahkan kolom ID ke header
        var newHeader = [];

        geojsonData.features.forEach(function(feature) {
            var properties = Object.keys(feature.properties);
            if (properties.length === maxProperties) {
                header = properties;
                // newHeader = header.concat(properties);
            }
        });
        header.unshift(idColumn); // menambahkan kolom ID ke posisi pertama
        // header = newHeader; // ganti semua isi array dengan newHeader yang telah di concat

        listCsvData.push(header.join(";"));
        listAllCSV.header.push(header);

        // Data CSV
        geojsonData.features.forEach(function(feature) {
            var rowData = [];
            header.forEach(function(property) {
                var value = feature.properties[property];
                if (property == idColumn) {
                    rowData.push(feature.id); // Menambahkan ID ke baris data
                } else {
                    rowData.push(value ? value : '-'); // Jika nilainya kosong, gunakan karakter '-'
                }
                // rowData.push(feature.properties[property]);
            });
            listCsvData.push(rowData.join(";"));
            listAllCSV.row.push(rowData);
        });

        console.log("listCsvData: ", listCsvData);
        console.log("listAllCSV: ", listAllCSV);
        // Gabungkan baris menjadi satu teks CSV
        var csvText = listCsvData.join("\n");
        // console.log("csvText: ", csvText);

        return csvText;

        // if (isFeature === null && geojsonData.features.length > 0) {
        //     var features = geojsonData.features;
        //     var listCSV = [];

        //     features.forEach((feature, index) => {
        //         const properties = Object.keys(feature.properties);
        //         const val_prop = Object.values(feature.properties);
        //         const coordinates = feature.geometry.coordinates;
        //         // const csvData = [properties.join(",")];
        //         // csvData.push(val_prop.join(","));
        //         const csvData = [properties.join(";")];
        //         csvData.push(val_prop.join(";"));
        //         const csv = csvData.join("\n");

        //         var outputCSV = {
        //             "feature": feature,
        //             "properties": properties,
        //             "val_prop": val_prop,
        //             "coordinates": coordinates,
        //             "csvData": csvData,
        //             "csv": csv,
        //         };
        //         listCSV.push(outputCSV);
                
        //         console.log("==================================");
        //         console.log("outputCSV:", outputCSV);
        //         console.log("csv: ", csv);
        //     });
        //     console.log("listCSV: ", listCSV);
        //     return listCSV;

        // } else {
        //     const properties = Object.keys(geojsonData.properties);
        //     const val_prop = Object.values(geojsonData.properties);
        //     const coordinates = geojsonData.geometry.coordinates;
        //     // const csvData = [properties.join(",")];
        //     // csvData.push(val_prop.join(","));
        //     const csvData = [properties.join(";")];
        //     csvData.push(val_prop.join(";"));
        //     const csv = csvData.join("\n");
        //     var outputCSV = {
        //         "properties": properties,
        //         "val_prop": val_prop,
        //         "coordinates": coordinates,
        //         "csvData": csvData,
        //         "csv": csv,
        //     };
        //     console.log("outputCSV:", outputCSV);
        //     // console.log("CSV:", csv);
        //     return csv;
        // }
    }

    function downloadCSV(csv, filename, id) {
        var csvFile;
        var downloadLink;

        // CSV file
        csvFile = new Blob([csv], {type: "text/csv"});

        // Download link
        downloadLink = document.createElement("a");

        // File name
        downloadLink.download = filename;

        // We create a link to the CSV blob
        downloadLink.href = window.URL.createObjectURL(csvFile);

        // Hide download link
        downloadLink.style.display = "none";

        // Add the link to DOM
        document.body.appendChild(downloadLink);

        // Click download link
        downloadLink.click();
        hideLoadingBtn(id);
    }

    function convertAndDownloadCSV(geoJSONURL = "", filename = 'GeoJSON_Data.csv', id) {
        showLoadingBtn(id);
        // var filename = "GeoJSON_Data.csv"; // default file
        if (geoJSONURL != "") {
            var url = geoJSONURL;
            loadGeoJSONFromURL(geoJSONURL, (error, newGeojsonData) => {
                if (error) {
                    console.error("Error loading GeoJSON from URL:", error);
                } else {
                    // Lakukan apa yang Anda inginkan dengan data GeoJSON di sini
                    console.log("OLD GeoJSON data:", geojsonData);
                    console.log("NEW set geojson: ", newGeojsonData);

                    geojsonData = newGeojsonData;
                    var csvData = convertToCSV();
                    // console.log("result CSV: ", csvData);
                    
                    if (!csvData || csvData != "") {
                        downloadCSV(csvData, filename, id);
                        alert("Success to convert data to CSV");
                    } else {
                        alert("Failed to convert data to CSV");
                    }

                    // csvData.forEach((v, i, a) => {
                    //     var getCSV = v.csv;
                    //     var featProp = v.feature.properties;
                    //     var getFilename = (featProp.filename == undefined || featProp.filename == null) ? "GeoJSON_Data" : featProp.filename;
                    //     getFilename = filename;

                    //     downloadCSV(getCSV, getFilename);
                    //     console.log("Still processing the download, please wait...");
                    // });
                }
            })
        }

        // If the result is an array of CSV data (multiple features)
        // if (Array.isArray(csvData)) {
        //     // We'll handle this later, maybe prompt the user to choose which feature to download
        //     console.log("Multiple features detected, handling not implemented yet.");
        // } else {
        //     // Single CSV data, directly download
        //     downloadCSV(csvData, filename);
        // }

    }

    function loadGeoJSONFromURL(url, callback) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", url, true);
        xhr.responseType = "json";

        xhr.onload = function() {
            var status = xhr.status;
            if (status == 200) {
                callback(null, xhr.response);
            } else {
                callback(new Error("Failed to load GeoJSON from URL"), null);
            }
        };

        xhr.onerror = function() {
            callback(new Error("Network error occurred"), null);
        };

        xhr.send();
    }
    // ==========================================================
    // END FUNCTION CONVERT GEOJSON TO CSV & DOWNLOAD FILE CSV
    // ==========================================================

</script>

<!-- <script type="module">
    var parse = require('wellknown');
    console.log("parse: ", parse);
    parse('POINT(1 2)');
</script> -->