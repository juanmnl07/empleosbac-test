<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contacto extends CI_Controller {

    public function __construct()
    {
	    parent::__construct();
		//$this->output->cache(3600);
		$this->lang->load('contacto_lang', 'es'); //cargar SEO
    }
 	public function index()
	{
		$data['titulo'] = $this->lang->line('titulo');
		$data['meta_desc'] = $this->lang->line('meta_desc');
		$data['meta_keywords'] = $this->lang->line('meta_keywords');
		
		$data['vista']  = 'contacto';
		$this->breadcrumb->clear();
		$this->breadcrumb->add('Inicio', '/');
		$this->breadcrumb->add('Contáctanos');

		$this->load->view('index', $data);
	}			    

}
