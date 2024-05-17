<?php 
    $check_variable = (is_array($data_email)) ? true : false;
    $full_name = ($check_variable) ? $data_email['first_name']. ' '. $data_email['last_name'] : $data_email->first_name . ' ' . $data_email->last_name;
    $email = ($check_variable) ? $data_email['email'] : $data_email->email;            
?>

Hi <?= $full_name ?>,

You have sent the forgotten password to <?= NAMA_WEB_ASLI ?> with your email <?= $email ?>

To solve forgot your password, please copy the following code. Click the button below and paste it in the code field.

<?= $code ?>


Please click link to continue change password. 

<?= base_url('auth/v_verify/'.$id_lang) ?>

