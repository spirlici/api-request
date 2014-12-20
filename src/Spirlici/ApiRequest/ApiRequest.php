<?php
/**
 * Api Requester
 * 
 */


class ApiRequest {

    protected
        $vars,
        // $url  = 'https://httpapi.com/api/',
        $url = 'https://test.httpapi.com/api/',
        $uri,
        $mothod
    ;
    
    /**
     * Constructor
     */
    
    function __construct($api_url) {
        $user = Config::get('rc.auth-userid');
        $pass = Config::get('rc.api-key');
        $this->with('auth-userid', $user);
        $this->with('api-key', $pass);
    }
    
    static function instance() {
        return new self();
    }
    
    static function i(){
        return self::instance();
    }
    
    static function countryList(){
        return self::api()->get('country/list');
    }
    
    function with($var, $val = NULL) {
        if(!$var) return $this;
        if(!is_string($var)) {
            $var = array($var => $val);
        }
        if(!$this->vars) $this->vars = array();
        foreach($var as $key => $val) {
            if(!$this->vars[$key]) {
                $this->vars[$key] = array();
            }
            $val = (array)$val;
            foreach($val as $v) {
                $this->vars[$key][] = $v;
            }
        }
        return $this;
    }
    
    function get($uri = NULL){
        return self::request($uri, 'get');
    }
    
    function post($uri = NULL){
        return self::request($uri, 'post');
    }
    
    /**
     * Make request
     */
    static function request($uri, $method) {
        $client = new GuzzleHttp\Client();
        try {
            $resp = $client->post($url);
            $resp = $resp->json();
            return $resp;
        }
        catch(Exception $e) {
            var_export($e->getMessage());
        }
    }
    
    
}