<?php 
    function ubahTanggal_v1($tanggal) {
        $tanggalHariIni = strtotime(date("Y-m-d"));
        $tanggalInput = strtotime($tanggal);

        // Cek apakah tanggal sama dengan hari ini
        if ($tanggalInput == $tanggalHariIni) {
            return "Today";
        }

        // Cek apakah tanggal sama dengan hari kemarin
        $tanggalKemarin = strtotime("-1 day", $tanggalHariIni);
        if ($tanggalInput == $tanggalKemarin) {
            return "Yesterday";
        }

        // Cek apakah tanggal dalam 2 jam terakhir
        $sekarang = time();
        if ($sekarang - $tanggalInput < 7200) { // 7200 detik = 2 jam
            return "2 hours ago";
        }

        // Jika tidak ada yang cocok, kembalikan tanggal asli
        return $tanggal;
    }

    function ubahTanggal($tanggal) {
        $sekarang = time(); // Waktu saat ini dalam timestamp
        $tanggalInput = strtotime($tanggal); // Konversi tanggal masukan ke timestamp

        // Hitung selisih waktu dalam detik
        $selisihDetik = $sekarang - $tanggalInput;

        // Hitung selisih dalam jam
        $selisihJam = floor($selisihDetik / 3600);

        // Hitung selisih dalam menit
        $selisihMenit = floor(($selisihDetik % 3600) / 60);

        // Jika selisih kurang dari 24 jam dan positif (artinya tanggal masukan adalah hari ini atau kemarin)
        if ($selisihJam >= 0 && $selisihJam <= 24) {
            if ($selisihJam == 0) {
                if ($selisihMenit == 0) {
                    return "Just now";
                } else {
                    return $selisihMenit . " minutes ago";
                }
            } elseif ($selisihJam == 24) {
                return "Yesterday ";
            } else {
                return $selisihJam . " hours ago";
            }
        } else {
            if ($selisihJam == 0) {
                return "Today";
            } elseif ($selisihJam == 8) {
                return "Yesterday";
            } else {
                return $tanggal; // Jika lebih dari 24 jam, kembalikan tanggal asli
            }
        }
    }
?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card card-effect">
                        <div class="card-body">
                            <div class="card-title mb-4"><?= !empty($this->lang->line('my_account')) ? $this->lang->line('my_account') : 'Profile'; ?></div>
                            
                            <?php if($get_user->token != "Already verified") : ?>
                                <div class="alert alert-warning d-none" role="alert">
                                    Please check the email we sent <b><?= $get_user->email ?></b> to verify your account
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <?= $this->session->flashdata('msg_profile'); ?>

                            <form action="<?=base_url('profile/edit')?>" method="post">
                                <div class="row">
                                    <?php $name = ''; $foto = $get_user->profile_picture; 
                                    if (empty($get_user->last_name)) {
                                        $name = empty($get_user->first_name) ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $get_user->first_name[0];
                                    } else {
                                        // $name = $first_name[0] . $last_name[0];
                                        $name = (empty($get_user->first_name) && empty($get_user->last_name)) ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $get_user->first_name[0] . $get_user->last_name[0];
                                    }
                                    ?>
                                    <?php if ($foto == null || empty($foto)) : ?>
                                        <div class="original_photo col-2 col-lg-1 pe-0 my-4 text-center">
                                            <!-- Jika tidak ada foto yg diupload user -->
                                            <b class="header-profile-user rounded bg-transparent border border-primary border-2 text-primary bg-primary bg-soft p-3 font-size-20 custom-avatar"><?= $name ?></b>
                                        </div>
                                    <?php elseif(strpos($foto, 'http://') !== false || strpos($foto, 'https://') !== false) : ?>
                                        <div class="original_photo col-2 mb-3 text-center">
                                            <!-- Jika ada foto yg di ambil dari google account -->
                                            <img loading="lazy" class="rounded img-fluid" src="<?= $foto ?>" alt="<?= $name ?>">
                                        </div>
                                    <?php else : ?>
                                        <div class="original_photo col-2 mb-3 text-center">
                                            <!-- Jika ada foto yg di upload user -->
                                            <img loading="lazy" class="rounded img-fluid" src="<?= base_url() . $foto ?>" alt="<?= $name ?>">
                                        </div>
                                    <?php endif; ?>

                                    <div class="change_photo d-none col-2 mb-3 text-center">
                                        <img id="new_img" src="" alt="New Photo" class="rounded img-fluid" loading="lazy">
                                        <input type="hidden" name="url_upload_image" id="url_upload_image">
                                        <input type="hidden" name="url_image_size" id="url_image_size">
                                    </div>

                                    <div class="col-10 mb-3">
                                        <div style="font-weight: 600;"><?= $get_user->first_name.' '.$get_user->last_name ?></div>
                                        <div style="font-weight: 600;"><?= !empty($this->lang->line('last_login')) ? $this->lang->line('last_login') : 'Last login'; ?> <?= ubahTanggal($get_user->last_login) ?></div>
                                        <!-- <div style="font-weight: 600;">Last login <?= ubahTanggal('2023-09-22 11:10:33') ?></div> -->
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#modalUploadImage" class="btn btn-primary btn-sm waves-effect waves-light mt-1"><?= !empty($this->lang->line('change_photo')) ? $this->lang->line('change_photo') : 'Change Photo'; ?></button>
                                    </div>

                                    <div class="col-6 mb-3">
                                        <label for="first_name" class="form-label"><?= !empty($this->lang->line('first_name')) ? $this->lang->line('first_name') : 'First Name'; ?></label>
                                        <input type="text" class="form-control" disabled value="<?= $get_user->first_name ?>">
                                        <input type="hidden" class="form-control" name="first_name" id="first_name" value="<?= $get_user->first_name ?>">
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="last_name" class="form-label"><?= !empty($this->lang->line('last_name')) ? $this->lang->line('last_name') : 'Last Name'; ?></label>
                                        <input type="text" class="form-control" disabled value="<?= $get_user->last_name ?>">
                                        <input type="hidden" class="form-control" name="last_name" id="last_name" value="<?= $get_user->last_name ?>">
                                    </div>

                                    <div class="col-6 mb-3">
                                        <label for="username" class="form-label"><?= !empty($this->lang->line('username')) ? $this->lang->line('username') : 'Username'; ?></label>
                                        <input type="text" class="form-control" name="username" id="username" value="<?= $get_user->username ?>" disabled style="cursor: no-drop;">
                                    </div>

                                    <div class="col-6 mb-3">
                                        <label for="email" class="form-label"><?= !empty($this->lang->line('email')) ? $this->lang->line('email') : 'Email'; ?></label>
                                        <input type="email" class="form-control" name="email" id="email" value="<?= $get_user->email ?>" disabled style="cursor: no-drop;">
                                    </div>

                                    <div class="col-6 mb-3">
                                        <label for="company" class="form-label"><?= !empty($this->lang->line('company')) ? $this->lang->line('company') : 'Company'; ?></label>
                                        <input type="text" class="form-control" name="company" id="company" value="<?= $get_user->company ?>">
                                    </div>

                                    <div class="col-6 mb-3">
                                        <label for="address" class="form-label"><?= !empty($this->lang->line('address')) ? $this->lang->line('address') : 'Address'; ?></label>
                                        <input type="text" class="form-control" name="address" id="address" value="<?= $get_user->address ?>">
                                    </div>

                                    <div class="text-center mb-3">
                                        <button type="submit" class="btn btn-primary w-lg waves-effect waves-light"><?= !empty($this->lang->line('save_change')) ? $this->lang->line('save_change') : 'Save Change'; ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- Modal Upload Image -->
<div class="modal fade" id="modalUploadImage" tabindex="-1" data-bs-backdrop="static" aria-labelledby="modalUploadImageTitle" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalUploadImageTitle">Change Photo</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="mb-0">
					<div id="upload_image"></div>

					<div id="errorImages" class="text-danger mt-1"></div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary waves-effect waves-light" data-bs-dismiss="modal" aria-label="Close">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<!-- Sweet Alert-->
<link media="screen" type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css"/>
<script async type="text/javascript" src="<?= base_url() ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

<!-- Plugins dropzone -->
<link media="screen" rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/libs/dropzone/min/dropzone.min.css" />
<script src="<?= base_url() ?>assets/libs/dropzone/min/dropzone.min.js"></script>

<script type="text/javascript">
    Dropzone.autoDiscover = false;
    let arr_url_img = [],
        str_url_image = "",
        str_image_size = "",
        username = $("#username").val(),
        uploadFile = null,
		newImg = $("#new_img"),
		originalPhoto = $(".original_photo"),
		error_upload = $("#errorUpload"),
		error_images = $("#errorImages");

    window.onload = () => {
        load_drag_image();
    }

	function load_drag_image(){
		// reset string & array
		arr_url_img = [];
		str_url_image = ""; str_image_size = ""; 

		$('#upload_image').empty();
		var html = `<div class="dropzone images">
						<div class="fallback">
							<input name="file_product_en" type="file" multiple />
						</div>

						<div class="dz-message needsclick">
							<div class="mb-3">
								<img src="<?=base_url()?>assets/images/image-upload-icon.svg" width="50" height="50" loading="lazy" alt="upload image" style="opacity: 0.6;">
							</div>

							<h4>Drop files here or click to upload.</h4>
							<h6>You can only upload images</h6>
						</div>
					</div>`;
		$('#upload_image').append(html);

        uploadImage = new Dropzone(".dropzone.images", {
            url: "<?= base_url('home/upload_images') ?>",
            maxFiles: 1, // only one file upload
            maxFilesize: 5, // 5MB
            method: "post",
            // acceptedFiles: "image/*",
            // acceptedFiles: "image/jpeg,image/jpg,image/png,image/gif,image/webp,image/avif,image/svg,image/bmp,image/tiff,image/jp2,image/x-icon",
            acceptedFiles: ".png, .jpg, .jpeg, .gif, .webp, .avif",
            paramName: "outputImages",
            dictInvalidFileType: "This file type is not allowed",
            addRemoveLinks: true,
            // renameFile: function(file) {
            //     let x = file.name.split(".");
            //     var extention = "." + x[x.length - 1];
			// 	var d = new Date();
			// 	var dt = d.getFullYear()+''+(d.getMonth()+1)+''+d.getDate()+''+d.getHours()+''+d.getMinutes()+''+d.getSeconds()+''+d.getTime();
            //     var rename = username + '-' + dt + extention;
            //     return rename;
            // }
        });

		function uniqueStr(inputString){
			const inputArray = inputString.split(","); // ubah jadi array
			const uniqueArray = [...new Set(inputArray)]; // hapus duplikat
			const uniqueString = uniqueArray.join(","); // kembalikan ke string
			return uniqueString;
		}

        //Event ketika Memulai mengupload bisa gunakan on("sending") atau on("success")
        uploadImage.on("success", function(get_file, response, fromData) {
			var uniqueArray = [];

			// console.log(`${get_file.status} photo EN ${get_file.upload.filename}`);
			// console.log("get_file : ", get_file);
			// console.log("========================");

			var allFile = uploadImage.files;
			var result = response.result;
			console.log("status upload: ", get_file.status);
			console.log("status server: ", result.status);

			if(allFile.length == arr_url_img.length){
				// clearInterval(interUp);
				// jika ada duplikat karna salah satu foto gagal di upload
				// hapus duplikat
				arr_url_img = [...new Map(arr_url_img.map((m) => [m.filename, m])).values()];
				console.clear();
			} else {
				if(!result.status) {
					// clearInterval(interUp);
					// Tampilkan pesan error
					var errorNode = document.createElement("span");
					errorNode.setAttribute('data-dz-errormessage', result.msg);
					errorNode.textContent = result.msg;
					$(get_file.previewElement).children('.dz-error-message').attr("style", "display: block; opacity: 1;").html(errorNode);
					console.log("imgError: ", result, "\nfile: ", get_file.upload.filename);
					// console.log("previewElement: ", errorNode, $(get_file.previewElement).children('.dz-error-message'));
				
				} else {
                    get_file.name = result.nama;
                    get_file.upload.filename = result.nama;

					arr_url_img.push({
						token_foto: get_file.token,
						path: 'upload/images/' + get_file.upload.filename,
						filename: get_file.upload.filename,
						str_photo_en: str_url_image,
						size_en: str_image_size,
						size: get_file.size,
						type: get_file.type,
						status_respond: result.status,
						status_upload: get_file.status
					});

					error_images.text(null);
					
					// hapus duplikat
					uniqueArray = [...new Map(arr_url_img.map((m) => [m.filename, m])).values()];

                    // show newImg
                    newImg.parent().removeClass("d-none");
                    originalPhoto.addClass("d-none");
                    if (uniqueArray.length == 1) {
                        newImg.attr("src", `<?=base_url()?>upload/images/${result.nama}`);
                    }

					console.log("get_file : ", get_file);
					console.log("save images : ", arr_url_img, "\nuniqueArray: ", uniqueArray);
					// console.log("str images : ", str_url_image.split(","), "\nuniqueStr: ", unique_all_img.split(","));
					// console.log("str img size : ", str_image_size.split(","), "\nuniqueStr: ", unique_img_size.split(","));
					console.log("========================");

				} 
			}
			// reset url file
			const resultUrl = uniqueArray.map(item => '<?=base_url()?>'+item.path);
			str_url_image = resultUrl.join(",");
			// reset size file
			const resultSize = uniqueArray.map(item => item.size);
			str_image_size = resultSize.join(",");
			
			$("#url_upload_image").val(str_url_image);
			$("#url_image_size").val(str_image_size);

			console.log("urlImg: ", str_url_image.split(","), "sizeImg: ", str_image_size.split(","));
			console.log("allFile: ", allFile.length, " url_img: ", arr_url_img.length, " unique: ", uniqueArray.length);
			console.log("========================");
			// var interUp = setInterval(() => {
			// }, 1500);
        });

        //Event ketika foto dihapus
        uploadImage.on("removedfile", function(a) {
            var token = a.token;
            var path = '<?=base_url('upload/images/')?>'+a.upload.filename;
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
                url: "<?= base_url('home/remove_images') ?>",
                cache: false,
                dataType: 'json',
                success: function(response) {
                    // console.log("status Foto : ", response.status);
                    // console.log("response foto : ", response);

                    $("#" + token).remove();
                    // hapus array
                    for (let i = 0; i < arr_url_img.length; i++) {
                        const el = arr_url_img[i];
                        if (el.filename == a.upload.filename) {
                            arr_url_img.splice(i, 1);
                        }
                    }
                    console.log("after remove : ", arr_url_img);
					reset_element();

                },
                error: function(e) {
                    console.log("Error : ", e);
                }
            });
        });

        function reset_element(){
            // hide newImg
            newImg.parent().addClass("d-none");
            originalPhoto.removeClass("d-none");

            // reset string dan ubah value
            str_url_image = "";
            str_image_size = "";
			error_images.text(null);

            if (arr_url_img.length == 0) {
                $("#url_upload_image").val(null);
                $("#url_image_size").val(null);
            } else {
                for (let u = 0; u < arr_url_img.length; u++) {
                    const element = arr_url_img[u];
                    if (str_url_image == "") {
                        str_url_image = "<?= base_url() ?>upload/images/" + element.filename;
                        str_image_size = element.size;
                    } else {
                        str_url_image += ",<?= base_url() ?>upload/images/" + element.filename;
                        str_image_size += "," + element.size;
                    }

                    $("#url_upload_image").val(str_url_image);
                    $("#url_image_size").val(str_image_size);
                    console.log("change_file_en : ", str_url_image);
                    console.log("change_size_en : ", str_image_size);
                }
            }
        }

		$("#removeimage").on('click', () => {
			uploadImage.removeAllFiles();
			arr_url_img = []; // reset array
			reset_element();
			str_url_image = ""; str_image_size = ""; // reset string
			console.clear();
			// var allFile = uploadImage.files;
			// console.log("get all file: ", allFile);
		});
	}
</script>