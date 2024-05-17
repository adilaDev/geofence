<?php
$token_user = $this->session->userdata("user_token");
?>
<div id='my_map'></div>
<style>
    #my_map { position: absolute; top: 0; bottom: 0; width: 100%; }
    .mapboxgl-popup{
        max-width: none !important;
    }
    .repeater {
    /* .mapboxgl-popup-content { */
        max-height: 15em;
        overflow-y: auto;
        margin-right: 10px;
    }
</style>
<button type="button" id="btn_draw_rectangle" class="btn btn-light btn-sm d-none waves-effect waves-light" onclick="changeModeDraw('draw_rectangle')">
    <i class="bx bx-rectangle font-size-18 align-middle" style="font-weight: 800 !important;"></i>
</button>
<button type="button" id="btn_draw_circle" class="btn btn-light btn-sm d-none waves-effect waves-light" onclick="changeModeDraw('draw_circle')">
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

<!-- center modal -->
<!-- <button type="button" id="btn_save_polygon" class="btn btn-light btn-sm d-none waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".modal_polygon_name"> -->

<div class="modal fade modal_polygon_name" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Save Drawing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="source_name">Sources Name</label>
                    <input type="text" class="form-control" id="source_name" name="source_name">
                </div>

                <div class="mb-3">
                    <label for="layer_name">Layer Name</label>
                    <input type="text" class="form-control" id="layer_name" name="layer_name">
                </div>

                <button type="button" onclick="modal_save_polygon()" class="btn btn-primary waves-effect waves-light me-2" data-bs-dismiss="modal" aria-label="Close">Save</button>
                <button type="button" class="btn btn-secondary waves-effect waves-light me-2" data-bs-dismiss="modal" aria-label="Close">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- mapbox gl -->
<link href="<?= base_url() ?>assets/libs/mapbox/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">
<script src="<?= base_url() ?>assets/libs/mapbox/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>
<!-- <link href="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.js"></script> -->

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

<!-- Table Editable plugin -->
<script src="<?=base_url()?>assets/libs/table-edits/build/table-edits.min.js"></script>
<!-- form repeater js -->
<script src="<?=base_url()?>assets/libs/jquery.repeater/jquery.repeater.min.js"></script>

<!-- DataTables -->
<link href="<?=base_url()?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<!-- Required datatable js -->
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
<!-- <script src="<?= base_url('vendor/mapbox-gl-draw-circle-master/lib/modes/byFadil/SimpleSelectModeByFadil.js?v=').time() ?>"></script> -->
<script src="<?= base_url('vendor/mapbox-gl-draw-circle-master/lib/modes/byFadil/additonal_function.js?v=').time() ?>"></script>
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
    const OSM_STYLE_3D = "https://api.maptiler.com/maps/streets-v2/style.json?key=eIgS48TpQ70m77qKYrsx&mtsid=0baa23da-3d7c-4615-adbb-2d7b00126f06";
    const OSM_STYLE_DATAVIZ = "https://api.maptiler.com/maps/dataviz/style.json?key=eIgS48TpQ70m77qKYrsx&mtsid=0baa23da-3d7c-4615-adbb-2d7b00126f06";
    const token_user = '<?= $token_user ?>';
    var undoStack = [], redoStack = [];

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

    function get_html_popup(){
        return `<div id="form_repeater" class="repeater">
            <table class="table table-editable table-sm table-nowrap align-middle border border-secondary table-edits-dynamic mb-0">
                <thead>
                    <tr>
                        <th>Key</th>
                        <th>Value</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tbody_edit" data-repeater-list="group-a">
                    <tr data-repeater-item>
                        <td data-field="key">Country</td>
                        <td data-field="value">Indonesia</td>
                        <td>
                            <a class="btn btn-outline-secondary btn-sm edit me-1" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a data-repeater-delete class="btn btn-outline-danger btn-sm delete" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <input data-repeater-create type="button" class="btn btn-primary btn-sm mt-2 mt-lg-0" value="Add Row"/>
            <input type="button" onclick="deleteFeature(this)" id="btnDelFeat" class="btn btn-danger btn-sm mt-2 mt-lg-0" value="Delete Feature"/>
        </div>`;
    }
    function repeater(){
        repeater_html = $('.repeater').repeater({
            show: function () {
                $(this).slideDown();
                initDtEdit();
            },
            hide: function (deleteElement) {
                if(confirm('Are you sure you want to delete this element?')) {
                    console.log("deleteElement: ", $(this).parent());
                    $(this).slideUp(deleteElement);
                    initDtEdit();
                }
            },
            ready: function (setIndexes) {
                initDtEdit();
            }
        });
        return repeater_html;
    }

    var jawaban = [];
    var pickers = {};
    function initDtEdit(){
        var edit_table = $('.table-edits-dynamic tr').editable({
            dropdowns: {
                gender: ['Male', 'Female']
            },
            edit: function (values) {
                $(".edit i", this)
                    .removeClass('fa-pencil-alt')
                    .addClass('fa-save')
                    .attr('title', 'Save');
                // console.log("edit: ", values, " pickers: ", pickers, "\nthis: ", this);
            },
            save: function (values) {
                $(".edit i", this)
                    .removeClass('fa-save')
                    .addClass('fa-pencil-alt')
                    .attr('title', 'Edit');

                saveInfo(values);
                // console.log("save: ", values, " edit_table: ", edit_table);

                if (this in pickers) {
                    pickers[this].destroy();
                    delete pickers[this];
                    console.log("save pickers: ", pickers);
                }
            },
            cancel: function (values) {
                $(".edit i", this)
                    .removeClass('fa-save')
                    .addClass('fa-trash-alt')
                    .attr('title', 'Edit');

                // console.log("cancel: ", values, " pickers: ", pickers, "\nthis: ", this);
                if (this in pickers) {
                    pickers[this].destroy();
                    delete pickers[this];
                }
            }
        });
    }

    $("#searchInput").on('input', initPlacesSearch);
    function initPlacesSearch() {
        var input = document.getElementById('searchInput');
        var searchBox = new google.maps.places.SearchBox(input);
        var val = $(input).val();
        if (val == "") {
            marker.remove();
        }
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
        //     $(row).find('td').each(function(index, val) {
        //         // Set contenteditable to true unless it's the 'action' column
        //         $(this).attr('contenteditable', index !== Object.keys(data[0]).indexOf('action'));
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
                    data: 'action', title: "Action",
                    // render: function (data, type, row, col) {
                    //     // console.log("render data: ", data, "\ntype: ", type, "\nrow: ", row, "\ncol: ", col);
                    //     // return '<a class="btn btn-outline-secondary btn-sm edit me-1" title="Edit"><i class="fas fa-pencil-alt"></i></a>' +
                    //     //         '<a class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></a>';
                    //     return '<a class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></a>';
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
        
        $('#dynamic_table').on('blur', 'tbody tr', function (e) {
            var child =  $(this).children();
            var newData = {'no': '', 'key': '', 'value': '', 'action': '<a class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></a>'};
            const no = $(child[0]).text();
            const key = underscore($(child[1]).text());
            const val = $(child[2]).text();
            newData.no = no;
            newData.key = key;
            newData.value = val;
    
            var edit = tables.row(this)
            .data(newData).draw();
            // console.log("edit: ", edit, "\nnewData: ",newData);
        });
    
        $('#dynamic_table tbody').on('click', 'a.delete', function () {
            tables.row($(this).parents('tr')).remove().draw();
        });
    }

    $('#addRowBtn').on('click', function() {
        var allData = tables.rows().data().toArray();
        var lastData = allData[allData.length-1];
        var no = parseInt(lastData.no)+1;
        console.log("lastData: ", lastData);

        // Buat baris kosong baru
        var newRowData = {'no': no, 'key': '', 'value': '', 'action': '<a class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></a>'};

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
            confirmButtonColor: "#20b2aa",
            showCancelButton: false
        }).then(() => {
            // tutup canvas
            $("#canvasDataTable").click();
            draw.changeMode('simple_select');
            marker.remove();
        });
    });

    function saveDataTableToProperties(){
        // Simpan data yang sedang diedit ke DataTable
        var allData = tables.rows().data().toArray();
        changeFormatToProperties();
        var getPolygon = draw.getSelected();
        // console.log("saveDataTableToProperties: ", allData, "\npolygon: ", getPolygon);
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
        // console.log("clear: ", feature);
        return feature;
    }
    
    function changeFormatToProperties(){
        var data = tables.rows().data().toArray();
        var getPolygon = draw.getSelected();
        var id = draw.getSelectedIds()[0];
        // tambahkan fungsi kosongkan semua properties sebelum ditambahkan
        var clear = clearProperties(getPolygon.features[0]);
        // console.log("getProperties: ", getPolygon.features);

        const result = data.reduce((acc, item) => {
            if (item.key != "" || item.value != "") {
                // Ambil properti 'key' dan masukkan ke dalam objek
                acc[item.key] = item.value;
                draw.setFeatureProperty(id, item.key, item.value);
            }
            return acc;
        }, {});
        // console.log("changeFormat: ", result);
        return result;
    }

    function changeObjectToArray(obj) {
        return Object.entries(obj).map(([key, value], index) => {
            return {
                no: (index + 1).toString(), // Sesuaikan dengan cara Anda memberikan nomor
                key: key,
                value: value,
                action: '<a class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></a>'
            };
        });
    }
</script>

<script>
    // ======================================
    // start load Map
    // ======================================
	mapboxgl.accessToken = TOKEN_MAP;
    const map = new mapboxgl.Map({
        container: 'my_map', // container ID
        // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
        // style: 'mapbox://styles/mapbox/dark-v11', // style URL
        // style: (item_style != null || item_style != undefined) ? item_style : 'mapbox://styles/mapbox/dark-v11', // style URL
        // style: get_style_map, // style URL
        style: OSM_STYLE_DATAVIZ, // style URL
        center: viewJapan, // starting position
        // zoom: 5, // starting zoom
        zoom: 10, // starting zoom
        attributionControl: false
    });
    
    map.addControl(new mapboxgl.AttributionControl({
        customAttribution: `© <?= NAMA_WEB ?>. Design & Developed by <a href="https://asiaresearchinstitute.com/" target="_blank" rel="noopener noreferrer"><img src="<?= base_url() ?>assets/images/LOGO_ARI/logo_ari_green.svg" alt="" width="auto" height="13"></a>`
    }));
    // map.addControl(
    //     new MapboxGeocoder({
    //         accessToken: mapboxgl.accessToken,
    //         mapboxgl: mapboxgl,
    //         // language: 'ja',
    //         // placeholder: '住所検索',
    //     }),
    // 'bottom-left');

    // tambahkan button ke UI mapbox
    // $("#btn_save_polygon").addClass("mapboxgl-ctrl m-0").appendTo(".mapboxgl-ctrl-bottom-right > .mapboxgl-ctrl.mapboxgl-ctrl-group").removeClass("btn btn-light btn-sm d-none");
    
    var modes = MapboxDraw.modes;
    // modes = MapboxDrawGeodesic.enable(modes); // https://github.com/zakjan/mapbox-gl-draw-geodesic
    modes.draw_rectangle = DrawRectangle.default; // https://gist.github.com/erick-otenyo/e22cefb2c69fb4d4db4c19d7778ed574
    modes.draw_circle = DragCircleMode;
    modes.draw_freehand = FreehandMode;
    // modes.simple_select = SimpleSelectModeOverride;
    modes.cut_polygon = CutPolygonMode;
    modes.cut_polygon_passing_draw_polygon = mapboxGlDrawPassingMode.passing_draw_polygon;
    console.log("modes: ", modes);

    // var draw = new MapboxDraw({  modes: modes });
    var draw = new MapboxDraw({
        displayControlsDefault: false,
        keybindings: true,
        controls: {
            line_string: true,
            polygon: true,
            point: false,
            trash: true,
            combine_features: true,
            uncombine_features: true,
        },
        modes: modes,
        // styles: styleDraw()
    });
    map.addControl(draw,'bottom-right');
    map.addControl(new mapboxgl.NavigationControl(),'bottom-right');
    map.addControl(new mapboxgl.FullscreenControl(),'bottom-right');

    // tambahkan button ke UI mapbox
    // $(".mapboxgl-ctrl-bottom-right > .mapboxgl-ctrl.mapboxgl-ctrl-group:first-child").append($btn_modal);
    
    // var $btn_circle = $("#btn_draw_circle").removeClass("btn btn-light btn-sm d-none").addClass("mapboxgl-gl-draw_ctrl-draw-btn m-0");
    // $(".mapboxgl-ctrl-bottom-right > .mapboxgl-ctrl.mapboxgl-ctrl-group:nth-child(3) > button.mapbox-gl-draw_line").after($btn_circle);
    
    addtionalBtn();
    
    // Create a popup, but don't add it to the map yet.
    const popupTop = new mapboxgl.Popup({
        anchor: 'top',
        closeOnClick: true,
        closeButton: true
    });

    map.on('style.load', (e) => {
        console.log("map load: ", e);
        dummy_polygon();
        improveMapDelete();
        changeStyleDraw();
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

    function changeModeDraw(get_mode){
        draw.changeMode(get_mode);
    }

    function htmlPolygon(lngLat, popup){
        return `<div class="row px-2">
                    <div class="col" id="content-popup">
                        <button type="button" onclick="getAPI(${JSON.stringify(lngLat)})" class="btn btn-outline-info btn-sm waves-effect me-1">Add Information</button>
                    </div>
                </div>`;
    }

    function closePopup(pop){
        var popup = JSON.parse(pop)
        console.log("closePopup: ", pop, popup);
    }

    function setPopupHTML(lngLat = null){
        var lng = lngLat[0];
        var lat = lngLat[1];

        var popup = new mapboxgl.Popup({closeOnClick: true, closeButton: true})
        .setLngLat((lngLat == null) ? viewJapan : lngLat)
        // .setHTML(get_html_popup())
        .setHTML(htmlPolygon(lngLat, popup))
        .addTo(map);
        // var html_rep = repeater();
        const popupElem = popup.getElement();
        var getBtn = $(popup._closeButton).addClass("btn btn-outline-danger btn-sm waves-effect").removeClass("mapboxgl-popup-close-button").text("Edit");
        var parent = $(".mapboxgl-popup #content-popup");
        parent.append(getBtn);
        var callback = {"popup": popup, "lngLat": lngLat, "popupElem": popupElem, "getBtn": getBtn};
        console.log("callback: ", callback);
        return callback;
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

            //     geocodeToDataTable.push({'no': no, 'key': "formatted_address_"+no, 'value': value, 'action': '<a class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></a>'});
            // }

            var no = 1;
            geocodeToDataTable.push({'no': no, 'key': 'formatted_address', 'value': list_main.formatted_address, 'action': '<a class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></a>'});
            // dapatkan semua informasi dari index ke 1
            for (let i = 0; i < list_address.length; i++) {
                const item = list_address[i];
                const key = item.types[0];
                const value = item.long_name;
                no++;

                geocodeToDataTable.push({'no': no, 'key': key, 'value': value, 'action': '<a class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></a>'});
            }
            var lat = list_main.geometry.location.lat;
            var lng = list_main.geometry.location.lng;
            geocodeToDataTable.push({'no': no+=1, 'key': 'latitude', 'value': lat, 'action': '<a class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></a>'});
            geocodeToDataTable.push({'no': no+=1, 'key': 'longitude', 'value': lng, 'action': '<a class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></a>'});
            
            var getPolygon = draw.getSelected();
            var prop = getPolygon.features[0].properties;
            var checkProp = isObjectEmpty(prop);
            if (!checkProp && prop.isCircle) {
                geocodeToDataTable.push({'no': no+=1, 'key': 'isCircle', 'value': prop.isCircle, 'action': '<button type="button" disabled class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></button>'});
                geocodeToDataTable.push({'no': no+=1, 'key': 'radiusInKm', 'value': prop.radiusInKm, 'action': '<button type="button" disabled class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></button>'});
                geocodeToDataTable.push({'no': no+=1, 'key': 'center', 'value': prop.center.toString(), 'action': '<button type="button" disabled class="btn btn-outline-danger btn-sm delete" title="Delete"><i class="fas fa-trash-alt"></i></button>'});
            }

            // console.log("API GoogleMap: ", data);
            // console.log("API Gmap: ", geocodeToDataTable);
            superDynamicDT(geocodeToDataTable);
            saveDataTableToProperties();
        });
    }

    function saveInfo(values){
        var feature_id = draw.getSelectedIds();
        var feature = draw.getSelected();
        // values['feature_origin'] = feature;
        
        // var list_key = Object.keys(values.key);
        // var list_val = Object.values(values);
        // for (let i = 0; i < list_val.length; i++) {
        //     const key = list_key[i];
        //     const val = list_val[i];
        // }
        // console.log("list_key: ", list_key, " list_val: ", list_val);
        draw.setFeatureProperty(feature_id, values.key, values.value);
        // values['feature_edit'] = draw.getSelected();
        jawaban.push(values);
        var new_feature = draw.getSelected();
        console.log("save: ", values, " jawaban: ", jawaban);
        console.log("new_feature: ", new_feature);
    }

    // map.on('draw.create', function (e){
    //     var geojson = e.features[0];
    //     var sourceId = 'drawn-feature';
    //     var layerId = 'drawn-feature-layer';

    //     console.log("create: ", draw.getMode(), "\ngeojson: ", geojson);
    //     // Tambahkan sumber jika belum ada
    //     if (!map.getSource(sourceId)) {
    //         map.addSource(sourceId, {
    //             type: 'geojson',
    //             data: geojson
    //         });
    //     } else {
    //         // Jika sumber sudah ada, tambahkan fitur baru ke sumber yang sudah ada
    //         // var existingData = map.getSource(sourceId).serialize().data;
    //         var existingData = map.getSource(sourceId)._data;
    //         existingData.features.push(geojson.features[0]);
    //         map.getSource(sourceId).setData(existingData);
    //     }

    //     // Tambahkan layer jika belum ada
    //     if (!map.getLayer(layerId)) {
    //         // Tambahkan layer baru untuk memvisualisasikan poligon.
    //         map.addLayer({
    //             id: layerId+"fill",
    //             type: 'fill',
    //             source: sourceId,
    //             paint: {
    //                 'fill-color': '#0080ff',
    //                 'fill-opacity': 0.5
    //             }
    //         });
            
    //         // Tambahkan garis luar di sekitar poligon.
    //         map.addLayer({
    //             'id': layerId+'outline',
    //             'type': 'line',
    //             'source': sourceId,
    //             'layout': {},
    //             'paint': {
    //                 'line-color': '#0080ff',
    //                 'line-width': 2
    //             }
    //         });
    //     }
        
    //     map.on('click', layerId, (e) => {
    //         new mapboxgl.Popup()
    //         .setLngLat(e.lngLat)
    //         .setHTML(JSON.stringify(e.features[0]))
    //         .addTo(map);
    //     });
    //     map.on('mouseenter', layerId, () => {
    //         map.getCanvas().style.cursor = 'pointer';
    //     });
        
    //     map.on('mouseleave', layerId, () => {
    //         map.getCanvas().style.cursor = '';
    //     });
    // });

    function getCenterPoint(features){
        var geomet = features.geometry;

        // Dapatkan koordinat pusat poligon
        var centerCoord = turf.centerOfMass(geomet).geometry.coordinates;
        // console.log("centerCoord: ", centerCoord);
        return centerCoord;
    }

    map.on('draw.create', function(e) {
        var features = e.features[0];
        var geomet = features.geometry;
        var id_geojson = features.id;
        
        // Dapatkan propertis dari fitur (nama properties)
        var properties = features.properties;
        // var geocodingApiUrl = geocodingApi(features);
        // toggleModalPolygon(true); // show modal

        // undoStack.push(features);
        undoStack.push({ "features": features, "action": "create" });
        // Bersihkan redoStack setiap kali pengguna membuat tindakan baru
        redoStack = [];
        console.log("undo: ", undoStack);

        console.log("Create draw: ", draw.getMode(), draw.getAll());
        
        // if (draw.getMode() == 'draw_polygon' || draw.getMode() == 'draw_rectangle'){
        //     // drawDeletePolygonById(id_geojson);
        //     createPolygon(id_geojson, features, id_geojson);
        // }
        // console.log("======================================");
        
    });
    
    map.on('draw.modechange', function (e) {
        console.log("modeChange: ", e.mode);
        var mode = e.mode;
        changeStyleDraw();
    });

    // map.on("draw.update", function (e){
    //     var features = e.features[0];
    //     var geomet = features.geometry;
    //     var id_geojson = features.id;
    //     console.log("update: ", e.action, features);

    //     // Dapatkan propertis dari fitur (nama properties)
    //     var properties = features.properties;
        
    //     var id_layer = e.features[0].id;
    //     var getSource = map.getSource(id_layer);
    //     var getLayer1 = map.getLayer(id_layer+"_fill");
    //     var getLayer2 = map.getLayer(id_layer+"_outline");

    //     if (getLayer1 && getLayer2) {
    //         map.removeLayer(id_layer+"_fill");
    //         map.removeLayer(id_layer+"_outline");
    //         if (getSource) {
    //             map.removeSource(id_layer);
    //             createPolygon(id_geojson, features, id_geojson);
    //         }
    //     }
        
    // });

    map.on("draw.update", function (e){
        var updatedFeatures = e.features[0];
        console.log("update: ", e.action, draw.getMode(), updatedFeatures);

        if (draw.getMode() == 'direct_select' || draw.getMode() == 'simple_select') {
            // Periksa apakah ada perubahan geometri
            if (e.action === "move" || e.action === "change_coordinates") {
                undoStack.push({ "features": updatedFeatures, "action": e.action });
                console.log("addUndo: ", undoStack);
            }
        }
    });
    
    map.on("draw.delete", function (e){
        console.log("delete: ", e.features);
        var id_layer = e.features[0].id;
        var getSource = map.getSource(id_layer);
        var getLayer1 = map.getLayer(id_layer+"_fill");
        var getLayer2 = map.getLayer(id_layer+"_outline");

        console.log("deleteSource: ", getSource);
        console.log("deleteLayer1: ", getLayer1);
        console.log("deleteLayer2: ", getLayer2);

        if (getLayer1 && getLayer2) {
            map.removeLayer(id_layer+"_fill");
            map.removeLayer(id_layer+"_outline");
            if (getSource) {
                map.removeSource(id_layer);
            }
        }
        marker.remove()
    });

    var actionable;
    map.on('draw.actionable', function (e){
        actionable = e.actions;
        // console.log("action: ", e.actions);
    });

    map.on('draw.combine', function (e){
        // var com = draw.combineFeatures();
        console.log("combine: ", e);
    });

    map.on('draw.uncombine', function (e){
        // var com = draw.unCombineFeatures();
        console.log("uncombine: ", e);
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
        console.log("selectionchange getMode: ", draw.getMode(), actionable);

        // const multiFeatures = draw.getSelected()
        // .filter(
        //     feature => this.isInstanceOf('MultiFeature', feature)
        // );
        // console.log("multiFeatures: ", multiFeatures);

        // if (draw.getMode() == 'simple_select') {
        //     console.log("combine: ", draw.combineFeatures());
        //     console.log("uncombine: ", draw.uncombineFeatures());
        // }

        if (features.length != 0 && draw.getMode() != "direct_select") {
            var center = getCenterPoint(features[0]);
            var prop = features[0].properties;
            var checkProp = isObjectEmpty(prop);

            if (checkProp) {
                // setPopupHTML(center);
                getAPI(center);
            } else {
                if (prop.isCircle) {
                    getAPI(center);
                } else {
                    var listArrayDT = changeObjectToArray(prop);
                    superDynamicDT(listArrayDT);
                    // console.log("listArrayDT: ", listArrayDT);
                }
            }
            // console.log("propertiesEmpty: ", checkProp);
            // marker.setLngLat(center).setPopup(new mapboxgl.Popup().setHTML(`<span>${JSON.stringify(features[0].properties)}</span>`)).addTo(map);
            var btnDelFeat = $("#btnDelFeat").attr("id-feature", features[0].id);
        } 
        
        // else {
        //     marker.remove();
        // }
    });
    
    function undo() {
        var newUndo = [];
        if (undoStack.length > 0) {
            var lastUndo = undoStack.pop();
            var undoneFeatures = lastUndo.features;
            var action = lastUndo.action;
            var getMode = draw.getMode();
            redoStack.push(lastUndo);

            for (let i = 0; i < undoStack.length; i++) {
                const element = undoStack[i].features;
                newUndo.push(element);
            }

            // console.clear();
            if (action == 'create') {
                draw.delete(undoneFeatures.id);
            } else {
                draw.set({
                    type: 'FeatureCollection',
                    features: newUndo
                });
            }
            console.log("undoClick: ", undoStack, " redoStack: ", redoStack,"\nmode: ", getMode, action, undoneFeatures.id);
            console.log("newUndo: ", newUndo, ' all: ', draw.getAll());
        }
    }
    
    function redo() {
        if (redoStack.length > 0) {
            var lastRedo = redoStack.pop();
            var redoneFeatures = lastRedo.features;
            var action = lastRedo.action;
            var getMode = draw.getMode();
            undoStack.push(lastRedo);
            draw.add(redoneFeatures);
            console.log("redoClick: ", redoStack, " undoStack: ", undoStack, "\nmode: ", getMode, action, ' all: ', draw.getAll(), redoneFeatures.id);
        }
    }

    function removeFeature(){
        var getId = draw.getSelectedIds().toString();
        var res = draw.delete(getId).getAll().features;
        $(".btn-close").click();
    }

    function isObjectEmpty(obj) {
        return Object.entries(obj).length === 0;
    }

    function deleteFeature(e){
        var getSelectedIds = draw.getSelectedIds().toString();
        var after_delete = draw.delete(getSelectedIds).getAll();
        $(".mapboxgl-popup-close-button").click();

        console.log("getSelectedIds: ", getSelectedIds);
        console.log("after_delete: ", after_delete);
    }

    var old_data = {
        "type": "FeatureCollection",
        "features": []
    };
    function createPolygon(source_name, data_source, id_layer){
        if(!map.getSource(source_name)){
            // jika sourcenya belum ada, buat source nya
            map.addSource(source_name, {
                type: 'geojson',//geojson,video,image,canvas
                data: data_source,// Feature data or FeatureCollection data
            });

            old_data.features.push(data_source);
        } else { 
            var getSumberData = map.getSource(source_name).serialize().data;
            // getSumberData.features.push(data_source);
            // map.getSource(source_name).setData(getSumberData);
            old_data.features.push(data_source);
            map.getSource(source_name).setData(old_data);

            console.log("getSumber: ", getSumberData);
        }
        console.log("old_data: ", old_data);

        if (!map.getLayer(id_layer) && !map.getLayer(id_layer+"_outline")) {
            // Tambahkan layer baru untuk memvisualisasikan poligon.
            map.addLayer({
                'id': id_layer+"_fill",
                'type': 'fill',
                'source': source_name,
                'layout': {},
                'paint': {
                    'fill-color': '#0080ff', // blue color fill
                    // 'fill-color': '#0080ff', // blue color fill
                    'fill-opacity': 0.3
                }
            });
            // Tambahkan garis luar di sekitar poligon.
            map.addLayer({
                'id': id_layer+'_outline',
                'type': 'line',
                'source': source_name,
                'layout': {},
                'paint': {
                    'line-color': '#0080ff',
                    // 'line-color': '#0080ff',
                    'line-width': 1.5
                }
            });
        }
        // console.log("layerFill: ", map.getLayer(id_layer));
        // console.log("layerOutline: ", map.getLayer(id_layer+"_outline"));

        map.on('click', id_layer+"_fill", (e) => {
            // // popupTop
            // new mapboxgl.Popup()
            // .setLngLat(e.lngLat)
            // .setHTML(JSON.stringify(e.features[0]))
            // .addTo(map);
            // // console.log("click: ", e, "\npopupTop: ", popupTop, "\nlayer: ", map.getLayer(id_layer));
        });
        map.on('mouseenter', id_layer+"_fill", () => {
            map.getCanvas().style.cursor = 'pointer';
        });
        
        map.on('mouseleave', id_layer+"_fill", () => {
            map.getCanvas().style.cursor = '';
        });
    }

    function drawDeleteAllPolygon() {
        var data = draw.getAll();

        if (data.features.length > 0) {
            // Ambil ID fitur poligon pertama
            var firstPolygonId = data.features[0].id;

            // Hapus poligon berdasarkan ID
            draw.delete(firstPolygonId);
        } else {
            console.log('No polygon to remove.');
        }
    }

    function drawDeletePolygonById(polygonId) {
        // Hapus poligon berdasarkan ID
        draw.delete(polygonId);
    }

    // Fungsi untuk menampilkan sweetInput
    function showSweetInput() {
        return sweetInput()
            .then((result) => {
                var answer = result.value;
                var s_name = answer[0];
                var l_name = answer[answer.length-1];
                // console.log("s_name: ", s_name, " l_name: ", l_name);

                // Validasi input
                if (s_name == "" || l_name == "") {
                    // Tampilkan pesan error
                    return Swal.fire({
                        icon: 'error',
                        title: 'Source Name and Layer Name are required',
                        confirmButtonColor: "#20b2aa",
                        showCancelButton: true
                    }).then((r) => {
                        // Jika pengguna mengklik OK, panggil ulang fungsi
                        if (r.isConfirmed) {
                            return showSweetInput();
                        }
                        // Jika pengguna mengklik Cancel, kembalikan pesan error
                        return Promise.reject('Input validation error');
                    });
                }

                // Jika validasi sukses, kembalikan nilai
                return { s_name, l_name };
            });
    }

    async function sweetInput(){
        return Swal.mixin({
            input: 'text',
            confirmButtonText: 'Next &rarr;',
            showCancelButton: true,
            confirmButtonColor: "#20b2aa",
            cancelButtonColor: "#74788d",
            progressSteps: ['1', '2']
        })
        .queue([{ title: 'Source Name', text: 'Please input source name' }, { title: 'Layer Name', text: 'Please input layer name' }, ]);
    }

    function geocodingApi(features){
        var geomet = features.geometry;

        // Dapatkan koordinat pusat poligon
        var centerCoord = turf.centerOfMass(geomet).geometry.coordinates;
        console.log("centerCoord: ", centerCoord);
        
        // Panggil API Geocoding untuk mendapatkan informasi lokasi
        var apiUrl = 'https://api.mapbox.com/geocoding/v5/mapbox.places/' + centerCoord[0] + ',' + centerCoord[1] +
        '.json?access_token='+TOKEN_MAP;

        fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            // Ambil informasi lokasi dari respons API
            var result = data.features;
            if (result.length > 0) {
                var locationInfo = result[0].context;

                // Setel propertis GeoJSON dengan informasi lokasi
                features.properties = {};

                for (var i = 0; i < locationInfo.length; i++) {
                    var type = locationInfo[i].id.split('.')[0];
                    var value = locationInfo[i].text;
                    features.properties[type] = value;
                }
                // tambahkan place name & address
                features.properties["place_name"] = result[0].place_name;
                features.properties["address"] =  result[0].properties.address;

                // Tampilkan informasi propertis di konsol atau lakukan sesuatu yang lain
                console.log('Properties:', features.properties);
            }

            // Convert the drawn polygon to a string
            featureCollection.features.push(features);
            var geojsonString = JSON.stringify(featureCollection);

            // toggleModalPolygon(true);

            // Swal.fire({
            //     title: 'Masukan nama untuk menyimpan polygon',
            //     input: 'text',
            //     showCancelButton: true,
            //     confirmButtonText: 'Submit',
            //     // showLoaderOnConfirm: true,
            //     confirmButtonColor: "#20b2aa",
            //     cancelButtonColor: "#f46a6a",
            //     allowOutsideClick: false
            // }).then(function (result) {
            //     if (result.isConfirmed) {
            //         if (current_polygon_name != "" && current_polygon_name != result.value) {
            //             // jika tidak sama
            //             featureCollection.features = [features];
            //             geojsonString = JSON.stringify(featureCollection);
            //             console.log("reset featureCollection");
            //         }
            //         current_polygon_name = result.value;
            //         // Send the data to the server for saving
            //         savePolygon(features.id, result.value, JSON.stringify(features), geojsonString);
            //     }
            //     // console.log("result: ", result);
            // })
        })
        .catch((error) => {
            console.error('Error:', error)
        });
    }

    var isAlertAlready = false;
    $("#btn_save_polygon").on("click", function (e){
        // e.preventDefault();

        Swal.fire({
            title: 'Enter a file name to save the polygon',
            input: 'text',
            showCancelButton: true,
            confirmButtonText: 'Submit',
            // showLoaderOnConfirm: true,
            confirmButtonColor: "#20b2aa",
            cancelButtonColor: "#f46a6a",
            allowOutsideClick: false
        }).then(function (result) {
            if (result.isConfirmed) {
                // if (current_polygon_name != "" && current_polygon_name != result.value) {
                //     // jika tidak sama
                //     featureCollection.features = [features];
                //     geojsonString = JSON.stringify(featureCollection);
                //     console.log("reset featureCollection");
                // }
                // current_polygon_name = result.value;
                
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
                        "token_user": token_user,
                        "id_polygon": id,
                        "polygon_name": underscore(result.value),
                        "data": JSON.stringify(data_table),
                        "center_point": JSON.stringify(center_point),
                        "feature_collection": JSON.stringify(data),
                    };
                    // dataArrPoly.push(dataPoly);
                }
                // console.log("dataArrPoly: ", dataArrPoly);
                
                var dataPoly = {
                    "token_user": token_user,
                    "polygon_name": underscore(result.value),
                    "data": JSON.stringify(listDt),
                    "feature_collection": JSON.stringify(data),
                };
                console.log("dataPolygon: ", dataPoly);

                // Send the data to the server for saving
                // savePolygon(JSON.stringify(dataArrPoly));
                savePolygon(JSON.stringify(dataPoly));
            }
            // console.log("result: ", result);
        });
    });

    function savePolygon(dataPoly = {}) {
        nama_polygon = dataPoly.polygon_name;
        // Send an AJAX request to the server to save the polygon
        // You can use any AJAX library or the native fetch API
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>client/savePolygon",
            data: dataPoly,
            // dataType: "application/json",
            success: function (data) {
                console.log('Polygon saved:', data);
                if (!isAlertAlready) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Polygon saved successfully!',
                        text: "Do you want to create a new drawing?",
                        confirmButtonText: "Yes, I want to create a new",
                        cancelButtonText: "No, I want to see the results",
                        confirmButtonColor: "#20b2aa",
                        // cancelButtonColor: "#f46a6a",
                        showCancelButton: true,
                        allowOutsideClick: false,
                    }).then((e) => {
                        isAlertAlready = true;
                        if (e.isConfirmed) {
                            window.location = window.location.href;
                        } else if(e.isDismissed){
                            window.location = '<?= base_url('client') ?>';
                        }
                    });
                }
                
                // drawDeletePolygonById(dataPoly.id_polygon);
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

    function dummy_polygon(){
        if (!map.getSource("maine")) {
            // Add a data source containing GeoJSON data.
            map.addSource('maine', {
                'type': 'geojson',
                'data': {
                    'type': 'Feature',
                    'geometry': {
                        'type': 'Polygon',
                        // These coordinates outline Maine.
                        'coordinates': [
                            [
                                [-67.13734, 45.13745],
                                [-66.96466, 44.8097],
                                [-68.03252, 44.3252],
                                [-69.06, 43.98],
                                [-70.11617, 43.68405],
                                [-70.64573, 43.09008],
                                [-70.75102, 43.08003],
                                [-70.79761, 43.21973],
                                [-70.98176, 43.36789],
                                [-70.94416, 43.46633],
                                [-71.08482, 45.30524],
                                [-70.66002, 45.46022],
                                [-70.30495, 45.91479],
                                [-70.00014, 46.69317],
                                [-69.23708, 47.44777],
                                [-68.90478, 47.18479],
                                [-68.2343, 47.35462],
                                [-67.79035, 47.06624],
                                [-67.79141, 45.70258],
                                [-67.13734, 45.13745]
                            ]
                        ]
                    }
                }
            });
            
            // Add a new layer to visualize the polygon.
            map.addLayer({
                'id': 'maine',
                'type': 'fill',
                'source': 'maine', // reference the data source
                'layout': {},
                'paint': {
                    'fill-color': '#0080ff', // blue color fill
                    'fill-opacity': 0.5
                }
            });
            // Add a black outline around the polygon.
            map.addLayer({
                'id': 'outline',
                'type': 'line',
                'source': 'maine',
                'layout': {},
                'paint': {
                    'line-color': '#0080ff',
                    'line-width': 2
                }
            });
        }
    }

    function styleDraw(){
        // return [
        //     // ACTIVE (being drawn)
        //     // line stroke
        //     {
        //         "id": "gl-draw-line",
        //         "type": "line",
        //         "filter": ["all", ["==", "$type", "LineString"], ["!=", "mode", "static"]],
        //         "layout": {
        //         "line-cap": "round",
        //         "line-join": "round"
        //         },
        //         "paint": {
        //             "line-color": "#D20C0C", // merah maroon
        //             // "line-color": "#0080ff", // blue
        //             "line-dasharray": [1.5, 5],
        //             "line-width": 3
        //         }
        //     },
        //     // polygon fill
        //     {
        //         "id": "gl-draw-polygon-fill",
        //         "type": "fill",
        //         "filter": ["all", ["==", "$type", "Polygon"], ["!=", "mode", "static"]],
        //         "paint": {
        //             "fill-color": "#0080ff",
        //             "fill-outline-color": "#0080ff",
        //             "fill-opacity": 0.4
        //         }
        //     },
        //     // polygon mid points
        //     {
        //         'id': 'gl-draw-polygon-midpoint',
        //         'type': 'circle',
        //         'filter': ['all',
        //             ['==', '$type', 'Point'],
        //             ['==', 'meta', 'midpoint']],
        //         'paint': {
        //             'circle-radius': 3,
        //             // 'circle-color': '#fbb03b',
        //             'circle-color': '#419efa',
        //         }
        //     },
        //     // polygon outline stroke
        //     // This doesn't style the first edge of the polygon, which uses the line stroke styling instead
        //     {
        //         "id": "gl-draw-polygon-stroke",
        //         "type": "line",
        //         "filter": ["all", ["==", "$type", "Polygon"], ["!=", "mode", "static"]],
        //         "layout": {
        //             "line-cap": "round",
        //             "line-join": "round"
        //         },
        //         "paint": {
        //             // "line-color": "#D20C0C", // maroon
        //             "line-color": "#0080ff", // blue
        //             "line-dasharray": [2, 5],
        //             "line-width": 3
        //         }
        //     },
        //     {
        //         "id": "gl-draw-polygon-stroke-normal",
        //         "type": "line",
        //         "filter": ["all", ["==", "$type", "Polygon"], ["==", "mode", "simple_select"]],
        //         "layout": {
        //             "line-cap": "round",
        //             "line-join": "round"
        //         },
        //         "paint": {
        //             // "line-color": "#D20C0C", // maroon
        //             "line-color": "#0080ff", // blue
        //             "line-width": 3
        //         }
        //     },
        //     // vertex point halos
        //     {
        //         "id": "gl-draw-polygon-and-line-vertex-halo-active",
        //         "type": "circle",
        //         "filter": ["all", ["==", "meta", "vertex"], ["==", "$type", "Point"], ["!=", "mode", "static"]],
        //         "paint": {
        //             "circle-radius": 5,
        //             "circle-color": "#FFF"
        //         }
        //     },
        //     // vertex points
        //     {
        //         "id": "gl-draw-polygon-and-line-vertex-active",
        //         "type": "circle",
        //         "filter": ["all", ["==", "meta", "vertex"], ["==", "$type", "Point"], ["!=", "mode", "static"]],
        //         "paint": {
        //             "circle-radius": 3,
        //             "circle-color": "#0080ff",
        //         }
        //     },
        // ]

        // return [
        //     // Set the line style for the user-input coordinates
        //     {
        //         'id': 'gl-draw-line',
        //         'type': 'line',
        //         'layout': {
        //             'line-cap': 'round',
        //             'line-join': 'round'
        //         },
        //         'paint': {
        //             'line-color': '#438EE4', // blue
        //             'line-dasharray': [0.2, 2],
        //             'line-width': 2,
        //             // custom disini
        //             // "line-color": "orange", // yellow
        //             // 'line-width': 3,
        //             // 'line-opacity': 0.7 // 0.7
        //         }
        //     },
        //     {
        //         'id': 'gl-draw-line-fill',
        //         "type": "fill",
        //         "layout": {},
        //         "paint": {
        //             "fill-color": "#fbb03b", // yellow
        //             "fill-opacity": 0.5
        //         }
        //     },
        //     // Style the vertex point halos
        //     {
        //         'id': 'gl-draw-polygon-and-line-vertex-halo-active',
        //         'type': 'circle',
        //         'paint': {
        //             'circle-radius': 2,
        //             'circle-color': '#FFF'
        //         }
        //     },
        //     // Style the vertex points
        //     {
        //         'id': 'gl-draw-polygon-and-line-vertex-active',
        //         'type': 'circle',
        //         'paint': {
        //             'circle-radius': 0,
        //             // 'circle-color': '#438EE4', // blue
        //             "circle-color": "#fbb03b", // yellow
        //         }
        //     }
        // ]

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

    function replaceSpaceWith_(inputString) {
        // Gunakan metode replace dengan ekspresi reguler untuk mengganti spasi dengan underscore
        return inputString.replace(/\s+/g, '_');
    }

    function modal_save_polygon(){
        var s_name = $("#source_name").val();
        var l_name = $("#layer_name").val();
        console.log("sourceName: ", s_name, " layerName: ", l_name);
    }

    function toggleModalPolygon(is_show = true){
        if (is_show) {
            // $("#btn_save_polygon").click();
            $(".modal_polygon_name").modal('show');
        } else {
            $(".modal_polygon_name").modal('hide');
        }
    }

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

    function style_map(e){
        console.clear();
        const style_id = e.id;
        // console.log("style_map: ", style_id, e);
        
        set_active_style(e);
        improveMapDelete();
        
        if (style_id == 'default') {
            map.setStyle(MAIN_STYLE);
            sessionStorage.setItem('mb_style', MAIN_STYLE);
        } else {
            map.setStyle(STYLE_MAPBOX + style_id);
            sessionStorage.setItem('mb_style', STYLE_MAPBOX + style_id);
        }
        
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
</script>