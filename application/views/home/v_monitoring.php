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
    <div class="page-content p-0 pt-3">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Monitoring Users</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?=base_url('home')?>">Home</a></li>
                                <li class="breadcrumb-item active">Monitoring Users</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card card-effect">
                        <div class="card-body">
                            <pre class="d-none" style="max-height: 300px;">
                                <?= print_r ($list_all_info);?>
                            </pre>

                            <div class="table-responsive">
                                <table id="table_info" class="table table-sm table-bordered table-hover border border-secondary w-100" style="border-collapse: collapse !important;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Username</th>
                                            <th>Fullname</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Company</th>
                                            <th>Free Account</th>
                                            <th>IP Address</th>
                                            <th>Location</th>
                                            <th>Last Updated</th>
                                            <th>City</th>
                                            <th>Region</th>
                                            <th>Country</th>
                                            <th>Timezone</th>
                                            <!-- <th>Privacy</th> -->
                                            <th>Browser Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($list_all_info as $key => $item) : 
                                            $browser = json_decode($item->browser_name, true);
                                            $data_ip = json_decode($item->data_ip_address, true);
                                            $privacy_str = "";
                                            if (isset($data_ip['privacy'])) {
                                                // Mengonversi nilai boolean menjadi string
                                                $vpnString = $data_ip['privacy']['vpn'] ? 'true' : 'false';
                                                $proxyString = $data_ip['privacy']['proxy'] ? 'true' : 'false';
                                                $torString = $data_ip['privacy']['tor'] ? 'true' : 'false';
                                                $relayString = $data_ip['privacy']['relay'] ? 'true' : 'false';
                                                $hostingString = $data_ip['privacy']['hosting'] ? 'true' : 'false';
                                                $serviceString = $data_ip['privacy']['service'];

                                                // Tampilkan nilai 'privacy'
                                                $privacy_str .= 'VPN: ' . $vpnString . '<br>';
                                                $privacy_str .= 'Proxy: ' . $proxyString . '<br>';
                                                $privacy_str .= 'Tor: ' . $torString . '<br>';
                                                $privacy_str .= 'Relay: ' . $relayString . '<br>';
                                                $privacy_str .= 'Hosting: ' . $hostingString . '<br>';
                                                $privacy_str .= 'Service: ' . $serviceString . '<br>';
                                            } else {
                                                $privacy_str .= 'Kunci "privacy" tidak ditemukan dalam data IP address.';
                                            }
                                        ?>
                                            <tr>
                                                <th><?= $no++ ?></th>
                                                <th><?= $item->username ?></th>
                                                <th><?= $item->first_name .' '. $item->last_name ?></th>
                                                <th><?= $item->email ?></th>
                                                <th><?= $item->address ?></th>
                                                <th><?= $item->company ?></th>
                                                <th><?= $item->free_account ?></th>
                                                <th><?= $item->ip_address ?></th>
                                                <th><?= $item->latLon ?></th>
                                                <th><?= date('d-M-Y H:i', strtotime($item->last_updated)) ?></th>
                                                <th><?= $data_ip['city'] ?></th>
                                                <th><?= $data_ip['region'] ?></th>
                                                <th><?= $data_ip['country'] ?></th>
                                                <th><?= $data_ip['timezone'] ?></th>
                                                <!-- <th><?= $privacy_str ?></th> -->
                                                <th><?= $browser['userAgent'] ?><b class="ms-2">Device :</b> <?= $browser['device'] ?></th>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- ./row -->

            <div class="row">
                <div class="col-12 mb-3">
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
            </div>

        </div> <!-- ./container-fluid -->
    </div> <!-- ./page-content -->
</div> <!-- ./main-content -->

<!-- DataTables -->
<link href="<?=base_url()?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<!-- Required datatable js -->
<script src="<?=base_url()?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

<!-- jquery.dataTables -->
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> -->

<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap.min.js"></script> -->

<!-- dataTables responsive -->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap.min.css">
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<!-- bootstrap responsive -->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap.min.css">
<script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap.min.js"></script>

<!-- fixedHeader bootstrap -->
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.bootstrap.min.css">
<script src="https://cdn.datatables.net/fixedheader/3.3.2/js/fixedHeader.bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        loadDT();
    });

    function loadDT(){
        var table = $("#table_info").DataTable({
            responsive: true,
            // scrollX: true,
            // scrollY: '56vh',
            // // scrollY: '32vh',
            // // ordering: false,
            // scrollCollapse: true,
            // fixedHeader: true,
            // fixedColumns: true,
            // lengthMenu: [
            //     [10, 25, 50, -1],
            //     [10, 25, 50, 'All'],
            // ],
            // autoWidth: false, 
            // columnDefs: [
            //     { width: '1%', targets: 0 },
            //     { width: '20%', targets: 1 },
            //     { width: '15%', targets: 2 },
            //     { width: '15%', targets: 3 },
            //     { width: '70%', targets: 4 },
            // ],
        });
        // new $.fn.dataTable.FixedHeader( table );
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

<!-- Supercluster Mapbox -->
<script src="https://unpkg.com/supercluster@8.0.0/dist/supercluster.min.js"></script>

<script type="text/javascript">
    // const viewJapan = [140.34, 38.28]; // format lng, lat
    const viewJapan = [106.82717644101359, -6.175421942384241]; // format lng, lat in monas
    // const viewJapan = [-68.137343, 45.137451]; // starting position in US
    const TOKEN_MAP = 'pk.eyJ1IjoiYXNpYXJlc2VhcmNoIiwiYSI6ImNrY211eG10dDAzZGEyc28yeGlwYTh5bHUifQ.l9-iLbSNuCYulPNGr5ux9A';
    const MAIN_STYLE = '<?= style_japan ?>';
    const STYLE_MAPBOX = 'mapbox://styles/mapbox/';
    const item_style = sessionStorage.getItem('mb_style');
    const get_style_map = (item_style == null || item_style == 'null' || item_style == '' || item_style == undefined) ? MAIN_STYLE : item_style;
    const id_user = '<?= $id_user ?>';

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
    const allDataFc = <?= json_encode($list_all_info) ?>;
    let getDataFc = [];
    let getFeatureCollection = "", current_id = "";
    console.log("allDataFc: ", allDataFc);
    
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
        console.log("current_id: ", current_id);
        if (current_id != "") {
            showFeatures(current_id);
        }
        addMarkerUser();
    });
    var inter = setInterval(() => {
        var improve_map = $(".mapboxgl-control-container > .mapboxgl-ctrl-bottom-right > .mapboxgl-ctrl-attrib > .mapboxgl-ctrl-attrib-inner").children(".mapbox-improve-map");
        if (improve_map.length != 0) {
            improve_map.remove();
            console.log("improve map: ", improve_map);
            clearInterval(inter);
        }
    }, 500);

    // function addMarkerUser(){
    //     var list_bbox = [], listMarker = [];

    //     allDataFc.forEach(function (marker, i) {
    //         // Destructuring data
    //         var { id_info, id_user, email, first_name, last_name, last_updated, latLon } = marker;
    //         var [longitude, latitude] = latLon.split(',');

    //         var getInfo = getInfoById(id_info);
    //         // console.log("getInfo: ", getInfo);
            
    //         // Tambahkan marker ke peta
    //         var getMarker = new mapboxgl.Marker({
    //             // color: '#20b2aa'
    //             color: 'red'
    //         }).setLngLat([parseFloat(latitude), parseFloat(longitude)])
    //         .setPopup(new mapboxgl.Popup({ offset: 25, anchor: 'bottom', maxWidth: '600px' }) // Tambahkan popup saat marker diklik
    //         .setHTML(getInfo.html))
    //         // .setHTML('<h3>Informasi</h3><p>ID: ' + id_info + '</p>'))
    //         .addTo(map);
    //         listMarker.push(getMarker);
                
    //         // set camera map
    //         list_bbox.push([parseFloat(latitude), parseFloat(longitude)]);
    //         list_bbox = removeDuplicates(list_bbox);
    //         console.log(list_bbox);
    //         console.log(listMarker);

    //         if (i == (allDataFc.length-1)) {
    //             map.fitBounds(list_bbox, {padding: 120 });
    //         }
    //     });
    // }
    
    function generateFeatures(){
        var features = allDataFc.map(function (marker) {
            var { id_info, latLon } = marker;
            var [latitude, longitude] = latLon.split(',');

            // Dapatkan informasi HTML
            var getInfo = getInfoById(id_info, true);
            return {
                type: 'Feature',
                properties: getInfo,
                geometry: {
                    type: 'Point',
                    coordinates: [parseFloat(longitude), parseFloat(latitude)]
                }
            };
        });
        // console.log("feature: ", features);
        var FeatureCollection = {
            type: 'FeatureCollection',
            features: features
        }
        // console.log("FeatureCollection: ", FeatureCollection);
        return FeatureCollection;
    }
    

    function addMarkerUser() {
        var listMarker = [];

        var getFeatures = generateFeatures();
        console.log("generateFeatures: ", getFeatures);

        // Tambahkan source untuk data marker
        map.addSource('markers', {
            type: 'geojson',
            // data: {
            //     type: 'FeatureCollection',
            //     features: userData
            // },
            data: getFeatures,
            cluster: true, // Aktifkan fitur clustering
            // clusterMaxZoom: 14, // Zoom maksimum untuk clustering
            clusterMaxZoom: 17, // Zoom maksimum untuk clustering
            clusterRadius: 50 // Radius clustering dalam piksel
        });

        // Tambahkan layer untuk menangani marker
        map.addLayer({
            id: 'clusters',
            type: 'circle',
            source: 'markers',
            filter: ['has', 'point_count'],
            paint: {
                'circle-color': [
                    'step',
                    ['get', 'point_count'],
                    '#51bbd6',
                    10,
                    '#f1f075',
                    30,
                    '#f28cb1'
                ],
                'circle-radius': [
                    'step',
                    ['get', 'point_count'],
                    15,
                    10,
                    20,
                    30,
                    25
                ]
            }
        });

        map.addLayer({
            id: 'cluster-count',
            type: 'symbol',
            source: 'markers',
            filter: ['has', 'point_count'],
            layout: {
                'text-field': '{point_count_abbreviated}',
                'text-font': ['DIN Offc Pro Medium', 'Arial Unicode MS Bold'],
                'text-size': 14,
            }
        });

        map.addLayer({
            id: 'unclustered-point',
            type: 'circle',
            source: 'markers',
            filter: ['!', ['has', 'point_count']],
            paint: {
                'circle-color': 'red',
                'circle-radius': 5,
                'circle-stroke-width': 1,
                'circle-stroke-color': '#fff'
            }
        });

        // Tampilkan popup ketika marker di-klik
        map.on('click', 'clusters', function (e) {
            var features = map.queryRenderedFeatures(e.point, { layers: ['clusters'] });
            var clusterId = features[0].properties.cluster_id;

            map.getSource('markers').getClusterExpansionZoom(clusterId, function (err, zoom) {
                if (err) return;

                map.easeTo({
                    center: features[0].geometry.coordinates,
                    zoom: zoom
                });
            });
        });

        // Tampilkan popup ketika marker di-klik
        // map.on('click', 'clusters', function (e) {
        //     var features = map.queryRenderedFeatures(e.point, { layers: ['clusters'] });
        //     var clusterId = features[0].properties.cluster_id;

        //     map.getSource('markers').getClusterExpansionZoom(clusterId, function (err, zoom) {
        //         if (err) return;

        //         map.easeTo({
        //             center: features[0].geometry.coordinates,
        //             zoom: zoom
        //         });

        //         // Ambil semua fitur dalam cluster yang diklik
        //         var clusterFeatures = map.querySourceFeatures('markers', {
        //             filter: ['all', ['has', 'point_count'], ['==', 'cluster_id', clusterId]]
        //         });
        //         console.log("zoom: ", zoom);
        //         console.log("clusterId: ", clusterId, " clusterFeatures: ", clusterFeatures);
        //         // Tampilkan popup untuk setiap fitur dalam cluster
        //         clusterFeatures.forEach(function (feature) {
        //             var coordinates = feature.geometry.coordinates.slice();
        //             // var info = feature.properties.info;
        //             var info = feature.properties;

        //             console.log("feature: ", feature);
        //             console.log("info: ", info);

        //             new mapboxgl.Popup({anchor: 'bottom', maxWidth: '600px' })
        //                 .setLngLat(coordinates)
        //                 .setHTML(info.html)
        //                 .addTo(map);
        //         });
        //     });
        // });

        map.on('click', 'unclustered-point', function (e) {
            var coordinates = e.features[0].geometry.coordinates.slice();
            // var info = e.features[0].properties.info;
            var info = e.features[0].properties;

            new mapboxgl.Popup({anchor: 'bottom', maxWidth: '600px' })
                .setLngLat(coordinates)
                .setHTML(info.html)
                .addTo(map);
                
            console.log("featurePoint: ", e.features);

            var zoom = 22;
            map.easeTo({
                center: coordinates,
                zoom: zoom
            });
            
        });

        map.on('mouseenter', 'clusters', function () {
            map.getCanvas().style.cursor = 'pointer';
        });

        map.on('mouseleave', 'clusters', function () {
            map.getCanvas().style.cursor = '';
        });

        map.on('mouseenter', 'unclustered-point', function () {
            map.getCanvas().style.cursor = 'pointer';
        });

        map.on('mouseleave', 'unclustered-point', function () {
            map.getCanvas().style.cursor = '';
        });
    }

    function removeDuplicates(arr) {
        const uniqueMap = {};
        const result = [];

        for (const item of arr) {
            const key = item.join(',');

            if (!uniqueMap[key]) {
                uniqueMap[key] = true;
                result.push(item);
            }
        }

        return result;
    }

    function generateTableFromObject(obj) {
        let tableHtml = '<table class="table">';
        for (const key in obj) {
            if (obj.hasOwnProperty(key)) {
                const value = obj[key];
                let valueHtml = typeof value === 'object' ? generateTableFromObject(value) : value;
                tableHtml += `<tr>
                                <td class="border border-secondary"><strong>${key}</strong></td>
                                <td class="border border-secondary">${valueHtml}</td>
                            </tr>`;
            }
        }
        tableHtml += '</table>';
        return tableHtml;
    }
    function getInfoById(idInfo, showAll = false) {
        var listAll = {};
        for (let i = 0; i < allDataFc.length; i++) {
            const el = allDataFc[i];

            if (idInfo == el.id_info) {
                // Bangun HTML sebagai tabel dengan format <table><tbody>
                var html = `<div style="max-height: 250px;overflow: auto;padding-right: 20px;padding-left: 20px;">
                <table class="table table-sm table-hover">
                                <tbody>
                                    <tr>
                                        <td colspan="2" class="border border-secondary"><strong>Detail Information</strong></td>
                                    </tr>`;

                for (const key in el) {
                    if (el.hasOwnProperty(key)) {
                        const value = el[key];

                        let valid1 = (key != 'id_user' && key != 'profile_picture' && key != 'password' && key != 'id_level' && key != 'status' && key != 'token' && key != 'active' && key != 'create_at' && key != 'last_login' && key != 'login_type');
                        let valid2 = (key != 'data_ip_address');
                        let valid3 = (key != 'browser_name');
                        let valid4 = (key != 'location_user');
                        let validParse2 = (key == 'data_ip_address');
                        let validParse3 = (key == 'browser_name');
                        let validParse4 = (key == 'location_user');
                        
                        let all_valid = (valid1 && valid2 && valid3 && valid4);

                        if (all_valid) {
                            // Tambahkan setiap pasangan key-value ke tabel
                            html += `<tr>
                                        <td class="border border-secondary"><strong>${key}</strong></td>
                                        <td class="border border-secondary">${value}</td>
                                        <td class="border border-secondary d-none">${validParse2 || validParse3 || validParse4 ? generateTableFromObject(JSON.parse(value)) : value}</td>
                                    </tr>`;

                            listAll[key] = (validParse2 || validParse3 || validParse4) ? JSON.parse(value) : value;
                        }
                    }
                }

                // Tutup HTML
                html += `</tbody></table></div>`;
                listAll['html'] = html;

                if (showAll) { 
                    return listAll;
                } else {
                    return { html: html, info: el };
                }
            }
        }

        return null;
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