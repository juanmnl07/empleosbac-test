<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Puestos extends CI_Controller {

    public function __construct()
    {
	    parent::__construct();
		//$this->output->cache(3600);
		$this->lang->load('puestos_lang', 'es'); //cargar SEO
    }
 	public function index()
	{
		$data['titulo'] = $this->lang->line('titulo');
		$data['meta_desc'] = $this->lang->line('meta_desc');
		$data['meta_keywords'] = $this->lang->line('meta_keywords');
		$data['vista']  = 'puestos';

		$this->breadcrumb->clear();
		$this->breadcrumb->add('Inicio', '/');
		$this->breadcrumb->add('Puestos disponibles');
		
		$this->load->view('index', $data);
	}

	public function detalle()
	{

		
		$info = $this->cache->get('puesto-detalle_puesto-id-'.$this->uri->segment(3));
		if(!$info){
			$info = $this->general->getJSON('/rrhh/api/puestos/puesto-detalle?puesto-id='.$this->uri->segment(3));
			$this->cache->write($info, 'puesto-detalle_puesto-id-'.$this->uri->segment(3));
		}


		if(!empty($info['results'][0]) && isset($info['results'][0])){
			$info = $info['results'][0];
			//exit(var_export($info));
			if(($this->session->userdata('user_role')!="administrador regional") and ($this->session->userdata('user_role')!="administrador país")){
				if($info['status']==0){
					$this->general->nofount();
				}else{				
					extract($info);

					$ftitle = $this->general->formatURL($title);

					if($this->uri->segment(2) !== $ftitle){ /*exit($ftitle);*/
						$this->general->nofount();
					}

					$data['titulo'] = $title;
					$data['meta_desc'] = '';
					$data['meta_keywords'] = '';


					$id = $this->uri->segment(3);
					$data['id'] = $id;

					$data['show_edit'] = false;

					$data['vista'] = 'puestos_detalles';
					

					$this->breadcrumb->clear();
					$this->breadcrumb->add('Inicio', '/');
					$this->breadcrumb->add('Puestos disponibles', '/puestos/');
					$this->breadcrumb->add($title);

					$data['info'] = $info;

					$this->load->view('index', $data);
				}
			}else{

				extract($info);

				$ftitle = $this->general->formatURL($title);

				if($this->uri->segment(2) !== $ftitle){ /*exit($ftitle);*/
					$this->general->nofount();
				}

				$data['titulo'] = $title;
				$id = $this->uri->segment(3);
				$data['id'] = $id;
				//exit(var_export($info));
				
				//obetner pais para validar acceso
				if (isset($info['pais_id'])){
					$pais_puesto = $info['pais_id'];
					//exit(var_export($pais_puesto));
				}else{
					$pais_puesto = 0;
				}
				


				//validar acceso a pais
				if($this->session->userdata('user_role')=="administrador país"){
					if($pais_puesto > 0){
						if($pais_puesto != $this->session->userdata('pais_admin')){
							$data['show_edit'] = false;
						}else{
							$data['show_edit'] = true;
						}
					}
				}else{
					$data['show_edit'] = true;

				}

				if(($this->input->get('creado')=="true") or ($this->input->get("editado")=="true") or ($status == 0)){
					$data['show_edit'] = false;
				}				
				
				$data['vista'] = 'puestos_detalles';
				

				$this->breadcrumb->clear();
				$this->breadcrumb->add('Inicio', '/');
				$this->breadcrumb->add('Puestos disponibles', '/puestos/');
				$this->breadcrumb->add($title);

				$data['info'] = $info;

				$this->load->view('index', $data);
			}
			

		}else{
			$this->general->nofount();
		}
		
	}


	public function listado_admin_general(){

	    $session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
	    $token = $this->session->userdata('token');
	    $url = base_url('/rrhh/api/users/obtener-user-id.xml');
	    $result = consumirServicio($url, $session_cookie, $token);
	    $idusuario = (string)@$result->results->item->uid['0'];
	    if($idusuario == '' or $this->session->userdata('user_id') != $idusuario){
	    	redirect('usuario/sess_destroy');
	    }

		$session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
		$csrf_token = ServicioObtenerToken($session_cookie);


		if(($this->session->userdata('user_role')!="administrador regional") and ($this->session->userdata('user_role')!="administrador país")){
			$this->general->noPermitido();
		}


		$data['titulo'] = 'Administración - Puestos - Listado General';
		$data['meta_desc'] = '';
		$data['meta_keywords'] = '';
		$data['vista']  = 'admin/puestos';

		$this->breadcrumb->clear();
		$this->breadcrumb->add('Inicio', '/');
		$this->breadcrumb->add('Dashboard', '/admin/dashboard');
		$this->breadcrumb->add('Puestos de trabajo');

		$this->load->view('index', $data);
	}


	public function crear(){
		$session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
		$csrf_token = ServicioObtenerToken($session_cookie);

		if(($this->session->userdata('user_role')!="administrador regional") and ($this->session->userdata('user_role')!="administrador país")){
			$this->general->noPermitido();
		}


		if($this->input->post()){
			$service_url = base_url().'/rrhh/api/puestos/node.xml'; // .xml asks for xml data in response
			$post_data = $this->input->post(null, true);
			$post_data['type'] = 'puesto_vacante'; 
			$xml = ServicioInsertarConPermisos($service_url, $session_cookie, $post_data, $csrf_token);
			/*$data['response'] = $xml;
			$this->load->view('user/user-response', $data);*/
			if($xml[1] != 200){
				$error = (string)$xml[0];
				$data['mensaje'] = $error;
				$data['tipo_mensaje'] = 'alert-danger';
			} else {
				//agregar el archivo curriculum en el directorio uploads
				//se debe mostrar mensaje indicando que se agrego satisfactoriamente	
				redirect('admin/puestos/editar/'.(string)$xml[0]->nid);
			}	
		}	

		
		$this->breadcrumb->clear();
		$this->breadcrumb->add('Inicio', '/');
		$this->breadcrumb->add('Puestos', '/admin/puestos/');
		$this->breadcrumb->add('Nuevo');
		$data['typeform'] = 'nuevo';
		$data['titulo_pagina'] = 'Agregar';
		$data['vista'] = 'admin/form-puesto';
		$this->load->view('index', $data);	
	}

	public function editar($nid){
		$session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
		$csrf_token = ServicioObtenerToken($session_cookie);

		if(($this->session->userdata('user_role')!="administrador regional") and ($this->session->userdata('user_role')!="administrador país")){
			$this->general->noPermitido();
		}
		if($this->input->post()){	
			// REST Server URL
			$request_url = base_url().'/rrhh/api/puestos/node/'.$nid.'.xml'; // .xml asks for xml data in response
			$puesto_data = array('current_pass' => $this->input->post('title'), 
								   "body" => array(
											"und" => array(
												"0" => array(
													"value" => $this->input->post('body')
												)
											)
										),
								   "field_zona" => array(
											"und" => array(
												"0" => array(
													"value" => $this->input->post('field_zona')
												)
											)
										),
								   );
			// cURL
			$result = ServicioActualizar($request_url, $puesto_data, $session_cookie, $csrf_token);
			$httpcode = $result['httpcode'];
			$mensaje = $result['mensaje'];

			//agregar el archivo curriculum en el directorio uploads
			/*$config['upload_path'] = './rrhh/sites/default/files/curriculum/';
			$config['allowed_types'] = 'docx|doc|pdf';
			$config['encrypt_name'] = TRUE;
			$this->load->library('upload', $config);*/

			//subir la imagen del puesto	

			//consultar los datos del puesto
			redirect('admin/puestos/editar/'.$nid);

			//validar el codigo html devuelto
			if($httpcode == 200){
				$success = "Los datos se han actualizado satisfactoriamente";
				$data['mensaje'] = $success;
				$data['tipo_mensaje'] = 'alert-success';
			} else {
				$error = "Ha orurrido un error";
				//$xml = new SimpleXMLElement($mensaje);
				$data['mensaje'] = $error. '<br /><br />'.$mensaje;
				$data['tipo_mensaje'] = 'alert-danger';
			}

		}else{
			$service_url = base_url('/rrhh/api/puestos/node/'.$nid.'.xml'); // .xml asks for xml data in response
			// consumir recurso
			$xml = consumirServicio($service_url, $session_cookie, $csrf_token); 
			//extraer la informacion del puesto
			$data['title'] = $xml->title;
			$data['description'] = (string)$xml->body->und->item->value;
			$data['zona'] = (string)$xml->field_zona->und->item->value;
			//$data['response'] = (string)$xml->field_zona->ind->item->value;
			//$this->load->view('user/user-response', $data);
		}
		$this->breadcrumb->clear();
		$this->breadcrumb->add('Inicio', '/');
		$this->breadcrumb->add('Puestos', '/admin/puestos/');
		$this->breadcrumb->add('Editar');
		$data['typeform'] = 'editar';
		$data['titulo_pagina'] = 'Editar';
		$data['nid'] = $nid;
		$data['vista'] = 'admin/form-puesto';
		$this->load->view('index', $data);
	}

}
