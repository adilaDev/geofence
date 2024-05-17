<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Facebook_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->tableName = 'facebook_users';
        $this->primaryKey = 'id';
    }

    // ==================================================
    // Model create by Fadil
    // ==================================================
    public function validation_email_fb($email, $user, $access_token)
    {
        $lang = $this->session->userdata('language');

        $uid = $user['id'];
        $email = $user['email'];
        $first_name = $user['first_name'];
        $last_name = $user['last_name'];
        $name = $user['name'];
        $foto = $user['picture']['url'];

        $cek = $this->auth->count_user($email);
        $data_email = $this->auth->cek_email($email);
        $after_login = $this->session->flashdata('after_login');
        
        if ($cek > 0) {
            // jika user sudah ada di tb_users, kemudian simpan ke session
            $sess = array(
                'id'       => $data_email->id_user,
                'first_name' => $data_email->first_name,
                'last_name' => $data_email->last_name,
                'email'    => $data_email->email,
                'username' => $data_email->username,
                'password' => $data_email->password,
                'photo_profil' => $data_email->profile_picture,
                'id_level' => $data_email->id_level,
                'status' => $data_email->status,
                'after_login' => $after_login
            );

            $fb_user = array(
                'is_login' => TRUE,
                'token' => $access_token,
                'id_fb' => $uid,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'name' => $name,
                'picture' => $foto,
                'user_register' => null
            );
            $this->session->set_userdata('fb_user_info', $fb_user);


            if ($sess['id_level'] != 0) {
                $this->session->set_userdata('data_login', $sess);
                $this->auth->update_last_login($sess['id']);
                setcookie("user", $data_email->username, time() + 3600);

                if ($this->session->userdata('data_login') != '' || $this->session->userdata('data_login') != null) {
                    $cart_by_user = $this->m_product->get_data_cart_by_user();
                    $data_cart = array('cart_by_user' => $cart_by_user);
                    $this->session->set_userdata($data_cart);
                }

                $this->db->update('tb_users', array('login_type' => 'fb'), ['id_user' => $data_email->id_user]);

                if ($lang == "jp") {
                    $this->session->set_flashdata('login_success', '<div class="alert alert-success" role="alert">ログイン成功</div>');
                } else {
                    $this->session->set_flashdata('login_success', '<div class="alert alert-success" role="alert">Login Successfully</div>');
                }
                $this->session->keep_flashdata('data_checkout');
                $this->session->keep_flashdata('after_login');
                // redirect($_SERVER['HTTP_REFERER'], 'refresh');
                redirect(base_url(), 'refresh');
                $msg_error = 'Tidak ada error, berhasil login';
            } else {

                if ($lang == "jp") {
                    $this->session->set_flashdata('login_admin', '<div class="alert alert-danger" role="alert">管理者アカウントでログインしてください</div>');
                } else {
                    $this->session->set_flashdata('login_admin', '<div class="alert alert-danger" role="alert">Please login with admin account</div>');
                }
                redirect(base_url('login'));
                $msg_error = 'Please login with admin account';
            }

        } else {
            // jika user blm terdaftar di tb_users
            $this->session->set_flashdata('fb_flash', 'Akun <b>' . $name . '</b> dengan email <b>' . $email . '</b> belum terdaftar melalui Facebook.<br>Silahkan mendaftar terlebih dahulu');
            // redirect('register');


            $generate_token = $this->generateToken(28)['result_token'];
            // $first_name = $user['given_name']; // Ambil nama dari Akun Google
            // $last_name = $user['family_name']; // Ambil nama dari Akun Google
            // $foto = $user['picture']; // Ambil nama dari Akun Google
            // $fullname = $first_name . " " . $last_name;

            # jika user belum terdaftar
            $user_register = array(
                'token'             => $generate_token,
                'active'            => 0,
                'first_name'        => $first_name,
                'last_name'         => $last_name,
                'email'             => $email,
                'username'          => $name,
                'password'          => '',
                // 'profile_picture'   => 'assets/images/users/blank.png',
                'profile_picture'   => (getimagesize($foto) !== FALSE) ? $foto : 'assets/images/users/blank.png',
                'id_level'          => 2,
                'status'            => 0,
                'last_login'        => date("Y-m-d H:i:s"),
                'login_type' => 'fb'
            );

            $fb_user = array(
                'is_login' => TRUE,
                'token' => $access_token,
                'id_fb' => $uid,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'name' => $name,
                'picture' => $foto,
                'user_register' => $user_register
            );
            
            $this->session->set_userdata('fb_user_info', $fb_user);

            //enkripsi id
            $id_user = $this->auth->add_user($user_register);
            // $id_user = 1; // dummy
            $send_email = $this->sendEmailRegister($email, md5($id_user), $user_register);
            if ($send_email['send']) {
                // jika berhasil simpan ke session
                $sess = array(
                    'id'       => $id_user,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email'    => $email,
                    'username' => $name,
                    'password' => '',
                    'photo_profil' => (getimagesize($foto) !== FALSE) ? $foto : 'assets/images/users/blank.png',
                    'id_level' => 2,
                    'status' => 0,
                    // 'cek' => $password . " == " . $data_email->password,
                    'after_login' => $after_login
                );
                $this->session->set_userdata('data_login', $sess);
                if ($lang == "jp") {
                    $this->session->set_flashdata('log_reg_google', 'アカウントが正常に追加されました。 アカウント確認用のメールを確認し、すぐにパスワードを変更してください');
                } else {
                    $this->session->set_flashdata('log_reg_google', 'The account was added successfully. Please check your email for account verification and change your password immediately');
                }
                $msg_error = 'Email is not registered, please register now => Account added successfully. Please check your email for account verification';
            } else {
                $this->session->set_flashdata('login_failed', $send_email['hasil']);
            }
            // redirect($_SERVER['HTTP_REFERER'], 'refresh');
            redirect(base_url(), 'refresh');
            
        }
    }

    public function sendEmailRegister($email, $encrypted_id, $data_email)
    {

        $config['protocol']    = 'smtp';
        $config['smtp_host']    = 'ssl://smtp.googlemail.com';
        $config['smtp_port']    = '465';
        $config['smtp_timeout'] = '400';
        $config['smtp_user']    = 'achmadfadillah97@gmail.com';
        $config['smtp_pass']    = 'bpselyxhnuotdtmf'; // bpselyxhnuotdtmf
        $config['charset']    = 'UTF-8'; // iso-8859-1
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html';
        $config['wordwrap'] = FALSE;

        $this->load->library('email', $config);
        // $this->email->initialize($config);

        $language = $this->session->userdata('language');
        $this->email->from('info@asiaresearchinstitute.com', 'Asia Research Institute');
        $this->email->to($email);
        if ($language == 'jp') {
            $this->email->subject('アカウントの確認');
        } else {
            $this->email->subject('Account verification');
        }

        $gabung = $encrypted_id . "_" . $language;
        $data = array(
            "lang" => $language,
            "id" => $encrypted_id,
            "email" => $email,
            "id_lang" => $gabung,
            "data_email" => $data_email
        );

        $this->email->message($this->load->view('auth/aktivasi/v_mail_verify', $data, true));
        $this->email->set_newline("\r\n");

        $result['send'] = $this->email->send();
        if ($result['send']) {
            $result['hasil'] = 'Email berhasil dikirim ';
            $result['debug'] = $this->email->print_debugger();
        } else {
            $result['hasil'] = 'Email gagal dikirim ';
            $result['debug'] = $this->email->print_debugger();
        };
        $result['data_msg'] = $data;
        return $result;
    }

    public function generateToken($max)
    {
        // https://code.tutsplus.com/tutorials/generate-random-alphanumeric-strings-in-php--cms-32132
        $alphanumeric = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $result_token = '';
        $random_string = '';
        for ($i = 0; $i < $max; $i++) {
            $random_character = $alphanumeric[mt_rand(0, $max - 1)];
            $random_string .= $random_character;
        }

        $result_token = substr(str_shuffle($alphanumeric), 0, $max);
        $uniqid = uniqid() . uniqid();

        $result = array(
            'uniq_id' => $uniqid,
            'random_string' => $random_string,
            'result_token' => $result_token,
        );
        return $result;
        // $this->output->set_content_type('application/json')->set_output(json_encode($result));

    }


    // ==================================================
    // pisah model sumber : https://jurnalmms.web.id/codeigniter/membuat-register-login-with-facebook-di-codeigniter-3/
    // ==================================================
    public function is_facebook_user_has_registered($user_id)
    {
        $check = $this->db
            ->where(array('oauth_provider' => 'facebook', 'oauth_uid' => $user_id))
            ->get('facebook_users');

        return ($check->num_rows() > 0) ? TRUE : FALSE;
    }

    public function register_new_user($data)
    {
        $this->db->insert('facebook_users', $data);

        return $this->db->insert_id();
    }

    public function is_facebook_user_exist($email, $uid)
    {
        $check = $this->db
            ->where(array('email' => $email, 'oauth_provider' => 'facebook', 'oauth_uid' => $uid))
            ->get('facebook_users');

        return ($check->num_rows() > 0) ? TRUE : FALSE;
    }

    public function get_facebook_user_data($uid)
    {
        $data = $this->db
            ->where(array('oauth_provider' => 'facebook', 'oauth_uid' => $uid))
            ->get('facebook_users');

        return $data->row();
    }

    // ==================================================
    // pisah model sumber : https://www.codexworld.com/facebook-login-codeigniter/
    // ==================================================
    /*
     * Insert / Update facebook profile data into the database
     * @param array the data for inserting into the table
     */
    public function checkUser($userData = array())
    {
        if (!empty($userData)) {
            //check whether user data already exists in database with same oauth info
            $this->db->select($this->primaryKey);
            $this->db->from($this->tableName);
            $this->db->where(array('oauth_provider' => $userData['oauth_provider'], 'oauth_uid' => $userData['oauth_uid']));
            $prevQuery = $this->db->get();
            $prevCheck = $prevQuery->num_rows();

            if ($prevCheck > 0) {
                $prevResult = $prevQuery->row_array();

                //update user data
                $userData['modified'] = date("Y-m-d H:i:s");
                $update = $this->db->update($this->tableName, $userData, array('id' => $prevResult['id']));

                //get user ID
                $userID = $prevResult['id'];
            } else {
                //insert user data
                $userData['created']  = date("Y-m-d H:i:s");
                $userData['modified'] = date("Y-m-d H:i:s");
                $insert = $this->db->insert($this->tableName, $userData);

                //get user ID
                $userID = $this->db->insert_id();
            }
        }

        //return user ID
        return $userID ? $userID : FALSE;
    }

}
