<?php

// require_once(APPPATH . 'controllers/Prefecture.php'); //include controller

class Lang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // load Session Library
        $this->load->library('session');
        $this->load->helper('url', 'form', 'file');
        $this->load->library('form_validation');

        $this->load->model('M_Lang', 'm_lang');

        // https://stackoverflow.com/questions/39486862/codeigniter-3-issue-in-changing-default-language-dynamically
        $lang = $this->session->userdata('language');
        if ($lang == "en") {
            $lang = "english";
        } else {
            $lang = "indonesia";
        }
        // ubah bahasa untuk form_validation CI
        $this->config->set_item('language', $lang);
        $this->load->helper('language');
    }

    public function index()
    {
        $this->load->view('home/v_first_page');
    }

    // public function language()
    // {
    //     $this->load->view('v_home');
    // }

    public function translate($language = 'en'){    
        $this->session->unset_userdata('language');
        $this->session->unset_userdata('data_lang');

        $lang_name = ($language == 'jp') ? "japanese" : "english";
        $this->lang->load($language, $lang_name);
        $data_lang = $this->lang->language;
        
        $array = array(
            'language' => $language,
            'data_lang' => $data_lang,
        );
        $this->session->set_userdata($array);
        
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function translate_old($language)
    {
        if ($language == 'en') {
            $data_lang = $this->m_lang->lang_en();
        } else if ($language == 'jp') {
            $data_lang = $this->m_lang->lang_jp();
        }

        $data = array(
            'language' => $language,
            'data_lang' => $data_lang,
        );

        $this->session->set_userdata($data);

        $PHP_SELF = $_SERVER['PHP_SELF'];
        $HTTP_HOST = $_SERVER['HTTP_HOST'];
        $REQUEST_URI = $_SERVER['REQUEST_URI'];
        $HTTP_REFERER = $_SERVER['HTTP_REFERER'];
        $REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
        $uri_string = $this->uri->uri_string();
        $current_url = current_url();

        // if ($HTTP_REFERER == 'http://localhost/adik_ra/prefecture/confirm' ||
        //     $HTTP_REFERER == 'https://loketechdemo.asiaresearchinstitute.com/prefecture/confirm') {
        //     $this->session->keep_flashdata('lang_data_pref');
        // }
        
        if ($this->session->userdata('language')) {
            $data = $this->session->userdata('lang_data_pref');
            $a = array(
                'PHP_SELF' => $PHP_SELF,
                'HTTP_HOST' => $HTTP_HOST,
                'REQUEST_URI' => $REQUEST_URI,
                'HTTP_REFERER' => $HTTP_REFERER,
                'REQUEST_METHOD' => $REQUEST_METHOD,
                'uri_string' => $uri_string,
                'current_url' => $current_url,
                'APPPATH' => APPPATH,
                'prefObj' => $data,
            );

            // if ($HTTP_REFERER == 'http://localhost/adik_ra/prefecture/confirm' ||
            //     $HTTP_REFERER == 'https://loketechdemo.asiaresearchinstitute.com/prefecture/confirm') {
            //     // $this->session->keep_flashdata('lang_data_pref');
            //     redirect($_SERVER['HTTP_REFERER'], $data);   
            // }      
            $this->session->set_flashdata('change_lang', 'true');
            
            redirect($_SERVER['HTTP_REFERER']);   
            // $this->output->set_content_type('application/json')->set_output(json_encode($a));
        }
    }
}