<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

	private $is_ajax;

    public function __construct()
    {
	    parent::__construct();
    }

 	public function index()
	{
		$this->general->noajax();
	}
	
	public function queryFilter()
	{
		$this->general->noajax();
		$this->output->set_content_type('application/json');

		$orden = $this->input->post('orden');
		$termino = $this->input->post('termino');
		$carrera = $this->input->post('carrera');
		$idioma = $this->input->post('idioma');
		$pais = $this->input->post('pais');
		$jornada = $this->input->post('jornada');
		$preparacion = $this->input->post('preparacion');
		$page = $this->input->post('page');



		$info = array(
			'url'    => 'puestos/puestos-todos-' . $orden,
			'datos'  => array(
				'titulo'   => $this->input->post('termino'),
				'carreras' => $this->input->post('carrera'),
				'idiomas'  => $this->input->post('idioma'),
				'pais'     => $this->input->post('pais'),
				'jornadas' => $this->input->post('jornada'),
				'nivel-academico' => $this->input->post('preparacion'),
				'page'     => $this->input->post('page')
			)
		);

		$name_filter_cache = 'puesto-filter_' . $orden . $this->general->formatURL($termino);


		if(is_array($carrera)){
			foreach ($carrera as $key => $value) {
				$name_filter_cache .= $value;
			}
		}
		if(is_array($idioma)){
			foreach ($idioma as $key => $value) {
				$name_filter_cache .= $value;
			}
		}
		if(is_array($pais)){
			foreach ($pais as $key => $value) {
				$name_filter_cache .= $value;
			}
		}
		if(is_array($jornada)){
			foreach ($jornada as $key => $value) {
				$name_filter_cache .= $value;
			}
		}
		if(is_array($preparacion)){
			foreach ($preparacion as $key => $value) {
				$name_filter_cache .= $value;
			}
		}						

		$name_filter_cache .= $page;

		$datos = $this->cache->get($name_filter_cache);
		if(!$datos){
			$datos = $this->general->getData($info);
			$this->cache->write($datos, $name_filter_cache);
		}

		
		foreach ($datos["results"] as $key=> $result) {
			$url = $this->general->formatURL($result["title"]);
			$datos["results"][$key]["url"] = $url;
		}
		die(json_encode($datos));
	}

	public function queryFilterAdmin()
	{

		$this->general->noajax();
		$this->output->set_content_type('application/json');
		$info = array(
			'url'    => 'puestos/puestos_listado_admin',
			'datos'  => array(
				'page'     => $this->input->post('page'),
				'items_per_page' => $this->input->post('items_per_page'),
				'field_orden' => $this->input->post('field_orden'),
				'tipo_orden' => $this->input->post('tipo_orden'),				
				'title_search'   => $this->input->post('termino'),
				'pais'     => $this->input->post('pais'),
				'carrera' => $this->input->post('carrera'),				
				'estado'     => $this->input->post('estado'),
				'admin'     => $this->input->post('admin'),

			)
		);
		$datos = $this->general->getData($info);
		die(json_encode($datos));		
		
	}
	public function queryFilterAdminDashboard()
	{

		$this->general->noajax();
		$this->output->set_content_type('application/json');
		$info = array(
			'url'    => 'puestos/puestos_listado_dashboard',
			'datos'  => array(				
				'items_per_page' => $this->input->post('items_per_page'),
				'field_orden' => $this->input->post('field_orden_puestos'),
				'tipo_orden' => $this->input->post('tipo_orden_puestos'),
				'pais'     => $this->input->post('pais')
				

			)
		);
		$datos = $this->general->getData($info);
		die(json_encode($datos));		
		
	}

	/* consulta personas Dashboard */
	public function queryPersonasDashboard()
	{

		$this->general->noajax();
		$this->output->set_content_type('application/json');
		$info = array(
			'url'    => 'users/personas_listado_dashboard',
			'datos'  => array(				
				'items_per_page' => $this->input->post('items_per_page'),
				'field_orden' => $this->input->post('field_orden_personas'),
				'tipo_orden' => $this->input->post('tipo_orden_personas'),
				'pais'     => $this->input->post('pais')
				

			)
		);
		$datos = $this->general->getData($info);		
		$this->session->set_userdata('lista_ids_aplicantes', $datos['items_total']);
		die(json_encode($datos));		
		
	}


	public function queryDashboardGeneralInfo()
	{

		$this->general->noajax();
		$this->output->set_content_type('application/json');
		$info = array(
			'url'    => 'users/dashboard_general_info',
			'datos'  => array(				
				'pais'     => $this->input->post('pais')

			)
		);
		$datos = $this->general->getData($info);
		die(json_encode($datos));		
		
	}

	public function queryFilterAdminAplicantesGeneral()
	{

		$this->general->noajax();
		$this->output->set_content_type('application/json');
		$info = array(
			'url'    => 'users/aplicantes_listado_general_admin',
			'datos'  => array(				
				'page'     => $this->input->post('page'),
				'items_per_page' => $this->input->post('items_per_page'),
				'field_orden' => $this->input->post('field_orden'),
				'tipo_orden' => $this->input->post('tipo_orden'),	
				'pais'     => $this->input->post('pais'),
				'carrera' => $this->input->post('carrera'),				
				'preparacion'     => $this->input->post('preparacion'),
				'genero'     => $this->input->post('genero'),

			)
		);
		$datos = $this->general->getData($info);
		$this->session->set_userdata('lista_ids_aplicantes', $datos['items_total']);
		die(json_encode($datos));		
		
	}
	public function queryFilterAdminAplicantesPuesto()
	{

		$this->general->noajax();
		$this->output->set_content_type('application/json');
		$info = array(
			'url'    => 'users/aplicantes_listado_puesto_admin',
			'datos'  => array(				
				'page'     => $this->input->post('page'),
				'items_per_page' => $this->input->post('items_per_page'),
				'field_orden' => $this->input->post('field_orden'),
				'tipo_orden' => $this->input->post('tipo_orden'),	
				'nid_puesto' => $this->input->post('nid_puesto'),
				'estado' => $this->input->post('estado'),				
				'preparacion'     => $this->input->post('preparacion'),
				'genero'     => $this->input->post('genero'),

			)
		);
		$datos = $this->general->getData($info);
		$this->session->set_userdata('lista_ids_aplicantes', $datos['items_total']);
		die(json_encode($datos));		
		
	}

	public function queryPuestosAplicadosPorAplicante()
	{

		$this->general->noajax();
		$this->output->set_content_type('application/json');
		$info = array(
			'url'    => 'puestos/puestos_aplicados_por_aplicante',
			'datos'  => array(				
				'uid'     => $this->input->post('uid')

			)
		);
		$datos = $this->general->getData($info);
		die(json_encode($datos));		
		
	}



	public function webformSubmit()
	{
		
		$url = base_url('/rrhh/api/webforms/webform_submission'); 
		$respuesta = ServicioInsertar($url, '', $this->input->post(), '');
		$data['response'] = $respuesta;
		$this->load->view('user/user-response', $data);
		
	}

	public function formSubmit()
	{
		
		$url = base_url('/rrhh/api/users/user/160/password/?guid=00000'); 
		$respuesta = ServicioInsertar($url, '', $this->input->post(), '');
		$data['response'] = $respuesta;
		$this->load->view('user/user-response', $data);
		
	}


}
