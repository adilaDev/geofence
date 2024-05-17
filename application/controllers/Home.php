<?php
// Register autoloader
require_once(FCPATH.'vendor/gasparesganga/php-shapefile/src/Shapefile/ShapefileAutoloader.php');
Shapefile\ShapefileAutoloader::register();

// Import classes
use Shapefile\Shapefile;
use Shapefile\ShapefileException;
use Shapefile\ShapefileWriter;
use Shapefile\Geometry\Point;

class Home extends CI_Controller
{

    public $session;
    public $input;
    public $output;
    public $config;
    public $lang;
    public $upload;

    public $auth;
    public $m_geo;
    public $db_draw;
    public $convert;
    public $shp;
    public $phpshp;

    public function __construct()
    {
        parent::__construct();
        // Load Session Library
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url', 'form');
        $this->load->helper('language');
        $this->load->database();

        $this->load->model('M_ShapeFile', 'shp');
        $this->load->model('PhpShapeFile', 'phpShp');
        $this->load->model('Converter', 'convert');
        $this->load->model('M_Drawing', 'db_draw');
        $this->load->model('M_GeoDraw', 'm_geo');

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
        
        header('X-Frame-Options: ALLOW-FROM https://geofence.asiaresearchinstitute.com/client');
    }

    public function index(){
        $all_data = $this->m_geo->getAllData()->result();
        $lang = $this->session->userdata('language');
        $data_lang = $this->session->userdata('data_lang');

        $data['lang'] = $lang;
        $data['data_lang'] = $data_lang;
        $data['list_all_geo'] = $all_data;
        $data_head['title'] = 'Home';
        // ====================================
        // layout horizontal
        // ====================================
        $this->load->view('layout/header', $data_head);
        $this->load->view('layout/navbar');
        $this->load->view('home/v_dashboard', $data);
        $this->load->view('layout/footer');
        // $this->output($data);
    }

    public function import(){
        $lang = $this->session->userdata('language');
        $data_lang = $this->session->userdata('data_lang');
        $initUser = $this->initUserData();

        $data = $initUser;
        $data['lang'] = $lang;
        $data['data_lang'] = $data_lang;
        $data_head['title'] = 'Import File';
        // ====================================
        // layout horizontal
        // ====================================
        $this->load->view('layout/header', $data_head);
        $this->load->view('layout/navbar');
        $this->load->view('home/v_import_geojson', $data);
        $this->load->view('layout/footer');
        // $this->output($data);
    }

    public function upload_files()
    {
        $data_user = $this->session->userdata("data_login");
        $id_user = (isset($data_user)) ? $data_user['id'].'_'.$data_user['first_name'].''.$data_user['last_name'] : 0;
        $nama_folder = ($id_user != 0) ? $id_user : 'sample';
        $folderPath = $this->createFolder('import', $nama_folder);
        $filePath = $folderPath['path'].'/';
        
        $save_path = $filePath;
        // $save_path = "/upload/import/";

        $config['upload_path']          = FCPATH . $save_path;
        // $config['allowed_types']        = 'jpg|jpeg|png|gif|ico';
        // $config['allowed_types']        = 'csv|xlsx|xls';
        // $config['allowed_types'] = 'geojson|application/geo+json|application/vnd.geo+json';
        $config['allowed_types'] = '*';
        // $config['file_name']            = $filename;
        $config['overwrite']            = false;
        // $config['max_size']             = 5024; // 2024 = 2MB

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('outputFiles')) {
            $data['result'] = array(
                'status' => false,
                'msg' => $this->upload->display_errors('', ''),
                'config' => $config,
            );
        } else {
            $uploaded_data = $this->upload->data();
            $token = $this->input->post('token_foto');
            $nama = $this->upload->data('file_name');
            $data['result'] = [
                'status' => true,
                'msg' => 'Uploaded successfully',
                'token' => $token,
                'nama' => $nama,
                'path' => $save_path . $uploaded_data['file_name'],
                'uploaded_data' => $uploaded_data,
                'display_errors' => $this->upload->display_errors()
            ];
            
        }
        
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
        return $data['result'];
    }

    //Untuk menghapus foto
    function remove_files(){
        //Ambil token foto
        // $token = $this->input->post('token');
        // $foto = $this->db->get_where('foto', array('token' => $token));

        // if ($foto->num_rows() > 0) {
        //     $hasil = $foto->row();
        //     $nama_foto = $hasil->nama_foto;
        //     if (file_exists($file = FCPATH . '/upload-foto/' . $nama_foto)) {
        //         unlink($file);
        //     }
        //     $this->db->delete('foto', array('token' => $token));
        // }
        // echo "{}";
        
        $data_user = $this->session->userdata("data_login");
        $id_user = (isset($data_user)) ? $data_user['id'].'_'.$data_user['first_name'].''.$data_user['last_name'] : 0;
        $nama_folder = ($id_user != 0) ? $id_user : 'sample';
        $folderPath = $this->createFolder('import', $nama_folder);
        $filePath = $folderPath['path'].'/';

        $token = $this->input->post('token');
        $path = $this->input->post("path_file");
        $nama_foto = $this->input->post("nama_foto");
        // $save_path = "upload/import/";
        $save_path = $filePath;
        $file = $save_path . $nama_foto;
        $file1 = FCPATH . $save_path . $nama_foto;
        // $file1 = $path;
        $status = '';

        // Check file exist or not 
        if (file_exists($file1)) {
            // Remove file 
            // unlink($path);
            unlink($file);
            $status = 'File deleted successfully';
        } else {
            $status = 'Files failed to delete';
        }

        $callback = array(
            'token' => $token,
            'path' => $path,
            'nama_foto' => $nama_foto,
            'file_exists' => file_exists($file1),
            'file' => $file,
            'file1' => $file1,
            'status' => $status
        );

        $this->output->set_content_type('application/json')->set_output(json_encode($callback));
    }

    public function monitoring(){
        $all_data = $this->db_draw->tb_info_get_all_data(true)->result();
        $data['list_all_info'] = $all_data;
        $data_head['title'] = 'Monitoring';
        // ====================================
        // layout horizontal
        // ====================================
        $this->load->view('layout/header', $data_head);
        $this->load->view('layout/navbar');
        $this->load->view('home/v_monitoring', $data);
        $this->load->view('layout/footer');
    }

    public function pricelist(){
        $data_head['title'] = 'Price list';
        // ====================================
        // layout horizontal
        // ====================================
        $this->load->view('layout/header', $data_head);
        $this->load->view('layout/navbar');
        $this->load->view('price/list_price');
        $this->load->view('layout/footer');
    }

    public function geo(){
        $all_data = $this->db_draw->tb_drawing_get()->result();
        $data['all_data'] = $all_data;
        $data_head['title'] = 'Home';
        // ====================================
        // layout horizontal
        // ====================================
        $this->load->view('layout/header', $data_head);
        $this->load->view('layout/navbar');
        $this->load->view('home/v_home', $data);
        $this->load->view('layout/footer');
    }

    public function savePolygon(){
        $data['all_post'] = $this->input->post();
        $id_polygon = $_POST['id_polygon'];
        $polygon_name = $_POST['polygon_name'];
        $features = ($_POST['features']);
        $feature_collection = ($_POST['feature_collection']);
        $filename = $polygon_name.'.geojson';
        $create_file = $this->createFile($filename, $feature_collection);
        $data['create_file'] = $create_file;

        $link = base_url().$create_file['path'];

        // prepare to insert db
        $check_name = $this->db_draw->tb_drawing_check_name($polygon_name);
        $data['check_name'] = $check_name;
        $data_insert = $this->db_draw->tb_drawing_data_insert($id_polygon, $polygon_name, "source_".$polygon_name, "layer_".$polygon_name, $link, $features, $feature_collection);
        $data['data_insert'] = $data_insert;

        // if ($check_name) {
        //     // jika sama maka update ke db
        //     $update = $this->db_draw->tb_drawing_update(null)->result();
        //     $data['update'] = $update;
        // } else {
        //     // jika tidak sama insert ke db
        //     $save = $this->db_draw->tb_drawing_save(null)->result();
        //     $data['save'] = $save;
        // }
        // jika tidak sama insert ke db
        $save = $this->db_draw->tb_drawing_save(null)->result();
        $data['save'] = $save;

        // $data['save&download'] = $this->saveAndDownloadShapefile();
        $this->output($data);
    }

    public function deleteId($id){
        $del = $this->m_geo->deleteData(['polygon_name' => $id]);
        // $del = $this->m_geo->removeDuplicateRows('polygon_name');
        $this->output($del);
    }
    
    public function deleteAll(){
        $del = $this->m_geo->deleteAllData();
        $this->output($del);
    }

    public function check($polygon_name){
        $check_name = $this->db_draw->tb_drawing_check_name($polygon_name);
        $data['check_name'] = $check_name;
        $get_all_data = $this->db_draw->tb_drawing_get()->result();
        $data['get_all_data'] = $get_all_data;
        $this->output($data);
    }

    public function convert(){
        // Menulis ke file
        // $data_to_write = 'Data yang akan ditulis ke file';
        // write_file('path/to/your/file.txt', $data_to_write);

        $all = $this->input->post();
        $data['all'] = $all;
        $data_file = $this->input->post("data_file");
        $encode = json_decode($data_file);
        $data['encode'] = $encode;
        $data['data_file'] = $encode->dbf;
        
        // Menulis ke file dbf
        $urlDbf = write_file('upload/shp/example.dbf', json_encode($encode->dbf));
        $urlShp = write_file('upload/shp/example.shp', json_encode($encode->shp));
        $urlPrj = write_file('upload/shp/example.prj', $encode->prj);
        $urlShx = write_file('upload/shp/example.shx', json_encode($encode->shx));
        $data['url_file'] = array(
            'dbf' => $urlDbf,
            'shp' => $urlShp,
            'shx' => $urlShx,
            'prj' => $urlPrj,
        );

        $this->output($data);
    }

    public function createFile($new_file, $fileContent) {
        $folderPath = $this->createFolder('files', 'sample');
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

    public function createFolder($path = 'files', $new_folder) {
        $folderPath = 'upload/'.$path.'/'.$new_folder;

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

    public function info123(){
        // $x = $this->shp->getShapeFileInfo(FCPATH.'upload/files/file.shp');
        // $x = $this->shp->getShapeFileInfo(FCPATH.'sample/New Delhi Population/New Delhi Population.shp');
        $x['converter'] = $this->convert->converterGeoJsonToShp();
        $x['save'] = $this->convert->save();
        // $x['readShp'] = $this->shp->getShapeFileInfo(FCPATH.'upload/files/polygon_shapefile.shp');
        // $x['initGeojson'] = $this->shp->initFromGeoJSON();
        $this->output($x);
    }

    public function readShp(){
        $shp = $this->shp->getShapeFileInfo(FCPATH.'upload/files/polygon_shapefile.shp');
    }
    
    public function saveAndDownloadShapefile() {
        // Data polygon (contoh)
        $polygonData = '{"type":"Feature","geometry":{"type":"Polygon","coordinates":[[[-74.0,40.7],[-74.0,40.8],[-73.9,40.8],[-73.9,40.7],[-74.0,40.7]]]},"properties":{}}';

        // Convert GeoJSON to array
        $geometry = json_decode($polygonData, true);

        // Panggil fungsi untuk menyimpan shapefile
        $shpFilePath = $this->saveShapefile($geometry);

        $this->output($shpFilePath);
        // Buat dan unduh file zip
        // $zipFilename = 'polygon_shapefile.zip';
        // $this->createAndDownloadZip([$shpFilePath], $zipFilename);
    }

    private function saveShapefile($geometry) {
        // $shp = new ShapeFileWriter(FCPATH.'upload/files/example_polygon_shapefile.shp');
        // // Tambahkan geometri ke shapefile
        // $shp->addShape($geometry);
        // // Simpan shapefile
        // $shpFilePath = $shp->save();
        // return $shpFilePath;

        try {
            // Open Shapefile
            $Shapefile = new ShapeFileWriter(FCPATH.'upload\files\file.shp');
            
            // Set shape type
            // $Shapefile->setShapeType(Shapefile::SHAPE_TYPE_POINT);
            $Shapefile->setShapeType(Shapefile::SHAPE_TYPE_POLYGON);
            
            // Create field structure
            // $Shapefile->addNumericField('ID', 10);
            // $Shapefile->addCharField('DESC', 25);
            
            // Write some records (let's pretend we have an array of coordinates)
            // foreach ($geometry as $i => $coords) {
            //     // Create a Point Geometry
            //     $Point = new Point($coords['x'], $coords['y']);
            //     // Set its data
            //     $Point->setData('ID', $i);
            //     $Point->setData('DESC', "Point number $i");
            //     // Write the record to the Shapefile
            //     $Shapefile->writeRecord($Point);
            // }

            // Write the record to the Shapefile
            $Shapefile->writeRecord($geometry);
            
            // Finalize and close files to use them
            $Shapefile = null;
            return $Shapefile;

        } catch (ShapefileException $e) {
            // Print detailed error information
            echo "Error Type: " . $e->getErrorType()
                . "\nMessage: " . $e->getMessage()
                . "\nDetails: " . $e->getDetails();
        }
    }

    private function createAndDownloadZip($filePaths, $zipFilename) {
        $zip = new ZipArchive();
        $zip->open($zipFilename, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        foreach ($filePaths as $filePath) {
            // Masukkan file ke dalam zip
            $zip->addFile($filePath, basename($filePath));
        }

        $zip->close();

        // Unduh file zip
        force_download($zipFilename, file_get_contents($zipFilename));
    }

    public function upload_images()
    {
        // $file_product = $this->input->post('file_product');
        // $filename = 'test_'.$file_product;
        $save_path = "/upload/images/";
        $type = $_FILES['outputImages']['type'];

        $config['upload_path']          = FCPATH . $save_path;
        $config['allowed_types']        = 'jpg|jpeg|png|gif|ico|webp|avif|svg';
        // $config['file_name']            = $filename;
        $config['overwrite']            = false; // true = replace foto dgn nama yg sama
        $config['max_size']             = 5024; // 2024 = 2MB

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('outputImages')) {
            $data['result'] = array(
                'status' => false,
                'msg' => $this->upload->display_errors('', ''),
                'type' => $_FILES['outputImages']['type'],
                '_FILES' => $_FILES,
                'do_upload' => $this->upload->do_upload('outputImages'),
                'is_allowed_filetype' => $this->upload->is_allowed_filetype(),
                'config' => $config,
            );
        } else {
            $uploaded_data = $this->upload->data();
            $token = $this->input->post('token_foto');
            $nama = $this->upload->data('file_name');

            $data['result'] = [
                'status' => true,
                'msg' => 'Uploaded successfully',
                'token' => $token,
                'nama' => $nama,
                'path' => $save_path . $uploaded_data['file_name'],
                'uploaded_data' => $uploaded_data,
                'display_errors' => $this->upload->display_errors()
            ];
        }

        // print_r('Image Uploaded Successfully.');
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
        return $data['result'];
    }

    //Untuk menghapus foto
    function remove_images()
    {
        $token = $this->input->post('token');
        $path = $this->input->post("path_file");
        $nama_foto = $this->input->post("nama_foto");
        $save_path = "upload/images/";
        $file = $save_path . $nama_foto;
        $file1 = FCPATH . $save_path . $nama_foto;
        // $file1 = $path;
        $status = '';

        // Check file exist or not 
        if (file_exists($file1)) {
            // Remove file 
            // unlink($path);
            unlink($file);
            $status = 'File deleted successfully';
        } else {
            $status = 'Files failed to delete';
        }

        $callback = array(
            'token' => $token,
            'path' => $path,
            'nama_foto' => $nama_foto,
            'file_exists' => file_exists($file1),
            'file' => $file,
            'file1' => $file1,
            'status' => $status
        );

        $this->output->set_content_type('application/json')->set_output(json_encode($callback));
    }

    /**
     * Initialize User Data
     *
     * @return array
     */
    public function initUserData() {
        $data_user = $this->session->userdata("data_login");
        $id_user = "";
        $first_name = "";
        $last_name = "";
        $fullname = "";
        $username = "";
        $foto = "";
        $sp_foto = "";
        $lang = $this->session->userdata('language');
        $data_lang = $this->session->userdata('data_lang');
    
        if (isset($data_user)) {
            $id_user  = $data_user['id'];
            $first_name  = $data_user['first_name'];
            $last_name  = $data_user['last_name'];
            $fullname = $first_name.' '.$last_name;
            $username  = $data_user['username'];
            // $foto = base_url() . $data_user['photo_profil'];
            $foto = $data_user['photo_profil'];
            $sp_foto = explode("/", $foto);
        }
    
        $name = '';
        if (empty($last_name)) {
            $name = empty($first_name) ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $first_name[0];
        } else {
            // $name = $first_name[0] . $last_name[0];
            $name = (empty($first_name) && empty($last_name)) ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : $first_name[0] . $last_name[0];
        }
    
        // Mengembalikan array dengan data yang diambil dari sesi
        $return = [
            'id_user' => $id_user,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'fullname' => $fullname,
            'username' => $username,
            'foto' => $foto,
            'sp_foto' => $sp_foto,
            'name' => $name,
            'lang' => $lang,
            'data_lang' => $data_lang
        ];
    
        // Contoh cara mengakses data dalam array yang dikembalikan
        // $userData = $this->initUserData();
        // echo $userData['first_name'];
        // echo $userData['last_name'];
    
        return $return;
    }

    public function output($json){
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
}