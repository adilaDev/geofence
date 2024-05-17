<?php
// defined('BASEPATH') OR exit('No direct script access allowed');

use Google\Service\Adsense\Alert;

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

define('CREDENTIALS_PATH', '~/php-yt-oauth2.json');

date_default_timezone_set('Asia/Jakarta');
class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // load Session Library
        $this->load->library('session');
        $this->load->helper('url', 'form');
        $this->load->library('form_validation');
        $this->load->database();

        $this->load->model('Facebook_model');

        $this->load->model('M_Auth', 'auth');
        $this->load->model('M_Curl', 'm_Curl');
        $this->load->model('M_Lang', 'm_lang');
        $this->load->library('encryption');

        // https://stackoverflow.com/questions/39486862/codeigniter-3-issue-in-changing-default-language-dynamically
        $lang = $this->session->userdata('language');
        if ($lang == "jp") {
            $lang = "japanese";
        } else {
            $lang = "english";
            // $lang = "indonesia";
        }
        // ubah bahasa untuk form_validation CI
        $this->config->set_item('language', $lang);

        // jika change language blm di pilih, tampilkan default language
        $dl = $this->session->userdata('data_lang');
        if (!isset($dl) || $dl == null) {
            $this->m_lang->default_lang();
        }
    }

    public function index(){
        // redirect('login','refresh');
        redirect('auth/login_google','refresh');
        // redirect('auth/g_login','refresh');
    }

    public function login_google()
    {
        $lang = $this->session->userdata('language');
        // $this->load->library('google');
        // Include Librari Google Client (API)
        include_once APPPATH . 'libraries/google-client/Google_Client.php';
        include_once APPPATH . 'libraries/google-client/contrib/Google_Oauth2Service.php';

        $client_id = '353489683098-a4ma4kjp9qmvmmg91vqc77ut13jv1pc1.apps.googleusercontent.com'; // Google client ID
        $client_secret = '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'; // Google Client Secret
        $redirect_url = base_url('auth/login_google'); // Callback URL

        // Call Google API
        $gclient = new Google_Client();
        $gclient->setApplicationName('Google Login'); // Set dengan Nama Aplikasi Kalian
        $gclient->setClientId($client_id); // Set dengan Client ID
        $gclient->setClientSecret($client_secret); // Set dengan Client Secret
        $gclient->setRedirectUri($redirect_url); // Set URL untuk Redirect setelah berhasil login
        $google_oauthv2 = new Google_Oauth2Service($gclient);

        if (isset($_GET['code'])) {
            $gclient->authenticate($_GET['code']);
            $this->session->set_userdata('google_access_token', $gclient->getAccessToken());
            header('Location: ' . filter_var($redirect_url, FILTER_SANITIZE_URL));
        }
        if ($this->session->userdata('google_access_token')) {
            $gclient->setAccessToken($this->session->userdata('google_access_token'));
        }

        $cek = '';
        $data_email = '';
        $gpuserprofile = '';
        $authUrl = $gclient->createAuthUrl();

        if ($gclient->getAccessToken()) {
            $gpuserprofile = $google_oauthv2->userinfo->get();
            // $first_name = $gpuserprofile['given_name']; // Ambil nama dari Akun Google
            // $last_name = $gpuserprofile['family_name']; // Ambil nama dari Akun Google
            // $fullname = $first_name. " " . $last_name;
            $email = $gpuserprofile['email']; // Ambil email Akun Google nya
            $this->session->set_userdata('google_user_info', $gpuserprofile);            
            
            // $this->session->set_userdata('user_data1', $user_data);
            $cek = $this->auth->count_user($email);
            $data_email = $this->auth->cek_email($email);

            $after_login = $this->session->flashdata('after_login');
            if($cek > 0){
                // jika berhasil simpan ke session
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
                    // 'cek' => $password . " == " . $data_email->password,
                    'after_login' => $after_login
                );

                if ($sess['id_level'] != 0){
                    $this->session->set_userdata('data_login', $sess);
                    $this->auth->update_last_login($sess['id']);
                    setcookie("user", $data_email->username, time() + 3600);

                    $this->db->update('tb_users', array('login_type' => 'google'), ['id_user' => $data_email->id_user]);

                    if ($lang == "jp") {
                        $this->session->set_flashdata('login_success', '<div class="alert alert-success" role="alert">ログイン成功</div>');
                    } else {
                        $this->session->set_flashdata('login_success', '<div class="alert alert-success" role="alert">Login Successfully</div>');
                    }
                    $this->session->keep_flashdata('data_checkout');
                    $this->session->keep_flashdata('after_login');
                    redirect($_SERVER['HTTP_REFERER']);
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
                // $this->session->set_flashdata('gagal', 'Email is not registered, please register now');
                // redirect('login');
                // $msg_error = 'Email is not registered, please register now';

                $generate_token = $this->generateToken(28)['result_token'];
                $first_name = $gpuserprofile['given_name']; // Ambil nama dari Akun Google
                $last_name = $gpuserprofile['family_name']; // Ambil nama dari Akun Google
                $foto = $gpuserprofile['picture']; // Ambil nama dari Akun Google
                $fullname = $first_name. " " . $last_name;

                # jika user belum terdaftar
                $user_register = array(
                    'token'             => $generate_token,
                    'active'            => 0,
                    'first_name'        => $first_name,
                    'last_name'         => $last_name,
                    'email'             => $email,
                    'username'          => $fullname,
                    'password'          => '',
                    // 'profile_picture'   => 'assets/images/users/blank.png',
                    'profile_picture'   => (getimagesize($foto) !== FALSE) ? $foto : 'assets/images/users/blank.png',
                    'id_level'          => 2,
                    'status'            => 0,
                    'last_login'        => date("Y-m-d H:i:s"),
                );

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
                        'username' => $fullname,
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
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            header("location: " . $authUrl);
        }

        $all_session = array(
            'data_login' => $this->session->userdata('data_login'),
            'cart_by_user' => $this->session->userdata('cart_by_user'),
            'data_checkout' => $this->session->flashdata('data_checkout'),
            'after_login' => $this->session->flashdata('after_login')
        );

        // https://developers.google.com/identity/protocols/oauth2/web-server#php_3
        $data = array(
            'session_token' => ($this->session->userdata('google_access_token') ? json_decode($this->session->userdata('google_access_token')) : "Yahh session juga kosong"),
            'auth_url' => $authUrl,
            'cek' => $cek,
            'msg_error' => $msg_error,
            'data_email' => $data_email,
            'gpuserprofile' => $gpuserprofile,
            'check_picture' => (getimagesize('assets/images/users/blank.png')) ? getimagesize('assets/images/users/blank.png') : 'bukan',
            'all_session' => $all_session
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
        
    }

    public function fb_login(){
        // Load facebook oauth library 
        $this->load->library('facebook');
        $userData = array();
        $this->session->unset_userdata('userData');

        // Authenticate user with facebook 
        if ($this->facebook->is_authenticated()) {
            // Get user info from facebook 
            $fbUser = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,link,gender,picture');

            // Preparing data for database insertion 
            $userData['oauth_provider'] = 'facebook';
            $userData['oauth_uid']    = !empty($fbUser['id']) ? $fbUser['id'] : '';;
            $userData['first_name']    = !empty($fbUser['first_name']) ? $fbUser['first_name'] : '';
            $userData['last_name']    = !empty($fbUser['last_name']) ? $fbUser['last_name'] : '';
            $userData['email']        = !empty($fbUser['email']) ? $fbUser['email'] : '';
            // $userData['gender']        = !empty($fbUser['gender']) ? $fbUser['gender'] : '';
            $userData['profile_picture']    = !empty($fbUser['picture']['data']['url']) ? $fbUser['picture']['data']['url'] : '';
            // $userData['link']        = !empty($fbUser['link']) ? $fbUser['link'] : 'https://www.facebook.com/';

            // Insert or update user data to the database 
            $userID = $this->Facebook_model->checkUser($userData);

            // Check user data insert or update status 
            if (!empty($userID)) {
                // Facebook logout URL 
                $userData['logoutURL'] = $this->facebook->logout_url();
                $userData['logoutURL2'] = 'https://graph.facebook.com/me/permissions?method=delete&access_token='. $this->facebook->is_authenticated();
                $data['userData'] = $userData;

                // Store the user profile info into session 
                $this->session->set_userdata('userData', $userData);
                
            } else {
                $data['userData'] = array();
            }
            
            // redirect('home');
            $this->login();
            
        } else {
            // Facebook authentication url 
            $data['authURL'] =  $this->facebook->login_url();
            // header("location: " . $data['authURL']);
            header('Location: ' . filter_var($data['authURL'], FILTER_SANITIZE_URL));
        }
        
        // $this->output->set_content_type('application/json')->set_output(json_encode($data));
        
    }

    public function out_fb(){
        $url_fb_user = 'https://graph.facebook.com/me/permissions?method=delete&access_token=' . $this->session->userdata('fb_access_token');
        $url_delete_user = $this->m_Curl->getWithCURL($url_fb_user);
        $result = json_decode($url_delete_user);
        
        // if (is_array($result)) {
        //     if ($result['success']) {                
        //         $this->logout();
        //         redirect('login');          
        //     }
        // } elseif (is_object($result->success)) {
        //     if ($result->success) {
        //         $this->logout();
        //         redirect('login');
        //     }
        // }

        $this->output->set_content_type('application/json')->set_output(json_encode($result));
        
    }

    public function login_fb()
    {
        // Load facebook oauth library 
        $this->load->library('facebook');
        $data_auth['token_fb'] = $this->facebook->is_authenticated();
        $lang = $this->session->userdata('language');

        $data_auth['authURL'] =  $this->facebook->login_url();
        $msg_error = '';

        // Authenticate user with facebook 
        if ($this->facebook->is_authenticated()) {
            // Get user info from facebook 
            $fbUser = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,link,gender,picture');

            // $data['fbUser'] = $fbUser;

            // Preparing data for database insertion 
            $userData['oauth_provider'] = 'facebook';
            $userData['oauth_uid']    = !empty($fbUser['id']) ? $fbUser['id'] : '';;
            $userData['first_name']    = !empty($fbUser['first_name']) ? $fbUser['first_name'] : '';
            $userData['last_name']    = !empty($fbUser['last_name']) ? $fbUser['last_name'] : '';
            $userData['email']        = !empty($fbUser['email']) ? $fbUser['email'] : '';
            // $userData['gender']        = !empty($fbUser['gender']) ? $fbUser['gender'] : '';
            $userData['profile_picture']    = !empty($fbUser['picture']['data']['url']) ? $fbUser['picture']['data']['url'] : '';
            // $userData['link']        = !empty($fbUser['link']) ? $fbUser['link'] : 'https://www.facebook.com/';
            
            $this->session->set_userdata('fb_user_info', $userData);
            

            $cek = $this->auth->count_user($userData['email']);
            $data_email = $this->auth->cek_email($userData['email']);

            if ($cek > 0) {
                // jika berhasil simpan ke session
                $after_login = $this->session->flashdata('after_login');
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
                    // 'cek' => $password . " == " . $data_email->password,
                    'after_login' => $after_login
                );

                if ($sess['id_level'] != 0) {
                    $this->session->set_userdata('data_login', $sess);
                    $this->auth->update_last_login($sess['id']);
                    setcookie("user", $data_email->username, time() + 3600);

                    $this->db->update('tb_users', array('login_type' => 'google'), ['id_user' => $data_email->id_user]);

                    if ($lang == "jp") {
                        $this->session->set_flashdata('login_success', '<div class="alert alert-success" role="alert">ログイン成功</div>');
                    } else {
                        $this->session->set_flashdata('login_success', '<div class="alert alert-success" role="alert">Login Successfully</div>');
                    }
                    $this->session->keep_flashdata('data_checkout');
                    $this->session->keep_flashdata('after_login');
                    redirect($_SERVER['HTTP_REFERER']);
                    $msg_error = 'Tidak ada error, berhasil login';
                } else {

                    if ($lang == "jp") {
                        $this->session->set_flashdata('login_admin',
                            '<div class="alert alert-danger" role="alert">管理者アカウントでログインしてください</div>'
                        );
                    } else {
                        $this->session->set_flashdata('login_admin',
                            '<div class="alert alert-danger" role="alert">Please login with admin account</div>'
                        );
                    }
                    redirect(base_url('login'));
                    $msg_error = 'Please login with admin account';
                }

            } else {

                // Insert or update user data to the database 
                $userID = $this->Facebook_model->checkUser($userData);

                // Check user data insert or update status 
                if (!empty($userID)) {
                    $data_auth['userData'] = $userData;
                } else {
                    $data_auth['userData'] = array();
                }
            }

            // Facebook logout URL 
            $data_auth['logoutURL'] = $this->facebook->logout_url();
        } else {
            // Facebook authentication url 
            // $data_auth['authURL'] =  $this->facebook->login_url();
            header('Location: ' . filter_var($this->facebook->login_url(), FILTER_SANITIZE_URL));
        }

        $all_session = array(
            'data_login' => $this->session->userdata('data_login'),
            'fb_user_info' => $this->session->userdata('fb_user_info'),
            'cart_by_user' => $this->session->userdata('cart_by_user'),
            'data_checkout' => $this->session->flashdata('data_checkout'),
            'after_login' => $this->session->flashdata('after_login')
        );

        // https://developers.google.com/identity/protocols/oauth2/web-server#php_3
        $data = array('auth_url' => $data_auth['authURL'],
            'token' => $this->facebook->is_authenticated(),
            'data_auth' => $data_auth,
            // 'cek' => $cek,
            // 'msg_error' => $msg_error,
            // 'data_email' => $data_email,
            'check_picture' => (getimagesize('assets/images/users/blank.png')) ? getimagesize('assets/images/users/blank.png') : 'bukan',
            'all_session' => $all_session
        );

        // $head = 'Login | ' . NAMA_WEB;
        // $data = array('title' => $head);
        $this->load->view('auth/v_login', $data);
        // $this->output->set_content_type('application/json')->set_output(json_encode($data));
        
    }

    public function sign_in_fb()
    {
        // Load facebook oauth library 
        $this->load->library('facebook');
        $facebook_login_url = $this->facebook->create_auth_url(base_url('auth/with_facebook'));
        header('Location: ' . filter_var($facebook_login_url, FILTER_SANITIZE_URL));
        $flash = $this->session->flashdata('fb_flash');

        $data = array(
            'facebook_login_url' => $facebook_login_url,
            'flash' => $flash
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function with_facebook()
    {
        // Load facebook oauth library 
        $this->load->library('facebook');
        $code = $this->input->get('code');
        $obj_data = null;

        if ($code) {
            try {
                $helper = $this->facebook->create_helper();
                $access_token = $this->facebook->get_access_token();
                $obj_data['helper'] = $helper;
                $obj_data['access_token'] = $access_token;

                $this->facebook->set_access_token($access_token);
            } catch (Facebook\Exceptions\FacebookResponseException $e) {
                exit('Graph returned an error: ' . $e->getMessage());
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                exit('Facebook SDK returned an error: ' . $e->getMessage());
            }

            if (!isset($access_token)) {
                if ($helper->getError()) {
                    header('HTTP/1.0 401 Unauthorized');
                    echo "Error: " . $helper->getError() . "\n";
                    echo "Error Code: " . $helper->getErrorCode() . "\n";
                    echo "Error Reason: " . $helper->getErrorReason() . "\n";
                    echo "Error Description: " . $helper->getErrorDescription() . "\n";
                } else {
                    header('HTTP/1.0 400 Bad Request');
                    echo 'Bad request';
                }
                exit;
            }

            $user = $this->facebook->get_user();

            $obj_data['user'] = $user;

            $uid = $user['id'];
            $name = $user['name'];
            $email = $user['email'];
            $picture = $user['picture'];

            if ($this->Facebook_model->is_facebook_user_has_registered($uid)) {
                $this->session->set_flashdata('fb_flash', '<b>' . $name . '</b> sebelumnya sudah mendaftar menggunakan akun Facebook.<br>Silahkan login di halaman login menggunakan akun Facebook');
                // redirect(site_url('register'));
            } else {
                $picture_name = strtolower($name);
                $picture_name = str_replace(' ', '-', $picture_name);

                $ch = curl_init($picture['url']);
                $fp = fopen('./assets/users/' . $picture_name . '.jpeg', 'wb');
                curl_setopt($ch, CURLOPT_FILE, $fp);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_exec($ch);
                curl_close($ch);
                fclose($fp);

                $user_data = [
                    'oauth_provider' => 'facebook',
                    'oauth_uid' => $uid,
                    'email' => $email,
                    'name' => $name,
                    'profile_picture' => $picture_name . '.jpeg'
                ];

                $this->Facebook_model->register_new_user($user_data);

                $data = array('is_login' => TRUE, 'uid' => $uid);

                $this->session->set_userdata('login_data', $data);

                $this->session->set_flashdata('fb_flash', '<b>Berhasil!</b><br>Kamu berhasil mendaftar menggunakan akun Facebook. Selanjutnya, saat login silahkan gunakan tombol <b>Login with Facebook</b> dan tidak perlu memasukkan username / password');
                // redirect('dashboard');
                $obj_data['msg'] = 'Login success';
            }
        } else {
            // show_404();
            $this->output->set_status_header(404);
            $this->load->view('errors/404');
            
            $obj_data['msg'] = 'Error 404';
        }
        $obj_data['code'] = $code;
        $obj_data['facebook_login_url'] = $this->facebook->create_auth_url(base_url('auth/with_facebook'));
        $obj_data['login_data'] = $this->session->userdata('login_data');
        $data['data_fb'] = $obj_data;

        header('Location: ' . filter_var($obj_data['facebook_login_url'], FILTER_SANITIZE_URL));
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function login()
    {
        // https://www.codexworld.com/login-with-google-account-in-codeigniter/
        // https://www.mynotescode.com/form-login-google-php-mysql/
        // https://codingrakitan.blogspot.com/2021/03/cara-membuat-login-google-dengan.html

        $head = 'Login | ' . NAMA_WEB;
        $data = array('title' => $head);
        $this->load->view('auth/v_login', $data);
    }

    public function register()
    {
        $head = 'Register | '. NAMA_WEB;
        $data = array('title' => $head);
        $this->load->view('auth/v_register', $data);
    }

    public function forgot()
    {
        $head = 'Forgot Password | ' . NAMA_WEB;
        $data = array('title' => $head);
        $this->load->view('auth/v_forgot', $data);
    }

    public function check_forgot()
    {
        $lang = $this->session->userdata('language');
        $this->form_validation->set_rules('useremail', 'Email', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->forgot();
        } else {
            $email = $this->input->post("useremail");
            $cek = $this->auth->cek_email($email);
            
            if ($cek == null) {
                $this->session->set_flashdata('error_forgot', ($lang == 'jp') ? 
                'メールアドレスが登録されていません。 登録リンク<a href="' . base_url('register') . '">こちら</a>をクリックしてください' : 
                'Sorry your email is not registered. Please click the register link <a href="'.base_url('register').'">here</a>');
                
            } else {
                $get_code = $this->generateNumber(6);

                $data_token = array(
                    'token' => $get_code
                );
                $up = $this->auth->update_password($data_token, $cek->id_user);
                // $this->db->update('tb_users', $data_token, ['md5(id_user)' => $cek->id]);

                if ($up) {
                    // jika berhasil di update
                    // kirim email
                    $this->sendEmailForgot($email, md5($cek->id_user), $get_code, $cek);
                    $this->session->set_flashdata('success_forgot', ($lang == 'jp') ? 'リンクを送信しました。 メールを確認してください' : 'We have sent the link. Please check your email');
                } 
                // else {
                //     $this->session->set_flashdata('success_forgot', ($lang == 'jp') ? 'リンクを送信しました。 メールを確認してください' : 'We have sent the link. Please check your email');
                // }
                
                $data = array(
                    'hash_id' => md5($cek->id_user),
                    'data' => $cek,
                    'update' => $up
                );
                // $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }
            redirect('forgot', 'refresh');
        }
    }

    public function lockScreen()
    {
        $head = 'Lock Screen | '. NAMA_WEB;
        $data = array('title' => $head);
        $this->load->view('auth/v_lock_screen', $data);        
    }

    public function v_verify($params)
    {
        if ($params != null) {
            $split = explode("-", $params);
            $lang = $split[count($split) - 4];
            $id = $split[count($split) - 3];
            $code = $split[count($split) - 2];
            $email = $split[count($split) - 1];
            $data_user = $this->auth->cek_email($email);

            $head = 'Changes Password | ' . NAMA_WEB;
            $data = array(
                    'title' => $head,
                    'lang' => $lang,
                    'id' => $id,
                    'email' => $email,
                    'code' => $code,
                    // 'params' => $split,
                    'data_user' => $data_user,
                );
            // $this->load->view('auth/aktivasi/v_verify', $data);
            $this->load->view('auth/aktivasi/v_two_step_verify', $data);
        } else {

            $head = 'Changes Password | ' . NAMA_WEB;
            $data = array('title' => $head);
            $this->load->view('auth/aktivasi/v_expired', $data);
            // $this->load->view('auth/aktivasi/v_two_step_verify', $data);
        }

        // $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function hide_code_check($str)
    {
        $hide_code = $this->input->post('hide_code');
        $result = '';
        if ($str == $hide_code){
            $result = TRUE;
            // return TRUE;
        } else {
            $this->form_validation->set_message('hide_code_check', 'The {field} field you entered is incorrect');
            $result = FALSE;
            // return FALSE;
        }
        $x = array(
            'str' => $str,
            'hide' => $hide_code,
            'str_hide' => ($str == $hide_code),
            'result' => $result
        );
        // $this->output->set_content_type('application/json')->set_output(json_encode($x));
        return $result;
        
    }

    public function forgot_password($params = null){

        // $data_user = $this->session->userdata('data_login');
        if ($params == null) {
            $this->session->set_flashdata('forgot_error', 'Sorry an error occurred. Please enter the email below or reopen the email we sent and click on the link');
            redirect('forgot','refresh');
            // $this->v_verify($params);
            // $this->forgot();
        } else {
            $data_user = $this->auth->cek_email($this->input->post('hide_email'));

            $validation = $this->form_validation; //untuk menghemat penulisan kode

            $pinlogin_0 = $this->input->post('layout_pin_pinlogin_0');
            $pinlogin_1 = $this->input->post('layout_pin_pinlogin_1');
            $pinlogin_2 = $this->input->post('layout_pin_pinlogin_2');
            $pinlogin_3 = $this->input->post('layout_pin_pinlogin_3');
            $pinlogin_4 = $this->input->post('layout_pin_pinlogin_4');
            $pinlogin_5 = $this->input->post('layout_pin_pinlogin_5');
            $pinlogin = $pinlogin_0 . $pinlogin_1 . $pinlogin_2 . $pinlogin_3 . $pinlogin_4 . $pinlogin_5;

            // $hide_id_md5 = $this->input->post('hide_id_md5');
            // $hide_email = $this->input->post('hide_email');
            // $hide_code = $this->input->post('hide_code');
            // $hide_code_done = $this->input->post('hide_code_done');

            $forgot_pass = $this->input->post('forgot_pass');
            $confirm_password = $this->input->post('confirm_password');

            // $validation->set_rules('layout_pin_pinlogin_5', 'Digit code', 'required');
            $validation->set_rules('hide_code_done', 'Digit code', 'required|callback_hide_code_check');
            $validation->set_rules('forgot_pass', 'Password', 'required');
            $validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[forgot_pass]');

            if ($validation->run() == FALSE) {
                $this->session->set_flashdata('update_password', 'Updated password failed');
                $this->v_verify($params);
            } else {
                $awal = date_create($data_user->last_login); // bisa gunakan created_at atau last_login
                $current_time = date_create(); // tgl dn waktu skrng
                $diff  = date_diff($awal, $current_time);
                
                if ($data_user->token != 'Already verified' && $diff->days == 0) {
                    // jika akun blm di verifikasi dan selisih waktu tidak lebih dari 0 hari
                    $update_pass = array(
                        'password' => sha1($confirm_password),
                    );

                    $data['default'] = array(
                        'id_user' => $data_user->id_user,
                        'new' => $forgot_pass,
                        'confirm' => $confirm_password,
                        'pinlogin' => $pinlogin,
                        'update_pass' => $update_pass,
                    );
                    $data['sha1'] = array(
                        'new' => sha1($forgot_pass),
                        'confirm' => sha1($confirm_password),
                        'data_user' => $data_user,
                    );

                    if (sha1($forgot_pass) == sha1($confirm_password)) {
                        // jika password lama tidak sama dengan password baru, maka update disini
                        $this->auth->update_password($update_pass, $data_user->id_user);
                        $this->auth->changeActiveState(md5($data_user->id_user));
                        $this->session->set_flashdata('update_password_success', 'Password has been updated');
                    } else {
                        $this->session->set_flashdata('update_password_failed', 'Updated password failed');
                    }
                    $this->v_verify($params);
                    // redirect('forgot');
                } else {
                    $this->v_verify(null);
                }

                $data = array(
                    'created_at' => $awal,
                    'current_time' => $current_time,
                    'diff' => $diff,
                    'diff days' => $diff->days,
                    'data_user' => $data_user,
                );
                // $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }
        }
        
    }

    public function curl_del($path)
    {
        $url = "https://graph.facebook.com/" . $path;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        // $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $data = array('url' => $url, 'result' => json_decode($result));
        return $data;
    }
    
    public function logout()
    {
        $id_user = $this->session->userdata('data_login');
        $id = $id_user['id'];
        $login_type = $this->db->get_where('tb_users', ['id_user' => $id])->row('login_type');
        // $this->db->update('tb_users', array('login_type' => ''), ['id_user' => $id]);

        if ($login_type == 'fb') {
            // ========== session jika login with FB account ==========
            // Load facebook oauth library 
            // $this->load->library('facebook');
            // $this->facebook->destroy_session();
            // ========== End session jika login with FB account ==========

            $login_data = $this->session->userdata('login_data');
            $fb_user_info = $this->session->userdata('fb_user_info');
            $uid1 = ($login_data != null) ? $login_data['uid'] : null;
            $uid = ($uid1 == null && $fb_user_info != null) ? $fb_user_info['id_fb'] : '187039100474984';
            $app_token = '450661640542275|E3x0I5WlsGE67I-1r4Mt6VyuWQA';
            $getToken = ($login_data != null) ? $login_data['token'] : $app_token;

            // $result = $this->curl_del("v15.0/". $uid."/permissions?access_token=" . $getToken);
            $this->curl_del("v15.0/" . $uid . "/permissions?access_token=" . $getToken);

            $this->session->unset_userdata('fb_user_info');
            $this->session->unset_userdata('login_data');

        } else {
            // ========== session jika login with google account ==========
            $this->session->unset_userdata('google_access_token'); 
            $this->session->unset_userdata('google_user_info');        
            // ========== End session jika login with google account ==========
            // redirect(base_url('login'));
        }

        $this->session->unset_userdata('data_login');
        $this->session->unset_userdata('cart_by_user');
        $this->session->set_flashdata('logout1', 'Logout Successfull');
        $this->session->set_flashdata(
            'logout2',
            '<div class="alert alert-success" role="alert">Logout Successfull</div>'
        );
        // redirect($_SERVER['HTTP_REFERER']);
        redirect(base_url('login'));

        // $da = array(
        //     'data_login' => $id_user,
        //     'login_type' => $login_type,
        //     'login_data' => $this->session->userdata('login_data'),
        //     'fb_user_info' => $this->session->userdata('fb_user_info'),
        //     'uid1' => $uid1,
        //     'uid' => $uid,
        //     'getToken' => $getToken,
        //     // 'result' => $result
        // );
        // $this->output->set_content_type('application/json')->set_output(json_encode($da));
        

        return !$this->session->has_userdata('data_login');
        
    }

    public function log_off()
    {
        // $this->session->unset_userdata('data_login');
        $alert_boostrap = '
        <div class="alert alert-danger alert-dismissible fade show mt-3 mb-4" role="alert">
            Session has end, please login again
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';

        $toast =
        '<div aria-live="polite" aria-atomic="true">
            <div class="toast fade show align-items-center text-white bg-danger border-0 mb-4" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <strong>Session has end</strong>
                        <br/>
                        Please enter the password to unlock the lock screen
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>';

        $custom_toast = '<div class="toast fade show" role="alert" aria-live="assertive" data-bs-autohide="false" aria-atomic="true">
                                <div class="toast-header">
                                    <img src="assets/images/logo.svg" alt="" class="me-2" height="18">
                                    <strong class="me-auto">Skote</strong>
                                    <small class="text-muted">11 mins ago</small>
                                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                    Hello, world! This is a toast message.
                                </div>
                            </div>';

        $this->session->set_flashdata('message_logout', $toast);
        redirect(base_url('lock-screen'));
    }

    public function cek_login()
    {
        $this->load->library('form_validation');

        $rules = $this->auth->rules_login();
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $this->login();
        } else {
            $email = $this->input->post('email');
            $password = sha1($this->input->post('password'));

            $user = array(
                'email'         => $email,
                'password'      => $password
            );

            $cek = $this->auth->count_user($email);
            $data = $this->auth->cek_email($email);

            $my['user'] = $user;
            $my['data'] = $data;
            $my['cek'] = $cek;
            // $this->output->set_content_type('application/json')->set_output(json_encode($my));


            if ($cek > 0) {

                if ($password != $data->password) {

                    $sess = array(
                        'id'       => $data->id_user,
                        'first_name' => $data->first_name,
                        'last_name' => $data->last_name,
                        'email'    => $data->email,
                        'username' => $data->username,
                        'password' => $data->password,
                        'photo_profil' => $data->profile_picture,
                        'id_level' => $data->id_level,
                        'status' => $data->status,
                        'cek' => $password . " != " . $data->password
                    );
                    $this->session->set_flashdata('login_failed', 'Email or Password you entered is incorrect');
                    redirect('login');
                } else {

                    $after_login = $this->session->flashdata('after_login');
                    $sess = array(
                        'id'       => $data->id_user,
                        'first_name' => $data->first_name,
                        'last_name' => $data->last_name,
                        'email'    => $data->email,
                        'username' => $data->username,
                        'password' => $data->password,
                        'photo_profil' => $data->profile_picture,
                        'id_level' => $data->id_level,
                        'status' => $data->status,
                        // 'cek' => $password . " == " . $data->password,
                        'after_login' => $after_login
                    );

                    if ($sess['id_level'] != 0) {
                        $this->session->set_userdata('data_login', $sess);
                        $this->auth->update_last_login($sess['id']);
                        setcookie("user", $data->username, time() + 3600);

                        $this->db->update('tb_users', array('login_type' => 'default'), ['id_user' => $data->id_user]);

                        $this->session->set_flashdata('login_success', '<div class="alert alert-success" role="alert">Login Successfull</div>');
                        // redirect('user');

                        // if ($data->status == 0) {
                        //     redirect('user/setting');
                        // } else {
                        //     redirect('user');
                        // }

                        $this->session->keep_flashdata('data_checkout');
                        $this->session->keep_flashdata('after_login');
                        // redirect(`{$this->session->flashdata('after_login')}`);
                        // if ($this->session->flashdata('after_login')) {
                        // } else {
                        // }
                        // redirect('home');
                        redirect($_SERVER['HTTP_REFERER']);

                    } else {
                        $this->session->set_flashdata('login_admin', '<div class="alert alert-danger" role="alert">
                    Please login with admin account </div>');
                        redirect(base_url('login'));
                    }
                }

                // $sess = $data;

                // if ($sess['after_login'] != null || empty($sess['after_login'])) {
                    
                //     redirect($sess['after_login']);
                    
                //     // $this->output->set_content_type('application/json')->set_output(json_encode($sess['after_login']));
                // } else {
                //     if ($sess['id_level'] != 0){
                //         redirect('home');                        
                //     }
                //     // $this->output->set_content_type('application/json')->set_output(json_encode($sess));
                // }

            } else {

                $this->output->set_content_type('application/json')->set_output(json_encode($my));
                // $this->session->set_flashdata('gagal', 'Email is not registered, please contact Harga Pedia for registration');
                $this->session->set_flashdata('gagal', 'Email is not registered, please register now');
                redirect('login');
            }

            $all_session = array(
                'data_login' => $this->session->userdata('data_login'),
                'cart_by_user' => $this->session->userdata('cart_by_user'),
                'data_checkout' => $this->session->flashdata('data_checkout'),
                'after_login' => $this->session->flashdata('after_login')
            );

            $my_data = array(
                    'session_token' => ($this->session->userdata('google_access_token') ? json_decode($this->session->userdata('google_access_token')) : "Yahh session juga kosong"),
                    'cek' => $cek,
                    'data' => $data,
                    'sess' => $sess,
                    'all_session' => $all_session
                );
            // $this->output->set_content_type('application/json')->set_output(json_encode($my_data));
            
        }
    }

    public function cek_register_with_cpanel()
    {
        // $this->load->library('form_validation');

        $rules = $this->auth->rules_register();
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $this->register();
        } else {

            $username = $this->input->post('username');
            $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
            $email = $this->input->post('email');
            $pass = $this->input->post('password');
            $password = (empty($pass) || $pass == null) ? "kosong" : sha1($pass);
            // $password = sha1($this->input->post('password'));

            $user = array(
                // 'username'      => $username,
                // 'first_name'    => $first_name,
                // 'last_name'     => $last_name,
                'email'         => $email,
                'password'      => $password
            );

            $cek = $this->auth->count_user($email);
            $data = $this->auth->cek_email($email);
            $data_username = $this->auth->cek_user_email($username);

            $my['user'] = $user;
            $my['data_email'] = $data;
            $my['data_username'] = $data_username;
            $my['cek'] = $cek;
            $get_token = $this->generateToken(28)['result_token'];
            $my['get_token'] = $get_token;

            if ($data != null) {
                # jika email sudah terdaftar
                $this->session->set_flashdata(
                    'login_failed',
                    'Email yang anda masukan sudah terdaftar'
                );
                $my['cek_email'] = "Email sudah ada";
                redirect('register');
            } else if ($data_username != null) {
                # jika username sudah terdaftar
                $this->session->set_flashdata(
                    'login_failed',
                    'Username yang anda masukan sudah terdaftar'
                );                
                $my['cek_email'] = "Username sudah ada";
                redirect('register');
            } else if ($cek > 0) {
                # jika user sudah terdaftar
                // $this->session->set_flashdata('login_failed', 'Username or Email you entered is already registered');
                $this->session->set_flashdata('login_failed', 'Email yang anda masukan sudah terdaftar');
                $my['cek_email'] = "User sudah terdaftar";
                redirect('register');
            } else {
                # jika user belum terdaftar
                $user_register = array(
                    'token'         => $get_token,
                    'active'        => 0,
                    'username'      => $username,
                    'first_name'    => $first_name,
                    'last_name'     => $last_name,
                    'email'         => $email,
                    'password'      => $password,
                    'profile_picture' => 'assets/images/users/blank.png',
                    'id_level'      => 2,
                    'status'        => 0,
                    'last_login'    => date("Y-m-d H:i:s"),
                );
                // $this->db->insert('tb_users', $user_register);

                //enkripsi id
                $id_user = $this->auth->add_user($user_register);

                // $id_user = 1; // dummy
                $send_email = $this->sendEmailRegister($email, md5($id_user), $user_register);


                $x['id'] = $id_user;
                $x['md5 id'] = md5($id_user);
                $x['send_email'] = $send_email;
                $x['data'] = $user_register;
                // $this->output->set_content_type('application/json')->set_output(json_encode($x));

                if ($send_email['send']) {
                    $this->session->set_flashdata('register_success', 'Silahkan cek email anda untuk verifikasi akun');
                } else {
                    $this->session->set_flashdata('login_failed', $send_email['hasil']);
                }
                redirect('register');
            }

            // $language = $this->session->userdata('language');
            // $my['lang'] = $language;
            // $this->output->set_content_type('application/json')->set_output(json_encode($my));

        }
    }

    public function mm()
    {
        $get_token = $this->generateToken(28)['result_token'];
        $user_register = array(
            'token'         => $get_token,
            'active'        => 0,
            'username'      => 'dummy',
            'first_name'    => 'dum',
            'last_name'     => 'my',
            'email'         => 'dummy@gmail.com',
            'password'      => 123,
            'profile_picture' => 'assets/images/users/blank.png',
            'id_level'      => 2,
            'status'        => 0,
            'last_login'    => date("Y-m-d H:i:s"),
        );
        $this->cm("dummy@mail.com", 123, $user_register);
    }

    public function cm($email, $encrypted_id, $data_email){
        $language = $this->session->userdata('language');
        $gabung = $encrypted_id . "__" . $language;
        $data = array(
            "lang" => $language,
            "id" => $encrypted_id,
            "email" => $email,
            "id_lang" => $gabung,
            "data_email" => $data_email
        );
        
        // print_r($data);
        // die;
        $this->load->view('auth/aktivasi/v_mail_verify', $data);
        // $this->output->set_content_type('application/json')->set_output(json_encode($data));
        
    }

    public function cek_register()
    {
        // $this->load->library('form_validation');

        $rules = $this->auth->rules_register();
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $this->register();
        } else {

            // $username = $this->input->post('username');
            // $first_name = $this->input->post('first_name');
            // $last_name = $this->input->post('last_name');
            // $email = $this->input->post('email');
            // $pass = $this->input->post('password');
            // $password = (empty($pass) || $pass == null) ? "kosong" : sha1($pass);
            // // $password = sha1($this->input->post('password'));

            // $user = array(
            //     // 'username'      => $username,
            //     // 'first_name'    => $first_name,
            //     // 'last_name'     => $last_name,
            //     'email'         => $email,
            //     'password'      => $password
            // );

            // $cek = $this->auth->count_user($email);
            // $data = $this->auth->cek_email($email);
            // $data_username = $this->auth->cek_user_email($username);

            // $my['user'] = $user;
            // $my['data_email'] = $data;
            // $my['data_username'] = $data_username;
            // $my['cek'] = $cek;


            // if ($data != null) {
            //     # jika email sudah terdaftar
            //     $this->session->set_flashdata(
            //         'login_failed',
            //         'Email yang anda masukan sudah terdaftar'
            //     );
            //     $my['cek_email'] = "Email sudah ada";
            //     redirect('tab/register');

            // } else if ($data_username != null) {
            //     # jika username sudah terdaftar
            //     $this->session->set_flashdata(
            //         'login_failed',
            //         'Username yang anda masukan sudah terdaftar'
            //     );
            //     $my['cek_email'] = "Username sudah ada";
            //     redirect('tab/register');

            // } else if($cek > 0) {
            //     # jika user sudah terdaftar
            //     $this->session->set_flashdata('login_failed', 'Username or Email you entered is already registered');
            //     redirect('tab/register');

            // } else {
            //     # jika user belum terdaftar
            //     $user_register = array(
            //         'active'        => 0,
            //         'username'      => $username,
            //         'first_name'    => $first_name,
            //         'last_name'     => $last_name,
            //         'email'         => $email,
            //         'password'      => $password,
            //         'profile_picture'=> 'upload/users/blank.png',
            //         'id_level'      => 2,
            //         'status'        => 0,
            //         'last_login'    => date("Y-m-d H:i:s"),
            //     );
            //     // $this->db->insert('tb_users', $user_register);

            //     //enkripsi id
            //     $id_user = $this->auth->add_user($user_register);
            //     $send_email = $this->send_email($email, md5($id_user));
            //     // $this->auth->add_user($user_register);

            //     $x['id'] = $id_user;
            //     $x['md5 id'] = md5($id_user);
            //     $x['send_email'] = $send_email;
            //     $x['data'] = $user_register;
            //     $this->output->set_content_type('application/json')->set_output(json_encode($x));


            //     // $this->session->set_flashdata('login_failed', 'Akun berhasil terdaftar!');
            //     // redirect('tab/login');
            // }

            // Please specify your Mail Server - Example: mail.example.com.
            ini_set("SMTP", "smtp.gmail.com");

            // Please specify an SMTP Number 25 and 8889 are valid SMTP Ports.
            ini_set("smtp_port", "8889");

            // Please specify the return address to use
            ini_set('sendmail_from', 'dilfadillah97@gmail.com');

            $to      = 'achmadfadillah97@gmail.com';
            $id_user = 1;

            $send_email = $this->send_email($to, md5($id_user));
            if ($send_email) {
                $x['send_email'] = $send_email;
                $this->output->set_content_type('application/json')->set_output(json_encode($x));
            } else {
                $x['send_email'] = $send_email;
                $this->output->set_content_type('application/json')->set_output(json_encode($x));
            }
            // $this->output->set_content_type('application/json')->set_output(json_encode($my));
        }
    }

    public function sendEmailRegister($email, $encrypted_id, $data_email)
    {

        $config['protocol']    = 'smtp';
        $config['smtp_host']    = 'ssl://smtp.googlemail.com';
        $config['smtp_port']    = '465';
        // $config['smtp_port']    = '587';
        $config['smtp_timeout'] = '400';
        $config['smtp_user']    = 'achmadfadillah97@gmail.com';
        $config['smtp_pass']    = 'bpselyxhnuotdtmf'; // bpselyxhnuotdtmf
        $config['charset']    = 'UTF-8'; // iso-8859-1
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html';
        $config['wordwrap'] = FALSE;

        $this->load->library('email', $config);
        $this->email->initialize($config);

        $language = $this->session->userdata('language');
        $this->email->from('info@asiaresearchinstitute.com', 'Asia Research Institute');
        $this->email->to($email);
        if ($language == 'jp') {
            $this->email->subject('アカウントの確認');
        } else {
            $this->email->subject('Account verification');
        }

        $gabung = $encrypted_id."_".$language;
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

    public function sendEmailForgot($email, $encrypted_id, $code, $data_email)
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
        $this->email->from('info@asiaresearchinstitute.com', NAMA_PANJANG_WEB_EN);
        $this->email->to($email);
        if ($language == 'jp') {
            $this->email->subject('パスワードをお忘れですか');
        } else {
            $this->email->subject('Forgot password');
        }

        $gabung = $language."-". $encrypted_id."-".$code."-".$email;
        // $gabung = $encrypted_id;
        $data = array(
            "lang" => $language,
            "id" => $encrypted_id,
            "id_user" => md5($encrypted_id),
            "email" => $email,
            "code" => $code,
            "id_lang" => $gabung,
            "data_email" => $data_email
        );
        
        $this->session->set_userdata('email_forgot', $data);        

        $this->email->message($this->load->view('auth/aktivasi/v_mail_forgot', $data, true));
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

    public function send_email($email, $encrypted_id)
    {

        $config['protocol']    = 'mail';
        $config['smtp_host']    = 'ssl://hargapedia.id';
        $config['smtp_port']    = '465';
        $config['smtp_timeout'] = '400';
        $config['smtp_user']    = 'smtp@hargapedia.id';
        $config['smtp_pass']    = 'w]6(hG$#J*[s';
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html';
        $config['validation'] = FALSE;
        //memanggil library email dan set konfigurasi untuk pengiriman email

        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->from('info@hargapedia.id', 'Harga Pedia');
        $this->email->to($email);
        // $this->email->subject("Verifikasi Akun");
        // $this->email->message(
        //     'Terima Kasih telah melakuan registrasi, untuk memverifikasi silahkan klik tautan dibawah ini<br><br>'.
        //     '<a href="'. site_url("tab/verification/$encrypted_id") .'" class="text-primary">
        //         Aktivasi Sekarang
        //     </a>'
        // );
        $this->email->set_newline("\r\n");

        $lang = "en";
        if ($lang == "en") {
            $gabung = $encrypted_id . "__" . $lang;
            $this->email->subject("Account Verification");
            $this->email->message(
                "Thank you for registering, to verify your account, please click the link below<br><br>" .
                '<a href="' . site_url("tab/verification/$gabung") . '" class="text-primary">
                    Activate Now
                </a>'
            );
        } else {
            $gabung = $encrypted_id . "__" . $lang;
            $this->email->subject("Verifikasi Akun");
            $this->email->message(
                "Terima Kasih telah melakuan registrasi, untuk memverifikasi silahkan klik tautan dibawah ini<br><br>" .
                '<a href="' . site_url("tab/verification/$gabung") . '" class="text-primary">
                    Aktivasi Sekarang
                </a>'
            );
        }

        if ($this->email->send()) {
            $this->session->set_flashdata('aktivasi', 'Successfully registered, please check your email');
            return true;
        } else {
            $this->session->set_flashdata('aktivasi_gagal', 'Successfully registered, but failed to send email verification');
            return false;
        }
    }

    public function verification($key)
    {
        $this->load->helper('url');

        $id = explode("_", $key);
        $ok = $this->auth->changeActiveState($id[0]);

        $this->db->select("*");
        $this->db->where('md5(id_user)', $id[0]);
        $id_user = $this->db->get('tb_users')->row();

        $lang = $id[1];

        $data['lng'] = $lang;
        $data['data'] = array(
            'id' => $id,
            'change' => $ok,
            'data_user' => $id_user
        );

        $this->load->view('auth/aktivasi/v_confirm_email', $data);
    }

    public function vactive($key = null)
    {
        $id = $this->auth->get_user_by_md5($key['id'])->row();
        $data['key_data'] = $key;
        $data['msg'] = $key['msg'];
        $data['pesan'] = $key['pesan'];
        $data['data_user'] = $id;
        $this->load->view('tableau/aktivasi/v_aktivasi', $data);
    }

    public function active()
    {
        // $encrypted_id = md5(1);
        // $email = "achmadfadillah97@gmail.com";

        $input_params = $this->input->get(); // this will give you all parameters
        if (empty($input_params)) {
            $this->output->set_status_header('404');
            redirect('404');
        } else {

            $id = $input_params['y'];
            // $encrypted_id = md5($id);
            // $email = $input_params['z'];

            $cek_id = $this->auth->get_user_by_md5($id)->num_rows();

            if ($cek_id == 0) {
                // tampilkan kesalahan id_user tidak ada di db

                $gagal = "Maaf terjadi kesalahan data tidak ditemukan.";
                $join = array('cek_id' => '', 'id' => '', 'email' => '', 'msg' => 'gagal', 'pesan' => $gagal);
                $this->vactive($join);
            } else {

                $encrypted_id = $input_params['y'];
                $my_lang = $input_params['lng'];
                $email = $this->auth->get_user_by_md5($id)->row('email');

                $this->load->library('email');

                $config['protocol']    = 'mail';
                $config['smtp_host']    = 'ssl://hargapedia.id';
                $config['smtp_port']    = '465';
                $config['smtp_timeout'] = '400';
                $config['smtp_user']    = 'smtp@hargapedia.id';
                $config['smtp_pass']    = 'w]6(hG$#J*[s';
                $config['charset']    = 'utf-8';
                $config['newline']    = "\r\n";
                $config['mailtype'] = 'html';
                $config['validation'] = FALSE;
                //memanggil library email dan set konfigurasi untuk pengiriman email

                $this->email->initialize($config);
                $this->email->from('info@hargapedia.id', 'Harga Pedia');
                $this->email->to($email);
                if ($my_lang == "en") {
                    $this->email->subject("Account Verification");
                    $gabung = $encrypted_id . "__" . $my_lang;
                    $this->email->message(
                        "Thank you for registering, to verify please click the link below<br><br>" .
                        '<a href="' . site_url("tab/verification/$gabung") . '" class="text-primary">
                            Activate Now
                        </a>'
                    );

                    $berhasil = "Email sent successfully. <br/>Please check your email for account verification";
                    $gagal = "Sorry, an error occurred while sending the email verification. <br/>Please try again later";
                } else {
                    $gabung = $encrypted_id . "__" . $my_lang;
                    $this->email->subject("Verifikasi Akun");
                    $this->email->message(
                        "Terima Kasih telah melakuan registrasi, untuk memverifikasi silahkan klik tautan dibawah ini<br><br>" .
                        '<a href="' . site_url("tab/verification/$gabung") . '" class="text-primary">
                            Aktivasi Sekarang
                        </a>'
                    );

                    $berhasil = "Email berhasil dikirim. <br/>Silahkan cek email kamu untuk verifikasi akun";
                    $gagal = "Maaf terjadi kesalahan saat mengirim verifikasi email. <br/>Silahkan coba lagi nanti";
                }

                $this->email->set_newline("\r\n");

                // $join = array('cek_id' => $cek_id, 'id' => $id, 'email' => $email, 'msg' => 'berhasil', 'pesan' => $berhasil);
                // $this->vactive($join);

                if ($this->email->send()) {
                    $join = array('id' => $id, 'email' => $email, 'msg' => 'berhasil', 'pesan' => $berhasil);
                    $this->vactive($join);
                } else {
                    $join = array('id' => $id, 'email' => $email, 'msg' => 'gagal', 'pesan' => $gagal);
                    $this->vactive($join);
                }
            }
        }
    }

    public function cek_lock_screen()
    {
        $this->load->library('form_validation');

        $rules = $this->auth->rules_login();
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $this->lockScreen();
        } else {
            $email = $this->input->post('email');
            $password = sha1($this->input->post('password'));

            $user = array(
                'email'         => $email,
                'password'      => $password
            );

            $cek = $this->auth->count_user($email);
            $data = $this->auth->cek_email($email);

            $my['user'] = $user;
            $my['data'] = $data;
            $my['cek'] = $cek;
            // $this->output->set_content_type('application/json')->set_output(json_encode($my));


            if ($cek > 0) {

                if ($password != $data->password) {

                    $sess = array(
                        'id'       => $data->id_user,
                        'first_name' => $data->first_name,
                        'last_name' => $data->last_name,
                        'email'    => $data->email,
                        'username' => $data->username,
                        'password' => $data->password,
                        'photo_profil' => $data->profile_picture,
                        'id_level' => $data->id_level,
                        'status' => $data->status,
                        'cek' => $password . " != " . $data->password
                    );
                    $this->session->set_flashdata('login_failed', 'Password you entered is incorrect');
                    redirect('lock-screen');
                } else {

                    $sess = array(
                        'id'       => $data->id_user,
                        'first_name' => $data->first_name,
                        'last_name' => $data->last_name,
                        'email'    => $data->email,
                        'username' => $data->username,
                        'password' => $data->password,
                        'photo_profil' => $data->profile_picture,
                        'id_level' => $data->id_level,
                        'status' => $data->status,
                        'cek' => $password . " == " . $data->password
                    );

                    if ($sess['id_level'] != 0) {
                        $this->session->set_userdata('data_login', $sess);
                        $this->auth->update_last_login($sess['id']);
                        setcookie("user", $data->username, time() + 3600);

                        $this->session->set_flashdata('login_success', '<div class="alert alert-success" role="alert">
                    Login Successfull</div>');
                        // redirect('user');

                        // if ($data->status == 0) {
                        //     redirect('user/setting');
                        // } else {
                        //     redirect('user');
                        // }

                        $this->session->keep_flashdata('data_checkout');
                        if ($this->session->flashdata('after_login')) {
                            redirect($this->session->flashdata('after_login'));
                        } else {
                            redirect('home');
                        }
                    } else {
                        $this->session->set_flashdata('login_admin', '<div class="alert alert-danger" role="alert">
                    Please login with admin account </div>');
                        redirect(base_url('lock-screen'));
                    }
                }

                // $sess = $data;

                $this->output->set_content_type('application/json')->set_output(json_encode($sess));
            } else {

                $this->output->set_content_type('application/json')->set_output(json_encode($my));
                // $this->session->set_flashdata('gagal', 'Email is not registered, please contact Harga Pedia for registration');
                $this->session->set_flashdata('gagal', 'Email is not registered, please register now');
                redirect('lock-screen');
            }
        }
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
        $uniqid = uniqid().uniqid();

        $result = array(
            'uniq_id' => $uniqid,
            'random_string' => $random_string,
            'result_token' => $result_token,
        );
        return $result;
        // $this->output->set_content_type('application/json')->set_output(json_encode($result));
        
    }

    public function generateNumber($max)
    {
        // https://code.tutsplus.com/tutorials/generate-random-alphanumeric-strings-in-php--cms-32132
        $alphanumeric = '0123456789';
        $result_token = '';
        $random_string = '';
        for ($i = 0; $i < $max; $i++) {
            $random_character = $alphanumeric[mt_rand(0, $max - 1)];
            $random_string .= $random_character;
        }
        
        $result_token = substr(str_shuffle($alphanumeric), 0, $max);
        // $uniqid = uniqid().uniqid();

        // $result = array(
        //     'uniq_id' => $uniqid,
        //     'random_string' => $random_string,
        //     'result_token' => $result_token,
        // );
        return $result_token;
        // $this->output->set_content_type('application/json')->set_output(json_encode($result));
        
    }

}
