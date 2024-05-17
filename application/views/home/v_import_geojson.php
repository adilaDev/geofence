<div class="main-content">
    <div class="page-content m-0 pb-0">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between pb-3 pt-2">
                        <h4 class="mb-sm-0 font-size-18"><?= !empty($this->lang->line('import_file')) ? $this->lang->line('import_file') : 'Import File'; ?></h4>
                        <div class="page-title-right d-none">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                                <li class="breadcrumb-item active">Import File</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <button type="button" onclick="window.location='<?=base_url('home')?>'" class="btn btn-outline-dark btn-sm waves-effect waves-light">
                            <i class="bx bx-arrow-back font-size-18 align-middle"></i> <?= !empty($this->lang->line('back')) ? $this->lang->line('back') : 'Backs'; ?>
                        </button>
                    </div>
                    <div class="card card-effect">
                        <div class="card-body">
                            
                            <div class="mb-3">
                                <input name="url_upload_file" id="url_upload_file" type="hidden" />
                                <input name="get_tmp_file" id="get_tmp_file" type="hidden" />
                                <input name="url_file_size" id="url_file_size" type="hidden" />
                                <input name="form_type" id="form_type" type="hidden" />

                                <div id="upload_file"></div>

                                <div id="errorFile" class="text-danger mt-1"></div>
                                <span class="text-danger"><?php echo validation_errors(); ?></span>
                            </div>

                            <div class="text-center">
                                <button type="button" id="btn-preview" onclick="previewFile()" class="btn btn-primary waves-effect waves-light me-2"><?= !empty($this->lang->line('preview')) ? $this->lang->line('preview') : 'Preview'; ?></button>
                                <button type="button" id="btn-save-file" onclick="saveFile()" class="btn btn-outline-primary d-none waves-effect waves-light me-2"><?= !empty($this->lang->line('save')) ? $this->lang->line('save') : 'Save'; ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- ./row -->

            <div id="row-preview" class="row">
                <div class="col-12">
                    <div class="card-title"><?= !empty($this->lang->line('preview')) ? $this->lang->line('preview') : 'Preview'; ?></div>
                    <div class="card card-effect">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8 col-12">
                                    <div class="table-responsive my-2">
                                        <div class="card-title text-muted"><?= !empty($this->lang->line('list_poly_info')) ? $this->lang->line('list_poly_info') : 'List of polygon information'; ?></div>
                                        <table id="preview-tbl" class="table table-sm table-bordered table-hover border border-dark w-100" style="border-collapse: collapse !important;">
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-12">
                                    <div id="map-preview" style="width: 100%; height: 500px;"></div>
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
                                    <div class="d-none mapboxgl-ctrl mapboxgl-ctrl-group" id="deleteFeature">
                                        <button type="submit" onclick="deleteAllFeature()" id="btnDeleteFeature" title="Delete all polygon" class="mapboxgl-gl-draw_ctrl-draw-btn waves-effect waves-light">
                                            <i class="fas fa-trash font-size-16 align-middle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="image-container"></div>

                            <div id="addInfo" class="d-none">
                                <hr>
                                <div class="card-title text-muted">List of polygon</div>
                            </div>
                            <div id="superDT" class="table-responsive mb-3"></div>
                        </div>
                    </div>
                </div>
            </div> <!-- ./row -->

        </div> <!-- ./container-fluid -->
    </div> <!-- ./page-content -->
</div> <!-- ./main-content -->

<!-- Plugins Loading -->
<link media="screen" rel="stylesheet" type="text/css" href="<?= base_url() ?>custom-loading/css/modal-loading.css" />
<script src="<?= base_url() ?>custom-loading/js/modal-loading.js"></script>

<!-- Sweet Alerts -->
<link href="<?=base_url()?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<script src="<?=base_url()?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

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
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap.min.css">
<script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap.min.js"></script> -->

<!-- Plugins dropzone -->
<link media="screen" rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/libs/dropzone/min/dropzone.min.css" />
<script src="<?= base_url() ?>assets/libs/dropzone/min/dropzone.min.js"></script>

<!-- Turf.js & D3.js -->
<script src="https://unpkg.com/@turf/turf@6/turf.min.js"></script>
<script src="https://d3js.org/d3.v7.min.js"></script>

<!-- required Mapbox -->
<link href="<?= base_url() ?>assets/libs/mapbox/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">
<script src="<?= base_url() ?>assets/libs/mapbox/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>

<!-- Load the `mapbox-gl-geocoder` plugin. -->
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css">
<script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-language/v1.0.0/mapbox-gl-language.js'></script>

<!-- Google Map Place API -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCuP573ebN6ZJTbs3IGcW2G-zgiBH4pp0Q&libraries=places&callback=initPlacesSearch"></script>

<script type="text/javascript">
    Dropzone.autoDiscover = false;
    let arr_url_file = [],
        str_url_file = "",
        str_file_size = "",
        uploadFile = null,
        loading = null,
		error_file = $("#errorFile")
        id_user = '<?= $id_user ?>';

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
    const allDataFc = <?= isset($list_all_geo) ? json_encode($list_all_geo) : '[]'?>;
    let getDataFc = [];
    let getFeatureCollection = {
        type: "FeatureCollection",
        features: [],
    };
    let current_id = "";
    let save_to_db = null;

    window.onload = () => {
        load_drag_file();
    }

    function custom_loading(isShow = false) {
        loading = new Loading({
            animationOriginColor: 'rgb(32 178 170)',
            defaultApply: true,
        });;

        if (!isShow) {
            loadingOut(loading);
        }

        return loading;
    }

    function loadingOut(getLoad, timeSec = 1000) {
        setTimeout(() => getLoad.out(), timeSec);
    }

	function load_drag_file(){
		// reset string & array
		arr_url_file = [];
		str_url_file = ""; str_file_size = ""; 

		$('#upload_file').empty();
		var html = `<div class="dropzone images">
						<div class="fallback">
							<input name="select_excel" type="file" multiple />
						</div>

						<div class="dz-message needsclick">
							<div class="mb-3">
                                <i class="fas fa-file-upload align-middle" style="font-size: 35px; opacity: 0.8;"></i>
							</div>

							<h4><?= !empty($this->lang->line('drop_file')) ? $this->lang->line('drop_file') : 'Drop files here or click to upload.'; ?></h4>
							<h6><?= !empty($this->lang->line('only_geojson')) ? $this->lang->line('only_geojson') : 'You can only upload files in <b>GeoJSON formats</b>'; ?></h6>
						</div>
					</div>`;
		$('#upload_file').append(html);
		
        uploadFile = new Dropzone(".dropzone.images", {
            url: "<?= base_url('home/upload_files') ?>",
            // maxFiles: 1, // only one file upload
            maxFilesize: 215, // 215MB
            method: "post",
            // acceptedFiles: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            // acceptedFiles: '.geojson,application/vnd.geo+json', // Only accept GeoJSON files
            paramName: "outputFiles",
            dictInvalidFileType: "This file type is not allowed",
            addRemoveLinks: true,
            // renameFile: function(file) {
            //     let user = "<?= $fullname ?>";
            //     let x = file.name.split(".");
            //     var extention = "." + x[x.length - 1];
			// 	var d = new Date();
			// 	// var dt = d.getFullYear()+''+(d.getMonth()+1)+''+d.getDate()+''+d.getHours()+''+d.getMinutes()+''+d.getSeconds()+''+d.getTime();
			// 	var dt = d.getFullYear()+''+(d.getMonth()+1)+''+d.getDate()+''+d.getHours()+''+d.getMinutes()+''+d.getSeconds();
            //     var rename = "GEO-" + user + dt + extention;
            //     return rename;
            // }
        });

		function uniqueStr(inputString){
			const inputArray = inputString.split(","); // ubah jadi array
			const uniqueArray = [...new Set(inputArray)]; // hapus duplikat
			const result = uniqueArray.join(","); // kembalikan ke string
			return result;
		}
        
        //Event ketika Memulai mengupload bisa gunakan on("sending") atau on("success")
        uploadFile.on("success", function(get_file, response, fromData) {
			var uniqueArray = [];

			// console.log(`${get_file.status} photo EN ${get_file.upload.filename}`);
			// console.log("get_file : ", get_file);
			// console.log("========================");

			var allFile = uploadFile.files;
			var result = response.result;
			console.log("status upload: ", get_file.status);
			console.log("status server: ", result.status);

			if(allFile.length == arr_url_file.length){
				// clearInterval(interUp);
				// jika ada duplikat karna salah satu foto gagal di upload
				// hapus duplikat
				arr_url_file = [...new Map(arr_url_file.map((m) => [m.filename, m])).values()];
				console.clear();
			} else {
                // if (result.status == undefined) {
                //     loading.out();
                // }
				if(!result.status) {
                    // loading.out();

                    // clearInterval(interUp);
					// Tampilkan pesan error
					var errorNode = document.createElement("span");
					errorNode.setAttribute('data-dz-errormessage', result.msg);
					errorNode.textContent = result.msg;
					$(get_file.previewElement).children('.dz-error-message').attr("style", "display: block; opacity: 1;").html(errorNode);
					console.log("imgError: ", result, "\nfile: ", get_file.upload.filename);
					console.log("response: ", response, "\nget_file: ", get_file);
					// console.log("previewElement: ", errorNode, $(get_file.previewElement).children('.dz-error-message'));
				
				} else {
                    get_file.name = result.nama;
                    get_file.upload.filename = result.nama;

					arr_url_file.push({
						token_foto: get_file.token,
						// path: 'upload/import/' + get_file.upload.filename,
						path: result.path,
						filename: get_file.upload.filename,
						str_photo_en: str_url_file,
						size_en: str_file_size,
						size: get_file.size,
						type: get_file.type,
						status_respond: result.status,
						status_upload: get_file.status
					});

					error_file.text(null);
					
					// hapus duplikat
					uniqueArray = [...new Map(arr_url_file.map((m) => [m.filename, m])).values()];

                    // loading.out();

					console.log("get_file : ", get_file);
					console.log("result_data : ", result.data);
					console.log("save images : ", arr_url_file, "\nuniqueArray: ", uniqueArray);
					// console.log("str images : ", str_url_file.split(","), "\nuniqueStr: ", unique_all_img.split(","));
					// console.log("str img size : ", str_file_size.split(","), "\nuniqueStr: ", unique_img_size.split(","));
					console.log("========================");

                    // // simpan thead & tbody
                    // var thead = result.set_column.thead;
                    // var tbody = result.set_column.tbody;

                    // $("#hide_thead").val(JSON.stringify(thead));
                    // $("#hide_tbody").val(JSON.stringify(tbody));

                    // var all_sheet = result.sheet_name;
                    // if (all_sheet.length > 0) {
                    //     var btn_sheet = '';
                    //     for (let i = 0; i < all_sheet.length; i++) {
                    //         const name = all_sheet[i];
                    //         btn_sheet += `<button type="button" class="btn btn-secondary waves-effect wave-light me-2 mb-2">${name}</button>`;
                    //     }
                        
                    //     $("#sheet_name").html(btn_sheet);
                    // }

                    // $("#result_import").html(result.html);
                    // load_datatable();
				} 
			}
			// reset url file
			const resultUrl = uniqueArray.map(item => '<?=base_url()?>'+item.path);
			str_url_file = resultUrl.join(",");
			// reset size file
			const resultSize = uniqueArray.map(item => item.size);
			str_file_size = resultSize.join(",");
			
			$("#url_upload_file").val(str_url_file);
			$("#url_file_size").val(str_file_size);
			$("#get_tmp_file").val(result.tmp_name);

			console.log("urlImg: ", str_url_file.split(","), "sizeImg: ", str_file_size.split(","));
			console.log("allFile: ", allFile.length, " url_img: ", arr_url_file.length, " unique: ", uniqueArray.length);
			console.log("========================");
			// var interUp = setInterval(() => {
			// }, 1500);
        });

        //Event ketika foto dihapus
        uploadFile.on("removedfile", function(a) {
            var token = a.token;
            var path = '<?=base_url('upload/import/')?>'+a.upload.filename;
            var data_post = {
                token: token,
                path_file: path,
                nama_foto: a.upload.filename
            };
            // console.log("removefile : ", a);
            // console.log("removefile data_post : ", data_post);
            // console.log("removefile token : ", token);

            $.ajax({
                type: "post",
                data: data_post,
                url: "<?= base_url('home/remove_files') ?>",
                cache: false,
                dataType: 'json',
                success: function(response) {
                    // console.log("status Foto : ", response.status);
                    // console.log("response foto : ", response);

                    $("#" + token).remove();
                    // hapus array
                    for (let i = 0; i < arr_url_file.length; i++) {
                        const el = arr_url_file[i];
                        if (el.filename == a.upload.filename) {
                            arr_url_file.splice(i, 1);
                        }
                    }
                    console.log("after remove : ", arr_url_file);
                    $("#form_type").val(null);
					reset_element();

                },
                error: function(e) {
                    $("#form_type").val(null);
                    console.log("Error : ", e);
                }
            });
        });

        function reset_element(){
            if ($.fn.DataTable.isDataTable('#dynamic_table')) {
                // Jika sudah ada, hapus tabel DataTable yang sudah ada
                $('#dynamic_table').DataTable().destroy();
                $('#superDT').empty();
            }
            // Cek apakah tabel DataTable sudah ada
            if ($.fn.DataTable.isDataTable('#preview-tbl')) {
                // Jika sudah ada, hapus tabel DataTable yang sudah ada
                $('#preview-tbl').DataTable().destroy();
                $('#preview-tbl').empty();
            }
            $("#result_import").html(null);
            $("#hide_thead").val(null);
            $("#hide_tbody").val(null);
            $("#sheet_name").html(null);
            $("#btnDeleteFeature").click();
            $("#btn-save-file").addClass("d-none");
            $("#row-preview").addClass("d-none");
            save_to_db = null;

            // reset string dan ubah value
            str_url_file = "";
            str_file_size = "";
			error_file.text(null);

            if (arr_url_file.length == 0) {
                $("#url_upload_file").val(null);
                $("#url_file_size").val(null);
            } else {
                for (let u = 0; u < arr_url_file.length; u++) {
                    const element = arr_url_file[u];
                    if (str_url_file == "") {
                        str_url_file = "<?= base_url() ?>upload/import/" + element.filename;
                        str_file_size = element.size;
                    } else {
                        str_url_file += ",<?= base_url() ?>upload/import/" + element.filename;
                        str_file_size += "," + element.size;
                    }

                    $("#url_upload_file").val(str_url_file);
                    $("#url_file_size").val(str_file_size);
                    console.log("change_file_en : ", str_url_file);
                    console.log("change_size_en : ", str_file_size);
                }
            }
        }

		$("#removeimage").on('click', () => {
			uploadFile.removeAllFiles();
			arr_url_file = []; // reset array
			reset_element();
			str_url_file = ""; str_file_size = ""; // reset string
			console.clear();
			// var allFile = uploadFile.files;
			// console.log("get all file: ", allFile);
		});
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

    function readGeoJSONFromURL(url) {
        return fetch(url).then(response => {
                if (!response.ok) {
                    throw new Error('Gagal memuat file.');
                }
                return response.json();
            }).then(data => {
                return data.features;
            });
        // return fetch(url)
        //     .then(response => {
        //         if (!response.ok) {
        //             throw new Error('Gagal memuat file.');
        //         }
        //         return response.json();
        //     })
        //     .then(data => {
        //         if (data.type === "FeatureCollection") {
        //             callback(null, data.features);
        //         } else {
        //             callback("File bukan GeoJSON FeatureCollection.", null);
        //         }
        //     })
        //     .catch(error => {
        //         callback(error.message, null);
        //     });
    }

    function saveFile(){
        if (save_to_db != null) {
            console.log("save_db: ", save_to_db);
            
            Swal.fire({
                icon: 'warning',
                title: '<?= !empty($this->lang->line('are_you_sure')) ? $this->lang->line('are_you_sure') : 'Are You Sure?'; ?>',
                confirmButtonText: "<?= !empty($this->lang->line('ok')) ? $this->lang->line('ok') : 'OK'; ?>",
                cancelButtonText: "<?= !empty($this->lang->line('cancel')) ? $this->lang->line('cancel') : 'Cancel'; ?>",
                confirmButtonColor: "#20b2aa",
                // cancelButtonColor: "#f46a6a",
                showCancelButton: true,
                allowOutsideClick: false,
            }).then((e) => {
                if (e.isConfirmed) {
                    var urlImport = "<?= base_url('map/savePolygon/') ?>";
                    callAjax(urlImport, 'post', JSON.stringify(save_to_db)).done((result) => {
                        Swal.fire({
                            icon: 'success',
                            title: '<?= !empty($this->lang->line('success_import_data')) ? $this->lang->line('success_import_data') : 'Successfully import data'; ?>',
                            confirmButtonColor: "#20b2aa",
                            showCancelButton: false
                        }).then(() => {
                            // window.location = window.location.href;
                            window.location = '<?= base_url('home') ?>';
                        });
                    }).fail((err) => {
                        
                        Swal.fire({
                            icon: 'error',
                            title: '<?= !empty($this->lang->line('failed_import_data')) ? $this->lang->line('failed_import_data') : 'Failed to import data'; ?>',
                            confirmButtonColor: "#20b2aa",
                            showCancelButton: false
                        });
                    });
                }
            });
            
        } else {
            
            Swal.fire({
                icon: 'info',
                title: '<?= !empty($this->lang->line('click_btn_preview')) ? $this->lang->line('click_btn_preview') : 'Please click button preview before click button save'; ?>',
                // confirmButtonText: "Yes, I want to create a new",
                // cancelButtonText: "No, I want to stay here",
                confirmButtonColor: "#20b2aa",
                // cancelButtonColor: "#f46a6a",
                showCancelButton: false,
                allowOutsideClick: false,
            });
        }
    }

    function previewFile(){
        console.clear();
        var url_file = $("#url_upload_file").val();
        var split_1 = url_file.split("/");
        var namafile = split_1[split_1.length-1].replace(".geojson", "");

        console.log("url_upload_file: ", url_file);
        console.log("split_1: ", split_1, " filename: ", namafile);
        if (url_file !== "") {
            // readGeoJSONFromURL(url_file, function(error, geoJSONFeatures) {
            //     if (error) {
            //         console.error("Error:", error);
            //     } else {
            //         getFeatureCollection = geoJSONFeatures;
            //         setCameraMap();
            //         addFeatureCollection(getFeatureCollection);
            //         console.log("GeoJSON Features:", geoJSONFeatures);
            //         // Lakukan sesuatu dengan geoJSONFeatures di sini
            //         var convertDT = geoJSONToDataTable(geoJSONFeatures);
            //         console.log("convertDT: ", convertDT);
            //         dynamicDataTable(convertDT);
                    
            //         var listArrayDT = changeObjectToArray(geoJSONFeatures[0].properties);
            //         // superDynamicDT(listArrayDT);
            //         generateDataForDB(geoJSONFeatures, namafile);
            //     }
            // });
            
            readGeoJSONFromURL(url_file)
            .then((geoJSONFeatures) => {
                $("#row-preview").removeClass("d-none");
                getFeatureCollection.features = geoJSONFeatures;
                console.log("GeoJSON Features:", geoJSONFeatures, "\ngetFeatureCollection: ", getFeatureCollection);
                // Lakukan sesuatu dengan geoJSONFeatures di sini
                var convertDT = geoJSONToDataTable(geoJSONFeatures);
                console.log("convertDT: ", convertDT);
                dynamicDataTable(convertDT);
                
                var listArrayDT = changeObjectToArray(geoJSONFeatures[0].properties);
                // superDynamicDT(listArrayDT);
                save_to_db = generateDataForDB(geoJSONFeatures, namafile);
                
                setCameraMap();
                addFeatureCollection(namafile, getFeatureCollection);
                $("#btn-save-file").removeClass("d-none");

            }).catch((error) => {
                console.error("Error:", error);
            });
            
            // Call the function to render GeoJSON image
            // renderGeoJSONImage(url_file);
        }
        console.log("call map: ", map);
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
        var type = filterPolygon[0].geometry.type;

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
        } else {
            // Render lin polygon
            svg.selectAll("path")
                .data(geoJSON.features)
                .enter()
                .append("path")
                .attr("d", path)
                .attr("fill", 'none')
            .style("stroke-width", "3px")
            .attr("stroke", "#0080ff");

        }

        // // Buat SVG container untuk gambar poligon
        // var svg = d3.select(containerId)
        //     .append("svg")
        //     .attr("width", width)
        //     .attr("height", height);

        // // Buat projeksi dan generator path untuk poligon
        // var projection = d3.geoMercator().fitSize([width, height], polygonCoordinates);
        // var path = d3.geoPath().projection(projection);

        // // Render poligon
        // svg.append("path")
        //     .datum({ type: "Polygon", coordinates: polygonCoordinates })
        //     .attr("d", path)
        //     .attr("fill", "steelblue")
        //     .attr("stroke", "black");

        // Anda juga dapat menyimpan gambar poligon dalam format lain, seperti base64, dan menampilkannya di tabel
    }

    // Function to load GeoJSON data and render polygon
    function renderGeoJSONImage(withFile = false, geoJSON = null, element = null) {
        // https://www.jafaraziz.com/blog/transform-geojson-to-png-with-d3-js/
        // https://www.w3.org/TR/SVG/shapes.html#InterfaceSVGCircleElement
        // https://d3-graph-gallery.com/graph/shape.html
        // https://observablehq.com/@harrylove/draw-a-circle-with-d3
        function renderPolygon(geoJSON, container){
            var width = 150;
            var height = 150;
            if (container == '#image-container') {
                // ubah lebar dan tinggi nya
                width = 500;
                height = 500;
                // dan kosongkan elementnya
                $(container).empty();
            }
            var colors = ["#63e6be", "#38d9a9", "#20c997", "#12b886"];

            console.log("geoJSON: ", geoJSON);
            // Create SVG container
            var svg = d3.select(container)
                        .append("svg")
                        .attr("width", width)
                        .attr("height", height);

            // Create projection and path generator
            var projection = d3.geoMercator().fitSize([width, height], geoJSON);
            var path = d3.geoPath().projection(projection);

            // Render polygon
            svg.selectAll("path")
                .data(geoJSON.features)
                .enter()
                .append("path")
                .attr("d", path)
                .attr("fill", function(d, i) {
                    return colors[i % 4];
                })
            .attr("stroke", "#000");
        }

        if (!withFile && geoJSON !== null && element !== null) {
            renderPolygon(geoJSON, element);
        } else {
            // var filename = '<?=base_url()?>upload/import/hildha_250324.geojson'; // Ganti dengan path sesuai lokasi file Anda
            // var filename = '<?=base_url()?>upload/files/2_DemoAccount/AM_Ha_Dong.geojson'; // Ganti dengan path sesuai lokasi file Anda
            // var filename = '<?=base_url()?>upload/files/2_DemoAccount/Aeon_Mall_JGC.geojson'; // Ganti dengan path sesuai lokasi file Anda
            d3.json(withFile).then(function(geoJSON) {
                renderPolygon(geoJSON, "#image-container");
            });
        }
    }

    // Call the function to render GeoJSON image
    // renderGeoJSONImage();
    

    function formatPropertyName(name) {
        return name.replace(/_/g, ' ').replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
    }
    
    function generateDataForDB(features, nama){
        var result = {"id": "", "data_table": [], "center_point": []};
        var listDt = [];
        var list_feature = {
            "type": "FeatureCollection",
            "features": features,
        }

        for (let i = 0; i < features.length; i++) {
            const ex = features[i];
            const id = ex.id;
            var center_point = getCenterPoint(ex);
            var data_table = changeObjectToArray(ex.properties);
            listDt.push({"id": id, "data_table":data_table, "center_point":center_point});
        }
        nama = nama.replace(".geojson", "");
        var dataPoly = {
            "id_user": id_user,
            "polygon_name": underscore(nama),
            "data": JSON.stringify(listDt),
            "feature_collection": JSON.stringify(list_feature),
            // "encode_data": (listDt),
            // "encode_feature_collection": (list_feature),
        };
        console.log("dataPoly: ", dataPoly);
        return dataPoly;
    }

    function getCenterPoint(features){
        var geomet = features.geometry;

        // Dapatkan koordinat pusat poligon
        var centerCoord = turf.centerOfMass(geomet).geometry.coordinates;
        // console.log("centerCoord: ", centerCoord);
        return centerCoord;
    }

    function isJapaneseText(str) {
        // Rentang Unicode untuk tulisan Jepang
        var japaneseRange = /[\u3040-\u30FF\u31F0-\u31FF\u4E00-\u9FFF\u3400-\u4DBF]/;
    
        // Mengecek apakah string mengandung karakter Jepang
        return japaneseRange.test(str);
    }

    function underscore(str){
        var result = decodeURIComponent(str).replace(/ /g, "_");
        return result;
        // if (isJapaneseText(str)) {
        //     // Melakukan encoding pada teks Jepang dan mengganti spasi dengan garis bawah (_)
        //     var result = decodeURIComponent(str).replace(/ /g, "_");
        //     return result;
        // } else {
        //     // Jika bukan tulisan Jepang, langsung ganti spasi dengan garis bawah (_)
        //     return str.replace(/ /g, "_");
        // }
    }

    function changeObjectToArray(obj) {
        return Object.entries(obj).map(([key, value], index) => {
            return {
                no: (index + 1).toString(), // Sesuaikan dengan cara Anda memberikan nomor
                key: key,
                value: value,
                action: '<button type="button" class="btn btn-outline-danger btn-sm delete" title="<?= !empty($this->lang->line('delete')) ? $this->lang->line('delete') : 'Delete'; ?>"><i class="fas fa-trash-alt"></i></button>'
            };
        });
    }
</script>

<!-- Khusus Mapbox -->
<script type="text/javascript">
    // Create a new marker.
    const marker = new mapboxgl.Marker({
        color: "#20b2aa",
        draggable: false
    });

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
    
    // ======================================
    // start load Map
    // ======================================
    mapboxgl.accessToken = TOKEN_MAP;
    const map = new mapboxgl.Map({
        container: 'map-preview', // container ID
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

    var $deleteFeature = $("#deleteFeature").removeClass("d-none").addClass("mapboxgl-gl-draw_ctrl-draw-btn");
    $(".mapboxgl-ctrl-bottom-right > .mapboxgl-ctrl-group:nth-child(3)").after($deleteFeature);

    const popup = new mapboxgl.Popup({anchor: 'left', closeOnClick: true, closeButton: true, maxWidth: '300px'});

    map.on('style.load', (e) => {
        $("#row-preview").addClass("d-none");
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
                info += '<li><strong>Polygon Id:</strong> ' + featureId + '</li>';
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
</script>

<script type="text/javascript">
    let tb_preview = $("#preview-tbl"),
    table = null,
    lang = '<?= $lang ?>';
    // https://datatables.net/reference/option/language
    // https://datatables.net/plug-ins/i18n/
    const url_cdn_en = '//cdn.datatables.net/plug-ins/2.0.1/i18n/en-GB.json';
    const url_cdn_ja = '//cdn.datatables.net/plug-ins/2.0.1/i18n/ja.json';
    const url_lang_en = '<?= base_url() ?>assets/lang/datatable/cdn/en-GB.json?v=<?= time() ?>';
    const url_lang_ja = '<?= base_url() ?>assets/lang/datatable/ja.json?v=<?= time() ?>';

    $(document).ready(function() {
        // createDataTable();
        $("#vertical-menu-btn").on("click", () => {
            fixBugDataTable();
        });
    });

    window.onresize = () => {
        console.log("onrize");
        fixBugDataTable();
        
        if(table != null && table.columns.adjust().columns().length != 0){
            table.columns.adjust().draw(); // perbaiki table head tidak responsive ketika tombol hide sidebar diklik
        }
    }

    function dynamicDataTable(dataArray){
        var optColResize = optionsColResize();
        // Cek apakah tabel DataTable sudah ada
        if ($.fn.DataTable.isDataTable('#preview-tbl')) {
            // Jika sudah ada, hapus tabel DataTable yang sudah ada
            $('#preview-tbl').DataTable().destroy();
        }

        table = tb_preview.DataTable({
            columns: dataArray.columns,
            data: dataArray.data,
            language: {
                url: (lang == 'en') ? url_lang_en : url_lang_ja,
            },
            scrollX: true,
            // scrollY: '62vh',
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
            // initComplete: function() {
            //     var tb = table;

            //     // Setelah inisialisasi tabel selesai, modifikasi sel-sel yang memerlukan perubahan
            //     tb.rows().every(function() {
            //         var rowData = this.data();
            //         var coordinates = JSON.parse(rowData.coordinates);

            //         console.log("tb: ", tb);
            //         console.log("rowData: ", rowData);
            //         renderPolygonToCanvas(coordinates, function(dataURL) {
            //             console.log("dataURL: ", dataURL);
            //             if (dataURL) {
            //                 var html = '<img src="' + dataURL + '" />';
            //                 tb.cell(this.index(), 1).data(html).draw();
            //             }
            //         });
            //     });
            // },
            // columnDefs: [
            //     { width: '1%', targets: 0 },
            //     { width: '20%', targets: 1 },
            //     { width: '15%', targets: 2 },
            //     { width: '15%', targets: 3 },
            //     { width: '70%', targets: 4 },
            // ],
            // colResize: optColResize
        });
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
        $("#addInfo").removeClass("d-none");
        $("#superDT").empty(); // kosongkan elemen apapun
        $("#superDT").append(table);

        let lang = '<?= $lang ?>';
        // https://datatables.net/reference/option/language
        // https://datatables.net/plug-ins/i18n/
        const url_cdn_en = '//cdn.datatables.net/plug-ins/2.0.1/i18n/en-GB.json';
        const url_cdn_ja = '//cdn.datatables.net/plug-ins/2.0.1/i18n/ja.json';
        const url_lang_en = '<?= base_url() ?>assets/lang/datatable/cdn/en-GB.json?v=<?= time() ?>';
        const url_lang_ja = '<?= base_url() ?>assets/lang/datatable/ja.json?v=<?= time() ?>';

        // Initialize DataTable
        tables = $(table).DataTable({
            language: {
                url: (lang == 'en') ? url_lang_en : url_lang_ja,
            },
            scrollX: true,
            scrollY: '56vh',
            // scrollY: '32vh',
            scrollCollapse: true,
            fixedHeader: true,
            responsive: true,
            columns: [
                { data: 'no', title: '<?= !empty($this->lang->line('no')) ? $this->lang->line('no') : 'No'; ?>' },
                { data: 'key', title: '<?= !empty($this->lang->line('title')) ? $this->lang->line('title') : 'Title'; ?>' },
                { data: 'value', title: '<?= !empty($this->lang->line('content')) ? $this->lang->line('content') : 'Content'; ?>'},
                {
                    data: 'action', width: '15%', title: "<?= !empty($this->lang->line('action')) ? $this->lang->line('action') : 'Action'; ?>",
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
        
        $('#dynamic_table').on('blur', 'tbody td[contenteditable=true]', function (e) {
            // console.log("focus after: ", ($(this).data('before') !== $(this).html()), $(this).data('before'));
            // if ($(this).data('before') !== $(this).html()) {
            // }
            var child =  $(this).parent().children();
            var newData = {
                'no': $(child[0]).text(),
                'key': underscore($(child[1]).text()),
                'value': $(child[2]).text(),
                'action': '<button type="button" class="btn btn-outline-danger btn-sm delete" title="<?= !empty($this->lang->line('delete')) ? $this->lang->line('delete') : 'Delete'; ?>"><i class="fas fa-trash-alt"></i></button>'
            };

            var rowIndex = $(this).closest('tr').index();
            var edit = tables.row($(this).closest('tr')).data(newData)
            .draw(false); // draw(false) => gambar ulang tabel dengan mempertahankan posisi paging saat ini
            // console.log("edit: ", "\nnewData: ",newData,"\nrowIndex: ", rowIndex);
        });
    
        $('#dynamic_table tbody').on('click', '.delete', function () {
            tables.row($(this).parents('tr')).remove().draw(false);
        });
    }

    function createDataTable(){
        var optColResize = optionsColResize();
        table = tb_preview.DataTable({
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
            // columnDefs: [
            //     { width: '1%', targets: 0 },
            //     { width: '20%', targets: 1 },
            //     { width: '15%', targets: 2 },
            //     { width: '15%', targets: 3 },
            //     { width: '70%', targets: 4 },
            // ],
            // colResize: optColResize
        });
    }
    
    function fixBugDataTable(){
        if(table != null && table.columns.adjust().columns().length != 0){
            table.columns.adjust().draw(); // perbaiki table head tidak responsive ketika tombol hide sidebar diklik
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