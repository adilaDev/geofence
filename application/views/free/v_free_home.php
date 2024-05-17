<?php 
    $token_user = $this->session->userdata("user_token");
?>
<div class="main-content">
    <div class="page-content m-0 pb-0">
        <div class="container-fluid">

            <div class="card-title mb-3">List Drawing Map</div>

            <div class="row mb-0">
                <div class="col-12">
                    <div class="card card-effect">
                        <div class="card-body">
                            <div class="card-title">Free User Information</div>
                            <hr>
                            <div class="data-user mb-3">
                                <?php if ($user_info): ?>
                                    <p class="mb-1"><strong>Token:</strong> <?= $user_info['token'] ?></p>
                                    <p class="mb-1"><strong>IP Address:</strong> <?= $user_info['ip_address'] ?></p>
                                    <p class="mb-1"><strong>Browser:</strong> <?= $user_info['browser'] ?></p>
                                    <p class="mb-1"><strong>Cookies:</strong> <?= $user_info['cookies'] ?></p>
                                    <p class="mb-1"><strong>Created At:</strong> <?= $user_info['created_at'] ?></p>
                                    <p class="mb-1"><strong>Last login:</strong> <?= $user_info['last_login'] ?></p>
                                <?php else: ?>
                                    <p>No user info available.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- ./row -->

            <div class="row mb-0">
                <div class="col-12 col-md-7 mb-0">
                    <div class="card card-effect">
                        <div class="card-body pb-2">

                            <div class="mb-3">
                                <a href="<?=base_url('client/map')?>" class="btn btn-outline-primary btn-sm waves-effect waves-light me-2">
                                    <i class="fas fa-map-marked-alt font-size-16 align-middle me-2"></i>Create Polygons
                                </a>
                                <button type="submit" onclick="deleteAll()" class="btn btn-outline-danger btn-sm waves-effect waves-light me-2" <?= (is_array($list_all_geo) && count($list_all_geo) == 0) ? 'disabled' : '' ?>>
                                    <i class="fas fa-trash font-size-16 align-middle me-2"></i>Delete All
                                </button>
                                <button type="submit" onclick="window.location='<?=base_url('client/map/downloadAll')?>'" class="btn btn-outline-info btn-sm waves-effect waves-light me-2" <?= (is_array($list_all_geo) && count($list_all_geo) == 0) ? 'disabled' : '' ?>>
                                    <i class="fas fa-file-archive font-size-16 align-middle me-2"></i>Download All
                                    <!-- <i class="mdi mdi-folder-download font-size-16 align-middle me-2"></i>Download All -->
                                </button>
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
                                            <td>No</td>
                                            <td>Filename</td>
                                            <td>Output</td>
                                            <td>Updated</td>
                                            <td>Action</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach ($list_all_geo as $item) : ?>
                                            <tr class="align-middle">
                                                <td><?= $no++ ?></td>
                                                <td><?= $item->polygon_name ?></td>
                                                <td>
                                                    <a href="<?= $item->link ?>" download class="btn btn-primary btn-sm waves-effect waves-light">
                                                        <!-- <i class="fas fa-file-download font-size-13 align-middle"></i>  -->
                                                        Download
                                                    </a>
                                                </td>
                                                <td><?= convert_ymdhi($item->last_update, "d-m-Y H:i") ?></td>
                                                <td>
                                                    <button type="button" onclick="showFeatures('<?= $item->id_drawing ?>')" class="btn btn-outline-info btn-sm waves-effect waves-light me-1 mb-lg-1 mb-2">
                                                        <i class="bx bx-map-alt align-middle font-size-14"></i> View
                                                    </button>
                                                    <button type="button" onclick="window.location='<?= base_url('client/map/edit/'.$item->polygon_name) ?>'" class="btn btn-outline-warning btn-sm waves-effect waves-light me-1 mb-lg-1 mb-2">
                                                        <i class="bx bx-pen align-middle font-size-14"></i> Edit
                                                    </button>
                                                    <button type="button" onclick="deleteId('<?= $item->id_drawing ?>', '<?=$item->polygon_name?>')" class="btn btn-outline-danger btn-sm waves-effect waves-light me-1 mb-lg-1 mb-2">
                                                        <i class="bx bx-trash align-middle font-size-14"></i> Delete
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
                        <button type="button" id="search-dropdown" class="waves-effect waves-light mapboxgl-gl-draw_ctrl-draw-btn m-0 pt-1 waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false">
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
    <button type="submit" onclick="deleteAllFeature()" id="btnDeleteFeature" title="Delete all polygon" class="mapboxgl-gl-draw_ctrl-draw-btn waves-effect waves-light">
        <i class="fas fa-trash font-size-16 align-middle"></i>
    </button>
</div>

<!-- DataTables -->
<link href="<?=base_url()?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<!-- Required datatable js -->
<script src="<?=base_url()?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

<!-- jQuery dataTables ColResize -->
<!-- <link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> -->
<link href="https://cdn.jsdelivr.net/npm/datatables.net-colresize-unofficial@latest/jquery.dataTables.colResize.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.jsdelivr.net/npm/datatables.net-colresize-unofficial@latest/jquery.dataTables.colResize.js"></script>

<script type="text/javascript">
    const tb = $("#dashboard");
    $(document).ready(function() {
        loadDataTable();
    });

    function loadDataTable(){
        var optColResize = optionsColResize();
        var table = tb.DataTable({
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

<script src="https://unpkg.com/@turf/turf@6/turf.min.js"></script>

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
    const MAIN_STYLE = '<?= style_japan ?>';
    const STYLE_MAPBOX = 'mapbox://styles/mapbox/';
    const item_style = sessionStorage.getItem('mb_style');
    const get_style_map = (item_style == null || item_style == 'null' || item_style == '' || item_style == undefined) ? MAIN_STYLE : item_style;
    const token_user = '<?= $token_user ?>';

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
            title: 'Are you sure delete data ['+polygonName+']',
            // confirmButtonText: "Yes, I want to create a new",
            // cancelButtonText: "No, I want to stay here",
            confirmButtonColor: "#20b2aa",
            // cancelButtonColor: "#f46a6a",
            showCancelButton: true,
            allowOutsideClick: false,
        }).then((e) => {
            if (e.isConfirmed) {
                callAjax(urlDelete, 'get').done((result) => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Successfully deleted data '+polygonName+'?',
                        confirmButtonColor: "#20b2aa",
                        showCancelButton: false
                    }).then(() => {
                        window.location = window.location.href;
                    });
                }).fail((err) => {
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to delete data ['+polygonName+']',
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
            title: 'Are you sure delete all data?',
            // confirmButtonText: "Yes, I want to create a new",
            // cancelButtonText: "No, I want to stay here",
            confirmButtonColor: "#20b2aa",
            // cancelButtonColor: "#f46a6a",
            showCancelButton: true,
            allowOutsideClick: false,
        }).then((e) => {
            if (e.isConfirmed) {
                callAjax(urlDelete, 'get').done((result) => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Successfully deleted all data',
                        confirmButtonColor: "#20b2aa",
                        showCancelButton: false
                    }).then(() => {
                        window.location = window.location.href;
                    });
                }).fail((err) => {
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to delete all data',
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
        zoom: 10, // starting zoom
        attributionControl: false
    });
    
    map.addControl(new mapboxgl.AttributionControl({
        customAttribution: `© <?= NAMA_WEB ?>. Design & Developed by <a href="https://asiaresearchinstitute.com/" target="_blank" rel="noopener noreferrer"><img src="<?= base_url() ?>assets/images/LOGO_ARI/logo_ari_green.svg" alt="" width="auto" height="13"></a>`
    }));
    map.addControl(new mapboxgl.NavigationControl(),'bottom-right');
    map.addControl(new mapboxgl.FullscreenControl(),'bottom-right');
    
    var $btn_search = $("#layout-search").removeClass("d-none").addClass("mapboxgl-gl-draw_ctrl-draw-btn");
    $(".mapboxgl-ctrl-bottom-right > .mapboxgl-ctrl-group:nth-child(1)").before($btn_search);

    var $deleteFeature = $("#deleteFeature").removeClass("d-none").addClass("mapboxgl-gl-draw_ctrl-draw-btn");
    $(".mapboxgl-ctrl-bottom-right > .mapboxgl-ctrl-group:nth-child(3)").after($deleteFeature);

    const popup = new mapboxgl.Popup({anchor: 'left', closeOnClick: true, closeButton: true, maxWidth: '300px'});

    map.on('style.load', (e) => {
        console.log("map load: ", e);
        // setCameraMap();
        // addFeatureCollection(getFeatureCollection);
        if (current_id != "") {
            showFeatures(current_id);
        }
    });
    var inter = setInterval(() => {
        var improve_map = $(".mapboxgl-control-container > .mapboxgl-ctrl-bottom-right > .mapboxgl-ctrl-attrib > .mapboxgl-ctrl-attrib-inner").children(".mapbox-improve-map");
        console.log("improve map: ", improve_map);
        if (improve_map.length != 0) {
            improve_map.remove();
            clearInterval(inter);
        }
    }, 500);

    function deleteAllFeature(){
        // hapus semua source & layer, sebelum ditambahkan supaya tdk bertumpuk
        var getFeat = removeAllSourceLayer();
        var check = isObjectEmpty(getFeat);
        if (check) {
            autocloseSweetAlert('Nothing polygon is shown, please click the button view on the table', 'info', 5000);
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

            if (geometryType === 'Polygon') {
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
            if (geometryType === 'LineString') {
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
            var featureIdClick = (geometryType === 'Polygon') ? layerIdFill : layerIdLine;
            map.on('click', featureIdClick, function (e) {
                // popup.remove();
                var properties = e.features[0].properties;
                var info = '<h3>'+polygon_name+'</h3><ul class="mb-0 ps-3" style="max-height: 200px; overflow: auto;">';
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