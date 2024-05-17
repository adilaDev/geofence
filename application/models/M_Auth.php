<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class M_Auth extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function rules_login()
    {
        return [
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required'
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|max_length[255]'
            ],
            // [
            //     'field' => 'captcha_login',
            //     'label' => 'Captcha',
            //     'rules' => 'required'
            // ],
        ];
    }

    public function rules_forgot()
    {
        return [
            [
                'field' => 'forgot_email',
                'label' => 'Email',
                'rules' => 'required'
            ]
        ];
    }

    public function rules_register()
    {
        return [
            [
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required'
            ],
            [
                'field' => 'first_name',
                'label' => 'First Name',
                'rules' => 'required'
            ],
            [
                'field' => 'last_name',
                'label' => 'Last Name',
                'rules' => 'required'
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required'
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|max_length[255]'
            ]
        ];
    }

    public function current_user()
    {
        if (!$this->session->has_userdata("data_login")) {
            return null;
        }

        $user_id = $this->session->userdata("data_login")['id'];
        $query = $this->db->get_where("tb_users", ['id_user' => $user_id]);
        return $query->row();
    }

    public function cek_email($email)
    {
        $this->db->select("*");
        $this->db->where('email', $email);
        $data_user =  $this->db->get('tb_users')->row();
        return $data_user;
    }

    public function cek_user_email($username)
    {
        $this->db->select("*");
        // $this->db->where('email', $email);
        $this->db->where('username', $username);
        $data_user =  $this->db->get('tb_users')->row();
        return $data_user;
    }

    public function count_user($data)
    {
        $this->db->select("*");
        $this->db->where('email', $data);
        $cek  = $this->db->get('tb_users')->num_rows();
        return $cek;
    }

    public function update_last_login($id)
    {
        $data = [
            'last_login' => date("Y-m-d H:i:s"),
        ];
        // $this->db->where('id_user', $id);

        return $this->db->update('tb_users', $data, ['id_user' => $id]);
    }

    public function get_user_by_userdata($id)
    {
        $this->db->select("id_user as id, first_name, last_name, email, username, password, profile_picture as photo_profil, id_level, status, last_login as after_login");
        $this->db->where('id_user', $id);
        return $this->db->get('tb_users');
    }

    public function get_user_by_id($id)
    {
        $this->db->select("*");
        $this->db->where('id_user', $id);
        // $cek  = $this->db->get_where('tb_users', $id);
        return $this->db->get('tb_users');
    }

    public function get_user_by_md5($id)
    {
        $this->db->select("*");
        $this->db->where('md5(id_user)', $id);
        // return $this->db->get('tb_users')->num_rows();
        return $this->db->get('tb_users');
    }

    public function update_password($data, $id)
    {
        return $this->db->update('tb_users', $data, ['id_user' => $id]);
    }

    public function changePassword($old_password, $new_password) {
        // Lakukan verifikasi old password (sesuai dengan struktur database Anda)
        $id_user = $this->session->userdata('data_login')['id'];
        $db_old_password = $this->db->get_where('tb_users', ['id_user' => $id_user])->row()->password;
        
        // Password lama cocok, lanjutkan dengan menyimpan password baru
        $old_password_hash = sha1($old_password);
        $new_password_hash = sha1($new_password);
        $data = ['password' => $new_password_hash];
        $verify = ($old_password_hash === $db_old_password);

        if ($verify) {
            // Password lama cocok, lanjutkan dengan menyimpan password baru
            $this->db->where('id_user', $id_user);
            $this->db->update('tb_users', $data);
        }

        $result = array(
            'verify' => $verify,
            'old_password_db' => $db_old_password,
            'old_password' => $old_password,
            'old_password_hash' => $old_password_hash,
            'new_password' => $new_password,
            'new_password_hash' => $new_password_hash,
            'data' => $data,
        );
        return $result;

    }

    public function add_user($user_register)
    {
        $this->load->database();
        $this->db->insert('tb_users', $user_register);
        $insertId = $this->db->insert_id();
        return $insertId;
    }

    public function changeActiveState($key)
    {
        $this->load->database();
        $data = array(
            'token' => 'Already verified',
            'active' => 1
        );

        $this->db->where('md5(id_user)', $key);
        $this->db->update('tb_users', $data);

        return true;
    }

    public function send_email($email, $encrypted_id, $lang)
    {
        $this->load->library('email');
        $config = array();
        $config['charset'] = 'utf-8';
        $config['useragent'] = 'Codeigniter';
        $config['protocol'] = "smtp";
        $config['mailtype'] = "html";
        $config['smtp_host'] = "ssl://smtp.gmail.com"; //pengaturan smtp
        $config['smtp_port'] = "465";
        $config['smtp_timeout'] = "400";
        $config['smtp_user']    = 'smtp@asiaresearchinstitute.com';
        $config['smtp_pass']    = '(WO6fz)t##;]';
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;
        //memanggil library email dan set konfigurasi untuk pengiriman email

        $this->email->initialize($config);
        //konfigurasi pengiriman
        $this->email->from($config['smtp_user']);
        $this->email->to($email);
        if ($lang == "en") {
            $this->email->subject("Account Verification");
            $this->email->message(
                "Thank you for registering, to verify your account, please click the link below<br><br>" .
                    site_url("tab/verification/$encrypted_id")
            );
        } else {
            $this->email->subject("Verifikasi Akun");
            $this->email->message(
                "Terima Kasih telah melakuan registrasi, untuk memverifikasi silahkan klik tautan dibawah ini<br><br>" .
                    site_url("tab/verification/$encrypted_id")
            );
        }


        if ($this->email->send()) {
            $this->session->set_flashdata('aktivasi', 'Berhasil melakukan registrasi, silahkan cek email kamu');
            return true;
        } else {
            $this->session->set_flashdata('aktivasi', 'Berhasil melakukan registrasi, namun gagal mengirim verifikasi email');
            return false;
        }
    }
    
    public function sendEmailViaCpanel($email, $data)
    {

        $config['protocol']    = 'mail';
        $config['smtp_host']    = 'ssl://asiaresearchinstitute.com';
        $config['smtp_port']    = '465';
        $config['smtp_timeout'] = '400';
        $config['smtp_user']    = 'smtp@asiaresearchinstitute.com';
        $config['smtp_pass']    = '(WO6fz)t##;]';
        $config['charset']    = 'iso-8859-1';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html';
        $config['wordwrap'] = FALSE;

        $this->load->library('email', $config);
        $this->email->from('info@asiaresearchinstitute.com', 'Asia Research Institute');
        $this->email->to($email);
        $this->email->subject('Request Quotation');
        $this->email->message($this->load->view('email/info_payment', $data['data_email'], true));
        $this->email->set_newline("\r\n");

        $result['send'] = $this->email->send();
        if ($result['send']) {
            $result['hasil'] = 'Email berhasil dikirim ';
            $result['debug'] = $this->email->print_debugger();
        } else {
            $result['hasil'] = 'Email gagal dikirim ';
            $result['debug'] = $this->email->print_debugger();
        };
        $result['data_email'] = $data['data_email'];
        return $result;
    }
    
    public function sendEmailViaLocalhost($email, $data)
    {

        $config['protocol']    = 'smtp';
        $config['smtp_host']    = 'ssl://smtp.googlemail.com';
        $config['smtp_port']    = '465';
        $config['smtp_timeout'] = '400';
        $config['smtp_user']    = 'achmadfadillah97@gmail.com';
        $config['smtp_pass']    = 'bpselyxhnuotdtmf';
        $config['charset']    = 'iso-8859-1';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html';
        $config['wordwrap'] = FALSE;

        $this->load->library('email', $config);
        // $this->email->initialize($config);
        $this->email->from('achmadfadillah97@gmail.com', 'Asia Research Institute');
        $this->email->to($email);
        $this->email->subject('Test email via localhost');
        // $this->email->message('Cobaaaa Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor includidunt ut labore er dolore magna aliqua. Ut enim ad minim veniam.');
        // $this->email->message($this->load->view('email/v_mail_alert', $data['data_email'], true));
        // $this->email->message($this->load->view('email/info_payment', $data['data_email'], true). $this->load->view('email/v_mail_alert', $data['data_email'], true));
        $this->email->message($this->load->view('email/info_payment', $data['data_email'], true));
        $this->email->set_newline("\r\n");
        // $this->email->attach(base_url('upload/files/invoice_8_16_2022.pdf'));

        $result['send'] = $this->email->send();
        if ($result['send']) {
            $result['hasil'] = 'Email berhasil dikirim ';
            $result['debug'] = $this->email->print_debugger();
        } else {
            $result['hasil'] = 'Email gagal dikirim ';
            $result['debug'] = $this->email->print_debugger();
        };
        $result['data_email'] = $data['data_email'];
        return $result;
    }
    
}
