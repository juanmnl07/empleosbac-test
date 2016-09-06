<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Carreras extends CI_Controller {

    public function __construct()
    {
	    parent::__construct();
	    //$this->output->cache(3600);
	    $this->lang->load('carreras_lang', 'es'); //cargar SEO
    }
 	public function index()
	{
		$data['titulo'] = $this->lang->line('titulo');
		$data['meta_desc'] = $this->lang->line('meta_desc');
		$data['meta_keywords'] = $this->lang->line('meta_keywords');
		$data['vista']  = 'carreras';

		$this->breadcrumb->clear();
		$this->breadcrumb->add('Inicio', '/');
		$this->breadcrumb->add('Carreras con impacto regional');

		

		$this->load->view('index', $data);
	}

	public function __detalle(){

		
		$info = $this->cache->get('carrera-detalle-'.$this->uri->segment(3));
		if(!$info){
			$info = $this->general->getJSON('/rrhh/api/carreras/carrera-detalle.json?carrera-id='.$this->uri->segment(3).'');
			$this->cache->write($info, 'carrera-detalle-'.$this->uri->segment(3));
		}		
		/*$hayresultados = $info['metadata']['total_results'];*/
		/*if($hayresultados == 0 or $hayresultados == NULL){
			$this->general->nofount();
		}*/
		
		$info = $info['results'][0];
		extract($info);

		$ftitle = $this->general->formatURL($title);

		if($this->uri->segment(2) !== $ftitle){
			$this->general->nofount();
		}

		$data['titulo'] = $title;
		$data['meta_desc'] = '';
		$data['meta_keywords'] = '';
		/*$id = $this->uri->segment(3);
		$data['id'] = $id;*/
		$puestos = $this->general->getJSON('/rrhh/api/puestos/puestos-todos-fecha.json?carreras[0]='.$id);
		$data['total'] = $puestos['metadata']['total_results'];
		
		$data['vista'] = 'carreras_detalles';
		

		$this->breadcrumb->clear();
		$this->breadcrumb->add('Inicio', '/');
		$this->breadcrumb->add('Carreras', '/carreras/');
		$this->breadcrumb->add($title);

		$data['info'] = $info;

		$this->load->view('index', $data);
	}

}
