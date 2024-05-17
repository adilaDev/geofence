<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller
{
    public $session;
    public $input;
    public $output;
    public $config;
    public $lang;
    public $db;
    public $form_validation;
    public $auth;

    public function __construct()
    {
        parent::__construct();
        // load Session Library
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->database();
        
        $this->load->model('M_Auth', "auth"); // Misalnya, model untuk autentikasi

		if ($this->session->userdata('data_login') == '' || $this->session->userdata('data_login') == null) {
            $this->session->set_flashdata('message_login', '<div class="alert alert-warning alert-dismissible fade show" role="alert">Your session has expired please login again<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
			redirect(base_url('login'));
		}
		
        // https://stackoverflow.com/questions/39486862/codeigniter-3-issue-in-changing-default-language-dynamically
        $lang = $this->session->userdata('language');
        if(empty($lang) || $lang == null){
            $lang = "en";
            $this->session->set_userdata(array('language' => $lang)); // set default english
        }
        
        $lang_name = ($lang == 'jp') ? "japanese" : "english";
        // load bahasa dgn library language default dari CI
        $this->lang->load($lang, $lang_name);
        
        // ubah bahasa untuk form_validation CI
        $this->config->set_item('language', $lang_name);
        
    }

    public function index(){
        // get data user
        $id_user = $this->session->userdata('data_login')['id'];
        $data['get_user'] = $this->db->get_where('tb_users', array('id_user' => $id_user))->row();

		$data_head['title'] = 'Profile';
		$this->load->view('layout/header', $data_head);
		$this->load->view('layout/navbar');
		$this->load->view('profile/v_profile', $data);
		$this->load->view('layout/footer');        
    }

    public function edit(){
        $validation = $this->form_validation;
        $validation->set_rules('first_name', 'First Name', 'required');
        $validation->set_rules('last_name', 'Last Name', 'required');

        if ($validation->run() == FALSE) {
            $this->index();
        } else {
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $company = $_POST['company'];
            $address = $_POST['address'];
            $profile_picture = $_POST['url_upload_image'];
            $id_user = $this->session->userdata('data_login')['id'];

            $data_update = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'company' => $company,
                'address' => $address,
                'profile_picture' => $profile_picture,
            );
            if (empty($company)) {
                # hapus company supaya tidak ke replace
                unset($data_update['company']);
            }
            if (empty($address)) {
                # hapus address supaya tidak ke replace
                unset($data_update['address']);
            }
            if (empty($profile_picture)) {
                # hapus profile_picture supaya tidak ke replace
                unset($data_update['profile_picture']);
            }

            // $this->output->set_content_type('application/json')->set_output(json_encode($data_update));
            
            $up = $this->db->update('tb_users', $data_update, array("id_user" => $id_user));
            if ($up) {
                $this->session->set_flashdata('msg_profile', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Your profile has been successfully updated
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            } else {
                $this->session->set_flashdata('msg_profile', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Your profile failed to update
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            }
            
            if (!empty($profile_picture)) {
                # jika user ganti foto, ubah juga session nya
                // $datauser = (array) $this->auth->get_user_by_userdata($id_user)->row();
                $db_user = $this->auth->get_user_by_userdata($id_user)->row();
                $datauser = array(
                    'id' => $db_user->id,
                    'first_name' => $db_user->first_name,
                    'last_name' => $db_user->last_name,
                    'email' => $db_user->email,
                    'username' => $db_user->username,
                    'password' => $db_user->password,
                    'photo_profil' => $db_user->photo_profil,
                    'id_level' => $db_user->id_level,
                    'status' => $db_user->status,
                    'after_login' => $db_user->after_login,
                );
                $this->session->set_userdata('data_login', $datauser);
                redirect('profile','refresh');
            } else {
                redirect('profile','refresh');
            }
        }
    }

    public function changepassword(){        
		$data_head['title'] = 'Profile';
		$this->load->view('layout/header', $data_head);
		$this->load->view('layout/navbar');
		$this->load->view('profile/change_password');
		$this->load->view('layout/footer');
    }

    public function check_old_password(){
        $old_db = $this->session->userdata('data_login')['password'];
        $old = $this->input->post('old_password');
        $old_sha1 = sha1($old);

        $data = array(
            'old_db' => $old_db,
            'old_sha1' => $old_sha1,
            'old' => $old,
            'result' => ($old_sha1 == $old_db),
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
        
    }
    public function check(){
        $validation = $this->form_validation;
        // Set rules untuk validasi
        $validation->set_rules('old_password', 'Old Password', 'required');
        $validation->set_rules('new_password', 'New Password', 'required|min_length[8]|max_length[20]');
        $validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]|min_length[8]|max_length[20]');
        
        if ($validation->run() == FALSE) {
            // Jika validasi gagal, tampilkan form kembali dengan pesan error
            $this->changepassword();
        } else {
            // Validasi sukses, lakukan perubahan password
            // Tambahkan kode untuk memverifikasi old password dan menyimpan new password
            $result = $this->auth->changePassword($_POST['old_password'], $_POST['new_password']);

            if ($result['verify']) {
                // Password berhasil diubah
                $output['alert'] = "alert-success";
                $output['msg'] = "Password has been changed successfully!";
            } else {
                // Gagal mengubah password
                $output['alert'] = "alert-danger";
                $output['msg'] = "Failed to change password. Please check your old password.";
            }
            $output['verify'] = $result['verify'];
            
            $this->session->set_flashdata('msg_password', 
            '<div class="alert '.$output['alert'].' alert-dismissible fade show" role="alert">
                '.$output['msg'].'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            
            redirect(base_url("profile/changepassword"));

            // $this->output->set_content_type('application/json')->set_output(json_encode($output));
            
        }
    }
}