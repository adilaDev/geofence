<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card card-effect">
                        <div class="card-body">
                            <div class="card-title mb-3"><?= !empty($this->lang->line('change_password')) ? $this->lang->line('change_password') : 'Change Password'; ?></div>

                            <?= $this->session->flashdata('msg_password'); ?>

                            <div class="row">
                                <div class="mb-1">
                                    <div id="all_validation" class="alert alert-warning" role="alert">
                                        <div class="card-title"><?= !empty($this->lang->line('password_contain')) ? $this->lang->line('password_contain') : 'The password must contain at least'; ?></div>
                                        <ul class="ps-0 mb-0" style="list-style: none; font-weight: bold;">
                                            <li id="valid1"><i class="far fa-check-circle me-2 font-size-16 align-middle"></i><?= !empty($this->lang->line('password_length')) ? $this->lang->line('password_length') : 'Password length is between 8 to 20 characters.'; ?></li>
                                            <li id="valid2"><i class="far fa-check-circle me-2 font-size-16 align-middle"></i><?= !empty($this->lang->line('minimum_uppercase')) ? $this->lang->line('minimum_uppercase') : 'Minimum 1 Uppercase letter.'; ?></li>
                                            <li id="valid3"><i class="far fa-check-circle me-2 font-size-16 align-middle"></i><?= !empty($this->lang->line('minimum_lowercase')) ? $this->lang->line('minimum_lowercase') : 'Minimum 1 Lowercase letter.'; ?></li>
                                            <li id="valid4"><i class="far fa-check-circle me-2 font-size-16 align-middle"></i><?= !empty($this->lang->line('minimum_digit')) ? $this->lang->line('minimum_digit') : 'Minimum 1 Numeric digit and.'; ?></li>
                                            <li id="valid5"><i class="far fa-check-circle me-2 font-size-16 align-middle"></i><?= !empty($this->lang->line('minimum_symbol')) ? $this->lang->line('minimum_symbol') : 'Minimum 1 symbol.'; ?></li>
                                        </ul>
                                    </div>
                                </div>

                                <form id="form_password" action="<?= base_url('profile/check') ?>" method="post" class="col">
                                    <div class="mb-3">
                                        <label for="old_password" class="form-label"><?= !empty($this->lang->line('old_password')) ? $this->lang->line('old_password') : 'Old Password'; ?></label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control" name="old_password" id="old_password" oninput="validasiPassword(this, 'validasi_old')" value="<?= set_value('old_password') ?>">
                                            <button class="btn btn-outline-secondary" type="button" id="toggle-old"><i class="mdi mdi-eye-outline label-icon"></i></button>
                                        </div>
                                        <small id="validasi_old" class="text-danger"><?=form_error('old_password', '', '')?></small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="new_password" class="form-label"><?= !empty($this->lang->line('new_password')) ? $this->lang->line('new_password') : 'New Password'; ?></label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control" name="new_password" id="new_password" oninput="validasiPassword(this, 'validasi_new')" value="<?= set_value('new_password') ?>">
                                            <button class="btn btn-outline-secondary" type="button" id="toggle-new"><i class="mdi mdi-eye-outline label-icon"></i></button>
                                        </div>
                                        <small id="validasi_new" class="text-danger"><?=form_error('new_password', '', '')?></small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label"><?= !empty($this->lang->line('confirm_password')) ? $this->lang->line('confirm_password') : 'Confirm Password'; ?></label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" oninput="validasiPassword(this, 'validasi_confirm')" value="<?= set_value('confirm_password') ?>">
                                            <button class="btn btn-outline-secondary" type="button" id="toggle-confirm"><i class="mdi mdi-eye-outline label-icon"></i></button>
                                        </div>
                                        <small id="validasi_confirm" class="text-danger"><?=form_error('confirm_password', '', '')?></small>
                                    </div>

                                    <div class="text-center mb-0">
                                        <button type="submit" class="btn btn-primary w-lg waves-effect waves-light"><?= !empty($this->lang->line('save_change')) ? $this->lang->line('save_change') : 'Save Change'; ?></button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="<?=base_url()?>assets/js/sha.js"></script>

<script type="text/javascript">
    const regexPanjang = /^.{8,20}$/, // 8 hingga 20 karakter
        regexHurufKapital = /[A-Z]/, // Setidaknya 1 huruf kapital
        regexHurufKecil = /[a-z]/, // Setidaknya 1 huruf kecil
        regexAngka = /[0-9]/, // Setidaknya 1 angka
        regexSimbol = /[!@#$%^&*()_+{}\[\]:;<>,.?~\\-]/; // Setidaknya 1 simbol
        
    let invalid_pass = "<?= !empty($this->lang->line('password_invalid')) ? $this->lang->line('password_invalid') : 'Password is invalid, please check the password criteria above.'; ?>";
    let invalid_new_pass = "<?= !empty($this->lang->line('new_password_invalid')) ? $this->lang->line('new_password_invalid') : 'New Password is invalid, please check the password criteria above.'; ?>";
    let invalid_confirm_pass = "<?= !empty($this->lang->line('confirm_password_invalid')) ? $this->lang->line('confirm_password_invalid') : 'The Confirm Password field does not match the New Password field.'; ?>";

    $(document).ready(function() {
        // show password input value
        $("#toggle-old").on('click', function () {
            if ($(this).siblings('input').length > 0) {
                $(this).siblings('input').attr('type') == "password" ? $(this).siblings('input').attr('type', 'input') : $(this).siblings('input').attr('type', 'password');
            }
        });
        $("#toggle-new").on('click', function () {
            if ($(this).siblings('input').length > 0) {
                $(this).siblings('input').attr('type') == "password" ? $(this).siblings('input').attr('type', 'input') : $(this).siblings('input').attr('type', 'password');
            }
        });
        $("#toggle-confirm").on('click', function () {
            if ($(this).siblings('input').length > 0) {
                $(this).siblings('input').attr('type') == "password" ? $(this).siblings('input').attr('type', 'input') : $(this).siblings('input').attr('type', 'password');
            }
        });

        document.getElementById("form_password").addEventListener('submit', checkPassword);
    });

    function validasiPassword(input, id_error) {
        var id_pass = input.id,
        pass_new = $("#new_password").val(),
        pass_confirm = $("#confirm_password").val();

        const password = input.value;
        
        const show_hide_ui_valid = function (){
            const all_validation = $("#all_validation"),
            valid1 = $("#valid1"),
            valid2 = $("#valid2"),
            valid3 = $("#valid3"),
            valid4 = $("#valid4"),
            valid5 = $("#valid5");
            if (password == "" && password.length == 0) {
                valid1.removeClass();
                valid2.removeClass();
                valid3.removeClass();
                valid4.removeClass();
                valid5.removeClass();
            } else {
                
                // valid 1
                if(regexPanjang.test(password)) {
                    valid1.removeClass("text-danger"); valid1.addClass("text-primary");
                } else {
                    valid1.removeClass("text-primary"); valid1.addClass("text-danger");
                }
                
                // valid 2
                if(regexHurufKapital.test(password)) {
                    valid2.removeClass("text-danger"); valid2.addClass("text-primary");
                } else {
                    valid2.removeClass("text-primary"); valid2.addClass("text-danger");
                }
                
                // valid 3
                if(regexHurufKecil.test(password)) {
                    valid3.removeClass("text-danger"); valid3.addClass("text-primary");
                } else {
                    valid3.removeClass("text-primary"); valid3.addClass("text-danger");
                }
                
                // valid 4
                if(regexAngka.test(password)) {
                    valid4.removeClass("text-danger"); valid4.addClass("text-primary");
                } else {
                    valid4.removeClass("text-primary"); valid4.addClass("text-danger");
                }
                
                // valid 5
                if(regexSimbol.test(password)) {
                    valid5.removeClass("text-danger"); valid5.addClass("text-primary"); 
                } else {
                    valid5.removeClass("text-primary"); valid5.addClass("text-danger");
                }
            }
        };
        show_hide_ui_valid();

        if (password != "" && password.length != 0) {
            if (id_pass != "old_password") {
                if (regexPanjang.test(password) && regexHurufKapital.test(password) && regexHurufKecil.test(password) && regexAngka.test(password) && regexSimbol.test(password)) {
                    document.getElementById(id_error).innerText = ""; // Password valid
                    // check apakah new password dan confirm password sama atau tidak
                    if (id_pass == 'confirm_password') {
                        if (pass_new == pass_confirm) {
                            document.getElementById(id_error).innerText = ""; // Password valid
                        } else {
                            // document.getElementById(id_error).innerText = "The Confirm Password field does not match the New Password field."; // Password valid
                            document.getElementById(id_error).innerText = invalid_confirm_pass; // Password valid
                        }
                    }
                } else {
                    // document.getElementById(id_error).innerText = "Password is invalid, please check the password criteria above.";
                    document.getElementById(id_error).innerText = invalid_pass;
                }
            }
        } else {
            document.getElementById(id_error).innerText = "";
        }
    }
    
    function checkPassword(e){
        var password = document.getElementById("old_password").value;
        var password_new = document.getElementById("new_password").value;
        var password_confirm = document.getElementById("confirm_password").value;
        
        let old_valid = ((regexPanjang.test(password) && regexHurufKapital.test(password) && regexHurufKecil.test(password) && regexAngka.test(password) && regexSimbol.test(password)));
        let new_valid = ((regexPanjang.test(password_new) && regexHurufKapital.test(password_new) && regexHurufKecil.test(password_new) && regexAngka.test(password_new) && regexSimbol.test(password_new)));
        let confirm_valid = ((password_confirm == password_new && regexPanjang.test(password_confirm) && regexHurufKapital.test(password_confirm) && regexHurufKecil.test(password_confirm) && regexAngka.test(password_confirm) && regexSimbol.test(password_confirm)));

        const valid = {
            "old_password": {
                "value": password,
                "valid": old_valid,
            },
            "new_password": {
                "value": password_new,
                "valid" : new_valid
            },
            "confirm_password": {
                "value": password_confirm,
                "valid": confirm_valid
            },
        }
        console.log("validasi: ", valid);

        // jika sama validasi lagi 
        if (new_valid && confirm_valid) {
            // jika semua sudah true kirim dan simpan perubahan
            $("#form_password").submit();
        } else {
            e.preventDefault();
            // if (!old_valid) {
            //     document.getElementById("validasi_old").innerText = "Password is invalid, please check the password criteria above.";
            // }
            if (!new_valid) {
                // document.getElementById("validasi_new").innerText = "Password is invalid, please check the password criteria above.";
                document.getElementById("validasi_new").innerText = invalid_new_pass;
            }

            if (confirm_valid != new_password) {
                document.getElementById("validasi_confirm").innerText = invalid_confirm_pass;                
            } else if (!confirm_valid) {
                document.getElementById("validasi_confirm").innerText = invalid_pass;
            }
        }
    }
</script>