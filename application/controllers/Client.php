<?php

class Client extends CI_Controller
{
    public $session;
    public $input;
    public $output;
    public $zip;

    public $client;
    public $db_draw;
    // public $m_geo;

    public function __construct()
    {
        parent::__construct();
        // Load Session Library
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url', 'form');
        $this->load->helper('language');
        $this->load->database();

        $this->load->library('zip');
        $this->load->model('ModelClient', 'client');
        $this->load->model('M_Drawing', 'db_draw');
        // $this->load->model('M_GeoDraw', 'm_geo');

        // $this->client = $this->clients;
    }

    public function index(){
        // Mendapatkan token yang dikirim oleh pengguna
        $userToken = $this->session->userdata('user_token');
        $data['userToken'] = $userToken;
        $data['isTokenValid'] = $this->client->isTokenValid($userToken);
        $data['user_info'] = "Invalid token.";
        
        $all_data = $this->client->getDataBy(['token_user' => $userToken], false)->result();
        // $data['list_all_geo'] = $this->client->getAllData()->result();
        $data['list_all_geo'] = $all_data;

        // Periksa apakah token sesuai
        if ($this->client->isTokenValid($userToken)) {
            // Token valid, ambil informasi pengguna dari database
            $userInfo = $this->client->getUserInfoFromDatabase($userToken);
            $data['user_info'] = $userInfo;
            $data_head['title'] = 'Free Users';

            $this->load->view('layout/header', $data_head);
            $this->load->view('layout/navbar');
            $this->load->view('free/v_free_home', $data);
            $this->load->view('layout/footer');
        } else {
            $this->client->generateToken(true);
        }
        
        // $this->output($data);
    }

    public function map(){
        $all_data = $this->db_draw->tb_drawing_get()->result();
        $data['all_data'] = $all_data;
        $data_head['title'] = 'Map';

        $this->load->view('layout/header', $data_head);
        $this->load->view('layout/navbar');
        $this->load->view('free/map/v_drawing', $data);
        $this->load->view('layout/footer');
    }

    public function view($poly_name){
        $all_data = $this->client->getDataBy(['polygon_name' => $poly_name], false)->result();
        $data['all_data'] = $all_data;
        $data_head['title'] = 'MapView';

        $this->load->view('layout/header', $data_head);
        $this->load->view('layout/navbar');
        $this->load->view('free/map/view_polygon', $data);
        $this->load->view('layout/footer');
        // $this->output($data);
    }

    public function edit($poly_name){
        $all_data = $this->client->getDataBy(['polygon_name' => $poly_name], false)->result();
        if (is_array($all_data) && count($all_data) == 0) {
            redirect('home','refresh');
        }
        $data['all_data'] = $all_data;
        $data_head['title'] = 'MapView';

        $this->load->view('layout/header', $data_head);
        $this->load->view('layout/navbar');
        $this->load->view('free/map/edit_polygon', $data);
        // $this->load->view('free/map/drawing_tools', $data);
        $this->load->view('layout/footer');
        // $this->output($data);
    }

    public function html(){
        $data['all_data'] = [];
        $data_head['title'] = 'Home';

        $this->load->view('layout/header', $data_head);
        $this->load->view('layout/navbar');
        // $this->load->view('free/map/html_popup', $data);
        $this->load->view('free/map/editor_datatable', $data);
        $this->load->view('layout/footer');
    }

    public function savePolygon(){
        // $id_user = $_POST['id_user'];
        // $polygon_name = $_POST['polygon_name'];
        // $feature_collection = ($_POST['feature_collection']);
        // // buat file geojson
        // $filename = $polygon_name.'.geojson';
        // $create_file = $this->createFile($filename, $feature_collection);
        // $link = base_url().$create_file['path'];

        // $data['insert'] = array(
        //     'id_user' => $id_user,
        //     'polygon_name' => $polygon_name,
        //     'feature_collection' => $feature_collection,
        //     'link' => $link,
        //     // 'create_file' => $create_file,
        // );
        // $data['after_insert'] = $this->client->addData($data['insert']);

        $json = file_get_contents('php://input');
        $data_origin = json_decode($json);
        // $data['origin'] = $data_origin;

        // foreach ($data_origin as $k => $v) {
        //     $polygon_name = $v->polygon_name;
        //     $feature_collection = $v->feature_collection;

        //     // buat file geojson
        //     $filename = $polygon_name.'.geojson';
        //     $create_file = $this->createFile($filename, $feature_collection);
        //     $link = base_url().$create_file['path'];
        //     $v->link = $link;

        //     $data['after_insert_'.$k] = $this->client->addData($v);
        // }

        $polygon_name = $data_origin->polygon_name;
        $feature_collection = $data_origin->feature_collection;
        // ubah jadi format json
        $list_fc = json_decode($feature_collection);
        $list_features = $list_fc->features;
        // tambahkan informasi filename kedalam properties
        for ($i=0; $i < count($list_features); $i++) { 
            $prop = $list_features[$i]->properties;
            $prop->filename = $polygon_name;
        }
        // kembalikan ke semula
        $feature_collection = json_encode($list_fc);
        $data_origin->feature_collection = $feature_collection;

        $filename = $polygon_name.'.geojson';
        $create_file = $this->createFile($filename, $feature_collection);
        $link = base_url().$create_file['path'];
        $data_origin->link = $link;

        $data['origin'] = $data_origin;
        $data['feature_collection'] = $feature_collection;
        $data['features'] = $list_fc;
        $data['after_insert'] = $this->client->addData($data_origin);
        $this->output($data);
    }

    public function updatePolygon($id){
        $json = file_get_contents('php://input');
        $data_origin = json_decode($json);
        // $data['origin'] = $data_origin;

        // foreach ($data_origin as $k => $v) {
        //     $polygon_name = $v->polygon_name;
        //     $feature_collection = $v->feature_collection;

        //     // buat file geojson
        //     $filename = $polygon_name.'.geojson';
        //     $create_file = $this->createFile($filename, $feature_collection);
        //     $link = base_url().$create_file['path'];
        //     $v->link = $link;

        //     $data['after_insert_'.$k] = $this->client->addData($v);
        // }

        $polygon_name = $data_origin->polygon_name;
        $feature_collection = $data_origin->feature_collection;
        
         // ubah jadi format json
        $list_fc = json_decode($feature_collection);
        $list_features = $list_fc->features;
        // tambahkan informasi filename kedalam properties
        for ($i=0; $i < count($list_features); $i++) { 
            $prop = $list_features[$i]->properties;
            $prop->filename = $polygon_name;
        }
        // kembalikan ke semula
        $feature_collection = json_encode($list_fc);
        $data_origin->feature_collection = $feature_collection;

        $filename = $polygon_name.'.geojson';
        $create_file = $this->createFile($filename, $feature_collection);
        $link = base_url().$create_file['path'];
        $data_origin->link = $link;

        $data['origin'] = $data_origin;
        $data['after_insert'] = $this->client->editData($id, $data_origin);
        $this->output($data);
    }

    public function downloadAll(){
        $files = $this->client->getDataDownloadAll()->result();
        
        // Direktori tempat menyimpan file sementara
        $tempDir = FCPATH . 'upload/temp/';
        $data['tempDir'] = $tempDir;

        // Membuat direktori temp jika belum ada
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }
        $data['list_files'] = $files;
        $data['zip'] = $this->zip;
        $data['list_zip'] = array();
        
        // Memproses file dan menambahkannya ke dalam ZIP
        foreach ($files as $file) {
            $tempFile = $tempDir . basename($file->link);
            file_put_contents($tempFile, file_get_contents($file->link));
            $r = $this->zip->read_file($tempFile);
            // Hapus file sementara setelah ditambahkan ke ZIP
            unlink($tempFile);
            
            // array_push($data['list_zip'], array('tempFile' => $tempFile, 'read' => $file));
        }

        $this->load->helper('array');
        $data_user = $this->session->userdata("data_login");
        $objDataUser = json_decode(json_encode($data_user));

        $fullname = $objDataUser->first_name.'_'.$objDataUser->last_name;
        $currentDate = date("d-M-Y_His");
        // $data['data_user'] = $data_user;
        // $data['fullname'] = $fullname;
        // $data['myObject'] = ($objDataUser);
        // $data['is_object'] = is_object($objDataUser);

        // // Nama file ZIP yang akan diunduh
        $zipFileName = $fullname.'_'.$currentDate.'.zip';

        // Membuat dan menyimpan file ZIP di server
        $this->zip->archive($zipFileName);

        // Mengirim file ZIP ke browser untuk diunduh
        $this->zip->download($zipFileName);
        $this->output($data);
    }

    public function savePolygonOld(){
        $data['all_post'] = $this->input->post();

        $id_polygon = $_POST['id_polygon'];
        $polygon_name = $_POST['polygon_name'];
        $source_name = $_POST['source_name'];
        $layer_name = $_POST['layer_name'];
        $features = ($_POST['features']);
        $feature_collection = ($_POST['feature_collection']);

        $filename = $polygon_name.'.geojson';
        $create_file = $this->createFile($filename, $feature_collection);
        $data['create_file'] = $create_file;

        $link = base_url().$create_file['path'];

        // prepare to insert db
        $check_name = $this->db_draw->tb_drawing_check_name($polygon_name);
        $data['check_name'] = $check_name;
        $data_insert = $this->db_draw->tb_drawing_data_insert($id_polygon, $polygon_name, $source_name, $layer_name, $link, $features, $feature_collection);
        $data['data_insert'] = $data_insert;

        // insert ke db
        $save = $this->db_draw->tb_drawing_save(null)->result();
        $data['save'] = $save;

        // $data['save&download'] = $this->saveAndDownloadShapefile();
        $this->output($data);
    }

    public function saveInfo(){
        $data['all_post'] = $this->input->post();        
        $this->output($data);
    }
    
    public function createFile($new_file, $fileContent) {
        $userToken = $this->session->userdata('user_token');
        $data_user = $this->session->userdata("data_login");
        $id_user = (isset($data_user)) ? $data_user['id'].'_'.$data_user['first_name'].''.$data_user['last_name'] : 0;
        $nama_folder = ($id_user != 0) ? $id_user : 'sample'; // validasi pertama
        $nama_folder = ($nama_folder == 'sample') ? $userToken : 'sample'; // validasi kedua
        $folderPath = $this->createFolder($nama_folder);
        $filePath = $folderPath['path'].'/'.$new_file;

        if (!file_exists($filePath)) {
            // Jika file belum ada, buat file baru
            // $fileContent = 'Hello, this is a new file!';
            file_put_contents($filePath, $fileContent);
            $output['msg'] = 'File created successfully.';
            $output['status'] = true;
        } else {
            // Menulis ke file dengan opsi FILE_APPEND untuk menggantikan file jika sudah ada
            // file_put_contents($filePath, $fileContent, FILE_APPEND | LOCK_EX);
            file_put_contents($filePath, $fileContent);
            $output['msg'] = 'File already exists. File created or replaced successfully.';
            $output['status'] = false;
        }
        $output['path'] = $filePath;
        $output['folderPath'] = $folderPath;
        return $output;
    }

    public function createFolder($new_folder) {
        $folderPath = 'upload/files/'.$new_folder;

        if (!is_dir($folderPath)) {
            // Jika folder belum ada, buat folder baru
            mkdir($folderPath, 0755, true);
            $output['msg'] = 'Folder created successfully.';
            $output['status'] = true;
        } else {
            $output['msg'] = 'Folder already exists.';
            $output['status'] = false;
        }
        $output['path'] = $folderPath;
        return $output;
    }

    public function output($data){
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
}