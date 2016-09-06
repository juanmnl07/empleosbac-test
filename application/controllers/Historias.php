<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Historias extends CI_Controller {

    public function __construct()
    {
	    parent::__construct();
		//$this->output->cache(3600);
		$this->lang->load('historias_lang', 'es'); //cargar SEO
    }
 	public function index()
	{
		$data['titulo'] = $this->lang->line('titulo');
		$data['meta_desc'] = $this->lang->line('meta_desc');
		$data['meta_keywords'] = $this->lang->line('meta_keywords');
		$data['vista']  = 'historias';

		$this->breadcrumb->clear();
		$this->breadcrumb->add('Inicio', '/');
		$this->breadcrumb->add('Historias de Liderazgo', '/historias');



		$data['inpbuscar'] = '';		

		if($this->input->get('buscar') != '' or $this->input->get('pagina') != ''){
			if($this->input->get('buscar') != ''){
				$data['inpbuscar'] = 'buscar=' . $this->input->get('buscar').'&';
				$this->breadcrumb->add('Búsqueda');
			}
			$url = 'blog/blog-todos';
			if($this->input->get('pagina') != '' and $this->input->get('buscar') == ''){
				$url = 'blog/blog-todos-skip-5';
				$this->breadcrumb->add('Página '.$this->input->get('pagina'));
			}
			$pagina = $this->input->get('pagina');
			$info = array(
				'url'    => $url,
				'datos'  => array(
					'titulo'   => $this->input->get('buscar'),
					'page'     => ($pagina-1)
				)
			);


			$name_blog_cache = 'blog-filter_' . $this->general->formatURL($info['datos']['titulo']) . $pagina;
			$data['listado_normal'] = $this->cache->get($name_blog_cache);
			if(!$data['listado_normal']){
				$data['listado_normal'] = $this->general->getData($info);
				$this->cache->write($data['listado_normal'], $name_blog_cache);
			}


			
			if($this->input->get('pagina') !== NULL){
				if((($this->input->get('pagina')-1) < 0) or (($this->input->get('pagina')-1) > $data['listado_normal']['metadata']['total_pages'])){
					$this->general->nofount();
				}
			}

			
		}else{
			
			$data['listado_normal'] = $this->cache->get('blog-todos-skip-5');
			if(!$data['listado_normal']){
				$data['listado_normal'] = $this->general->getJSON('/rrhh/api/blog/blog-todos-skip-5.json');	
				$this->cache->write($data['listado_normal'], 'blog-todos-skip-5');
			}

			//$data['listado_primero_5'] = $this->general->getJSON('/rrhh/api/blog/blog-todos-primero-de-5.json');
			$data['listado_primero_5'] = $this->cache->get('blog-todos-primero-de-5');
			if(!$data['listado_primero_5']){
				$data['listado_primero_5'] = $this->general->getJSON('/rrhh/api/blog/blog-todos-primero-de-5.json');
				$this->cache->write($data['listado_primero_5'], 'blog-todos-primero-de-5');
			}


			//$data['listado_2y3_5'] = $this->general->getJSON('/rrhh/api/blog/blog-todos-2y3-de-5.json');
			$data['listado_2y3_5'] = $this->cache->get('blog-todos-2y3-de-5');
			if(!$data['listado_2y3_5']){
				$data['listado_2y3_5'] = $this->general->getJSON('/rrhh/api/blog/blog-todos-2y3-de-5.json');	
				$this->cache->write($data['listado_2y3_5'], 'blog-todos-2y3-de-5');
			}


			//$data['listado_4_5'] = $this->general->getJSON('/rrhh/api/blog/blog-todos-4-de-5.json');
			$data['listado_4_5'] = $this->cache->get('blog-todos-4-de-5');
			if(!$data['listado_4_5']){
				$data['listado_4_5'] = $this->general->getJSON('/rrhh/api/blog/blog-todos-4-de-5.json');	
				$this->cache->write($data['listado_4_5'], 'blog-todos-4-de-5');
			}


			//$data['listado_5_5'] = $this->general->getJSON('/rrhh/api/blog/blog-todos-5-de-5.json');
			$data['listado_5_5'] = $this->cache->get('blog-todos-5-de-5');
			if(!$data['listado_5_5']){
				$data['listado_5_5'] = $this->general->getJSON('/rrhh/api/blog/blog-todos-5-de-5.json');	
				$this->cache->write($data['listado_5_5'], 'blog-todos-5-de-5');
			}





		}
	

		
		
		

		$this->load->view('index', $data);
	}

	/*public function pagina(){
		$data['titulo'] = 'Historias - Página '.$this->uri->segment(3);
		$data['vista']  = 'historias_pagina';

		$this->breadcrumb->clear();
		$this->breadcrumb->add('Inicio', '/');
		$this->breadcrumb->add('Historias de Liderazgo','/historias');
		$this->breadcrumb->add('Historias de Liderazgo - Página '.$this->uri->segment(3));


	


		$pagina_real =($this->uri->segment(3)-1);
		$data['listado_normal'] = $this->general->getJSON('/rrhh/api/blog/blog-todos.json?page='.$pagina_real);

					
		if($pagina_real < 0 or $pagina_real > $data['listado_normal']['metadata']['total_pages']){
			$this->general->nofount();
		}
		
		

		$this->load->view('index', $data);
	}*/
	public function guardarComentario(){
		 $correo = 'juanmnl07@gmail.com';
	}


	public function categoria(){

		$url_cat = $this->uri->segment(3);
		$id_cat = $this->uri->segment(4);

		
		$categorias['listado_categorias'] = $this->cache->get('blog-categorias_tid-'.$id_cat);
		if(!$categorias['listado_categorias']){
			$categorias['listado_categorias'] = $this->general->getJSON('/rrhh/api/blog/categorias-blog?tid='.$id_cat);
			$this->cache->write($categorias['listado_categorias'], 'blog-categorias_tid-'.$id_cat);
		}


		$nombre_cat = "";
		

		foreach($categorias['listado_categorias']['results'] as $categoria){
			extract($categoria);

			if($tid==$id_cat){
				$nombre_cat = $name;
			}
		}
		
		$data['categoria'] = $nombre_cat;
		$data['titulo'] = 'Historias - Categoria:  '.$nombre_cat;
		$data['meta_desc'] = '';
		$data['meta_keywords'] = '';
		$data['vista']  = 'historias_categoria';

		$this->breadcrumb->clear();
		$this->breadcrumb->add('Inicio', '/');
		$this->breadcrumb->add('Historias de Liderazgo','/historias');
		$this->breadcrumb->add('Categoria: '.$nombre_cat);

		if(isset($_GET['pagina'])){
			$pagina_real =($_GET['pagina']-1);
			
			$data['listado_normal'] = $this->cache->get('blog-todos_categoria-id-'.$this->uri->segment(4).'_page-'.$pagina_real);
			if(!$data['listado_normal']){
				$data['listado_normal'] = $this->general->getJSON('/rrhh/api/blog/blog-todos.json?categoria-id[0]='.$this->uri->segment(4).'&page='.$pagina_real);	
				$this->cache->write($data['listado_normal'], 'blog-todos_categoria-id-'.$this->uri->segment(4).'_page-'.$pagina_real);
			}


			
			if(($pagina_real < 0) or ($pagina_real > $data['listado_normal']['metadata']['total_pages'])){
				$this->general->nofount();
			}

		}else{
			
			$data['listado_normal'] = $this->cache->get('blog-todos_categoria-id-'.$this->uri->segment(4));
			if(!$data['listado_normal']){
				$data['listado_normal'] = $this->general->getJSON('/rrhh/api/blog/blog-todos.json?categoria-id[0]='.$this->uri->segment(4));				
				$this->cache->write($data['listado_normal'], 'blog-todos_categoria-id-'.$this->uri->segment(4));
			}
		}

		
		$data['nombre_categoria'] = $nombre_cat;
		$data['url_categoria'] = $url_cat;
		$data['id_categoria'] = $id_cat;
		

		$this->load->view('index', $data);
	}

	public function tag(){

		$url_cat = $this->uri->segment(3);
		$id_cat = $this->uri->segment(4);

		
		$categorias['listado_categorias'] = $this->cache->get('blog-tags_tid-'.$id_cat);
		if(!$categorias['listado_categorias']){
			$categorias['listado_categorias'] = $this->general->getJSON('/rrhh/api/blog/tags?tid='.$id_cat);
			$this->cache->write($categorias['listado_categorias'], 'blog-tags_tid'.$id_cat);
		}


		$nombre_cat = "";
		

		foreach($categorias['listado_categorias']['results'] as $categoria){
			extract($categoria);

			if($tid==$id_cat){
				$nombre_cat = $name;
			}
		}

		$data['titulo'] = 'Historias - Tag:  '.$nombre_cat;
		$data['meta_desc'] = '';
		$data['meta_keywords'] = '';
		$data['vista']  = 'historias_tag';


		$this->breadcrumb->clear();
		$this->breadcrumb->add('Inicio', '/');
		$this->breadcrumb->add('Historias de Liderazgo','/historias');
		$this->breadcrumb->add('Tag: '.$nombre_cat);

		if(isset($_GET['pagina'])){
			$pagina_real =($_GET['pagina']-1);
			
			$data['listado_normal'] = $this->cache->get('blog-todos_tag-id-'.$this->uri->segment(4).'_page-'.$pagina_real);
			if(!$data['listado_normal']){
				$data['listado_normal'] = $this->general->getJSON('/rrhh/api/blog/blog-todos.json?tag-id[0]='.$this->uri->segment(4).'&page='.$pagina_real);
				$this->cache->write($data['listado_normal'], 'blog-todos_tag-id-'.$this->uri->segment(4).'_page-'.$pagina_real);
			}

		
			if(($pagina_real < 0) or ($pagina_real > $data['listado_normal']['metadata']['total_pages'])){
				$this->general->nofount();
			}
		}else{
			
			$data['listado_normal'] = $this->cache->get('blog-todos_tag-id-'.$this->uri->segment(4));
			if(!$data['listado_normal']){
				$data['listado_normal'] = $this->general->getJSON('/rrhh/api/blog/blog-todos.json?tag-id[0]='.$this->uri->segment(4));
				$this->cache->write($data['listado_normal'], 'blog-todos_tag-id-'.$this->uri->segment(4));
			}
		}

		
		$data['nombre_categoria'] = $nombre_cat;
		$data['url_categoria'] = $url_cat;
		$data['id_categoria'] = $id_cat;
		

		$this->load->view('index', $data);
	}

	public function detalle()
	{
		$resultado="";
		//var_export($this->input->post('comment-body')); exit();
		if($this->input->post()){
			$url = base_url().'/rrhh/api/blog/comment.xml';
			$session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
			$csrf_token = ServicioObtenerToken($session_cookie);
			$post_data = array('subject'=>'',
				'comment_body'=> array(
					'und'=> array(
						'0'=>array(
							'value' => $this->input->post('comment-body')
							)
						)
					),
				'nid'=>$this->uri->segment(3),
				'uid' => $this->session->userdata('user_id'),
				
				);
			$resultado = ServicioInsertarConPermisos($url, $session_cookie, $post_data, $csrf_token);
			

		}

		
		$info = $this->cache->get('blog-detalle_id-'.$this->uri->segment(3));
		if(!$info){
			$info = $this->general->getJSON('/rrhh/api/blog/blog-detalle?blog-id='.$this->uri->segment(3));
			
			$this->cache->write($info, 'blog-detalle_id-'.$this->uri->segment(3));
		}

		$info = $info['results'][0];
		extract($info);

		$metatags = $this->general->getJSON('/rrhh/api/blog/metatag.json?nid='.$this->uri->segment(3));
		//exit(var_export($metatags));
		$data['meta_desc'] = '';
		$data['meta_keywords'] = '';
		$data['titulo'] = '';

		if($metatags['metatags'] != null){
			foreach ($metatags as $key => $value) {
				foreach ($value as $key2 => $value2) {
					if(isset($value2['description']))
						$data['meta_desc'] = $value2['description']['value'];
					if(isset($value2['keywords']))
						$data['meta_keywords'] = $value2['keywords']['value'];
					if(isset($value2['title']))
						$data['titulo'] = $value2['title']['value'];

				}
			}
		}

		$ftitle = $this->general->formatURL($title);

		if($this->uri->segment(2) !== $ftitle){ 
			$this->general->nofount();
		}

		if($data['titulo'] == '')
			$data['titulo'] = $title;
		
		$id = $this->uri->segment(3);
		$data['id'] = $id;
		//$puestos = $this->general->getJSON('http://bac.cr/rrhh/api/puestos/puestos-todos-fecha.json?carreras[0]='.$id);
		//$data['total'] = $puestos['metadata']['total_results'];
		
		$data['vista'] = 'historias_detalles';
		

		$this->breadcrumb->clear();
		$this->breadcrumb->add('Inicio', '/');
		$this->breadcrumb->add('Historias de Liderazgo', '/historias');
		$this->breadcrumb->add($title);

		$data['info'] = $info;
		$data['resultado'] = $resultado; /* Esta variable es solo para ver los resultados cuando hay errores. */

		$this->load->view('index', $data);
		
	}
	

}
