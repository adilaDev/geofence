<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <style type='text/css'>
                table,
                tr,
                td {
                    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
                }

                .custom_table {
                    box-sizing: border-box;
                    font-size: 14px;
                    width: 100%;
                    background-color: transparent;
                    margin: 0;
                }

                .custom_tr-1 {
                    box-sizing: border-box;
                    font-size: 14px;
                    margin: 0;
                }

                .custom_td-1 {
                    box-sizing: border-box;
                    font-size: 14px;
                    vertical-align: top;
                    margin: 0;
                }

                .custom_container {
                    box-sizing: border-box;
                    font-size: 14px;
                    display: block !important;
                    max-width: 600px !important;
                    clear: both !important;
                    margin: 0 auto;
                }

                .custom_content {
                    box-sizing: border-box;
                    font-size: 14px;
                    max-width: 600px;
                    display: block;
                    margin: 10px auto !important;
                    padding: 20px;
                }

                .custom_main {
                    box-sizing: border-box;
                    font-size: 14px;
                    border-radius: 7px;
                    background-color: #fff;
                    color: #495057;
                    margin: 0;
                    box-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, .03);
                }

                .custom_alert {
                    box-sizing: border-box;
                    font-size: 16px;
                    vertical-align: top;
                    color: #fff;
                    font-weight: 500;
                    text-align: center;
                    border-radius: 7px 7px 0 0;
                    background-color: #556ee6;
                    margin: 0;
                    padding: 20px;
                }

                .bg-primary.bg-soft {
                    background-color: rgb(32 178 170 / 55%) !important;
                }

                .custom_btn {
                    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
                    box-sizing: border-box;
                    font-size: 14px;
                    color: #FFF;
                    text-decoration: none;
                    line-height: 2em;
                    font-weight: bold;
                    text-align: center;
                    cursor: pointer;
                    display: inline-block;
                    border-radius: 5px;
                    text-transform: capitalize;
                    background-color: #34c38f;
                    margin: 0;
                    border-color: #34c38f;
                    border-style: solid;
                    border-width: 8px 16px;
                }

                .btn {
                    display: inline-block;
                    font-weight: 400;
                    line-height: 1.5;
                    color: #495057;
                    text-align: center;
                    vertical-align: middle;
                    cursor: pointer;
                    -webkit-user-select: none;
                    -moz-user-select: none;
                    -ms-user-select: none;
                    user-select: none;
                    background-color: transparent;
                    border: 1px solid transparent;
                    padding: 0.47rem 0.75rem;
                    font-size: .8125rem;
                    border-radius: 0.25rem;
                    -webkit-transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
                    transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
                    transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
                    transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
                }

                .btn.btn-primary {
                    color: white !important;
                    background-color: var(--custom-primary-color) !important;
                    border-color: var(--custom-primary-color) !important;
                }

                .btn.btn-primary:hover {
                    background-color: var(--custom-primary-hover) !important;
                    border-color: #0c847d !important;
                }

                .btn.btn-primary:focus,
                .btn.btn-outline-primary:focus {
                    box-shadow: 0 0 0 0.15rem rgb(32 178 169 / 50%);
                }

                .btn.btn-outline-primary {
                    color: #20b2aa !important;
                    border-color: var(--custom-primary-color) !important;
                }

                .btn.btn-outline-primary:hover {
                    color: var(--white) !important;
                    background-color: var(--custom-primary-color) !important;
                    border-color: var(--custom-primary-color) !important;
                }

                .custom_badge {
                    background-color: #f46a6a;
                    color: #ffffff;
                    padding: 5px 8px;
                    font-size: 12px;
                    border-radius: 4px
                }
            </style>

            <?php 
            $check_variable = (is_array($data_email)) ? true : false;
            $full_name = ($check_variable) ? $data_email['first_name']. ' '. $data_email['last_name'] : $data_email->first_name . ' ' . $data_email->last_name;
            $email = ($check_variable) ? $data_email['email'] : $data_email->email;            
            ?>

            <div class="col-12">
                <table style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: transparent; margin: 0;">
                    <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class="container" width="600" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
                            <div class="content" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                                <table class="main" width="100%" cellpadding="0" cellspacing="0" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 7px; background-color: #fff; color: #495057; margin: 0; box-shadow: 0 0.75rem 1.5rem rgb(0 0 0 / 30%)" bgcolor="#fff">
                                    <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td class="" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 22px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 0 0; background-color: #20b2aa; border: 2px solid lightseagreen; margin: 0; padding: 20px;" align="center" bgcolor="#71b6f9" valign="top">
                                            
                                            <?= ($lang == 'jp') ? ('パスワードをお忘れですか <b style="font-weight: 600; text-transform: uppercase;">'.NAMA_WEB.'</b>.') : 'Forgot password <b style="font-weight: 600; text-transform: uppercase;">'. NAMA_WEB .'</b>.' ?>
                                        </td>

                                    </tr>
                                    <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td class="content-wrap" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px; border: 2px solid lightseagreen;" valign="top">
                                            <table width="100%" cellpadding="0" cellspacing="0" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">

                                                <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                    <td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 10px;" valign="top">
                                                        <?= ($lang == "jp") ? ('やあ <strong>'. $full_name .'</strong>,') : 'Hi <strong>'. $full_name .'</strong>,' ?>
                                                    </td>
                                                </tr>
                                                <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                    <td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 10px;" valign="top">
                                                        <?= ($lang == 'jp') ? ("忘れたパスワードをメール <strong>$email</strong> で ".NAMA_WEB." に送信しました。") : 'You have sent the forgotten password to '. NAMA_WEB . ' with your email <strong>'. $email .'</strong>' ?>
                                                    </td>
                                                </tr>
                                                <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                    <td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 10px;" valign="top">
                                                        <?= ($lang == 'jp') ? ('パスワードを忘れた場合は、次のコードをコピーしてください。 下のボタンをクリックして、コード フィールドに貼り付けます') : 'To solve forgot your password, please copy the following code. Click the button below and paste it in the code field.' ?>
                                                    </td>
                                                </tr>

                                                <?php
                                                $amount_price = empty($amount_price) ? 0 : $amount_price;
                                                $tax = 0.1;
                                                $calculate_tax = $amount_price * $tax;
                                                $total_price = $amount_price - $calculate_tax;
                                                $estimation_amount = $amount_price + $calculate_tax;

                                                function formatYen($value)
                                                {
                                                    return number_format($value, 0, ",", ",");
                                                }
                                                ?>
                                                <table width="100%" cellpadding="0" cellspacing="0" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                    <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                        <td class="content-block aligncenter" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">
                                                            <table class="invoice" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; text-align: left; width: 100%; margin: 0px auto;">
                                                                <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                                    <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border-top-width: 0px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;" valign="top">
                                                                        <!-- Order #1234 <br>
                                                                        25 Aug, 2022 -->
                                                                        <strong style="font-size: 24px;"><?= $code ?></strong>
                                                                    </td>
                                                                </tr>
                                                                <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                                    <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; text-align: center; font-weight:normal; vertical-align: top; border-top-width: 0px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;" valign="top">
                                                                        <a href="<?= base_url('auth/v_verify/'.$id_lang) ?>" target="_blank" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #20b2aa; margin: 15px 0 0 0; border-color: #20b2aa; border-style: solid; border-width: 8px 16px;">
                                                                            <?= ($lang == 'jp') ? 'パスワードの変更を続行' : 'Continue Change Password' ?>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>

                                                    <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                        <td class="content-block aligncenter" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 20px 0 10px;" align="center" valign="top">
                                                            Asia Research Institute. 
                                                            <!-- Asia Research Institute Inc. Neoba Bldg 2-2-5, Tomigaya, Shibuya-ku, Tokyo, Japan, 151-0063 -->
                                                        </td>
                                                    </tr>

                                                    <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                        <td class="content-block" style="text-align: center;font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0;" valign="top">
                                                            &copy; 2022 <b style="color:lightseagreen;"><?= NAMA_WEB ?></b>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="col-12" style="display: none;">
                <div class="card card-effect" style="position:relative; display:flex; -webkit-box-orient: vertical; -webkit-box-direction: normal; 
                -ms-flex-direction: column; flex-direction: column; width: 40rem; word-wrap: 
                break-word; background-color: #fff; background-clip: border-box;
                border: 0 solid #f6f6f6; box-shadow: 0px 10px 15px rgb(135 135 135 / 25%) !important; border-radius: 10px;
                border-width: 3px!important; border-color: lightseagreen!important; margin: 15px auto;">

                    <div class="card-header" style="padding: 0.625rem 1.25rem; margin-bottom: 0; background-color: rgba(32, 178, 170, 0.50); border-bottom: 3px solid lightseagreen; color: lightseagreen; text-align: center;">
                        <div class="card-title" style="font-size: 20px; margin: 0; font-weight: 600;">Thank you for using <b><?= NAMA_WEB ?></b> </div>
                    </div>
                    <div class="card-body" style="-webkit-box-flex: 1; -ms-flex: 1 1 auto; flex: 1 1 auto; padding: 1.25rem 1.25rem;">
                        <?php foreach ($pesan as $msg) : ?>
                            <div style="color:#333; margin: 8px auto; font-size: 14px; font-weight: normal;"><?= $msg ?></div>
                        <?php endforeach; ?>
                        <div class="table-responsive" style="margin: 20px auto; overflow-x: auto;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;" valign="top">
                                        <p style="margin-bottom: 5px;">Order #6521</p>
                                        <p style="margin-bottom: 5px;">Aug 25, 2022</p>
                                        <h5 style="text-align: center; font-weight: 600; margin-bottom: 1.2rem;">Prefecture chain data</h5>
                                        <table class="invoice-items" cellpadding="0" cellspacing="0" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; margin: 0;">
                                            <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;" valign="top">Category
                                                </td>
                                                <td class="alignright" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;" align="right" valign="top">1
                                                </td>
                                            </tr>
                                            <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;" valign="top">Chain
                                                </td>
                                                <td class="alignright" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;" align="right" valign="top">3
                                                </td>
                                            </tr>
                                            <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;" valign="top">Store
                                                </td>
                                                <td class="alignright" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;" align="right" valign="top">1,510
                                                </td>
                                            </tr>
                                            <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;" valign="top">Fee per store
                                                </td>
                                                <td class="alignright" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;" align="right" valign="top">&yen; 10 / Store
                                                </td>
                                            </tr>
                                            <tr class="total" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                <td class="alignright" width="80%" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 2px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 5px 0;" align="right" valign="top">Total
                                                </td>
                                                <td class="alignright" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 2px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 5px 0;" align="right" valign="top">&yen; 13,590
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="footers" style="bottom: 0; margin-top:2rem; position: unset; right: 0; color: #74788d; left: 250px; font-size: 14px; background-color: transparent;">
                            <div class="container-fluid" style="text-align: center; width: 100%; margin: 0; padding: 0;">
                                <div class="row">
                                    <div class="col-12">
                                        Asia Research Institute Inc. Neoba Bldg 2-2-5, Tomigaya, Shibuya-ku, Tokyo, Japan, 151-0063
                                    </div>
                                    <div class="col-12" style="margin-top: 10px; margin-bottom: -10px;">&copy; 2022 <b style="color: lightseagreen;"><?= NAMA_WEB ?></b></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->
</div>