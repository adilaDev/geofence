<?php

class ModelClient extends CI_Model
{
    private $tb_free_users = 'tb_free_users';
    private $tb_free_geo = 'tb_free_geo_draw';

    // ========================================================
    // validasi free user
    // ========================================================
    public function generateToken($is_redirect = false) {
        $userToken = $this->session->userdata('user_token');

        // jika token tidak valid dan tidak ada di database
        if (!$this->isTokenValid($userToken)) {
            // Generate a unique token
            $token = bin2hex(random_bytes(16));
            
            // Mendapatkan informasi pengguna
            $ipAddress = $this->input->ip_address();
            $browserType = $this->input->user_agent();
            $cookies = $this->input->cookie();
    
            $data = array(
                'token' => $token,
                'ipAddress' => $ipAddress,
                'browserType' => $browserType,
                'cookies' => $cookies,
            );
    
            // Simpan informasi pengguna ke database
            $this->saveUserInfoToDatabase($token, $ipAddress, $browserType, $cookies);
    
    
            // Simpan token di session atau tempat penyimpanan lainnya
            $this->session->set_userdata('user_token', $token);
            $this->session->set_userdata('data_free_user', array(
                'token' => $token,
                'user_ip' => $ipAddress,
                'browser' => $browserType,
                'cookies' => json_encode($cookies),
            ));
    
            if ($is_redirect) {
                redirect('client','refresh');
            } else {
                // echo "Token generated: " . $token;
                $this->output($data);
            }
        }
    }

    private function saveUserInfoToDatabase($token, $ipAddress, $browserType, $cookies) {
        // Simpan informasi pengguna ke database sesuai kebutuhan
        // Contoh menggunakan CodeIgniter Active Record
        $data = array(
            'token' => $token,
            'ip_address' => $ipAddress,
            'browser' => $browserType,
            'cookies' => json_encode($cookies), // Simpan cookies sebagai JSON
            'created_at' => date('Y-m-d H:i:s')
        );

        $this->db->insert('tb_free_users', $data);
    }

    public function someProtectedAction($userToken = null) {
        // Mendapatkan token yang dikirim oleh pengguna
        // $userToken = $_GET('token');

        // Mendapatkan token dari session atau tempat penyimpanan lainnya
        $storedToken = $this->session->userdata('user_token');

        // Periksa apakah token sesuai
        if ($userToken != null && $userToken === $storedToken) {
            // Token valid, izinkan akses
            $status = "Access granted!";
        } else {
            // Token tidak valid, tolak akses
            $status = "Access denied!";
        }
        $this->output($status);
    }

    public function showUserInfo() {
        // Mendapatkan token yang dikirim oleh pengguna
        $userToken = $this->input->get('token');

        // Periksa apakah token sesuai
        if ($this->isTokenValid($userToken)) {
            // Token valid, ambil informasi pengguna dari database
            $userInfo = $this->getUserInfoFromDatabase($userToken);
            return $userInfo;
        } else {
            // Token tidak valid, tampilkan pesan error
            // echo "Invalid token.";
            return null;
        }
    }
    
    public function checkAndRetrieveUserInfo() {
        // Mendapatkan token yang dikirim oleh pengguna
        $userToken = $this->input->get('token');

        // Periksa apakah token sesuai
        if ($this->isTokenValid($userToken)) {
            // Token valid, ambil informasi pengguna dari database
            $userInfo = $this->getUserInfoFromDatabase($userToken);

            // Lakukan sesuatu dengan informasi pengguna
            print_r($userInfo);
        } else {
            // Token tidak valid, tolak akses
            echo "Invalid token.";
        }
    }

    public function isTokenValid($userToken) {
        // Mendapatkan token, IP address, dan cookies yang dikirim oleh pengguna
        $dataFreeUser = $this->session->userdata('data_free_user');
        $storedToken = $this->session->userdata('user_token');
        $storedIP = isset($dataFreeUser['user_ip']) ? $dataFreeUser['user_ip'] : ''; // Misalnya, IP disimpan di session
        $storedCookies = isset($dataFreeUser['cookies']) ? json_decode($dataFreeUser['cookies'], true) : '';

        // Mendapatkan token, IP address, dan cookies dari database
        $dbData = $this->getUserInfoFromDatabase($userToken);
        $dbToken = ($dbData) ? $dbData['token'] : NULL;
        $dbIP = ($dbData) ? $dbData['ip_address'] : NULL;
        $dbCookies = ($dbData) ? json_decode($dbData['cookies'], true) : NULL;

        // Validasi token, IP address, dan cookies
        $tokenValid = ($userToken === $storedToken) || ($userToken === $dbToken);
        $ipValid = ($storedIP === $dbIP);
        $cookiesValid = ($storedCookies == $dbCookies);

        // Return true hanya jika semua validasi berhasil
        return $tokenValid && $ipValid && $cookiesValid;
    }

    public function isTokenValidV1($userToken) {
        // Periksa apakah token sesuai dengan yang ada di session atau database
        $storedToken = $this->session->userdata('user_token');
        $dbToken = $this->getUserTokenFromDatabase($userToken);

        return ($userToken === $storedToken) || ($userToken === $dbToken);
    }

    public function getUserTokenFromDatabase($userToken) {
        // Dapatkan token pengguna dari database sesuai kebutuhan
        $query = $this->db->get_where($this->tb_free_users, array('token' => $userToken));
        $result = $query->row();

        return ($result) ? $result->token : NULL;
    }

    public function getUserInfoFromDatabase($userToken) {
        // Dapatkan informasi pengguna dari database sesuai kebutuhan
        $query = $this->db->get_where($this->tb_free_users, array('token' => $userToken));
        $result = $query->row_array();

        return $result;
    }
    // ========================================================
    // end validasi free user
    // ========================================================

    
    // ========================================================
    // geofence drawing
    // ========================================================
    public function getTokenUser(){
        $data_user = $this->session->userdata("user_token");
        return $data_user;
    }

    public function getAllData(){
        $token_user = $this->getTokenUser();
        if (isset($token_user) || !empty($token_user)) {
            $this->db->where('token_user', $token_user);
        }
        $this->db->group_by('polygon_name');
        $this->db->order_by('last_update', 'desc');
        return $this->db->get($this->tb_free_geo);
    }
    
    public function getDataBy($where, $withGroupBy = true){
        $token_user = $this->getTokenUser();
        if (isset($token_user) || !empty($token_user)) {
            $this->db->where('token_user', $token_user);
        }
        if ($withGroupBy) {
            $this->db->group_by('polygon_name');
        }
        $this->db->order_by('last_update', 'desc');
        return $this->db->get_where($this->tb_free_geo, $where);
    }

    public function getDataDownloadAll(){
        $token_user = $this->getTokenUser();
        if (isset($token_user) && empty($token_user)) {
            return [];
        }
        $this->db->select('id_drawing, token_user, polygon_name, link, last_update');
        $this->db->where('token_user', $token_user);
        $this->db->group_by('polygon_name');
        $this->db->order_by('last_update', 'desc');
        return $this->db->get($this->tb_free_geo);
    }

    public function addData($object){
        $this->db->insert($this->tb_free_geo, $object);
        // $this->removeDuplicateRows('polygon_name');
        return $this->getAllData()->result();
    }

    public function editData($id, $object){
        $this->db->where('id_drawing', $id);
        $this->db->update($this->tb_free_geo, $object);
    }

    public function deleteData($where){
        // $this->db->delete($this->tb_free_geo, ['id_drawing' => $id]);
        $this->db->delete($this->tb_free_geo, $where);
        return $this->getAllData()->result();
    }
    // ========================================================
    // end geofence drawing
    // ========================================================
    
    public function output($data){
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
}