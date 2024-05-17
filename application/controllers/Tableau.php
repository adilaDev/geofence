<?php

class Tableau extends CI_Controller
{
    public $session;
    public $form_validation;
    public $lang;
    public $config;
    public $input;
    public $output;
    public $curl;

    public function __construct() {
        parent::__construct();
        // Load Session Library
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url', 'form');
        $this->load->helper('language');
        $this->load->database();
        if ($this->session->userdata('data_login') == '' || $this->session->userdata('data_login') == null) {
            $this->session->set_flashdata('message_login', '<div class="alert alert-warning alert-dismissible fade show" role="alert">Your session has expired please login again<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            redirect(base_url('login'));
        }
        // Change default language dynamically
        $lang = $this->session->userdata('language');
        if (empty($lang) || $lang == null) {
            $lang = "en";
            $this->session->set_userdata(array('language' => $lang)); // set default English
        }
        $lang_name = ($lang == 'jp') ? "japanese" : "english";
        // Change language using CI's default language library
        $this->lang->load($lang, $lang_name);
        // Change language for CI form_validation
        $this->config->set_item('language', $lang_name);
    }

    public function index(){
        $data['link_embed'] = array(
            "link" => array(
                // "https://public.tableau.com/views/RegionalSampleWorkbook/Flights",
                // "https://public.tableau.com/views/RegionalSampleWorkbook/Obesity",
                // "https://public.tableau.com/views/RegionalSampleWorkbook/College",
                // "https://public.tableau.com/views/RegionalSampleWorkbook/Stocks",
                // "https://public.tableau.com/views/RegionalSampleWorkbook/Storms",
                "https://prod-apnortheast-a.online.tableau.com/t/asiaresearchinstituteglobal/views/BoschPowerToolsDummy_16850639352020/ThailandE-commerceCompetitorMonitoringDashboard",
                "https://prod-apnortheast-a.online.tableau.com/t/asiaresearchinstituteglobal/views/BoschPowerToolsDummy_16850639352020/MalaysiaE-commerceCompetitorMonitoringDashboard",
                "https://prod-apnortheast-a.online.tableau.com/t/asiaresearchinstituteglobal/views/BoschPowerToolsDummy_16850639352020/E-commerceSEASummaryDashboard",
                // "https://public.tableau.com/views/SCBusinessInsightsSample/GenaralInformation",
                "https://public.tableau.com/views/SCBusinessInsightsSample/ProductInformation",
            ),
            "thumbnail" => array(
                // "https://public.tableau.com/thumb/views/RegionalSampleWorkbook/Flights",
                // "https://public.tableau.com/thumb/views/RegionalSampleWorkbook/Obesity",
                // "https://public.tableau.com/thumb/views/RegionalSampleWorkbook/College",
                // "https://public.tableau.com/thumb/views/RegionalSampleWorkbook/Stocks",
                // "https://public.tableau.com/thumb/views/RegionalSampleWorkbook/Storms",
                "https://prod-apnortheast-a.online.tableau.com/vizportal/api/rest/v1/views/7498164/thumbnail",
                "https://prod-apnortheast-a.online.tableau.com/vizportal/api/rest/v1/views/7498165/thumbnail",
                "https://prod-apnortheast-a.online.tableau.com/vizportal/api/rest/v1/views/7498166/thumbnail",
                "https://public.tableau.com/thumb/views/SCBusinessInsightsSample/ProductInformation",
            )
        );

        $data_head['title'] = 'Tableau';
        $this->load->view('layout/header', $data_head);
        $this->load->view('layout/navbar');
        $this->load->view('tableau/v_tableau', $data);
        $this->load->view('layout/footer');
    }

    public function v3(){
        $data['link_embed'] = array(
            "link" => array(
                // "https://public.tableau.com/views/RegionalSampleWorkbook/Flights",
                // "https://public.tableau.com/views/RegionalSampleWorkbook/Obesity",
                // "https://public.tableau.com/views/RegionalSampleWorkbook/College",
                // "https://public.tableau.com/views/RegionalSampleWorkbook/Stocks",
                // "https://public.tableau.com/views/RegionalSampleWorkbook/Storms",
                "https://prod-apnortheast-a.online.tableau.com/t/asiaresearchinstituteglobal/views/BoschPowerToolsDummy_16850639352020/ThailandE-commerceCompetitorMonitoringDashboard",
                "https://prod-apnortheast-a.online.tableau.com/t/asiaresearchinstituteglobal/views/BoschPowerToolsDummy_16850639352020/MalaysiaE-commerceCompetitorMonitoringDashboard",
                "https://prod-apnortheast-a.online.tableau.com/t/asiaresearchinstituteglobal/views/BoschPowerToolsDummy_16850639352020/E-commerceSEASummaryDashboard",
                "https://public.tableau.com/views/SCBusinessInsightsSample/ProductInformation",
            ),
            "thumbnail" => array(
                // "https://public.tableau.com/thumb/views/RegionalSampleWorkbook/Flights",
                // "https://public.tableau.com/thumb/views/RegionalSampleWorkbook/Obesity",
                // "https://public.tableau.com/thumb/views/RegionalSampleWorkbook/College",
                // "https://public.tableau.com/thumb/views/RegionalSampleWorkbook/Stocks",
                // "https://public.tableau.com/thumb/views/RegionalSampleWorkbook/Storms",
                "https://prod-apnortheast-a.online.tableau.com/vizportal/api/rest/v1/views/7498164/thumbnail",
                "https://prod-apnortheast-a.online.tableau.com/vizportal/api/rest/v1/views/7498165/thumbnail",
                "https://prod-apnortheast-a.online.tableau.com/vizportal/api/rest/v1/views/7498166/thumbnail",
                "https://public.tableau.com/thumb/views/SCBusinessInsightsSample/ProductInformation",
            )
        );

        $data_head['title'] = 'Tableau';
        $this->load->view('layout/header', $data_head);
        $this->load->view('layout/navbar');
        $this->load->view('tableau/tableau_v3', $data);
        $this->load->view('layout/footer');
    }
    
    public function getDataFromTableau() {
        $this->load->library('curl');
        // Ganti dengan informasi Anda
        $token = 'b7VLZqOUTnuxS9BswdQHPQ==:9HOIhfsEbiPkivaGEckLcNZZ7d8xlbTZ';
        // $site_url = 'https://<site>.tableau.com';
        $site_url = 'https://10ay.online.tableau.com';
        $api_version = 'api/3.10';

        // URL Permintaan API
        // $url = $site_url . '/' . $api_version . '/sites/<site-id>/projects';
        // $url = $site_url . '/' . $api_version . '/sites/asiaresearchinstituteglobal/ProductInformation';
        $url = $site_url . '/#/sites/asiaresearchinstituteglobal/workbooks';

        // Header HTTP
        $headers = array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Bearer ' . $token
        );

        // Konfigurasi cURL
        $result = $this->curl->getWithCURL($url, $headers);
        // $this->curl->http_header($headers);
        // $result = $this->curl->execute();

        $this->output($result);
        // // Cek respon dari API Tableau
        // if ($this->curl->http_status_code == 200) {
        //     $data = json_decode($result, true);
        //     // Lakukan sesuatu dengan data yang diterima
        //     // var_dump($data);
        //     $this->output($data);
        // } else {
        //     // echo 'Error: ' . $this->curl->http_status_code;
        //     // echo '<br>';
        //     // echo $result;
        //     $data = array(
        //         'status' => 'Error: ' . $this->curl->http_status_code,
        //         'result' => $result
        //     );
        //     $this->output($data);
        // }
    }

    public function output($data){
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
        
    }
}