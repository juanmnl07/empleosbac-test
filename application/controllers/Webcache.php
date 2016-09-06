<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Webcache extends CI_Controller {

	private $tipos = array(
		'testimonio'	=> array(
			'testimonios-todos',
		),
		'slider' => array(
			'slider-todos',
		),
		'puesto_vacante' => array(
			'puesto-',
			'filtros-taxonomias',
		),
		'pais' => array(
			'pais-',
			'paises-',
			'filtros-entidades',
		),
		'carrera' => array(
			'carreras-todas',
			'filtros-entidades',
		),
		'blog' => array(
			'blog-',
		)										
	);


    public function __construct()
    {
	    parent::__construct();
    }

 	public function index()
	{
		$heading = 'Error';
		$message = '<p>URL no permitida</p>';
		show_error($message, 403, $heading);		
	}

	/*public function delall(){
		$this->cache->delete_all();
	}*/

	public function deletecache()
	{
		$tipo = $this->uri->segment(3);
		if($tipo == 'all'){
			$this->clear_all_cache();
		}else{
			if(array_key_exists($tipo, $this->tipos)){
				foreach ($this->tipos[$tipo] as $key => $value) {
					if(substr($value, -1) == '-'){
						$this->cache->delete_group($value);
					}else{
						$this->cache->delete($value);
					}
				}
			}
		}		
	}
	

 	public function clear()
	{
		$data['heading'] = 'Cache';
		$data['message'] = 'La cache se a eliminado correctamente.';	
		$id = $this->uri->segment(3);
		
		$this->delete_webcache();

		if($id != ''){
			$url = base64_decode($id);
			$this->clear_path_cache($url);
			$data['url'] = $url;
			$data['anchor'] = 'Ir a la página';
		}else{
			$this->clear_all_cache();
			$data['url'] = '';
			$data['anchor'] = 'Ir al inicio';		
		}
		$this->load->view('webcache', $data);
	}

	public function delete_webcache(){
		$archivo = $_SERVER['DOCUMENT_ROOT'] . '/cache.webcache';
		$abrir = fopen($archivo,'r+');
		$contenido = fread($abrir,filesize($archivo));
		fclose($abrir);
		// Separar linea por linea
		$contenido = explode("\n",$contenido);
		 // Modificamos la linea 2
		$contenido[1] = '#hash=' . md5(time()) . ' ' . date('Y-m-d g:i:sa');
		// Unir archivo
		$contenido = implode("\n",$contenido);
		// Guardar Archivo
		$abrir = fopen($archivo,'w');
		fwrite($abrir,$contenido);
		fclose($abrir);				
	}	

	public function clear_path_cache($uri)
	{
		$CI =& get_instance();
		$path = $CI->config->item('cache_path');
	
		$cache_path = ($path == '') ? APPPATH.'cache/' : $path;
	
		$uri =  $CI->config->item('base_url').
		$CI->config->item('index_page').
		$uri;
		$cache_path .= md5($uri);
	
		return @unlink($cache_path);
	}

	public function clear_all_cache()
	{
		$CI =& get_instance();
		$path = $CI->config->item('cache_path');
	
		$cache_path = ($path == '') ? APPPATH.'cache/' : $path;
	
		$handle = opendir($cache_path);
		while (($file = readdir($handle))!== FALSE) 
		{
			if ($file != '.htaccess' && $file != 'index.html')
			{
			   @unlink($cache_path.'/'.$file);
			}
		}
		closedir($handle);
	}
	
}
