<div id='my_map'></div>
<style>
    #my_map { position: absolute; top: 0; bottom: 0; width: 100%; }
</style>

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
                                    <th class="p-0">Name</th>
                                    <td class="p-0 ps-2"><?= $value->name ?></td>
                                </tr>
                                <tr>
                                    <th class="p-0">Layer Name</th>
                                    <td class="p-0 ps-2"><?= $value->layer_name ?></td>
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

<!-- center modal -->
<button type="button" id="btn_polygon_name" class="btn btn-light btn-sm d-none waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".modal_polygon_name">
    <i class="bx bx-bookmark-plus font-size-22 align-middle"></i>
</button>

<div class="modal fade modal_polygon_name" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Polygon</h5>
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

<script>
    // const viewJapan = [140.34, 38.28]; // format lng, lat
    // const viewJapan = [106.82717644101359, -6.175421942384241]; // format lng, lat in monas
    const viewJapan = [-68.137343, 45.137451]; // starting position; 
    const TOKEN_MAP = '<?= token_mapbox ?>';
    const MAIN_STYLE = '<?= style_japan ?>';
    const STYLE_MAPBOX = 'mapbox://styles/mapbox/';
    const item_style = sessionStorage.getItem('mb_style');
    const get_style_map = (item_style == null || item_style == 'null' || item_style == '') ? MAIN_STYLE : item_style;
    
    let _my_device = get_device();
    var featureCollection = {
        "type": "FeatureCollection",
        // "crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:OGC:1.3:CRS84" } },
        "features": []
    }, 
    current_polygon_name = "",
    _list_all_polygon = {};
</script>

<script>    
    // ======================================
    // start load Map
    // ======================================
	mapboxgl.accessToken = TOKEN_MAP;
    const map = new mapboxgl.Map({
        container: 'my_map', // container ID
        // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
        style: 'mapbox://styles/mapbox/dark-v11', // style URL
        center: [-68.137343, 45.137451], // starting position
        zoom: 5, // starting zoom
        attributionControl: false
    });
    
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

    // tambahkan button ke UI mapbox
    // $("#btn_polygon_name").addClass("mapboxgl-ctrl m-0").appendTo(".mapboxgl-ctrl-bottom-right > .mapboxgl-ctrl.mapboxgl-ctrl-group").removeClass("btn btn-light btn-sm d-none");
    
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

    $btn_modal = $("#btn_polygon_name").removeClass("btn btn-light btn-sm d-none").addClass("mapboxgl-ctrl m-0");
    $(".mapboxgl-ctrl-bottom-right > .mapboxgl-ctrl.mapboxgl-ctrl-group:first-child").append($btn_modal);

    map.on('load', (e) => {
        console.log("map load: ", e);
        dummy_polygon();
        
        var improve_map = $(".mapboxgl-control-container > .mapboxgl-ctrl-bottom-right > .mapboxgl-ctrl-attrib > .mapboxgl-ctrl-attrib-inner").children(".mapbox-improve-map");
        console.log("improve map: ", improve_map);
        if (improve_map.length != 0) {
            improve_map.remove();
        }
    });

    map.on('draw.create', function(e) {
        var features = e.features[0];
        var geomet = features.geometry;
        var id_geojson = features.id;
        
        // Dapatkan propertis dari fitur (nama properties)
        var properties = features.properties;
        // var geocodingApiUrl = geocodingApi(features);
        
        // toggleModalPolygon(true); // show modal
        
        // Panggil fungsi untuk menampilkan sweetAlertInput
        showSweetInput().then((result) => {
            // Convert the drawn polygon to a string
            featureCollection.features.push(features);
            var source_name = "source_"+replaceSpaceWith_(result.s_name);
            var layer_name = "layer_"+replaceSpaceWith_(result.l_name);

            // Lakukan sesuatu dengan hasil akhir
            var dataPoly = {
                "id_polygon": id_geojson,
                "polygon_name": result.s_name,
                "source_name": source_name, 
                "layer_name": layer_name,
                "features":  JSON.stringify(features),
                "feature_collection": JSON.stringify(featureCollection),
            };
            console.log('Final result:', result);
            console.log('Final:', dataPoly);
            console.log("======================================");
            savePolygon(dataPoly);
        }).catch((error) => {
            // Tangani error (misalnya, jika pengguna membatalkan input)
            console.log('Error:', error);
        });
        
        // console.log("id_geojson: ", id_geojson);
        // console.log("features: ", features);
        // // console.log("geocodingApiUrl: ", geocodingApiUrl);
        // console.log("properties: ", properties);
        // console.log("featureCollection: ", featureCollection);
        // // console.log("geometry: ", geomet);
        // console.log("======================================");
    });

    // Fungsi untuk menampilkan sweetInput
    async function showSweetInput() {
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
                        confirmButtonColor: "#556ee6",
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
            confirmButtonColor: "#556ee6",
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
            //     confirmButtonColor: "#556ee6",
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

    function savePolygon(dataPoly = {}) {
        nama_polygon = dataPoly.polygon_name;
        // Send an AJAX request to the server to save the polygon
        // You can use any AJAX library or the native fetch API
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>map/savePolygon",
            data: dataPoly,
            // dataType: "application/json",
            success: function (data) {
                console.log('Polygon saved:', data);
                Swal.fire({
                    icon: 'success',
                    title: 'Polygon saved successfully!',
                    html: `Polygon name: ${nama_polygon}`,
                    confirmButtonColor: "#556ee6",
                });
                
                removePolygonById(dataPoly.id_polygon);
                createPolygon(dataPoly.source_name, JSON.parse(dataPoly.features), dataPoly.layer_name);
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
    
    function removeAllPolygon() {
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

    function removePolygonById(polygonId) {
        // Hapus poligon berdasarkan ID
        draw.delete(polygonId);
    }

    function createPolygon(source_name, data_source, id_layer){
        if(!map.getSource(source_name)){
            // jika sourcenya belum ada, buat source nya
            map.addSource(source_name, {
                type: 'geojson',//geojson,video,image,canvas
                data: data_source,// Feature data or FeatureCollection data
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
                    'line-width': 3
                }
            });
        }
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
            // $("#btn_polygon_name").click();
            $(".modal_polygon_name").modal('show');
        } else {
            $(".modal_polygon_name").modal('hide');
        }
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