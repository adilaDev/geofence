<?php

defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class M_Curl extends CI_Model
{

    public function getWithCURL($url){
        // $url = "https://updatedistinct-xq32vsbsja-et.a.run.app/prefekturs";
        $authorization = "Authorization: Bearer gusjf97897979gu(^*&yujh";
        $headers = array(
            "Accept: application/json",
            // "X-Custom-Header: value",
            "Content-Type: application/json",
            "Content-Type: application/x-www-form-urlencoded",
            // "Content-Length: 217"
            // "Content-Length: 10000"
        );

        // urlencode($url);
        $url = str_replace(" ", '%20', $url);

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch,CURLOPT_HEADER, true);  // we want headers
        // curl_setopt($ch, CURLOPT_NOBODY  , true);  // we don't need body
        // curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt($ch, CURLOPT_HEADER, 0);


        // $return = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $return = curl_exec($ch);
        
        curl_close($ch); 
        return $return;

        

        // curl_setopt_array($ch, [
        //     CURLOPT_RETURNTRANSFER  => true,
        //     CURLOPT_HTTPGET         => true,
        //     CURLOPT_HTTPHEADER      => [$authorization],
        //     CURLOPT_URL             => $url
        // ]);

        // $return = json_decode(curl_exec($ch));
    }


    public function curlGetDropdownBy($slash)
    {
        if (empty($slash) || $slash == null) {
            # jika kosong berarti get all data
            $url = "https://updatedistinct-xq32vsbsja-et.a.run.app/";
        } else {
            $url = "https://updatedistinct-xq32vsbsja-et.a.run.app/" . $slash;
        }

        $response = $this->m_curl->getWithCURL($url);

        $all_data = array(
            'url_api' => $url,
            'result' => json_decode($response),
            'default_result' => $response
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($all_data));
        return json_decode($response);
    }

    public function postWithCURL($_url, $_param)
    {
        /* Keyword Seacrh : how to send post request using curl with codeigniter */
        /* Source : 1. https://stackoverflow.com/questions/31107354/codeigniter-sending-post-data-to-specific-url-api-data
                    2. https://www.positronx.io/codeigniter-send-curl-post-request-tutorial-example/ 
        */

        /* persiapkan data yang akan di kirim */
        $postData = '';
        // buat pasangan key dan value lalu di pisahkan dgn tanda &
        foreach ($_param as $key => $value) {
            $postData .= $key . '=' . $value . '&';
        }
        rtrim($postData, '&');

        /* persiapkan curl */
        $ch = curl_init();
        /* Menyetel data ke POST dan Tentukan tipe konten */
        curl_setopt($ch, CURLOPT_URL, $_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, count($_param));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        // $cc = rtrim($postData, '&');
        print_r(json_encode($ch));


        /* buat permintaan */
        $output = curl_exec($ch);

        /* Tutup curl */
        curl_close($ch);

        /* close curl */
        return $output;
    }

    public function load_files_json($path){
        $dummy = file_get_contents($path);
        return json_decode($dummy);
    }

    public function load_file_json($path, $encode)
    {
        $dummy = file_get_contents("./assets/files/" . $path);
        if ($encode == true) {
            return $dummy;
        } else {
            return json_decode($dummy);
        }
    }

    function force_download_file($path, $name)
    {
        // make sure it's a file before doing anything!
        if (is_file($path)) {
            // required for IE
            if (ini_get('zlib.output_compression')) {
                ini_set('zlib.output_compression', 'Off');
            }

            // get the file mime type using the file extension
            $this->load->helper('file');

            $mime = get_mime_by_extension($path);

            // Build the headers to push out the file properly.
            header('Pragma: public');     // required
            header('Expires: 0');         // no cache
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($path)) . ' GMT');
            header('Cache-Control: private', false);
            header('Content-Type: ' . $mime);  // Add the mime type from Code igniter.
            header('Content-Disposition: attachment; filename="' . basename($name) . '"');  // Add the file name
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . filesize($path)); // provide file size
            header('Connection: close');
            readfile($path); // push it out
            exit();
        }
    }

    public function getAllHistory(){
        return $this->db->get('tb_history');  
    }
    public function getHistoryIdUser($id)
    {
        $this->db->where('id_user', $id);
        $this->db->order_by('datetime', 'DESC');
        return $this->db->get_where('tb_history');
    }

    public function getHistoryFile($id)
    {
        $this->db->where('url_json', $id);
        return $this->db->get_where('tb_history');        
    }

    public function getHistoryId($id)
    {
        $this->db->where('id_history', $id);
        return $this->db->get_where('tb_history');        
    }
}