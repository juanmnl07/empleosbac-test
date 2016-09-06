<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Presencia_regional extends CI_Controller {

    public function __construct()
    {
	    parent::__construct();
		//$this->output->cache(3600);
		$this->lang->load('presencia_regional_lang', 'es'); //cargar SEO
    }
 	public function index()
	{
		$data['titulo'] = $this->lang->line('titulo');
		$data['meta_desc'] = $this->lang->line('meta_desc');
		$data['meta_keywords'] = $this->lang->line('meta_keywords');
		$data['vista']  = 'presencia_regional';

		$this->breadcrumb->clear();
		$this->breadcrumb->add('Inicio', '/');
		$this->breadcrumb->add('Presencia Regional');

		$this->load->view('index', $data);
	}

	public function detalle()
	{	
		$id = $this->uri->segment(3);

		
		$info = $this->cache->get('pais-detalle_pais-id-'.$id);
		if(!$info){
			$info = $this->general->getJSON('/rrhh/api/paises/pais-detalle?pais-id='.$id.'');
			$this->cache->write($info, 'pais-detalle_pais-id-'.$id);
		}


		$info = $info['results'][0];
		extract($info);

		$ftitle = $this->general->formatURL($title);

		if($this->uri->segment(2) !== $ftitle){ 
			$this->general->nofount();
		}

		$data['titulo'] = "Presencia Regional - ".$title;
		$data['meta_desc'] = '';
		$data['meta_keywords'] = '';					
		$data['vista'] = 'presencia_regional_detalle';
		

		$this->breadcrumb->clear();
		$this->breadcrumb->add('Inicio', '/');
		$this->breadcrumb->add('Presencia Regional', '/presencia-regional/');
		$this->breadcrumb->add($title);

		$data['info'] = $info;

		$this->load->view('index', $data);
	}


	

}
