<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class General extends CI_Model {

    private $is_ajax;

    public function __construct()
    {
        parent::__construct();
        $this->is_ajax = $this->input->is_ajax_request();
    }

    public function noajax(){
        if(!$this->is_ajax){
            $heading = 'Error';
            $message = '<p>URL no permitida</p>';
            show_error($message, 403, $heading);
        }               
    }
    public function nofount(){
        if(!$this->is_ajax){
            $heading = 'Error';
            $message = '<p>Página no encontrada</p>';
            show_error($message, 404, $heading);
        }               
    }
    public function noPermitido(){
        if(!$this->is_ajax){
            $heading = 'Error';
            $message = '<p>El URL al que está intentando acceder no está permitido para su acceso según el rol de su usuario.</p>';
            show_error($message, 403, $heading);
        }               
    }

    public function formatURL($string) {
        
        $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ'; 
        $b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr'; 
        $string = utf8_decode($string);     
        $string = strtr($string, utf8_decode($a), $b); 

        $string = strtolower(trim($string));
        $string = preg_replace("/[^a-z0-9-]/", "-", $string);
        $string = preg_replace("/-+/", "-", $string);
     
        /*if(substr($string, strlen($string) - 1, strlen($string)) === "-") {
            $string = substr($string, 0, strlen($string) - 1);
        }*/
     
        return $string;
    }
    public function getJSON($url)
    {
		$url = base_url($url);
		$result = file_get_contents($url);
		return json_decode($result, true);		
    }
	
	public function getData($data)
    {
		$datos = '';
		if(isset($data['datos']) and $data['datos'] != ''){
			$datos = $data['datos'];
			$datos = http_build_query($datos, '', '&');
		}
		if($datos !== ''){
			$datos = '?' . $datos;
		}		
		$url = '/rrhh/api/'.$data['url'] . '.json'. $datos;
		return $this->getJSON($url);

    }	

}
