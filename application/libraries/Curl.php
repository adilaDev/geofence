<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Curl {

    protected $ci;
    public $curl;

    public function __construct() {
        $this->ci =& get_instance();
        // $this->curl = $this->ci->curl;
    }

    public function create($url, $headers) {
        curl_setopt($this->ci->curl, CURLOPT_HTTPHEADER, $headers);
        $ch = curl_init($url);
        $this->ci->curl = $ch;
        return $this;
    }

    public function http_header($headers) {
        curl_setopt($this->ci->curl, CURLOPT_HTTPHEADER, $headers);
        return $this;
    }

    public function execute() {
        $result = curl_exec($this->ci->curl);
        // $this->__destruct();
        return $result;
    }

    public function http_status_code() {
        return curl_getinfo($this->ci->curl, CURLINFO_HTTP_CODE);
    }

    // public function __destruct() {
    //     if (isset($this->ci->curl)) {
    //         curl_close($this->ci->curl);
    //     }
    // }

    public function getWithCURL($url, $headers_tableau){
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
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers_tableau);
        // curl_setopt($ch, CURLOPT_HEADER, 0);


        // $return = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $return = curl_exec($ch);
        
        curl_close($ch); 
        return json_decode($return);

        

        // curl_setopt_array($ch, [
        //     CURLOPT_RETURNTRANSFER  => true,
        //     CURLOPT_HTTPGET         => true,
        //     CURLOPT_HTTPHEADER      => [$authorization],
        //     CURLOPT_URL             => $url
        // ]);

        // $return = json_decode(curl_exec($ch));
    }
}
