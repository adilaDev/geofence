<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content p-0"> <!-- kalo pake layout horizontal = p-0 kalo layout vertical px-0 -->
    <div id="my_map"></div> <!-- kalo pake layout horizontal = height: 490px; kalo layout vertical height: 466px; -->
        <div class="row">
            <div class="col-12">
                <!-- <a href='javascript:void(0);' id='export' class="btn btn-light btn-sm waves-effect waves-light"><i class="fas fa-file-export font-size-14 align-middle"></i></a>
                <a href="javascript:void(0);" id='updateDataset' class="btn btn-light btn-sm waves-effect waves-light"><i class="fa fa-database font-size-14 align-middle"></i></a>
                <div id="card-top-info" class="card card-effect d-none border border-3 border-secondary card-info-side w-100">
                    
                    <div class="row no-gutters align-items-center m-0 d-none">
                        <div class="col-2 px-0 ps-2">
                            <i id="icon_chain" class="bx bx-link bg-primary text-center text-white py-1 p-1 font-size-xxl align-middle rounded"></i>
                        </div>
                        <div class="col-10 px-4 px-lg-auto">
                            <div class="card-body px-0 py-2">
                                すべてのチェーン
                            </div>
                        </div>
                    </div>
                </div> -->

                <div class="btn-group dropstart mapboxgl-ctrl mapboxgl-ctrl-group d-none">
                    <button type="button" class="btn btn-light dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class='bx bx-layer font-size-18 align-middle'></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item item_style bg-secondary bg-soft" href="javascript:void(0);" id="default" onclick="style_map(this)">Streets</a>
                        <a class="dropdown-item item_style" href="javascript:void(0);" id="satellite-v9" onclick="style_map(this)">Satellite</a>
                        <a class="dropdown-item item_style" href="javascript:void(0);" id="dark-v10" onclick="style_map(this)">Dark</a>
                        <a class="dropdown-item item_style" href="javascript:void(0);" id="light-v10" onclick="style_map(this)">Light</a>
                    </div>
                </div>
            </div>
        </div> <!-- ./row -->
    </div>
    <!-- End Page-content -->
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel" style="visibility: hidden;" aria-hidden="true">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">List Drawing</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <?php foreach ($all_data as $key => $value) : ?>
            <div class="card card-effect" style="background-color: #f7f7f7;">
                <div class="card-body">
                    <div class="row row-cols-2">
                        <div class="col-7 pe-0 text-start">
                            <table class="table table-borderless m-0">
                                <tr>
                                    <th class="p-0">Title</th>
                                    <td class="p-0 ps-2"><?= $value->title ?></td>
                                </tr>
                                <tr>
                                    <th class="p-0">Name</th>
                                    <td class="p-0 ps-2"><?= $value->name ?></td>
                                </tr>
                                <tr>
                                    <th class="p-0">Date</th>
                                    <td class="p-0 ps-2"><?= date("Y-m-d H:i", strtotime($value->date_created)) ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-5 pe-0 text-end">
                            <a href="javascript:void(0)" class="btn btn-outline-primary btn-sm waves-effect waves-light me-1" title="Expand">
                                <i class="fas fa-expand-alt font-size-16 align-middle"></i>
                            </a>
                            <a href="<?= $value->link ?>" download="<?= $value->name ?>.geojson" class="btn btn-outline-info btn-sm waves-effect waves-light me-1" title="Download Geojson">
                                <i class="bx bx-download font-size-18 align-middle"></i>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm waves-effect waves-light me-1" title="Delete">
                                <i class="bx bx-trash font-size-18 align-middle"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    #my_map {
        position: absolute;
        /* margin-top: -1.4rem; */
        /* top: 55px; */
        top: 0;
        bottom: 0;
        width: 100%;
    }
    .mapboxgl-ctrl-top-right,
    .mapboxgl-ctrl-top-left{
        top: 20px !important;
    }
</style>

<!-- <link rel="stylesheet" href="<?= base_url() ?>assets/libs/mapbox/mapbox-gl-js/v2.14.1/mapbox-gl.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link media="print" rel="stylesheet" href="<?= base_url() ?>assets/libs/mapbox/mapbox-gl-js/v2.14.1/mapbox-gl.css"></noscript> -->
<link href="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.js"></script>

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

<script type="text/javascript">
    // const viewJapan = [140.34, 38.28]; // format lng, lat
    const viewJapan = [106.82717644101359, -6.175421942384241]; // format lng, lat in monas
    // const viewJapan = [-68.137343, 45.137451]; // starting position; 
    const TOKEN_MAP = '<?= token_mapbox ?>';
    const MAIN_STYLE = '<?= style_japan ?>';
    const STYLE_MAPBOX = 'mapbox://styles/mapbox/';
    const item_style = sessionStorage.getItem('mb_style');
    const get_style_map = (item_style == null || item_style == 'null' || item_style == '') ? MAIN_STYLE : item_style;
    
    let _my_device = get_device();
    let sc = null;
    
    function get_screen_type() {
        // Size of browser viewport.
        let win_W = $(window).width();
        let win_H = $(window).height();

        // Size of HTML document (same as pageHeight/pageWidth in screenshot).
        let doc_W = $(document).width();
        let doc_H = $(document).height();

        // For screen size
        let screen_W = window.screen.width;
        let screen_H = window.screen.height;
        // if (win_W > 1200) {
        //     $("#card-top-info").removeClass('w-auto').addClass('w-25');            
        // } else {
        //     $("#card-top-info").removeClass('w-25').addClass('w-auto');
        // }

        return {"win_width": win_W, "win_height": win_H, "doc_width": doc_W, "doc_height": doc_H, "screen_width": screen_W, "screen_height": screen_H}
	}

    function get_device() {
		let ua = navigator.userAgent.toLowerCase();
		if (ua.toLowerCase().indexOf("iphone") >= 0)  { return "iphone";  }
		if (ua.toLowerCase().indexOf("ipod") >= 0)    { return "iphone";  }
		if (ua.toLowerCase().indexOf("ipad") >= 0)    { return "iphone";  }
		if (ua.toLowerCase().indexOf("android") >= 0) { return "android"; }
		return "pc";
	}
    
    function change_map_layout(){
        sc = get_screen_type();
        setTimeout(() => {
            var w = (sc.screen_width == undefined) ? sc.win_width : sc.screen_width;
            // console.clear();
            // console.log("screen: ", sc, "\nw:", w);
            if ($("body").attr('class') == 'vertical-collpsed') {
                // $("#my_map").attr("style", `margin-top: -1.4rem; position: relative; width: 100%; height: ${w*2}px;`);                
                $("#my_map").attr("style", `margin-top: -1.4rem; position: relative; width: 100%; height: ${sc.win_height}px;`);
            } else {
                $("#my_map").attr("style", `margin-top: -1.4rem; position: relative; width: 100%; height: ${sc.win_height}px;`);
            }
            map.resize();
        }, 1);
    }
</script>

<script type="text/javascript">
    var featureCollection = {
        "type": "FeatureCollection",
        // "crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:OGC:1.3:CRS84" } },
        "features": []
    }, 
    current_polygon_name = "",
    _list_all_polygon = {};

    mapboxgl.accessToken = TOKEN_MAP;
    const map = new mapboxgl.Map({
        container: 'my_map', // container ID
        style: get_style_map,
        center: viewJapan,
        // minZoom: 2,
        // zoom: 5,
        zoom: 10,
        attributionControl: false,
        // pitchWithRotate: false,
        // dragRotate: false,
    });
    
    sc = get_screen_type();

    // const language = new MapboxLanguage({defaultLanguage: 'ja'});
    // map.addControl(language);
    map.addControl(new mapboxgl.AttributionControl({
        customAttribution: `© <?= NAMA_WEB ?>. Design & Developed by <a href="https://asiaresearchinstitute.com/" target="_blank" rel="noopener noreferrer"><img src="<?= base_url() ?>assets/images/LOGO_ARI/logo_ari_green.svg" alt="" width="auto" height="13"></a>`
    }));
    map.addControl(
        new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            mapboxgl: mapboxgl,
            // language: 'ja',
            // placeholder: '住所検索',
        }),
    'bottom-left');
    
    // $("#card-top-info").addClass("mapboxgl-ctrl").appendTo(".mapboxgl-ctrl-bottom-left");
    // $("#export").addClass("mapboxgl-ctrl").appendTo(".mapboxgl-ctrl-bottom-left");
    // $("#updateDataset").addClass("mapboxgl-ctrl").appendTo(".mapboxgl-ctrl-bottom-left");

    var draw = new MapboxDraw({
        displayControlsDefault: false,
        controls: {
            line_string: true,
            polygon: true,
            point: false,
            trash: true
        }
    });
    map.addControl(draw,'bottom-right');
    map.addControl(new mapboxgl.NavigationControl(),'bottom-right');
    map.addControl(new mapboxgl.FullscreenControl(),'bottom-right');
    // $drop = $(".dropstart").removeClass("d-none");
    // $(".mapboxgl-ctrl-bottom-right").prepend($drop);
    // $("#my_map").attr("style", `margin-top: -1.4rem; position: relative; width: 100%; height: ${sc.win_height}px;`);


    // window.addEventListener('resize', change_map_layout, true);
    $("#vertical-menu-btn").on("click", change_map_layout);
    
    // var improve_map = $(".mapboxgl-control-container > .mapboxgl-ctrl-bottom-right > .mapboxgl-ctrl-attrib > .mapboxgl-ctrl-attrib-inner").children(".mapbox-improve-map");
    // console.log("improve map: ", improve_map);
    // if (improve_map.length != 0) {
    //     improve_map.remove();
    // }

    map.on('load', () => {
        setTimeout(() => {
            map.resize();
        }, 10);
        // var improve_map = $(".mapbox-improve-map");

        // var inter_improve = setInterval(() => {
        //     if (improve_map.length != 0) {
        //         improve_map.addClass('d-none');
        //         clearInterval(inter_improve);
        //     }
        //     console.log("mapbox-improve-map: ", improve_map.length);
        // }, 500);
        // console.log("mapbox-improve-map: ", improve_map.length);
        
        console.log("attr: ", new mapboxgl.AttributionControl());

        Swal.mixin({
            input: 'text',
            confirmButtonText: 'Next &rarr;',
            showCancelButton: true,
            confirmButtonColor: "#556ee6",
            cancelButtonColor: "#74788d",
            progressSteps: ['1', '2']
        }).queue([
            {
                title: 'Question 1',
                text: 'Please input source name'
            },
            {
                title: 'Question 2',
                text: 'Please input layer name'
            },
        ]).then( function (result) {
            if (result.value) {
                Swal.fire({
                title: 'All done!',
                html:
                    'Your answers: <pre><code>' +
                    JSON.stringify(result.value) +
                    '</code></pre>',
                confirmButtonText: 'Lovely!',
                confirmButtonColor: "#556ee6",
                })
            }
        })
    });
    
    // map.on('moveend', get_moveend_flag);

    map.on('draw.create', function(e) {
        var features = e.features[0];
        var geomet = features.geometry;
        var id_geojson = features.id;
        
        // Dapatkan propertis dari fitur (nama properties)
        var properties = features.properties;
        var geocodingApiUrl = geocodingApi(features);

        console.log("id_geojson: ", id_geojson);
        // console.log("features: ", features);
        console.log("geocodingApiUrl: ", geocodingApiUrl);
        console.log("properties: ", properties);
        console.log("featureCollection: ", featureCollection);
        // console.log("geometry: ", geomet);

    });

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

            Swal.fire({
                title: 'Masukan nama untuk menyimpan polygon',
                input: 'text',
                showCancelButton: true,
                confirmButtonText: 'Submit',
                // showLoaderOnConfirm: true,
                confirmButtonColor: "#556ee6",
                cancelButtonColor: "#f46a6a",
                allowOutsideClick: false
            }).then(function (result) {
                if (result.isConfirmed) {
                    if (current_polygon_name != "" && current_polygon_name != result.value) {
                        // jika tidak sama
                        featureCollection.features = [features];
                        geojsonString = JSON.stringify(featureCollection);
                        console.log("reset featureCollection");
                    }
                    current_polygon_name = result.value;
                    // Send the data to the server for saving
                    savePolygon(features.id, result.value, JSON.stringify(features), geojsonString);
                }
                // console.log("result: ", result);
            })

            // Swal.mixin({
            //     input: 'text',
            //     confirmButtonText: 'Next &rarr;',
            //     showCancelButton: true,
            //     confirmButtonColor: "#556ee6",
            //     cancelButtonColor: "#74788d",
            //     progressSteps: ['1', '2']
            // }).queue([
            //     {
            //         title: 'Question 1',
            //         text: 'Masukan nama file'
            //     },
            //     {
            //         title: 'Question 2',
            //         text: 'Masukan nama polygon'
            //     },
            // ]).then( function (result) {
            //     if (result.value) {
            //         Swal.fire({
            //         title: 'All done!',
            //         html:
            //             'Your answers: <pre><code>' +
            //             JSON.stringify(result.value) +
            //             '</code></pre>',
            //         confirmButtonText: 'Lovely!',
            //         confirmButtonColor: "#556ee6",
            //         })
            //     }
            // })
        })
        .catch((error) => {
            console.error('Error:', error)
        });
    }

    function savePolygon(id_polygon, nama_polygon, features, feature_collection) {
        // Send an AJAX request to the server to save the polygon
        // You can use any AJAX library or the native fetch API
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>home/savePolygon",
            data: {"id_polygon": id_polygon, "polygon_name": nama_polygon, "feature_collection": feature_collection, "features":  features},
            // dataType: "application/json",
            success: function (data) {
                console.log('Polygon saved:', data);
                Swal.fire({
                    icon: 'success',
                    title: 'Polygon saved successfully!',
                    html: `Polygon name: ${nama_polygon}`,
                    confirmButtonColor: "#556ee6",
                });
            }, 
            error: function (error, status){
                console.error('Error saving polygon:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error saving polygon!',
                    confirmButtonColor: "#556ee6",
                });
            }
        });
        
        if (current_polygon_name != "" && current_polygon_name != nama_polygon) {
            // jika tidak sama
            featureCollection.features = []; // reset variable
            console.log("reset featureCollection");
        }
    }
    
    function savePolygonOld(id_polygon, nama_polygon, source_name, layer_name, features, feature_collection) {
        // Send an AJAX request to the server to save the polygon
        // You can use any AJAX library or the native fetch API
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>map/savePolygon",
            data: {
                "id_polygon": id_polygon,
                "polygon_name": nama_polygon,
                "source_name": source_name,
                "layer_name": layer_name,
                "feature_collection": feature_collection,
                "features":  features
            },
            // dataType: "application/json",
            success: function (data) {
                console.log('Polygon saved:', data);
                Swal.fire({
                    icon: 'success',
                    title: 'Polygon saved successfully!',
                    html: `Polygon name: ${nama_polygon}`,
                    confirmButtonColor: "#556ee6",
                });
            }, 
            error: function (error, status){
                console.error('Error saving polygon:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error saving polygon!',
                    confirmButtonColor: "#556ee6",
                });
            }
        });
        
        if (current_polygon_name != "" && current_polygon_name != nama_polygon) {
            // jika tidak sama
            featureCollection.features = []; // reset variable
            console.log("reset featureCollection");
        }
    }

    function createPolygon(source_name, data_source, id_layer){
        if(!map.getSource(source_name)){
            // jika sourcenya belum ada, buat source nya
            map.addSource(source_name, {
                type: 'geojson',//geojson,video,image,canvas
                data: data,// Feature data or FeatureCollection data
            });

            // Tambahkan layer baru untuk memvisualisasikan poligon.
            map.addLayer({
                'id': id_layer+'_fill',
                'type': 'fill',
                'source': source_name,
                'layout': {},
                'paint': {
                    'fill-color': '#0080ff', // blue color fill
                    'fill-opacity': 0.5
                }
            });
            // Tambahkan garis luar di sekitar poligon.
            map.addLayer({
                'id': id_layer+'outline',
                'type': 'line',
                'source': source_name,
                'layout': {},
                'paint': {
                    'line-color': '#0080ff',
                    'line-width': 2
                }
            });
        }
    }

    function getPolygon(id_feature){
        
    }

    function style_map(e){
        console.clear();
        const style_id = e.id;
        // console.log("style_map: ", style_id, e);

        set_active_style(e);
        
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

        if (is_mapbox == 'mapbox') {
            // style from mapbox
            get_id = $("#"+sp_style[sp_style.length-1]);
        } else {
            // default
            get_id = $("#default");
        }
        set_active_style(get_id[0]);
    }
    load_style();
</script>

<!-- Mapbox Draw with radius -->
<!-- <script>
    
    mapboxgl.accessToken = TOKEN_MAP;
    const map = new mapboxgl.Map({
        container: 'my_map', // container ID
        style: get_style_map,
        center: viewJapan,
        // minZoom: 2,
        zoom: 4,
        attributionControl: false,
        // pitchWithRotate: false,
        // dragRotate: false,
    });
    
    // ============= DRAW MAP ===============
    var lineDistance = turf.length;
    var idCircleMode = null,
        idCircleModeArr = [];
    var LotsOfPointsMode = MapboxDraw.modes.draw_line_string;

    var draw = new MapboxDraw({
        displayControlsDefault: false,
        //defaultMode: 'lots_of_points',
        // Adds the LotsOfPointsMode to the built-in set of modes
        modes: Object.assign({
            circle_mode: LotsOfPointsMode
        }, MapboxDraw.modes),

        controls: {
            circle_mode: true,
            line_string: true,
            polygon: true,
            trash: true
        },
        // sumber : https://codepen.io/Fadil-developer/pen/JjMxbKz?editors=1010
        styles: [
            // Set the line style for the user-input coordinates
            {
                'id': 'gl-draw-line',
                'type': 'line',
                'layout': {
                    'line-cap': 'round',
                    'line-join': 'round'
                },
                'paint': {
                    // 'line-color': '#438EE4', // blue
                    // 'line-dasharray': [0.2, 2],
                    // 'line-width': 2,
                    // custom disini
                    "line-color": "orange", // yellow
                    'line-width': 3,
                    'line-opacity': 0.7 // 0.7
                }
            },
            {
                'id': 'gl-draw-line-fill',
                "type": "fill",
                "layout": {},
                "paint": {
                    "fill-color": "#fbb03b", // yellow
                    "fill-opacity": 0.3
                }
            },
            // Style the vertex point halos
            // {
            //     'id': 'gl-draw-polygon-and-line-vertex-halo-active',
            //     'type': 'circle',
            //     'paint': {
            //         'circle-radius': 2,
            //         'circle-color': '#FFF'
            //     }
            // },
            // Style the vertex points
            {
                'id': 'gl-draw-polygon-and-line-vertex-active',
                'type': 'circle',
                'paint': {
                    'circle-radius': 0,
                    // 'circle-color': '#438EE4', // blue
                    "circle-color": "#fbb03b", // yellow
                }
            }
        ]
    });
    map.addControl(draw, 'bottom-right');
    
    LotsOfPointsMode.clickAnywhere = function(state, e) {
        // this ends the drawing after the user creates a second point, triggering this.onStop
        // console.log('LotsOfPointsMode.clickAnywhere : ', state);
        if (state.currentVertexPosition === 1) {
            state.line.addCoordinate(0, e.lngLat.lng, e.lngLat.lat);
            return this.changeMode('simple_select', {
                featureIds: [state.line.id]
            });
        }
        this.updateUIClasses({
            mouse: 'add'
        });
        state.line.updateCoordinate(state.currentVertexPosition, e.lngLat.lng, e.lngLat.lat);
        if (state.direction === 'forward') {
            state.currentVertexPosition += 1; // eslint-disable-line
            state.line.updateCoordinate(state.currentVertexPosition, e.lngLat.lng, e.lngLat.lat);
        } else {
            state.line.addCoordinate(0, e.lngLat.lng, e.lngLat.lat);
        }

        // Display a popup with radius km
        if ($(".mapbox-gl-draw_ctrl-draw-btn.mapbox-gl-draw_line").hasClass('active')) {

            $(".mapboxgl-popup-anchor-left .mapboxgl-popup-content").addClass("p-2");
            popupCircle
                // .setLngLat(center)
                .setLngLat([e.lngLat.lng, e.lngLat.lat])
                .setHTML("<strong class='font-size-14'>Radius : " + parseInt(getRadius) + " km</h>")
                .addTo(map);
        } else {
            popupCircle.remove();
        }

        // custom fitur khusus radius mode
        removeAllRadiusMode();

        return null;
    };

    LotsOfPointsMode.onStop = function(state) {
        doubleClickZoom.enable(this);
        this.activateUIButton();

        // check to see if we've deleted this feature
        if (this.getFeature(state.line.id) === undefined) return;
        // //remove last added coordinate
        state.line.removeCoordinate(`${state.currentVertexPosition}`);

        // remove last added coordinate
        // state.line.removeCoordinate('0');

        idCircleMode = (state.circle.id != undefined) ? state.circle.id : null;

        idCircleModeArr.push(idCircleMode);

        var template_circle = {
            features: [state.circle],
            type: "Feature"
        }

        // console.log("============= Radius onStop =============");
        // console.log("idCircleModeArr : ", idCircleModeArr);
        // console.log('STATE', state);
        // console.log("template_circle : ", template_circle);
        // console.log("==========================");

        getFilterFromCircleMode(template_circle); // data yg di dapatkan bisa di luar radius
        // getFilterInsideCircleMode(template_circle); // dapatkan hanya di dalam radius
        popupCircle.remove();
        getRadius = 0;

    };

    LotsOfPointsMode.toDisplayFeatures = function(state, geojson, display) {
        display(geojson);

        const isActiveLine = geojson.properties.id === state.line.id;
        geojson.properties.active = (isActiveLine) ? true : false;
        if (!isActiveLine) return display(geojson);

        // Only render the line if it has at least one real coordinate
        if (geojson.geometry.coordinates.length < 2) return null;
        geojson.properties.meta = 'feature';


        const center = geojson.geometry.coordinates[0];
        const radiusInKm = lineDistance(geojson, {
            units: 'kilometers'
        });
        const circleFeature = createGeoJSONCircle(center, radiusInKm, state.line.id);
        circleFeature.properties.meta = 'radius';
        circleFeature.id = state.line.id
        display(circleFeature);

        getRadius = radiusInKm;
        var str_radius_km = parseInt(radiusInKm) + " km";

        map.on('mousemove', (e) => {
            if (popupCircle.isOpen()) {
                popupCircle.setLngLat([e.lngLat.lng, e.lngLat.lat]);
                popupCircle.setHTML("<strong class='font-size-14'>Radius : " + str_radius_km + "</h>")
                popupCircle.addTo(map)
            } else {
                popupCircle.remove();
            }
        });

        map.on('mouseleave', (e) => {
            popupCircle.remove();
        });

        $("#idRadius").text(str_radius_km);

        var exampleTriggerEl = $('#idRadius').attr("title", str_radius_km);
        $("#idRadius").attr("data-bs-original-title", str_radius_km);

        state.circle = circleFeature;
    };

    function createGeoJSONCircle(center, radiusInKm, parentId, points = 64) {

        const coords = {
            latitude: center[1],
            longitude: center[0],
        };

        const km = radiusInKm;

        const ret = [];
        const distanceX = km / (111.320 * Math.cos((coords.latitude * Math.PI) / 180));
        const distanceY = km / 110.574;

        let theta;
        let x;
        let y;
        for (let i = 0; i < points; i += 1) {
            theta = (i / points) * (2 * Math.PI);
            x = distanceX * Math.cos(theta);
            y = distanceY * Math.sin(theta);

            ret.push([coords.longitude + x, coords.latitude + y]);
        }
        ret.push(ret[0]);

        return {
            type: 'Feature',
            geometry: {
                type: 'Polygon',
                coordinates: [ret],
            },
            properties: {
                parent: parentId,
                active: 'true'
            },
        };
    }
</script> -->