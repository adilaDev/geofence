<?php
$data_user = $this->session->userdata("data_login");
$first_name = "";
$last_name = "";
$username = "";
$id_user = "";
$lang = $this->session->userdata('language');
$data_lang = $this->session->userdata('data_lang');

if (isset($data_user)) {
    $first_name  = $data_user['first_name'];
    $last_name  = $data_user['last_name'];
    $username  = $data_user['username'];
    $id_user  = $data_user['id'];
}
?>
<div id='my_map'></div>

<style>
    #my_map { position: absolute; top: 0; bottom: 0; width: 100%; }
    /* .mapboxgl-popup{
        max-width: none !important;
    } */
    .repeater {
    /* .mapboxgl-popup-content { */
        max-height: 15em;
        overflow-y: auto;
        margin-right: 10px;
    }
</style>
<button type="button" id="btn_draw_rectangle" class="btn btn-light btn-sm d-none waves-effect waves-light" title="Rectangle Tool" onclick="changeModeDraw('draw_rectangle')">
    <i class="bx bx-rectangle font-size-18 align-middle" style="font-weight: 800 !important;"></i>
</button>
<button type="button" id="btn_draw_circle" class="btn btn-light btn-sm d-none waves-effect waves-light" title="Circle Tool" onclick="changeModeDraw('draw_circle')">
    <i class="bx bx-circle font-size-18 align-middle" style="font-weight: 800 !important;"></i>
</button>
<button type="button" id="btn_save_polygon" class="btn btn-light btn-sm d-none waves-effect waves-light" title="Save">
    <i class="bx bx-save font-size-18 align-middle"></i>
</button>
<button type="button" id="btn_free_hand" class="btn btn-light btn-sm d-none waves-effect waves-light" title="Freehand Tool"  onclick="changeModeDraw('draw_freehand')">
    <i class="bx bxs-paint font-size-18 align-middle"></i>
</button>
<button type="button" id="btn_cutpolygon" class="btn btn-light btn-sm d-none waves-effect waves-light" title="Cut Polygon"  onclick="changeModeDraw('cut_polygon')">
    <i class="bx bx-cut font-size-18 align-middle"></i>
</button>

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

<div class="offcanvas offcanvas-end w-75" tabindex="-1" id="offcanvasRight" data-bs-scroll="true" aria-labelledby="offcanvasRightLabel" style="visibility: hidden;" aria-hidden="true">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">List of information</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="text-start mb-2" id="rowBtn">
            <button id="addRowBtn" class="btn btn-outline-info btn-sm waves-effect waves-light me-1 mb-1"><i class="bx bx-list-plus font-size-18 align-middle"></i> Add Row</button>
            <button id="editPoly" class="btn btn-outline-warning btn-sm waves-effect waves-light me-1 mb-1" data-bs-dismiss="offcanvas" aria-label="Close"><i class="bx bx-pen font-size-18 align-middle"></i> Edit</button>
            <button class="btn btn-outline-danger btn-sm waves-effect waves-light me-1 mb-1" onclick="removeFeature()"><i class="bx bx-trash font-size-18 align-middle"></i> Delete</button>
            <button id="saveAll" class="btn btn-outline-primary btn-sm waves-effect waves-light me-1 mb-1"><i class="bx bx-save font-size-18 align-middle"></i> Save</button>
        </div>
        <div id="superDynamic" class="table-responsive mb-3"></div>
    </div>
</div>

<!-- mapbox gl -->
<link href="<?= base_url() ?>assets/libs/mapbox/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">
<script src="<?= base_url() ?>assets/libs/mapbox/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>

<!-- Load the `mapbox-gl-geocoder` plugin. -->
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css">

<script src="https://unpkg.com/@turf/turf@6/turf.min.js"></script>
<!-- mapbox-draw -->
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.4.0/mapbox-gl-draw.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.4.0/mapbox-gl-draw.css" type="text/css">

<!-- Sweet Alerts -->
<link href="<?=base_url()?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<script src="<?=base_url()?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

<script src="<?=base_url()?>assets/libs/mapbox/mapbox-gl-draw/mapbox-gl-draw-rectangle-mode.min.js"></script>
<script src="https://unpkg.com/mapbox-gl-draw-geodesic@2.3.0/dist/mapbox-gl-draw-geodesic.umd.min.js"></script>

<!-- DataTables -->
<link href="<?=base_url()?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<script src="<?=base_url()?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Required scroller datatable js -->
<link href="https://cdn.datatables.net/scroller/2.3.0/css/scroller.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.datatables.net/scroller/2.3.0/js/dataTables.scroller.min.js"></script>

<!-- Google Map Place API -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCuP573ebN6ZJTbs3IGcW2G-zgiBH4pp0Q&libraries=places&callback=initPlacesSearch"></script>

<!-- Addtional Custom Mode Drawing -->
<script src="<?= base_url('vendor/mapbox-gl-draw-circle-master/lib/modes/constants.js?v=').time() ?>"></script>
<script src='https://api.mapbox.com/mapbox.js/plugins/geojson-extent/v1.0.0/geojson-extent.js'></script>
<script src="<?= base_url('vendor/mapbox-gl-draw-circle-master/lib/modes/byFadil/FreehandModeByFadil.js?v=').time() ?>"></script>
<script src="<?= base_url('vendor/mapbox-gl-draw-circle-master/lib/modes/byFadil/CircleModeByFadil.js?v=').time() ?>"></script>
<script src="<?= base_url('vendor/mapbox-gl-draw-circle-master/lib/modes/byFadil/DragCircleModeByFadil.js?v=').time() ?>"></script>
<script src="<?= base_url('vendor/mapbox-gl-draw-circle-master/lib/modes/byFadil/DirectModeOverrideByFadil.js?v=').time() ?>"></script>
<script src="<?= base_url('vendor/mapbox-gl-draw-circle-master/lib/modes/byFadil/SimpleSelectModeByFadil.js?v=').time() ?>"></script>
<script src="<?= base_url('vendor/mapbox-gl-draw-circle-master/lib/modes/byFadil/additonal_function.js?v=').time() ?>"></script>
<script src="<?= "https://raw.githubusercontent.com/mapbox/mapbox-gl-draw/main/src/lib/move_features.js?v=".time()?>"></script>
<!-- <script src="https://raw.githubusercontent.com/mapbox/mapbox-gl-draw/main/src/lib/create_supplementary_points.js"></script> -->
<script src="<?= base_url('vendor/mapbox-gl-draw-circle-master/lib/modes/byFadil/CutPolygonMode.js?v=').time() ?>"></script>
<script src="https://unpkg.com/mapbox-gl-draw-passing-mode"></script>

<script type="text/javascript">
    // const viewJapan = [140.34, 38.28]; // format lng, lat
    const viewJapan = [106.82717644101359, -6.175421942384241]; // format lng, lat in monas
    // const viewJapan = [-68.137343, 45.137451]; // starting position in US
    const TOKEN_MAP = '<?= token_mapbox ?>';
    const MAIN_STYLE = '<?= style_japan ?>';
    const STYLE_MAPBOX = 'mapbox://styles/mapbox/';
    const item_style = sessionStorage.getItem('mb_style');
    const get_style_map = (item_style == null || item_style == 'null' || item_style == '' || item_style == undefined) ? MAIN_STYLE : item_style;
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
    let getFeatureCollection = JSON.parse(<?= json_encode($all_data[0]->feature_collection) ?>);
    let getDataTable = JSON.parse(<?= json_encode($all_data[0]->data) ?>);
    console.log("getFeatureCol: ", getFeatureCollection);
    console.log("getDataTable: ", getDataTable);
    
    function initPlacesSearch() {
        var input = document.getElementById('searchInput');
        var searchBox = new google.maps.places.SearchBox(input);
        // var searchBox = new google.maps.places.Autocomplete(input);
        
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

    // Create a new marker.
    const marker = new mapboxgl.Marker({
        color: "#20b2aa",
        draggable: false
    });

    function addMarkerGeolocation(place) {
        const location = place.geometry.location;
        const viewport = place.geometry.viewport;
        
        var lokasi = [location.lng(), location.lat()];
        // var bbox_viewport = [viewport.Bb, viewport.Va];
        var bbox_viewport = [viewport.La, viewport.eb];
        
        // console.log("Lokasi: ", lokasi);
        // console.log("bbox: ", bbox_viewport);

        marker.remove();
        // Create a new marker.
        marker.setLngLat(lokasi).addTo(map);

        map.flyTo({
            center: lokasi,
            // zoom: 12
            zoom: 18
        });
    }

    function geoAPIgoogle(centerCoord){
        // Panggil API Geocoding untuk mendapatkan informasi lokasi
        var lat = centerCoord[1];
        var lon = centerCoord[0];
        var api_key = 'AIzaSyDqRYyf2UD8U7Ow80y7Un-MmfBt4HHGpTM';
        var lang = 'en'; // en atau ja
        var apiUrl = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lon}&language=${lang}&result_type=street_address|political&key=${api_key}`;

        var geocodeToDataTable = [];

        return fetch(apiUrl)
        .then(response => response.json());
    }

    function superDynamicDT(data = []){
        if (data.length == 0) {
            return;
        }
        // tampilkan canvas
        $("#canvasDataTable").click();

        // Create table dynamically
        var table = $('<table>').attr('id', 'dynamic_table').attr('class', 'table table-sm table-bordered table-striped border-secondary w-100').addClass('display').attr("style", "border-collapse: collapse !important;");
        var thead = $('<thead>').appendTo(table);
        var tbody = $('<tbody>').appendTo(table);

        var headerRow = $('<tr class="align-middle">').appendTo(thead);
        // Add headers dynamically
        Object.keys(data[0]).forEach(function(key) {
            $('<th>').text(key.replace('_', ' ')).appendTo(headerRow);
        });

        // Add data to tbody
        // data.forEach(function(item) {
        //     var row = $('<tr>').appendTo(tbody);
        //     Object.values(item).forEach(function(value) {
        //         // $('<td>').attr('contenteditable', (value != "")).text(value).appendTo(row);
        //         $('<td>').text(value).appendTo(row);
        //     });
        //     // $(row).find('td').each(function(index, val, arr) {
        //     //     // Set contenteditable to true unless it's the 'action' column
        //     //     $(this).attr('contenteditable', index !== Object.keys(data[0]).indexOf('action'));
        //     //     // var parent = $(val).parent();
        //     //     // console.log("key: ", Object.keys(data[0]), " keys data: ", parent[0], 
        //     //     // // "\ntxt: ", $(val).text(),
        //     //     // "\ntxt: ", index,
        //     //     // );
        //     //     // if ($(val).text() == 'isCircle') {
        //     //     //     parent.children().attr('contenteditable', false).attr('style', "cursor: no-drop;");
        //     //     //     console.log("TRUE ", parent, val);
        //     //     // }
        //     // });
        //     $(row).find('td').each(function(index, val) {
        //         var parent = $(val).parent();
        //         // Set contenteditable to true unless it's the 'action' column
        //         var isEditable = (index !== Object.keys(data[0]).indexOf('action')) && ($(val).text() !== 'isCircle' && ($(val).text() !== 'radiusInKm') && ($(val).text() !== 'center'));
        //         $(this).attr('contenteditable', isEditable);
                
        //         if ($(val).text() === 'isCircle') {
        //             console.log('TRUE ', parent, val);
        //             // parent.children().attr('contenteditable', false).attr('style', 'cursor: no-drop;');
        //             row.find('td').attr('contenteditable', false).css('cursor', 'no-drop');
        //         }
        //         console.log("isEditable: ", isEditable, (isEditable === false));
        //     });
        // });

        data.forEach(function (item) {
            var row = $('<tr class="align-middle">').appendTo(tbody);
            var isNonEditableRow = false;

            Object.entries(item).forEach(function ([key, value], index) {
                var isEditable = (value != "") && (index !== Object.keys(data[0]).indexOf('action'));

                if (isEditable === false) {
                    $('<td>').html(value).appendTo(row);
                } else {
                    $('<td>').text(value).attr('contenteditable', isEditable).appendTo(row);
                }

                if (value === 'isCircle' || value === 'radiusInKm' || value === 'center') {
                    isNonEditableRow = true;
                }
            });
            
            if (isNonEditableRow) {
                var satubaris = row.find('td').attr('contenteditable', false).css('cursor', 'no-drop');
                // console.log("isEditable: ", isNonEditableRow, row, satubaris, item);
                // console.log("isEditable: ", isNonEditableRow, satubaris);
            }
        });

        // Append table to the body
        table.appendTo('body');
        $("#superDynamic").empty(); // kosongkan elemen apapun
        $("#superDynamic").append(table);

        // Initialize DataTable
        tables = $(table).DataTable({
            scrollX: true,
            scrollY: '56vh',
            // scrollY: '32vh',
            scrollCollapse: true,
            fixedHeader: true,
            responsive: true,
            columns: [
                { data: 'no', title: 'No' },
                { data: 'key', title: 'Title' },
                { data: 'value', title: 'Content'},
                {
                    data: 'action', title: 'Action',
                    // render: function (data, type, row, col) {
                    //     // console.log("render data: ", data, "\ntype: ", type, "\nrow: ", row, "\ncol: ", col);
                    //     // return '<button type="button" class="btn btn-outline-secondary btn-sm edit me-1" title="Edit"><i class="fas fa-pencil-alt"></i></button>' +
                    //     //         '<button type="button" class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></button>';
                    //     return '<button type="button" class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></button>';
                    // }
                }
            ],
            columnDefs: [{
                // "targets": "_all",
                targets: [0, 1],
                className: "editables",
            }],
            destroy: true,
            select: false,
            paging: false,
            // scroller: true,
            // lengthMenu: [
            //     [10, 25, 50, -1],
            //     [10, 25, 50, 'All'],
            // ],
        });
        // pindahkan tombol ke datatable
        // var cloneBtn = $("#rowBtn").clone().attr("id", "rowBtnClone").attr("class", "text-start");
        // $("#dynamic_table_wrapper > div:nth-child(1) > div:nth-child(1)").append(cloneBtn);
        
        $('#dynamic_table').on('blur', 'tbody td[contenteditable=true]', function (e) {
            // console.log("focus after: ", ($(this).data('before') !== $(this).html()), $(this).data('before'));
            // if ($(this).data('before') !== $(this).html()) {
            // }
            var child =  $(this).parent().children();
            var newData = {
                'no': $(child[0]).text(),
                'key': underscore($(child[1]).text()),
                'value': $(child[2]).text(),
                'action': '<button type="button" class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></button>'
            };

            var rowIndex = $(this).closest('tr').index();
            var edit = tables.row($(this).closest('tr')).data(newData)
            .draw(false); // draw(false) => gambar ulang tabel dengan mempertahankan posisi paging saat ini
            // console.log("edit: ", "\nnewData: ",newData,"\nrowIndex: ", rowIndex);
        });

        // $('#dynamic_table').on('blur', 'tbody tr', function (e) {
        //     var child =  $(this).children();
        //     var newData = {'no': '', 'key': '', 'value': '', 'action': '<button type="button" class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></button>'};
        //     const no = $(child[0]).text();
        //     const key = underscore($(child[1]).text());
        //     const val = $(child[2]).text();
        //     newData.no = no;
        //     newData.key = key;
        //     newData.value = val;
    
        //     var edit = tables.row(this)
        //     .data(newData).draw();
        //     // console.log("edit: ", edit, "\nnewData: ",newData);
        // });

        // $('#dynamic_table').on('mousedown', 'tbody td[contenteditable=true]', function (e) {
        //     e.preventDefault();
        //     console.log("mousedown: ", e);
        // });

    
        $('#dynamic_table tbody').on('click', '.delete', function () {
            tables.row($(this).parents('tr')).remove().draw(false);
        });
    }

    $('#addRowBtn').on('click', function() {
        var allData = tables.rows().data().toArray();
        var lastData = allData[allData.length-1];
        var no = parseInt(lastData.no)+1;
        console.log("lastData: ", lastData);

        // Buat baris kosong baru
        var newRowData = {'no': no, 'key': '', 'value': '', 'action': '<button type="button" class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></button>'};

        // Tambahkan baris baru ke awal DataTable
        var newRow = tables.row.add(newRowData).draw().node();
        // console.log("newRow: ", newRow);

        // Tetapkan atribut yang dapat diedit untuk setiap sel di baris baru
        // $(newRow).find('td').attr('contenteditable', true);
        $(newRow).find('td').each(function(index) {
            // Setel contenteditable ke true kecuali kolom 'action'
            $(this).attr('contenteditable', index !== Object.keys(lastData).indexOf('action'));
        });
        // tables.scroller.toPosition(no);
        $(newRow).children('td:nth-child(2)').focus();

        // Add new empty row to the top of the tbody
        // tbody.prepend(newRow);
    });
    
    $('#saveAll').on('click', function () {
        // // Simpan data yang sedang diedit ke DataTable
        // var allData = tables.rows().data().toArray();
        // changeFormatToProperties();
        // var getPolygon = draw.getSelected();
        // console.log("saveAll click: ", allData, "\npolygon: ", getPolygon);
        saveDataTableToProperties()
        
        Swal.fire({
            icon: 'success',
            title: 'Saved successfully!',
            confirmButtonColor: "#556ee6",
            showCancelButton: false
        }).then(() => {
            // tutup canvas
            $("#canvasDataTable").click();
            draw.changeMode('simple_select');
        });
    });

    function saveDataTableToProperties(){
        // Simpan data yang sedang diedit ke DataTable
        var allData = tables.rows().data().toArray();
        changeFormatToProperties();
        var getPolygon = draw.getSelected();
        console.log("saveDataTableToProperties: ", allData, "\npolygon: ", getPolygon);
    }

    function underscore(str){
        return str.replace(/ /g, "_");
    }

    function clearProperties(feature) {
        var id = feature.id;
        for (var prop in feature.properties) {
            if (feature.properties.hasOwnProperty(prop)) {
                draw.setFeatureProperty(id, prop, undefined); // setel semua value menjadi undefined
                // var d = delete feature.properties[prop];
                // console.log("clear: ", d, prop, feature.properties[prop]);
            }
        }
        console.log("clear: ", feature);
        return feature;
    }
    
    function changeFormatToProperties(){
        var data = tables.rows().data().toArray();
        var getPolygon = draw.getSelected();
        var prop = getPolygon.features[0].properties;
        var checkProp = isObjectEmpty(prop);
        var id = draw.getSelectedIds()[0];
        // tambahkan fungsi kosongkan semua properties sebelum ditambahkan
        var clear = clearProperties(getPolygon.features[0]);
        // console.log("getProperties: ", checkProp, (!checkProp && prop.isCircle), getPolygon.features, data);

        const result = data.reduce((acc, item) => {
            if (item.key != "" || item.value != "") {
                // Ambil properti 'key' dan masukkan ke dalam objek
                acc[item.key] = item.value;
                draw.setFeatureProperty(id, item.key, item.value);
            }
            return acc;
        }, {});
        console.log("changeFormat: ", result);
        return result;
    }

    function changeObjectToArray(obj) {
        return Object.entries(obj).map(([key, value], index) => {
            return {
                no: (index + 1).toString(), // Sesuaikan dengan cara Anda memberikan nomor
                key: key,
                value: value,
                action: '<button type="button" class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></button>'
            };
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
    // var modes = MapboxDraw.modes;
    // // modes = MapboxDrawGeodesic.enable(modes); // https://github.com/zakjan/mapbox-gl-draw-geodesic
    // modes.draw_rectangle = DrawRectangle.default; // https://gist.github.com/erick-otenyo/e22cefb2c69fb4d4db4c19d7778ed574
    // // additonal custom mode drawing
    // modes.draw_circle = DragCircleMode;
    // modes.direct_select = DirectModeOverride;
    // modes.draw_freehand = FreehandMode;
    // modes.cut_polygon = CutPolygonMode;
    // modes.cut_polygon_passing_draw_polygon = mapboxGlDrawPassingMode.passing_draw_polygon;

    var modes = {
        ...MapboxDraw.modes,
        draw_freehand: FreehandMode,
        // draw_circle: CircleMode,
        draw_circle: DragCircleMode,
        direct_select: DirectModeOverride,
        // simple_select: SimpleSelectModeOverride,
        cut_polygon: CutPolygonMode,
        cut_polygon_passing_draw_polygon: mapboxGlDrawPassingMode.passing_draw_polygon,
    }
    console.log("modes: ", modes);

    // var draw = new MapboxDraw({  modes: modes });
    var draw = new MapboxDraw({
        displayControlsDefault: false,
        controls: {
            line_string: true,
            polygon: true,
            point: false,
            trash: true,
            combine_features: true,
            uncombine_features: true,
        },
        // touchEnabled: false, // default touchEnabled = true
        // boxSelect: false, // default boxSelect = true
        modes: modes,
        // modes: { // disable drag mode : https://github.com/mapbox/mapbox-gl-draw/issues/667#issuecomment-1707799304
        //     ...MapboxDraw.modes,
        //     // simple_select: { ...MapboxDraw.modes.simple_select, dragMove() {}, clickOnFeature() {} },
        //     simple_select: { ...MapboxDraw.modes.simple_select, dragMove() {}},
        //     direct_select: { ...MapboxDraw.modes.direct_select, dragFeature() {} },
        // },
        // styles: styleDraw()
    });
    map.addControl(draw,'bottom-right');
    map.addControl(new mapboxgl.NavigationControl(),'bottom-right');
    map.addControl(new mapboxgl.FullscreenControl(),'bottom-right');
    // sembunyikan control MapboxDraw
    // $("#my_map > div.mapboxgl-control-container > div.mapboxgl-ctrl-bottom-right > div:nth-child(3)").addClass("d-none");
    
    addtionalBtn();

    const popup = new mapboxgl.Popup({closeOnClick: true, closeButton: true, maxWidth: '300px'});
    var interStyle = null;

    map.on('style.load', (e) => {
        setCameraMap();
        loadDrawing();
        improveMapDelete();
        interStyle = setInterval(() => {
            var x = changeStyleDraw();
            if (x.getlayer_fill_hot != undefined) {
                clearInterval(interStyle);
            }
        }, 1000);
        // addFeatureCollection(getFeatureCollection);
    });

    function improveMapDelete(){
        var intImprove = setInterval(() => {
            var improve_map = $(".mapboxgl-control-container > .mapboxgl-ctrl-bottom-right > .mapboxgl-ctrl-attrib > .mapboxgl-ctrl-attrib-inner").children(".mapbox-improve-map");
            if (improve_map.length != 0) {
                improve_map.remove();
                clearInterval(intImprove);
            }
        }, 1000);
    }

    function addtionalBtn(){
        var $btn_cutpolygon = $("#btn_cutpolygon").removeClass("btn btn-light btn-sm d-none").addClass("mapboxgl-gl-draw_ctrl-draw-btn m-0");
        $(".mapboxgl-ctrl-bottom-right > .mapboxgl-ctrl.mapboxgl-ctrl-group:nth-child(3) > button.mapbox-gl-draw_polygon").after($btn_cutpolygon);
        
        var $btnFreehand = $("#btn_free_hand").removeClass("btn btn-light btn-sm d-none").addClass("mapboxgl-gl-draw_ctrl-draw-btn m-0");
        $(".mapboxgl-ctrl-bottom-right > .mapboxgl-ctrl.mapboxgl-ctrl-group:nth-child(3) > button.mapbox-gl-draw_polygon").after($btnFreehand);

        var $btn_circle = $("#btn_draw_circle").removeClass("btn btn-light btn-sm d-none").addClass("mapboxgl-gl-draw_ctrl-draw-btn m-0");
        $(".mapboxgl-ctrl-bottom-right > .mapboxgl-ctrl.mapboxgl-ctrl-group:nth-child(3) > button.mapbox-gl-draw_polygon").after($btn_circle);
        
        var $btn_rectangle = $("#btn_draw_rectangle").removeClass("btn btn-light btn-sm d-none").addClass("mapboxgl-gl-draw_ctrl-draw-btn m-0");
        $(".mapboxgl-ctrl-bottom-right > .mapboxgl-ctrl.mapboxgl-ctrl-group:nth-child(3) > button.mapbox-gl-draw_polygon").after($btn_rectangle);

        var $btn_save = $("#btn_save_polygon").removeClass("btn btn-light btn-sm d-none").addClass("mapboxgl-gl-draw_ctrl-draw-btn m-0");
        $(".mapboxgl-ctrl-bottom-right > .mapboxgl-ctrl.mapboxgl-ctrl-group:nth-child(3) > .mapbox-gl-draw_trash").after($btn_save);

        var $btn_search = $("#layout-search").removeClass("d-none").addClass("mapboxgl-gl-draw_ctrl-draw-btn");
        $(".mapboxgl-ctrl-bottom-right > .mapboxgl-ctrl-group:nth-child(1)").before($btn_search);
    }

    // Fungsi untuk membuat sumber dan lapisan polygon atau line secara dinamis
    function addFeatureCollection(featureCollection) {
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
                    'line-width': 2
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
                    'line-color': '#000',
                    'line-width': 2
                    }
                };
                map.addLayer(lineLayerStyle);
            }

            
            // Tambahkan event handler untuk menampilkan informasi saat diklik
            var featureIdClick = (geometryType === 'Polygon') ? layerIdFill : layerIdLine;
            map.on('click', featureIdClick, function (e) {
                // popup.remove();
                var properties = e.features[0].properties;
                var info = '<ul class="mb-0 ps-3">';
                for (var key in properties) {
                    info += '<li><strong>' + key + ':</strong> ' + properties[key] + '</li>';
                }
                info += '</ul>';

                // Tampilkan informasi pada elemen HTML dengan ID 'info'
                popup.setLngLat(e.lngLat)
                .setHTML(info)
                .addTo(map);
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

    function loadDrawing(){
        var features = getFeatureCollection.features;
        if (features.length != 0) {
            for (let i = 0; i < features.length; i++) {
                const feature = features[i];
                // console.log("addfeature: ", feature, draw)
                var featureIds = draw.add(feature);
                // draw.changeMode('direct_select', {featureId: featureIds[0]});
                // draw.changeMode('simple_select', {featureId: featureIds[0]});

                // console.log("featureIds: ", featureIds, " mode: ", draw.getMode(), draw.getSelected());
            }
        }
    }

    map.on('draw.modechange', function (e) {
        // console.log("mode change: ", e.mode);
        var mode = e.mode;
        changeStyleDraw();
    });

    map.on("draw.selectionchange", function (e){
        var features = e.features;
        var all_data = draw.getAll();
        
        // console.log("selectionchange: ", features, "\ndraw:", draw,
        // "\nall: ", all_data.features);
        var id_layer = all_data.features[0].id;
        var current_id = (features.length > 0) ? features[0].id : id_layer;
        var current_id = id_layer;
        // console.log("selectionchange id: ", current_id, " mode: ", draw.getMode(), " all: ", all_data);

        if (features.length != 0 && draw.getMode() != "direct_select") {
            var center = getCenterPoint(features[0]);
            var prop = features[0].properties;
            var checkProp = isObjectEmpty(prop);

            if (checkProp) {
                getAPI(center);
            } else {
                if (prop.isCircle) {
                    getAPI(center);
                } else {
                    var listArrayDT = changeObjectToArray(prop);
                    superDynamicDT(listArrayDT);
                    console.log("listArrayDT: ", listArrayDT);
                }
            }
            // console.log("propertiesEmpty: ", checkProp, prop);
            // marker.setLngLat(center).setPopup(new mapboxgl.Popup().setHTML(`<span>${JSON.stringify(features[0].properties)}</span>`)).addTo(map);
            var btnDelFeat = $("#btnDelFeat").attr("id-feature", features[0].id);
        } else {
            marker.remove();
        }
    });

    var isAlertAlready = false;
    $("#btn_save_polygon").on("click", function (e){
        // e.preventDefault();
        var inputValue = "<?= $this->uri->segment(3) ?>";

        Swal.fire({
            icon: 'warning',
            title: 'Are you sure?',
            // input: 'text',
            // inputLabel: "Your IP address",
            // inputValue,
            confirmButtonText: "Save Changes",
            // denyButtonText: "See the results",
            // cancelButtonText: "Stay here",
            confirmButtonColor: "#20b2aa",
            denyButtonColor: "#4182fa", // #f46a6a = merah, #4182fa = biru
            showCancelButton: true,
            showDenyButton: false,
            allowOutsideClick: false,
        }).then((e) => {
            console.log(e);
            if (e.isConfirmed) { // tombol confirm diklik
                var data = draw.getAll();
                var features = data.features;

                console.clear();
                console.log("data: ", data);
                isAlertAlready = false; //reset variable
                var dataArrPoly = [];
                var listDt = [];

                for (let i = 0; i < features.length; i++) {
                    const ex = features[i];
                    const id = ex.id;
                    var center_point = getCenterPoint(ex);
                    var data_table = changeObjectToArray(ex.properties);
                    listDt.push({"id": id, "data_table":data_table, "center_point":center_point});

                    var dataPoly = {
                        "id_user": id_user,
                        "id_polygon": id,
                        "polygon_name": underscore(inputValue),
                        "data": JSON.stringify(data_table),
                        "center_point": JSON.stringify(center_point),
                        "feature_collection": JSON.stringify(data),
                    };
                    // dataArrPoly.push(dataPoly);
                }
                // console.log("dataArrPoly: ", dataArrPoly);
                
                var dataPoly = {
                    "id_user": id_user,
                    "polygon_name": underscore(inputValue),
                    "data": JSON.stringify(listDt),
                    "feature_collection": JSON.stringify(data),
                };
                console.log("dataPolygon: ", dataPoly);

                // Send the data to the server for saving
                // updateGeojson(JSON.stringify(dataArrPoly));
                updateGeojson(JSON.stringify(dataPoly));
            }
        });

    });
    
    function updateGeojson(dataPoly = {}) {
        nama_polygon = dataPoly.polygon_name;
        // Send an AJAX request to the server to save the polygon
        // You can use any AJAX library or the native fetch API
        $.ajax({
            type: "POST",
            url: "<?= base_url('map/updatePolygon/').$all_data[0]->id_drawing ?>",
            data: dataPoly,
            // dataType: "application/json",
            success: function (data) {
                console.log('Polygon saved:', data);
                if (!isAlertAlready) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Changes saved successfully!',
                        text: "Where are you going next?",
                        confirmButtonText: "Create a new",
                        denyButtonText: "See the results",
                        cancelButtonText: "Stay here",
                        confirmButtonColor: "#20b2aa",
                        // cancelButtonColor: "#f46a6a",
                        denyButtonColor: "#4182fa", // #f46a6a = merah, #4182fa = biru
                        showCancelButton: true,
                        showDenyButton: true,
                        allowOutsideClick: false,
                    }).then((e) => {
                        isAlertAlready = true;
                        // var v = {
                        //     "isConfirmed": false,
                        //     "isDenied": true,
                        //     "isDismissed": false,
                        //     "value": false
                        // }
                        console.log(e);
                        if (e.isConfirmed) { // tombol confirm diklik
                            window.location = '<?= base_url('map') ?>';
                        } else if (e.isDenied){ // tombol deny diklik
                            window.location = '<?= base_url('home') ?>';
                        }
                    });
                }
                
                // drawdeleteFeaturegonById(dataPoly.id_polygon);
                // createPolygon(dataPoly.source_name, JSON.parse(dataPoly.features), dataPoly.layer_name);
            }, 
            error: function (error, status){
                console.error('Error saving polygon:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error saving polygon!',
                    confirmButtonColor: "#20b2aa",
                });
            }
        });
        
        if (current_polygon_name != "" && current_polygon_name != nama_polygon) {
            // jika tidak sama
            featureCollection.features = []; // reset variable
            console.log("reset featureCollection");
        }
    }

    function getAPI(lngLat){
        geoAPIgoogle(lngLat).then((data) => {
            var geocodeToDataTable = [];
            var results = data.results;
            var list_main = results[0];
            var list_address = results[0].address_components;

            // dapatkan semua informasi formatted_address
            // for (let i = 0; i < results.length; i++) {
            //     const item = results[i];
            //     const key = Object.keys(item)[i];
            //     const value = item.formatted_address;
            //     no++;

            //     geocodeToDataTable.push({'no': no, 'key': "formatted_address_"+no, 'value': value, 'action': '<button type="button" class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></button>'});
            // }

            var no = 1;
            geocodeToDataTable.push({'no': no, 'key': 'formatted_address', 'value': list_main.formatted_address, 'action': '<button type="button" class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></button>'});
            // dapatkan semua informasi dari index ke 1
            for (let i = 0; i < list_address.length; i++) {
                const item = list_address[i];
                const key = item.types[0];
                const value = item.long_name;
                no++;

                geocodeToDataTable.push({'no': no, 'key': key, 'value': value, 'action': '<button type="button" class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></button>'});
            }
            var lat = list_main.geometry.location.lat;
            var lng = list_main.geometry.location.lng;
            geocodeToDataTable.push({'no': no+=1, 'key': 'latitude', 'value': lat, 'action': '<button type="button" class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></button>'});
            geocodeToDataTable.push({'no': no+=1, 'key': 'longitude', 'value': lng, 'action': '<button type="button" class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></button>'});
            
            var getPolygon = draw.getSelected();
            var prop = getPolygon.features[0].properties;
            var checkProp = isObjectEmpty(prop);
            if (!checkProp && prop.isCircle) {
                geocodeToDataTable.push({'no': no+=1, 'key': 'isCircle', 'value': prop.isCircle, 'action': '<button type="button" disabled class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></button>'});
                geocodeToDataTable.push({'no': no+=1, 'key': 'radiusInKm', 'value': prop.radiusInKm, 'action': '<button type="button" disabled class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></button>'});
                geocodeToDataTable.push({'no': no+=1, 'key': 'center', 'value': prop.center.toString(), 'action': '<button type="button" disabled class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></button>'});
            }

            // console.log("API GoogleMap: ", data);
            console.log("API Gmap: ", geocodeToDataTable);
            console.log("isCircle: ", (!checkProp && prop.isCircle));
            superDynamicDT(geocodeToDataTable);
            saveDataTableToProperties();
        });
    }

    function removeFeature(){
        var getId = draw.getSelectedIds().toString();
        var res = draw.delete(getId).getAll().features;
        $(".btn-close").click();
    }

    function isObjectEmpty(obj) {
        return Object.entries(obj).length === 0;
    }

    function getCenterPoint(features){
        var geomet = features.geometry;

        // Dapatkan koordinat pusat poligon
        var centerCoord = turf.centerOfMass(geomet).geometry.coordinates;
        // console.log("centerCoord: ", centerCoord);
        return centerCoord;
    }

    function changeModeDraw(get_mode){
        draw.changeMode(get_mode);
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

        console.log("getAllSource: ", getAllSource);
        console.log("sourceData: ", sourceData);
        console.log("sourceDatakeys: ", keys);
    }

    function style_map(e){
        // console.clear();
        const style_id = e.id;
        var getStyle = (style_id == 'default') ? MAIN_STYLE : STYLE_MAPBOX+style_id;
        set_active_style(e);
        improveMapDelete();
        
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
        // console.log("load_style: ", load);
    }
    load_style();

    function changeStyleDraw(){
        // mode draw line_string
        var layer_line_inactive_cold = "gl-draw-line-inactive.cold";
        var layer_line_inactive_hot = "gl-draw-line-inactive.hot";
        var getlayer_line_hot = map.getLayer(layer_line_inactive_hot);
        var getlayer_line_hold = map.getLayer(layer_line_inactive_cold);

        // mode draw polygon
        var layer_polygon_stroke_inactive_cold = "gl-draw-polygon-stroke-inactive.cold";
        var layer_polygon_stroke_inactive_hot = "gl-draw-polygon-stroke-inactive.hot";
        var getlayer_stroke_hot = map.getLayer(layer_polygon_stroke_inactive_hot);
        var getlayer_stroke_hold = map.getLayer(layer_polygon_stroke_inactive_cold);
        
        var layer_polygon_fill_inactive_cold = "gl-draw-polygon-fill-inactive.cold";
        var layer_polygon_fill_inactive_hot = "gl-draw-polygon-fill-inactive.hot";
        var getlayer_fill_hot = map.getLayer(layer_polygon_fill_inactive_hot);
        var getlayer_fill_hold = map.getLayer(layer_polygon_fill_inactive_cold);

        var allLayerDraw = {
            "getlayer_line_hot": getlayer_line_hot,
            "getlayer_line_hold": getlayer_line_hold,
            "getlayer_stroke_hot": getlayer_stroke_hot,
            "getlayer_stroke_hold": getlayer_stroke_hold,
            "getlayer_fill_hot": getlayer_fill_hot,
            "getlayer_fill_hold": getlayer_fill_hold,
        }

        if (getlayer_line_hot && getlayer_line_hold) {
            // ubah warnanya jadi warna biru
            map.setPaintProperty(layer_line_inactive_hot, "line-color", "#0080ff");
            map.setPaintProperty(layer_line_inactive_cold, "line-color", "#0080ff");
        }

        if (getlayer_stroke_hold && getlayer_stroke_hot) {
            // ubah warnanya jadi warna biru
            map.setPaintProperty(layer_polygon_stroke_inactive_hot, "line-color", "#0080ff");
            map.setPaintProperty(layer_polygon_stroke_inactive_cold, "line-color", "#0080ff");
        }

        if (getlayer_fill_hold && getlayer_fill_hot) {
            // ubah color & opacity nya
            map.setPaintProperty(layer_polygon_fill_inactive_hot, "fill-color", "#0080ff");
            map.setPaintProperty(layer_polygon_fill_inactive_hot, "fill-outline-color", "#0080ff");
            map.setPaintProperty(layer_polygon_fill_inactive_hot, "fill-opacity", 0.2);
    
            map.setPaintProperty(layer_polygon_fill_inactive_cold, "fill-color", "#0080ff");
            map.setPaintProperty(layer_polygon_fill_inactive_cold, "fill-outline-color", "#0080ff");
            map.setPaintProperty(layer_polygon_fill_inactive_cold, "fill-opacity", 0.2);
        }

        // var allSource = getAllSources();
        // console.log("allSource: ", allSource);
        // console.log("allLayerDraw: ", allLayerDraw);
        return allLayerDraw;
    }

    function styleDraw(){
        if (map.getLayer('gl-draw-line-static.hot')) {
            map.removeLayer('gl-draw-line-static.hot');
        }
        if (map.getLayer('gl-draw-polygon-stroke-static.hot')) {
            map.removeLayer('gl-draw-polygon-stroke-static.hot');
        }
        if (map.getLayer('')) {
            map.removeLayer('');
        }
        if (map.getLayer('gl-draw-point-static.hot')) {
            map.removeLayer('gl-draw-point-static.hot');
        }

        // default list styles mapbox-gl-draw
        return [
            {
                "id": "gl-draw-polygon-fill-inactive.cold",
                "type": "fill",
                "filter": [
                    "all",
                    [
                        "==",
                        "active",
                        "false"
                    ],
                    [
                        "==",
                        "$type",
                        "Polygon"
                    ],
                    [
                        "!=",
                        "mode",
                        "static"
                    ]
                ],
                "paint": {
                    "fill-color": "#0080ff",
                    "fill-outline-color": "#0080ff",
                    "fill-opacity": 0.5
                },
                "source": "mapbox-gl-draw-cold"
            },
            {
                "id": "gl-draw-polygon-fill-active.cold",
                "type": "fill",
                "filter": [
                    "all",
                    [
                        "==",
                        "active",
                        "true"
                    ],
                    [
                        "==",
                        "$type",
                        "Polygon"
                    ]
                ],
                "paint": {
                    "fill-color": "#fbb03b",
                    "fill-outline-color": "#fbb03b",
                    "fill-opacity": 0.5
                },
                "source": "mapbox-gl-draw-cold"
            },
            {
                "id": "gl-draw-polygon-midpoint.cold",
                "type": "circle",
                "filter": [
                    "all",
                    [
                        "==",
                        "$type",
                        "Point"
                    ],
                    [
                        "==",
                        "meta",
                        "midpoint"
                    ]
                ],
                "paint": {
                    "circle-radius": 3,
                    "circle-color": "#fbb03b"
                },
                "source": "mapbox-gl-draw-cold"
            },
            {
                "id": "gl-draw-polygon-stroke-inactive.cold",
                "type": "line",
                "filter": [
                    "all",
                    [
                        "==",
                        "active",
                        "false"
                    ],
                    [
                        "==",
                        "$type",
                        "Polygon"
                    ],
                    [
                        "!=",
                        "mode",
                        "static"
                    ]
                ],
                "layout": {
                    "line-cap": "round",
                    "line-join": "round"
                },
                "paint": {
                    "line-color": "#0080ff",
                    "line-width": 2
                },
                "source": "mapbox-gl-draw-cold"
            },
            {
                "id": "gl-draw-polygon-stroke-active.cold",
                "type": "line",
                "filter": [
                    "all",
                    [
                        "==",
                        "active",
                        "true"
                    ],
                    [
                        "==",
                        "$type",
                        "Polygon"
                    ]
                ],
                "layout": {
                    "line-cap": "round",
                    "line-join": "round"
                },
                "paint": {
                    "line-color": "#fbb03b",
                    "line-dasharray": [
                        0.2,
                        2
                    ],
                    "line-width": 2
                },
                "source": "mapbox-gl-draw-cold"
            },
            {
                "id": "gl-draw-line-inactive.cold",
                "type": "line",
                "filter": [
                    "all",
                    [
                        "==",
                        "active",
                        "false"
                    ],
                    [
                        "==",
                        "$type",
                        "LineString"
                    ],
                    [
                        "!=",
                        "mode",
                        "static"
                    ]
                ],
                "layout": {
                    "line-cap": "round",
                    "line-join": "round"
                },
                "paint": {
                    "line-color": "#0080ff",
                    "line-width": 2
                },
                "source": "mapbox-gl-draw-cold"
            },
            {
                "id": "gl-draw-line-active.cold",
                "type": "line",
                "filter": [
                    "all",
                    [
                        "==",
                        "$type",
                        "LineString"
                    ],
                    [
                        "==",
                        "active",
                        "true"
                    ]
                ],
                "layout": {
                    "line-cap": "round",
                    "line-join": "round"
                },
                "paint": {
                    "line-color": "#fbb03b",
                    "line-dasharray": [
                        0.2,
                        2
                    ],
                    "line-width": 2
                },
                "source": "mapbox-gl-draw-cold"
            },
            {
                "id": "gl-draw-polygon-and-line-vertex-stroke-inactive.cold",
                "type": "circle",
                "filter": [
                    "all",
                    [
                        "==",
                        "meta",
                        "vertex"
                    ],
                    [
                        "==",
                        "$type",
                        "Point"
                    ],
                    [
                        "!=",
                        "mode",
                        "static"
                    ]
                ],
                "paint": {
                    "circle-radius": 5,
                    "circle-color": "#fff"
                },
                "source": "mapbox-gl-draw-cold"
            },
            {
                "id": "gl-draw-polygon-and-line-vertex-inactive.cold",
                "type": "circle",
                "filter": [
                    "all",
                    [
                        "==",
                        "meta",
                        "vertex"
                    ],
                    [
                        "==",
                        "$type",
                        "Point"
                    ],
                    [
                        "!=",
                        "mode",
                        "static"
                    ]
                ],
                "paint": {
                    "circle-radius": 3,
                    "circle-color": "#fbb03b"
                },
                "source": "mapbox-gl-draw-cold"
            },
            {
                "id": "gl-draw-point-point-stroke-inactive.cold",
                "type": "circle",
                "filter": [
                    "all",
                    [
                        "==",
                        "active",
                        "false"
                    ],
                    [
                        "==",
                        "$type",
                        "Point"
                    ],
                    [
                        "==",
                        "meta",
                        "feature"
                    ],
                    [
                        "!=",
                        "mode",
                        "static"
                    ]
                ],
                "paint": {
                    "circle-radius": 5,
                    "circle-opacity": 1,
                    "circle-color": "#fff"
                },
                "source": "mapbox-gl-draw-cold"
            },
            {
                "id": "gl-draw-point-inactive.cold",
                "type": "circle",
                "filter": [
                    "all",
                    [
                        "==",
                        "active",
                        "false"
                    ],
                    [
                        "==",
                        "$type",
                        "Point"
                    ],
                    [
                        "==",
                        "meta",
                        "feature"
                    ],
                    [
                        "!=",
                        "mode",
                        "static"
                    ]
                ],
                "paint": {
                    "circle-radius": 3,
                    "circle-color": "#0080ff"
                },
                "source": "mapbox-gl-draw-cold"
            },
            {
                "id": "gl-draw-point-stroke-active.cold",
                "type": "circle",
                "filter": [
                    "all",
                    [
                        "==",
                        "$type",
                        "Point"
                    ],
                    [
                        "==",
                        "active",
                        "true"
                    ],
                    [
                        "!=",
                        "meta",
                        "midpoint"
                    ]
                ],
                "paint": {
                    "circle-radius": 7,
                    "circle-color": "#fff"
                },
                "source": "mapbox-gl-draw-cold"
            },
            {
                "id": "gl-draw-point-active.cold",
                "type": "circle",
                "filter": [
                    "all",
                    [
                        "==",
                        "$type",
                        "Point"
                    ],
                    [
                        "!=",
                        "meta",
                        "midpoint"
                    ],
                    [
                        "==",
                        "active",
                        "true"
                    ]
                ],
                "paint": {
                    "circle-radius": 5,
                    "circle-color": "#fbb03b"
                },
                "source": "mapbox-gl-draw-cold"
            },
            {
                "id": "gl-draw-polygon-fill-static.cold",
                "type": "fill",
                "filter": [
                    "all",
                    [
                        "==",
                        "mode",
                        "static"
                    ],
                    [
                        "==",
                        "$type",
                        "Polygon"
                    ]
                ],
                "paint": {
                    "fill-color": "#404040",
                    "fill-outline-color": "#404040",
                    "fill-opacity": 0.5
                },
                "source": "mapbox-gl-draw-cold"
            },
            {
                "id": "gl-draw-polygon-stroke-static.cold",
                "type": "line",
                "filter": [
                    "all",
                    [
                        "==",
                        "mode",
                        "static"
                    ],
                    [
                        "==",
                        "$type",
                        "Polygon"
                    ]
                ],
                "layout": {
                    "line-cap": "round",
                    "line-join": "round"
                },
                "paint": {
                    "line-color": "#404040",
                    "line-width": 2
                },
                "source": "mapbox-gl-draw-cold"
            },
            {
                "id": "gl-draw-line-static.cold",
                "type": "line",
                "filter": [
                    "all",
                    [
                        "==",
                        "mode",
                        "static"
                    ],
                    [
                        "==",
                        "$type",
                        "LineString"
                    ]
                ],
                "layout": {
                    "line-cap": "round",
                    "line-join": "round"
                },
                "paint": {
                    "line-color": "#404040",
                    "line-width": 2
                },
                "source": "mapbox-gl-draw-cold"
            },
            {
                "id": "gl-draw-point-static.cold",
                "type": "circle",
                "filter": [
                    "all",
                    [
                        "==",
                        "mode",
                        "static"
                    ],
                    [
                        "==",
                        "$type",
                        "Point"
                    ]
                ],
                "paint": {
                    "circle-radius": 5,
                    "circle-color": "#404040"
                },
                "source": "mapbox-gl-draw-cold"
            },
            {
                "id": "gl-draw-polygon-fill-inactive.hot",
                "type": "fill",
                "filter": [
                    "all",
                    [
                        "==",
                        "active",
                        "false"
                    ],
                    [
                        "==",
                        "$type",
                        "Polygon"
                    ],
                    [
                        "!=",
                        "mode",
                        "static"
                    ]
                ],
                "paint": {
                    "fill-color": "#0080ff",
                    "fill-outline-color": "#0080ff",
                    "fill-opacity": 0.5
                },
                "source": "mapbox-gl-draw-hot"
            },
            {
                "id": "gl-draw-polygon-fill-active.hot",
                "type": "fill",
                "filter": [
                    "all",
                    [
                        "==",
                        "active",
                        "true"
                    ],
                    [
                        "==",
                        "$type",
                        "Polygon"
                    ]
                ],
                "paint": {
                    "fill-color": "#fbb03b",
                    "fill-outline-color": "#fbb03b",
                    "fill-opacity": 0.5
                },
                "source": "mapbox-gl-draw-hot"
            },
            {
                "id": "gl-draw-polygon-midpoint.hot",
                "type": "circle",
                "filter": [
                    "all",
                    [
                        "==",
                        "$type",
                        "Point"
                    ],
                    [
                        "==",
                        "meta",
                        "midpoint"
                    ]
                ],
                "paint": {
                    "circle-radius": 3,
                    "circle-color": "#fbb03b"
                },
                "source": "mapbox-gl-draw-hot"
            },
            {
                "id": "gl-draw-polygon-stroke-inactive.hot",
                "type": "line",
                "filter": [
                    "all",
                    [
                        "==",
                        "active",
                        "false"
                    ],
                    [
                        "==",
                        "$type",
                        "Polygon"
                    ],
                    [
                        "!=",
                        "mode",
                        "static"
                    ]
                ],
                "layout": {
                    "line-cap": "round",
                    "line-join": "round"
                },
                "paint": {
                    "line-color": "#0080ff",
                    "line-width": 2
                },
                "source": "mapbox-gl-draw-hot"
            },
            {
                "id": "gl-draw-polygon-stroke-active.hot",
                "type": "line",
                "filter": [
                    "all",
                    [
                        "==",
                        "active",
                        "true"
                    ],
                    [
                        "==",
                        "$type",
                        "Polygon"
                    ]
                ],
                "layout": {
                    "line-cap": "round",
                    "line-join": "round"
                },
                "paint": {
                    "line-color": "#fbb03b",
                    "line-dasharray": [
                        0.2,
                        2
                    ],
                    "line-width": 2
                },
                "source": "mapbox-gl-draw-hot"
            },
            {
                "id": "gl-draw-line-inactive.hot",
                "type": "line",
                "filter": [
                    "all",
                    [
                        "==",
                        "active",
                        "false"
                    ],
                    [
                        "==",
                        "$type",
                        "LineString"
                    ],
                    [
                        "!=",
                        "mode",
                        "static"
                    ]
                ],
                "layout": {
                    "line-cap": "round",
                    "line-join": "round"
                },
                "paint": {
                    "line-color": "#0080ff",
                    "line-width": 2
                },
                "source": "mapbox-gl-draw-hot"
            },
            {
                "id": "gl-draw-line-active.hot",
                "type": "line",
                "filter": [
                    "all",
                    [
                        "==",
                        "$type",
                        "LineString"
                    ],
                    [
                        "==",
                        "active",
                        "true"
                    ]
                ],
                "layout": {
                    "line-cap": "round",
                    "line-join": "round"
                },
                "paint": {
                    "line-color": "#fbb03b",
                    "line-dasharray": [
                        0.2,
                        2
                    ],
                    "line-width": 2
                },
                "source": "mapbox-gl-draw-hot"
            },
            {
                "id": "gl-draw-polygon-and-line-vertex-stroke-inactive.hot",
                "type": "circle",
                "filter": [
                    "all",
                    [
                        "==",
                        "meta",
                        "vertex"
                    ],
                    [
                        "==",
                        "$type",
                        "Point"
                    ],
                    [
                        "!=",
                        "mode",
                        "static"
                    ]
                ],
                "paint": {
                    "circle-radius": 5,
                    "circle-color": "#fff"
                },
                "source": "mapbox-gl-draw-hot"
            },
            {
                "id": "gl-draw-polygon-and-line-vertex-inactive.hot",
                "type": "circle",
                "filter": [
                    "all",
                    [
                        "==",
                        "meta",
                        "vertex"
                    ],
                    [
                        "==",
                        "$type",
                        "Point"
                    ],
                    [
                        "!=",
                        "mode",
                        "static"
                    ]
                ],
                "paint": {
                    "circle-radius": 3,
                    "circle-color": "#fbb03b"
                },
                "source": "mapbox-gl-draw-hot"
            },
            {
                "id": "gl-draw-point-point-stroke-inactive.hot",
                "type": "circle",
                "filter": [
                    "all",
                    [
                        "==",
                        "active",
                        "false"
                    ],
                    [
                        "==",
                        "$type",
                        "Point"
                    ],
                    [
                        "==",
                        "meta",
                        "feature"
                    ],
                    [
                        "!=",
                        "mode",
                        "static"
                    ]
                ],
                "paint": {
                    "circle-radius": 5,
                    "circle-opacity": 1,
                    "circle-color": "#fff"
                },
                "source": "mapbox-gl-draw-hot"
            },
            {
                "id": "gl-draw-point-inactive.hot",
                "type": "circle",
                "filter": [
                    "all",
                    [
                        "==",
                        "active",
                        "false"
                    ],
                    [
                        "==",
                        "$type",
                        "Point"
                    ],
                    [
                        "==",
                        "meta",
                        "feature"
                    ],
                    [
                        "!=",
                        "mode",
                        "static"
                    ]
                ],
                "paint": {
                    "circle-radius": 3,
                    "circle-color": "#0080ff"
                },
                "source": "mapbox-gl-draw-hot"
            },
            {
                "id": "gl-draw-point-stroke-active.hot",
                "type": "circle",
                "filter": [
                    "all",
                    [
                        "==",
                        "$type",
                        "Point"
                    ],
                    [
                        "==",
                        "active",
                        "true"
                    ],
                    [
                        "!=",
                        "meta",
                        "midpoint"
                    ]
                ],
                "paint": {
                    "circle-radius": 7,
                    "circle-color": "#fff"
                },
                "source": "mapbox-gl-draw-hot"
            },
            {
                "id": "gl-draw-point-active.hot",
                "type": "circle",
                "filter": [
                    "all",
                    [
                        "==",
                        "$type",
                        "Point"
                    ],
                    [
                        "!=",
                        "meta",
                        "midpoint"
                    ],
                    [
                        "==",
                        "active",
                        "true"
                    ]
                ],
                "paint": {
                    "circle-radius": 5,
                    "circle-color": "#fbb03b"
                },
                "source": "mapbox-gl-draw-hot"
            },
            {
                "id": "gl-draw-polygon-fill-static.hot",
                "type": "fill",
                "filter": [
                    "all",
                    [
                        "==",
                        "mode",
                        "static"
                    ],
                    [
                        "==",
                        "$type",
                        "Polygon"
                    ]
                ],
                "paint": {
                    "fill-color": "#404040",
                    "fill-outline-color": "#404040",
                    "fill-opacity": 0.5
                },
                "source": "mapbox-gl-draw-hot"
            },
            {
                "id": "gl-draw-polygon-stroke-static.hot",
                "type": "line",
                "filter": [
                    "all",
                    [
                        "==",
                        "mode",
                        "static"
                    ],
                    [
                        "==",
                        "$type",
                        "Polygon"
                    ]
                ],
                "layout": {
                    "line-cap": "round",
                    "line-join": "round"
                },
                "paint": {
                    "line-color": "#404040",
                    "line-width": 2
                },
                "source": "mapbox-gl-draw-hot"
            },
            {
                "id": "gl-draw-line-static.hot",
                "type": "line",
                "filter": [
                    "all",
                    [
                        "==",
                        "mode",
                        "static"
                    ],
                    [
                        "==",
                        "$type",
                        "LineString"
                    ]
                ],
                "layout": {
                    "line-cap": "round",
                    "line-join": "round"
                },
                "paint": {
                    "line-color": "#404040",
                    "line-width": 2
                },
                "source": "mapbox-gl-draw-hot"
            },
            {
                "id": "gl-draw-point-static.hot",
                "type": "circle",
                "filter": [
                    "all",
                    [
                        "==",
                        "mode",
                        "static"
                    ],
                    [
                        "==",
                        "$type",
                        "Point"
                    ]
                ],
                "paint": {
                    "circle-radius": 5,
                    "circle-color": "#404040"
                },
                "source": "mapbox-gl-draw-hot"
            }
        ]

    }
</script>