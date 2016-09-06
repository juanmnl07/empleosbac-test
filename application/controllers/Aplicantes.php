<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Aplicantes extends CI_Controller {

    public function __construct()
    {
	    parent::__construct();
	    $session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
	    $token = $this->session->userdata('token');
	    $url = base_url('/rrhh/api/users/obtener-user-id.xml');
	    $result = consumirServicio($url, $session_cookie, $token);
	    $idusuario = (string)@$result->results->item->uid['0'];
	    if($idusuario == '' or $this->session->userdata('user_id') != $idusuario){
	    	redirect('usuario/sess_destroy');
	    }
	    
		if(($this->session->userdata('user_role')!="administrador regional") and ($this->session->userdata('user_role')!="administrador país")){
			$this->general->noPermitido();
		}

    }

    //inicio de sesion
 	public function index(){
 		//listado de aplicantes general para los administradores
 		$session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
		$csrf_token = ServicioObtenerToken($session_cookie);


		$parametro_pais ="";

		if (($this->session->userdata('user_role') == "administrador país") or ($this->session->userdata('user_role') == "administrador junior")){
			if($this->session->userdata('pais_admin')>0){
				$parametro_pais = "pais-id[0]=".$this->session->userdata('pais_admin'); 
			}
		}

		//consultar listado de aplicantes general para obtener el total de aplicantes registrados
		if($parametro_pais!=""){
			$service_url1 = base_url().'rrhh/api/users/aplicantes-cantidad.xml?'.$parametro_pais; // .xml asks for xml data in response
		}else{
			$service_url1 = base_url().'rrhh/api/users/aplicantes-cantidad.xml'; // .xml asks for xml data in response
		}
		

		//consumir recurso
		$result1 = consumirServicio($service_url1, $session_cookie, $csrf_token); 
		$data['total_aplicantes_registrados'] = $result1->metadata->total_results;



		//$data['niveles_academicos'] = $
		$data['titulo'] = 'Administración - Aplicantes';
		$data['meta_desc'] = '';
		$data['meta_keywords'] = '';
		$data['listado_aplicantes'] = 'general';
		$data['vista']  = 'admin/aplicantes';

		$this->breadcrumb->clear();
		$this->breadcrumb->add('Inicio', '/');
		$this->breadcrumb->add('Dashboard', '/admin/dashboard');
		$this->breadcrumb->add('Candidatos generales');

		$this->session->set_userdata('aplicantes', array(
														'tipo' => 'general'
														) );

		//Para obtener paginacion y parametros
		/*$parametro_pagina ="";
		$parametros = "";
		

		if($this->input->get('pagina') != ''){			
			$parametro_pagina = 'page='.($this->input->get('pagina')-1);
			$this->breadcrumb->add('Página '.$this->input->get('pagina'));
		}

		
		//para formar todos los parametros necesarios para el filtrado
		if(($this->obtenerParametrosFiltrado() != "") or ($parametro_pagina != "") or ($parametro_pais != "")){
			$parametros = "?";
			if ($parametro_pais != ""){
				$parametros.= $parametro_pais;
			}
			if($this->obtenerParametrosFiltrado() != ""){
				if(strlen($parametros)>1){
					$parametros .= "&".$this->obtenerParametrosFiltrado();
				}else{
					$parametros .= $this->obtenerParametrosFiltrado();
				}
			}
			if(($parametro_pagina != "")){
				if(strlen($parametros)>1){
					$parametros .= "&".$parametro_pagina;
				}else{
					$parametros .= $parametro_pagina;
				}
			}
		}*/

		
		//pasa los parametros para que sean pasados cuando se hace paginación
		/*$data['parametros_filtrado'] = $this->obtenerParametrosGetFormat();*/

		//consultar listado de aplicantes general
		//$service_url = base_url().'rrhh/api/users/aplicantes-general.xml'.$parametros; // .xml asks for xml data in response
		
		
		//exit(var_export($service_url));
		

		//consumir recurso
		/*$result = consumirServicio($service_url, $session_cookie, $csrf_token); 
		$data['aplicantes_general'] = $result->results;
		$data['aplicantes_general_metadata'] = $result->metadata;*/

		//para premarcar checks filtro cuando se hace un filtrado del listado
		/*$data['filtros_form'] = $this->obtenerParametrosArray();*/
		$data['session_cookie'] = $session_cookie;

		//asignamos dentro la sesion una variable para indicar el tipo de listado de aplicantes (general/por-puesto)
		
		
		
		/*if($this->input->get('pagina') !== NULL){
			if((($this->input->get('pagina')-1) < 0) or (($this->input->get('pagina')-1) > (int)$data['aplicantes_general_metadata']->total_pages)){
				$this->general->nofount();
			}
		}*/

		

		$this->load->view('index', $data);
 	}	

 	public function porPuesto($nid_puesto){
 		//listado de aplicantes general para los administradores
 		$session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
		$csrf_token = ServicioObtenerToken($session_cookie);

		if(($this->session->userdata('user_role')!="administrador regional") and ($this->session->userdata('user_role')!="administrador país")){
			$this->general->noPermitido();
		}

		//asignamos dentro la sesion una variable para indicar el tipo de listado de aplicantes (general/por-puesto)
		
		$this->session->set_userdata('aplicantes', array('tipo' => 'por-puesto',
														'id-puesto' => $nid_puesto));


		//consultar listado de aplicantes general para obtener el total de aplicantes registrados
		$service_url1 = base_url().'rrhh/api/users/aplicantes-cantidad.xml?nid_puesto='.$nid_puesto; // .xml asks for xml data in response

		//consumir recurso
		$result1 = consumirServicio($service_url1, $session_cookie, $csrf_token); 
		$data['total_aplicantes_registrados'] = $result1->metadata->total_results;


		//consultar nombre de Puesto
		$service_url2 = base_url().'rrhh/api/puestos/puesto-detalle-simple.xml?nid_puesto='.$nid_puesto; // .xml asks for xml data in response

		//consumir recurso
		$result2 = consumirServicio($service_url2, $session_cookie, $csrf_token); 
		
		$data['nombre_puesto_con_formato'] = "<a target='_blank' href='/puestos/".$this->general->formatURL($result2->results[0]->item->title)."/".$nid_puesto."'>".$result2->results[0]->item->title."</a>";
		$data['nombre_puesto'] = $result2->results[0]->item->title;
		//obetner pais para validar acceso
		if (isset($result2->results[0]->item->field_pais)){
			$pais_puesto = $result2->results[0]->item->field_pais;
			//exit(var_export($pais_puesto));
		}else{
			$pais_puesto = 0;
		}
		
		


		
		//estados
		$estados = $this->obtenerListadoEstadosBitacora(false);
		$data['titulo'] = 'Administración - Personas Registradas - '.$data['nombre_puesto'];
		$data['meta_desc'] = '';
		$data['meta_keywords'] = '';

		$data['estados'] = $estados;
		$data['nid_puesto'] = $nid_puesto;
		$data['listado_aplicantes'] = 'por-puesto';
		$data['vista']  = 'admin/aplicantes';

		


		$parametro_pagina ="";
		$parametros = "?nid_puesto=".$nid_puesto;

		if($this->input->get('pagina') != ''){	
		
			$parametro_pagina = 'page='.($this->input->get('pagina')-1);
			$this->breadcrumb->add('Página '.$this->input->get('pagina'));
		}

		//validar acceso a pais
		if($this->session->userdata('user_role')=="administrador país"){
			if($pais_puesto > 0){
				if($pais_puesto != $this->session->userdata('pais_admin')){
					$this->general->noPermitido();
				}
			}
		}
		
		
		

		//para formar todos los parametros necesarios para el filtrado
		if(($this->obtenerParametrosFiltrado() != "") or ($parametro_pagina != "")){			
			if($this->obtenerParametrosFiltrado() != ""){
				if(strlen($parametros)>1){
					$parametros .= "&".$this->obtenerParametrosFiltrado();
				}else{
					$parametros .= $this->obtenerParametrosFiltrado();
				}
			}
			if(($parametro_pagina != "")){
				if(strlen($parametros)>1){
					$parametros .= "&".$parametro_pagina;
				}else{
					$parametros .= $parametro_pagina;
				}
			}
		}


		//pasa los parametros para que sean pasados cuando se hace paginación
		$data['parametros_filtrado'] = $this->obtenerParametrosGetFormat();
		

		//consultar listado de aplicantes general
		$service_url = base_url().'/rrhh/api/users/aplicantes-por-puesto.xml'.$parametros;// .xml asks for xml data in response
		
		//$service_url = base_url().'/rrhh/api/users/aplicantes-por-puesto.xml?nid_puesto='.$nid_puesto;
		
		//consumir recurso
		$result = consumirServicioSinToken($service_url, $session_cookie); 
		$data['aplicantes_general'] = $result->results;
		$data['aplicantes_general_metadata'] = $result->metadata;

		//para premarcar checks filtro cuando se hace un filtrado del listado
		$data['filtros_form'] = $this->obtenerParametrosArray();


		$data['session_cookie'] = $session_cookie;


		
		if($this->input->get('pagina') !== NULL){
			if((($this->input->get('pagina')-1) < 0) or (($this->input->get('pagina')-1) > (int)$data['aplicantes_general_metadata']->total_pages)){
				$this->general->nofount();
			}
		}

		


		$this->breadcrumb->clear();
		$this->breadcrumb->add('Inicio', '/');
		$this->breadcrumb->add('Dashboard', '/admin/dashboard');
		$this->breadcrumb->add('Puestos de Trabajo', '/admin/puestos');
		$this->breadcrumb->add($data['nombre_puesto']);

		$this->load->view('index', $data);
 	}


 	public function detalle_aplicante(){
 		$session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
		$csrf_token = ServicioObtenerToken($session_cookie);
		$aplicante_id = $this->uri->segment(4);

 		$service_url = base_url().'rrhh/api/users/detalle-aplicante.xml?user_id='.$aplicante_id;

 		$result = consumirServicio($service_url, $session_cookie, $csrf_token);
 		//exit(var_export($result));
 		$data['informacion_aplicante'] = $result->results;

 		if($this->session->userdata('lista_ids_aplicantes')!== null){
 			$data['lista_ids_aplicantes'] = $this->session->userdata('lista_ids_aplicantes');
 			$data['aplicante_id'] = $aplicante_id;
 		}
 		

 		$service_url_puestos_aplicados = base_url().'rrhh/api/users/puestos_aplicados_total/retrieve.xml?uid_aplicante='.$aplicante_id.'';
 		$result_puestos_aplicados = consumirServicio($service_url_puestos_aplicados, $session_cookie, $csrf_token);
 		

 		if(($this->session->userdata('user_role')=="administrador país") or ($this->session->userdata('user_role')=="administrador junior")){

 			//Valida primero si el pais del administrador coincide con el pais del aplicante
 			$permiso_admin_pais = false;
 			if (isset($data['informacion_aplicante']->item->field_pais_trabajar_1->item)){
	 			foreach ($data['informacion_aplicante']->item->field_pais_trabajar_1->item as $key => $value) {
		 			if($value==$this->session->userdata('pais_admin')){
		 				$permiso_admin_pais = true;
		 			}
	 			}
	 			
	 		}

	 		//Valida si el pais del administrador coincide con el pais de alguno de los puestos a los cuales el aplicante ha aplicado
	 		if(isset($result_puestos_aplicados->item)){
	 			foreach($result_puestos_aplicados->item as $key => $value){
	 				//consultar paisvalue de Puesto
					$service_url_puesto_pais = base_url().'rrhh/api/puestos/puesto-detalle-simple.xml?nid_puesto='.$value->nid_puesto; // .xml asks for xml data in response
					$result_pais_puesto = consumirServicio($service_url_puesto_pais, $session_cookie, $csrf_token); 				
					
					//exit(var_export($result_pais_puesto));
					//obetner pais para validar acceso
					if (isset($result_pais_puesto->results[0]->item->field_pais)){
						if($result_pais_puesto->results[0]->item->field_pais == $this->session->userdata('pais_admin')){
							$permiso_admin_pais = true;
						}						
					}
	 			}
	 		}

	 		if($permiso_admin_pais==false){
	 			$this->general->noPermitido();
	 		}
 		}
 		
 		//validamos si en la sesion 'caplicantes' no encontramos en el listado por puesto para actualizar el estado 'no leido' a 'leido'
 		$tipo = $this->session->userdata('aplicantes')['tipo'];
 		if($tipo == 'por-puesto'){
 			//buscamos el estado de la aplicacion del usuario, si es igual a no leido, pasa a leido
 			//actualuzar con base en el id del puesto y en uid del aplicante
 			$nid_puesto = $this->session->userdata('aplicantes')['id-puesto'];
 			$result2 = consultarEstadoAplicante($aplicante_id, $nid_puesto, $session_cookie);
 			if((string)$result2->item->tid == '27'){
 				$this->actualizarEstadoAplicante($aplicante_id, $nid_puesto, '26', false);	
 			} 		
 		
 		} 
 		

 		//consultar los estados de cada puesto
		$estadosBitacora = $this->obtenerListadoEstadosBitacora(false);	
		foreach ($estadosBitacora->results as $item) {
			$option = '';
			foreach ($item as $key) {
				$option .= '<option value="' . $key->tid . '">' . $key->name . '</option>';
			}
		}

	   //consultar todos los puestos aplicados por el aplicante	
		$puestosAplicados = $this->obtenerListaPuestosAplicadosPorAplicante($aplicante_id, false);
		
	
	
		
		$rows = '';

		

		//$select = '<select id="cambiar-estado">'.$option.'</select>';
		$select_new = '';
		foreach ($puestosAplicados->results as $item) {
			foreach ($item as $key) {
				
				if($key->Nid!=""){
					$rows .= '<tr id="aplicante-' . $aplicante_id . '">';
					$rows .= '<td class="puesto-' . $key->Nid . '"><p class="title"><a target="_blank" href="/puestos/' . $this->general->formatURL($key->title) . '/' . $key->Nid . '">' . $key->title . '</a></p><p class="descripcion">' . strip_tags($key->descripcion) . '</p></td>';
					
					$estado_por_puesto = $this->consultarEstadoAplicante($aplicante_id, $key->Nid, false);
					foreach ($estado_por_puesto as $key2) {
						$pos = strpos($option, 'value="' . $key2->tid . '"');
						if($pos == true){
							$option_new = str_replace('value="' . $key2->tid . '"', 'value="' . $key2->tid . '" selected="selected"', $option);
						} 
						$select_new = '<select id="cambiar-estado" data-aplicante="' . $aplicante_id . '" data-puesto="' . $key->Nid . '">'.$option_new.'</select>';
					}
					$rows .= '<td class="estado" width="180"><p>' . $select_new . '</p></td>';
					$rows .= '</tr>';
				}
				
			}
		}

		if($rows != ""){
			$thead = '<thead><tr><th>Puestos</th><th width="170">Estados</th></tr></thead>';
			$table = '<table class="filtro_puestos_aplicados detalle_aplicante">'.$thead.$rows.'</table>';
			$data['puestos_aplicados'] = $table;
		}
		
		
		
		//var_export($puestosAplicados);

 		$data['titulo'] = 'Administración - Detalle de Aplicante: '.$data['informacion_aplicante']->item->field_nombre_y_apellidos;
 		$data['meta_desc'] = '';
		$data['meta_keywords'] = '';
		$data['vista']  = 'admin/aplicante_detalle';
		$this->breadcrumb->add('Inicio', '/');
		$this->breadcrumb->add('Dashboard', '/admin/dashboard');

		if($tipo == 'general'){
			$this->breadcrumb->add('Aplicantes' , '/admin/aplicantes');
			$this->breadcrumb->add('Detalle de Aplicante: '.$data['informacion_aplicante']->item->field_nombre_y_apellidos);
		} else {

			$service_url2 = base_url().'rrhh/api/puestos/puesto-detalle-simple.xml?nid_puesto='.$nid_puesto; // .xml asks for xml data in response
			//consumir recurso
			$result2 = consumirServicio($service_url2, $session_cookie, $csrf_token); 	
			$nid_puesto = $this->session->userdata('aplicantes')['id-puesto'];		
			$this->breadcrumb->add('Puestos de Trabajo', '/admin/puestos');
			$this->breadcrumb->add($result2->results[0]->item->title,"/puestos/".$this->general->formatURL($result2->results[0]->item->title)."/".$nid_puesto);
			$this->breadcrumb->add('Detalle de Aplicante: '.$data['informacion_aplicante']->item->field_nombre_y_apellidos);
		}

		$this->load->view('index', $data);
 	}

 	public function obtenerListaPuestosAplicadosPorAplicante($uid_aplicante, $returnJSON = true){
 		$session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
 		$csrf_token = ServicioObtenerToken($session_cookie);
		// Obtener todos los puestos aplicados por el aplicante
		$puestos_aplicados_url = base_url().'rrhh/api/users/listado-puestos-aplicados-por-aplicante?uid_aplicante=' . $uid_aplicante . '.xml';
		$puestos_aplicados = consumirServicioSinToken($puestos_aplicados_url, $session_cookie);

		if($returnJSON){
			$data['response'] = $puestos_aplicados->results;
			$this->load->view('user/user-response', $data);	
		}else{
			return $puestos_aplicados;
		}		
 	}

 	public function obtenerListadoEstadosBitacora($byJavascript = true){
 		$session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
 		$estados_bitacora_listado = base_url().'/rrhh/api/filtros/filtros-taxonomias-estados-bitacora.xml';
		$listado = consumirServicioSinToken($estados_bitacora_listado, $session_cookie);
		if($byJavascript){
			$data['response'] = $listado->results;
			$this->load->view('user/user-response', $data);
		}else{
			return $listado;
		}
 	}

 	public function consultarEstadoAplicante($uid_aplicante, $nid_puesto, $returnJSON = true){
 		$session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
 		$estados_bitacora_listado = base_url().'rrhh/api/users/puestos_aplicados_bitacora/retrieve?uid_aplicante=' . $uid_aplicante . '&nid_puesto=' . $nid_puesto . '.xml';
		$listado = consumirServicioSinToken($estados_bitacora_listado, $session_cookie);
		if($returnJSON){
			$data['response'] = $listado;
			$this->load->view('user/user-response', $data);
		} else {
			return $listado;
		}
 	}

 	public function actualizarEstadoAplicante($uid_aplicante, $nid_puesto, $tid_estado, $return = true){

 		//validar los puestos aplicados por el usuario como preseleccionado
 		$session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
 		$csrf_token = ServicioObtenerToken($session_cookie);

 	
		$user_data= array();
 		//Primero consultamos si el usuario tiene campos con valores nulos
 		$service_url = base_url().'rrhh/api/users/detalle-aplicante.xml?user_id='.$uid_aplicante;

 		$result = consumirServicio($service_url, $session_cookie, $csrf_token);
 		//exit(var_export($result));
 		$data['informacion_aplicante'] = $result->results;


 		//exit(var_export($data['informacion_aplicante']));

		 		
 		if(empty($data['informacion_aplicante']->item->field_discapacidad) ){
 			$tid_discapacidad=91;
 			 			
 			$user_data["field_discapacidad"] = array(
										"und" => array(
											"0" => $tid_discapacidad
										)
									);
 		}

 		if(empty($data['informacion_aplicante']->item->field_estado_civil) ){
 			$tid_estado_civil=92;			
 			
 			$user_data["field_estado_civil"] = array(
										"und" => array(
											"0" => $tid_estado_civil
										)
									);
 		}


		if(empty($data['informacion_aplicante']->item->field_trabajo_anteriormente_bac) ){
 			$tid_trabajo_bac_anteriormente=93;
 			
 			$user_data["field_trabajo_anteriormente_bac"] = array(
										"und" => array(
											"0" => $tid_trabajo_bac_anteriormente
										)
									);
 		}





 		/*Aquí actualiza el estado*/
 		$request_url = base_url().'rrhh/api/users/user/'. $uid_aplicante;
		

		//echo 'test';
		//exit();

		// cURL

		

		$user_data["field_estado"] = array(
									"und" => array(
										$tid_estado => $tid_estado
									)
								);
		$user_data["field_ultimo_puesto_aplicado"] = array(
									"und" => array(
										$nid_puesto => $nid_puesto
									)
								);

//exit(var_export($user_data));
		$result = ServicioActualizar($request_url, $user_data, $session_cookie, $csrf_token);

		if($return){
			$httpcode = $result['httpcode'];
			$mensaje = $result['mensaje'];
			if($httpcode == 200){
					$data['success'] = true;
				} else {
					$data['success'] = false;
					$data['error'] = $mensaje;
					$data['code'] = $httpcode;
				}
			$data['response'] = $data;
			$this->load->view('user/user-response', $data);
		}
 	}

 	public function obtenerParametrosFiltrado(){
 		$parametros_filtro ="";

		/*if($this->input->get('idioma')){
			if($parametros_filtro!=""){
				$parametros_filtro .= "&";
			}
			foreach ($this->input->get('idioma') as $key => $value) {
				if($key>0){
					$parametros_filtro .= "&";
				}
				$parametros_filtro .= "idioma-id[".$key."]=".$value;

			}
			
		} */
		if ($this->input->get('preparacion')){
			if($parametros_filtro!=""){
				$parametros_filtro .= "&";
			}
			foreach ($this->input->get('preparacion') as $key => $value) {
				if($key>0){
					$parametros_filtro .= "&";
				}
				$parametros_filtro .= "nivel-id[".$key."]=".$value;

			}
		}
		if ($this->input->get('carrera')){
			if($parametros_filtro!=""){
				$parametros_filtro .= "&";
			}
			foreach ($this->input->get('carrera') as $key => $value) {
				if($key>0){
					$parametros_filtro .= "&";
				}
				$parametros_filtro .= "carrera-id[".$key."]=".$value;

			}
		}


		if ($this->input->get('pais')){
			if($parametros_filtro!=""){
				$parametros_filtro .= "&";
			}
			foreach ($this->input->get('pais') as $key => $value) {
				if($key>0){
					$parametros_filtro .= "&";
				}
				$parametros_filtro .= "pais-id[".$key."]=".$value;

			}
		}
		if ($this->input->get('genero')){
			if($parametros_filtro!=""){
				$parametros_filtro .= "&";
			}
			foreach ($this->input->get('genero') as $key => $value) {
				if($key>0){
					$parametros_filtro .= "&";
				}
				$parametros_filtro .= "genero[".$key."]=".$value;

			}
		}		

		return $parametros_filtro;
 	}

 	public function obtenerParametrosArray(){
 		$array_filtro =array();

		/*if($this->input->get('idioma')){
			if($parametros_filtro!=""){
				$parametros_filtro .= "&";
			}
			foreach ($this->input->get('idioma') as $key => $value) {
				if($key>0){
					$parametros_filtro .= "&";
				}
				$parametros_filtro .= "idioma-id[".$key."]=".$value;

			}
			
		} */
		if ($this->input->get('preparacion')){
			
			foreach ($this->input->get('preparacion') as $key => $value) {
				
				$array_filtro["nivel-id"][$key] = $value;


			}
		}
		if ($this->input->get('carrera')){
			
			foreach ($this->input->get('carrera') as $key => $value) {
				
				$array_filtro["carrera-id"][$key] = $value;

			}
		}
		if ($this->input->get('pais')){
			
			foreach ($this->input->get('pais') as $key => $value) {
				
				$array_filtro["pais-id"][$key] = $value;

			}
		}else{ // esto es por si se ha hecho un filtrado general desde el cambiador de pais
			if($this->session->userdata('aplicantes')['tipo']=="general"){
				if($this->session->userdata('pais_admin')>0){
					$array_filtro["pais-id"][0] = $this->session->userdata('pais_admin'); 
				}
			}
			
		}
		if ($this->input->get('genero')){
			
			foreach ($this->input->get('genero') as $key => $value) {
				
				$array_filtro["genero"][$key] = $value;

			}
		}			

		return $array_filtro;
 	}

 	public function obtenerParametrosGetFormat(){
 		$parametros_get_format ="";

		/*if($this->input->get('idioma')){
			if($parametros_filtro!=""){
				$parametros_filtro .= "&";
			}
			foreach ($this->input->get('idioma') as $key => $value) {
				if($key>0){
					$parametros_filtro .= "&";
				}
				$parametros_filtro .= "idioma-id[".$key."]=".$value;

			}
			
		} */
		if ($this->input->get('preparacion')){
			if($parametros_get_format!=""){
				$parametros_get_format .= "&";
			}
			foreach ($this->input->get('preparacion') as $key => $value) {
				if($key>0){
					$parametros_get_format .= "&";
				}
				$parametros_get_format .= "preparacion[]=".$value;

			}
		}
		if ($this->input->get('carrera')){
			if($parametros_get_format!=""){
				$parametros_get_format .= "&";
			}
			foreach ($this->input->get('carrera') as $key => $value) {
				if($key>0){
					$parametros_get_format .= "&";
				}
				$parametros_get_format .= "carrera[]=".$value;

			}
		}
		if ($this->input->get('pais')){
			if($parametros_get_format!=""){
				$parametros_get_format .= "&";
			}
			foreach ($this->input->get('pais') as $key => $value) {
				if($key>0){
					$parametros_get_format .= "&";
				}
				$parametros_get_format .= "pais[]=".$value;

			}
		}else{ // esto es por si se ha hecho un filtrado general desde el cambiador de pais
			if($this->session->userdata('aplicantes')['tipo']=="general"){
				if($this->session->userdata('pais_admin')>0){				
					if($parametros_get_format!=""){
						$parametros_get_format .= "&";
					}
					$parametros_get_format .= "pais[]=".$this->session->userdata('pais_admin');
				}
			}
		}
		if ($this->input->get('genero')){
			if($parametros_get_format!=""){
				$parametros_get_format .= "&";
			}
			foreach ($this->input->get('genero') as $key => $value) {
				if($key>0){
					$parametros_get_format .= "&";
				}
				$parametros_get_format .= "genero[]=".$value;

			}
		}		

		return $parametros_get_format;
 	}

 	


 
}
