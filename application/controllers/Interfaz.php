<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Interfaz extends CI_Controller {

    public function __construct()
    {
	    parent::__construct();
	    $this->load->library('upload');
	    $this->load->model('File_managed');
	    $this->load->model('Node');
	    $this->load->model('Users');
	    $this->load->library('email');
    }

    public function actualizarEstadoAplicante($uid_aplicante, $nid_puesto, $tid_estado){
		//url para actualizar en estado de la ultima aplicacion del usuario     		
	 	$request_url = base_url().'rrhh/api/users/user/'. $uid_aplicante;	

    	//validar los argumentos url
    	if(!is_numeric($nid_puesto) || !is_numeric($uid_aplicante) || !is_numeric($tid_estado)){
    		$data['success'] = false;
			$data['error'] = 'Alguno de los argumentos no es numérico';
			$data['code'] = '406';
    	}else{
	 		$auth_data = $this->autenticacion();
		 	
		 	//validar sesion del usuario
		 	if($auth_data['valido']){
				$csrf_token = $auth_data['csrf_token'];
				$session_cookie = $auth_data['session_cookie'];

				//validar existencia del puesto
				$node = $this->Node->load($nid_puesto);
				if((int)count($node) > 0){

					//validar el usuario si existe
					$user = $this->Users->load($uid_aplicante);
					if((int)count($user) > 0){

						$puesto = $this->Node->load($nid_puesto);
						$usuario_admin = $this->Users->load($puesto[0]->uid);
						
						//validar autoria
						//validar usuario administrador
						if($_POST['mail'] == $usuario_admin[0]->mail){
							//Obtener el aplicante
							$aplicante_url = base_url('/rrhh/api/users/detalle-aplicante-blip.xml?user_id='.$uid_aplicante);
							$obtener_aplicante = consumirServicio($aplicante_url, $session_cookie, $csrf_token);

							$validar_aplicante = false;
							foreach ($obtener_aplicante->results as $key => $value) {
								foreach ($value as $key2 => $value2) {
									$pais_trabajar = $value2->field_pais_trabajar;
									foreach ($pais_trabajar as $key3 => $value3) {
										foreach ($value3->item as $key4 => $value4) {
											//validar si el aplicante desea laborar en Costa Rica
											if($value4->target_id == '10'){
												$validar_aplicante = true;		
											}
										}
									}
								}
							}

							//validar el aplicante
							if($validar_aplicante){	
								//validar si el estado ingresado es el que corresponde
								$estados_url = base_url('/rrhh/api/filtros/filtros-taxonomias-estados-bitacora.xml');
								$estados = consumirServicio($estados_url, $session_cookie, $csrf_token);
								$estado_valido = false;
								foreach ($estados->results as $key => $value) {
									foreach ($value as $key2 => $value2) {
										if($tid_estado == (int)$value2->tid){
											$estado_valido = true;
										}
									}
								}

								if($estado_valido){
									//verificar si el puesto a modificar es el correcto al usuario
									//extrar todas las aplicaciones del usuario
									//Obtener todos los puestos aplicados por el aplicante
									$puestos_aplicados_url = base_url('/rrhh/api/users/listado-puestos-aplicados-por-aplicante.xml?uid_aplicante='.$uid_aplicante);
									$puestos_aplicados_por_aplicante = consumirServicio($puestos_aplicados_url, $session_cookie, $csrf_token);

									$aplicacion_encontrada = false;
									foreach ($puestos_aplicados_por_aplicante->results as $key => $value) {
										foreach ($value as $key2 => $value2) {
											if($nid_puesto == (int)$value2->Nid){
												$aplicacion_encontrada = true;
											}
										}
									}

									// Obtener todos los puestos aplicados por el aplicante
									$puestos_aplicados_url = base_url('/rrhh/api/puestos/puestos_aplicados_por_aplicante.xml?uid='.$uid_aplicante);
									$puestos_aplicados = consumirServicio($puestos_aplicados_url, $session_cookie, $csrf_token);

									//validar si el puesto esta asignado al usuario, de lo contrario se realizara una auto asignacion
									if($aplicacion_encontrada){
										//validar preselecciones
										$listado_puestos = array();
										foreach ($puestos_aplicados->items as $value) {
											foreach ($value->item as $key2 => $value2) {
												$puesto = $value2;
												array_push($listado_puestos, array('estado' => (string)$puesto->tid_estado));
											}
										}
										$count_preselecciones = 0;
										foreach ($listado_puestos as $key => $value) {
											if($value['estado'] == '29')
												$count_preselecciones++;
										}

										if(($count_preselecciones < 1) || (($count_preselecciones == 1) && ($tid_estado != 29))) {

											$user_data = array("field_estado" => array(
																		"und" => array(
																			$tid_estado => $tid_estado
																		)
																	),
																"field_ultimo_puesto_aplicado" => array(
																		"und" => array(
																			$nid_puesto => $nid_puesto
																		)
																	),
															   );

											// cURL - utiliza el helper SevicioActualizar
											$result = ServicioActualizar($request_url, $user_data, $session_cookie, $csrf_token);

											if($result){
												$data['success'] = true;
												$data['code'] = $result['httpcode'];		
												if($data['code'] != 200){
													$data['success'] = false;
													$data['mensaje'] = $result['mensaje'];
												}
											}
										}else{
											//no se encontro ninguna aplicacion con el id ingresado desde el url
											$data['success'] = false;
											$data['error'] = 'Ha excedido la cantidad de preselecciones por aplicante';
											$data['code'] = '406';
										}	
									} else {

										//validar cantidad de aplicaciones y preselecciones
										if((int)count($puestos_aplicados_por_aplicante->results->item) < 3){

											//validar preselecciones
											$listado_puestos = array();
											foreach ($puestos_aplicados->items as $value) {
												foreach ($value->item as $key2 => $value2) {
													$puesto = $value2;
													array_push($listado_puestos, array('estado' => (string)$puesto->tid_estado));
												}
											}

											$count_preselecciones = 0;
											foreach ($listado_puestos as $key => $value) {
												if($value['estado'] == '29')
													$count_preselecciones++;
											}

											//exit(var_dump($count_preselecciones));

											if(($count_preselecciones < 1) || (($count_preselecciones == 1) && ($tid_estado != 29))) {

												//obtener el estado general, si esta en lista negra se sobreescribe el estado a aplicar
												$estado_general_url = base_url('/rrhh/api/users/obtener_estado_general/retrieve.xml?uid_aplicante='. $uid_aplicante);
												$estado_general = consumirServicio($estado_general_url, $session_cookie, $csrf_token);
												$tid_estado_general = 0;

												if(isset($estado_general->item)){
	 												foreach($estado_general->item as $key => $value){
	 													$tid_estado_general = $value->tid_estado;
	 												}
	 											}

	 											if($tid_estado_general == 28){
	 												$tid_estado = $tid_estado_general;
	 											}

	 											//$data['message'] = $tid_estado;

	 											//Se realizará una asignacion automática
												$user_data = array("field_estado" => array(
																			"und" => array(
																				(int)$tid_estado => (int)$tid_estado
																			)
																		),
																	"field_ultimo_puesto_aplicado" => array(
																			"und" => array(
																				$nid_puesto => $nid_puesto
																			)
																		),
																	"field_puesto" => array(
																			"und" => array()
																		),
																   );

											 	//exit(var_dump($puestos_aplicados));

												$listado_puestos = array();
												foreach ($puestos_aplicados->items as $value) {
													foreach ($value->item as $key2 => $value2) {
														$puesto = $value2;
														$listado_puestos[(string)$puesto->nid_puesto] = (string)$puesto->nid_puesto;
													}
												}
												//exit(var_dump($listado_puestos));
												//asignar el arreglo de los puestos aplicados junto con el que hay que agregar
												$user_data["field_puesto"]["und"] = $listado_puestos;
												$user_data["field_puesto"]["und"][$nid_puesto] = $nid_puesto;														

												//exit(var_dump($user_data));

												// cURL - utiliza el helper SevicioActualizar
												$result = ServicioActualizar($request_url, $user_data, $session_cookie, $csrf_token);

												if($result){
													$data['success'] = true;
													$data['code'] = $result['httpcode'];					
													$data['mensaje'] = 'Se ha aplicado satisfactoramiente al puesto con el id: ' . $nid_puesto;					
													if($data['code'] != 200){
														$data['success'] = false;
														$data['mensaje'] = $result['mensaje'];
													}
												}

											}else{
												//no se encontro ninguna aplicacion con el id ingresado desde el url
												$data['success'] = false;
												$data['error'] = 'Ha excedido la cantidad de preselecciones por aplicante';
												$data['code'] = '406';
											}								

										}else{
											//no se encontro ninguna aplicacion con el id ingresado desde el url
											$data['success'] = false;
											$data['error'] = 'No es posible realizar la aplicación, se ha excedido el máximo permitido de 3 puestos por usuario';
											$data['code'] = '406';
										}
									}							

								}else{
									//no se encontro ninguna aplicacion con el id ingresado desde el url
									$data['success'] = false;
									$data['error'] = 'Has ingresado un codigo de estado incorrecto, favor verifique';
									$data['code'] = '406';
								}

							} else {
								//no se pudo validar que el aplicante sea nacional
								$data['success'] = false;
								$data['error'] = 'El usuario aplicante con el id #'.$uid_aplicante. ', no es es permitido para hacer la asignación';
								$data['code'] = '406';
							}
						}else{
							$data['success'] = false;
							$data['error'] = 'Error: El puesto con el identificador #'.$nid_puesto.', no pertenece al usuario: '.$_POST['mail'];
							$data['code'] = '406';
						}

					}else{
						//no se pudo validar que el aplicante sea nacional
						$data['success'] = false;
						$data['error'] = 'No existe el aplicante con el codigo: '.$uid_aplicante.', por favor verifique';
						$data['code'] = '406';
					}

				} else {
					//no se pudo validar que el aplicante sea nacional
					$data['success'] = false;
					$data['error'] = 'No existe el puesto con el codigo: '.$nid_puesto.', por favor verifique';
					$data['code'] = '406';
				}			

			} else {
				//mensaje de error al fallar la autenticacion
				$data['success'] = false;
				$data['error'] = $auth_data['mensaje'];
				$data['code'] = '406';
			}
		}
			
			$data['response'] = $data;
			$this->load->view('user/user-response', $data);
 	}
 	
 	public function liberarEstadoAplicante($uid_aplicante, $nid_puesto, $return = true){
 		
 		//validar los argumentos url
    	if(!is_numeric($nid_puesto) || !is_numeric($uid_aplicante)){
    		$data['success'] = false;
			$data['error'] = 'Alguno de los argumentos no es numérico';
			$data['code'] = '406';
    	}else{
	 		$auth_data = $this->autenticacion();

		 	if($auth_data['valido']){
				$csrf_token = $auth_data['csrf_token'];
				$session_cookie = $auth_data['session_cookie'];

		 		$request_url = base_url().'rrhh/api/users/user/'. $uid_aplicante;
				$user_data = array("field_estado" => array(
											"und" => array(
												'27' => '27'
											)
										),
									"field_ultimo_puesto_aplicado" => array(
											"und" => array(
												$nid_puesto => $nid_puesto
											)
										),
									"field_liberar_estado" => array(
											"und" => array(
												'88' => '88'
											)
										),
								   );
				// cURL
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
		}
 	}

 	public function liberarEstadoAplicanteDirecto($uid_aplicante, $tid_estado, $return = true){
 		
 		//validar los argumentos url
    	if(!is_numeric($uid_aplicante) || !is_numeric($tid_estado)){
    		$data['success'] = false;
			$data['error'] = 'Alguno de los argumentos no es numérico';
			$data['code'] = '406';
    	}else{
	 		$auth_data = $this->autenticacion();
		 	if($auth_data['valido']){
				$csrf_token = $auth_data['csrf_token'];
				$session_cookie = $auth_data['session_cookie'];

				//validar si el estado ingresado es el que corresponde
				$estados_url = base_url('/rrhh/api/filtros/filtros-taxonomias-estados-bitacora.xml');
				$estados = consumirServicio($estados_url, $session_cookie, $csrf_token);
				$estado_valido = false;
				foreach ($estados->results as $key => $value) {
					foreach ($value as $key2 => $value2) {
						if($tid_estado == (int)$value2->tid){
							$estado_valido = true;
						}
					}
				}

				if($estado_valido){

					//validar el usuario si existe
					$user = $this->Users->load($uid_aplicante);
					if((int)count($user) > 0){					

				 		$request_url = base_url().'rrhh/api/users/liberar_estado/retrieve.xml?idAplicante='. $uid_aplicante . '&idEstado='. $tid_estado;
						$result = consumirServicio($request_url, $session_cookie, $csrf_token);

						if($return){
							$data['success'] = true;
							$data['error'] = 'Estado general actualizado satisfactoramiente';
							$data['code'] = '200';
									
						}
					}else{
						//no se pudo validar que el aplicante sea nacional
						$data['success'] = false;
						$data['error'] = 'No existe el aplicante con el codigo: '.$uid_aplicante.', por favor verifique';
						$data['code'] = '406';
					}
				} else {
					//no se encontro ninguna aplicacion con el id ingresado desde el url
					$data['success'] = false;
					$data['error'] = 'Has ingresado un codigo de estado incorrecto, favor verifique';
					$data['code'] = '406';
				}
			}
		}

		$data['response'] = $data;
		$this->load->view('user/user-response', $data);
 	}

 	public function desaplicar($uid_aplicante, $nid_puesto){
 		//obtener listado de puestos
 		if(!is_numeric($nid_puesto) || !is_numeric($uid_aplicante)){
    		$data['success'] = false;
			$data['error'] = 'Alguno de los argumentos no es numérico';
			$data['code'] = '406';
    	}else{
	 		$auth_data = $this->autenticacion();
	 		//exit(var_dump($auth_data));
	 		if($auth_data['valido']){
				$csrf_token = $auth_data['csrf_token'];
				$session_cookie = $auth_data['session_cookie'];
				//obtener el puesto y validad la autoria
				$puesto = $this->Node->load($nid_puesto);
				$usuario_admin = $this->Users->load($puesto[0]->uid);
				//validar usuario administrador
				if($_POST['mail'] == $usuario_admin[0]->mail){
					//si es el mismo se extrae todas las aplicaciones del usuario objetivo
					$puestos_aplicados_url = base_url('/rrhh/api/puestos/puestos_aplicados_por_aplicante.xml?uid='.$uid_aplicante);
					$puestos_aplicados = consumirServicio($puestos_aplicados_url, $session_cookie, $csrf_token);

					$listado_puestos = array();
					foreach ($puestos_aplicados->items as $value) {
						foreach ($value->item as $key2 => $value2) {
							$puesto = $value2;
							$listado_puestos[(string)$puesto->nid_puesto] = (string)$puesto->nid_puesto;
						}
					}
					
					//validar que el puesto a remover se encuentra dentro del listado de puestos aplicados
					$puesto_encontrado = false;
					foreach ($listado_puestos as $key => $value) {
						if($value == $nid_puesto)
							$puesto_encontrado = true;
					}
					
					//si se encuentra se remueve, sino se muestra un mensaje indicando que el puesto a desaplicar no fue encontrado
					if($puesto_encontrado){
						//remover puesto
						//Se realizará una asignacion automática
						$user_data = array("field_puesto" => array(
													"und" => array()
												),
										   );

						unset($listado_puestos[$nid_puesto]);
						$user_data["field_puesto"]["und"] = $listado_puestos;								
						// cURL - utiliza el helper SevicioActualizar
						$request_url = base_url().'rrhh/api/users/user/'. $uid_aplicante;	
						$result = ServicioActualizar($request_url, $user_data, $session_cookie, $csrf_token);

						$aplicante = $this->Users->load($uid_aplicante);
						$correo = (string)($aplicante[0]->mail);

						$puesto = $this->Node->load($nid_puesto);
						$puesto_title = (string)($puesto[0]->title);
						
						$body = '<img src="'.base_url().'/public/images/logo.gif" width="375" height="65"><br><br>
								<br /><br />
					        	<table>
						        	<tbody>
							        	<tr>
							        		<td>Has sido descartado del puesto> '.$puesto_title.'</td>
							        	</tr>
						        	</tbody>
					        	</table>'; // Mensaje a enviar

						$config['charset'] = 'UTF-8';
						$config['mailtype'] = 'html';
						$this->email->initialize($config);
						$this->email->from('reclutamientoregional@empleosbaccredomatic.com', 'Empleos BAC | Credomatic');
						$this->email->to($correo); 
						/*$this->email->cc('another@another-example.com'); 
						$this->email->bcc('them@their-example.com'); */

						$this->email->subject("Descartar puesto \r\n");
						$this->email->message($body);

						//También podríamos agregar simples verificaciones para saber si se envió:
						$status_email = $this->email->send();

						if($result){
							$data['success'] = true;
							$data['code'] = $result['httpcode'];				
							if($status_email != false){
								$data['success'] = false;
								$data['mensaje'] = 'No fue posible enviar el correo, revise la configuracion SMTP';
							}else if($data['code'] != 200){
								$data['success'] = false;
								$data['mensaje'] = $result['mensaje'];
							}
						}
					}else{
						$data['success'] = false;
						$data['error'] = 'El puesto con el identificador #'.$nid_puesto.', no se encuentra entre los puestos aplicados por el usuario seleccionado';
						$data['code'] = '406';
					}
				}else{
					$data['success'] = false;
					$data['error'] = 'Error: El puesto con el identificador #'.$nid_puesto.', no pertenece al usuario: '.$_POST['mail'];
					$data['code'] = '406';
				}
			}
	 	}
	 	$data['response'] = $data;
		$this->load->view('user/user-response', $data);
 	}

 	public function agregarPuesto(){
 		$auth_data = $this->autenticacion();

		if($this->input->post()){

 			//validar ingreso inicio de sesion
 			if($auth_data['valido']){
				$csrf_token = $auth_data['csrf_token'];
				$session_cookie = $auth_data['session_cookie'];
				$service_url = base_url().'/rrhh/api/puestos/node.json'; // .xml asks for xml data in response
				$post_data = $this->input->post(null, true);

				//exit(var_dump($post_data));
				$post_data['type'] = 'puesto_vacante';
				$post_data['field_pais']['und'][0] = 10; 

				//antes de enviar los datos de los puestos, hay que validar que los campos son los correctos, pasos:
				//1. extrer listado (paises, )
				//2. verificar que el codigo ingresado corresponde con el campo que se envio por metodo post
				/*$cod_pais = 0;
				$pais_valido = true;
				if(isset($post_data['field_pais']['und'][0])){
					$post_data['field_pais']['und'][0] = 10;
				} else {
					$mensaje_error = 'El campo: field_pais[und][0] es obligatorio';
				}
				if($cod_pais != 10){
					$pais_valido = false;	
				}

				if($pais_valido){*/
				//****** validar jornada *******
				$jornadas = ObtenerListado('filtros', 'filtros-taxonomias-jornadas', $session_cookie, $csrf_token);

				//exit(var_dump($jornadas));

				$cod_jornada = 0;
				$mensaje_error = 'El código jornada ingresado no existe, por favor verifique';
				if(isset($post_data['field_tipo_de_jornada']['und'][0])){
					$cod_jornada = (string)$post_data['field_tipo_de_jornada']['und'][0];
				} else {
					$mensaje_error = 'El campo: field_tipo_de_jornada[und][0] es obligatorio';
				}
				$jornada_valido = $this->validarEntidades($jornadas, $cod_jornada);

				if($jornada_valido){

					//****** validar carreras *******
					$carreras = ObtenerListado('filtros', 'filtros-entidades-carreras', $session_cookie, $csrf_token, false);

					//exit(var_dump($carreras));

					$cod_carrera = 0;
					$mensaje_error = 'El código carrera ingresado no existe, por favor verifique';
					if(isset($post_data['field_carrera']['und'][0])){
						$cod_carrera = (string)$post_data['field_carrera']['und'][0];
					} else {
						$mensaje_error = 'El campo: field_carrera[und][0] es obligatorio';
					}
					$carrera_valido = $this->validarEntidades($carreras, $cod_carrera);

					if($carrera_valido){

						//****** validar nivel academico *******
						$niveles_academicos = ObtenerListado('filtros', 'filtros-taxonomias-nivel-academico', $session_cookie, $csrf_token);
						$cod_nivel_academico = 0;

						$mensaje_error = 'El código del nivel académico ingresado no existe, por favor verifique';
						if(isset($post_data['field_nivel_academico_requerido']['und'][0])){
							$cod_nivel_academico = (string)$post_data['field_nivel_academico_requerido']['und'][0];
						} else {
							$mensaje_error = 'El campo: field_nivel_academico_requerido[und][0] es obligatorio';
						}
						$nivel_academico_valido = $this->validarEntidades($niveles_academicos, $cod_nivel_academico);

						//exit(var_dump($nivel_academico_valido));

						if($nivel_academico_valido){
							
							//****** validar nivel academico *******
							$idiomas = ObtenerListado('filtros', 'filtros-taxonomias-idiomas', $session_cookie, $csrf_token);

							//exit(var_dump($idiomas));

							$cod_idioma_0 =0;
							$cod_idioma_1 = 0;
							$idioma_0_valido = true;
							$idioma_1_valido = true;

							$mensaje_error = 'El código del idioma ingresado no existe, por favor verifique';

							if(isset($post_data['field_idiomas_requeridos']['und'][0])){
								$cod_idioma_0 = (string)$post_data['field_idiomas_requeridos']['und'][0];
								if(isset($post_data['field_idiomas_requeridos']['und'][1])){
									$cod_idioma_1 = (string)$post_data['field_idiomas_requeridos']['und'][1];
								}
							}elseif(isset($post_data['field_idiomas_requeridos']['und'][1])){
								$cod_idioma_1 = (string)$post_data['field_idiomas_requeridos']['und'][1];
							}else{
								$mensaje_error = 'Es necesario agregar por lo menos un idioma, por favor especifique';
							}
							
							if($cod_idioma_0 != 0){
								$idioma_0_valido = $this->validarEntidades($idiomas, $cod_idioma_0);
							}

							if($cod_idioma_1 != 0){
								$idioma_1_valido = $this->validarEntidades($idiomas, $cod_idioma_1);
							}

							if(($idioma_0_valido == true) && ($idioma_1_valido == true)){
								
								//exit(var_dump($post_data));
								
								/**** Validar campo fecha (requerido y formato) ******/
								$fecha_validada = true;
								if(isset($post_data['field_fecha_de_cierre_de_oferta']['und'][0]['value']['date'])){
									$fecha_despublicacion = (string)$post_data['field_fecha_de_cierre_de_oferta']['und'][0]['value']['date'];
									$fecha = $this->validarFecha($fecha_despublicacion);
									$fecha_validada = $fecha['status'];
									$mensaje_error = $fecha['msg'];
								} else {
									$mensaje_error = 'El campo: field_fecha_de_cierre_de_oferta[und][0][value][date] es obligatorio';
								}

								if($fecha_validada == true){

									$puesto = ServicioCrearPuesto($service_url, $session_cookie, $post_data, $csrf_token);				
									if($puesto[1] != 200){
										$error = (string)$puesto[0];
										$data['success'] = false;
										$data['mensaje'] = $error;
										$data['code'] = (int)$puesto[1];
									} else {
										$data['success'] = true;
										$data['mensaje'] = $puesto[0];
										$data['code'] = $puesto[1];
										//el puesto fue agregado satisfactoramiente, ahora se editara el puesto para asociar la imagen
										//$objPuesto = json_decode($puesto[0]);
										//$data = $this->actualizarImagenPuesto($objPuesto->nid, $post_data, $session_cookie, $csrf_token);
										//se subira la imagen correspondiente
										/*if(isset($post_data['imagen_puesto']['und'][0]['date'])){
											$data = $this->actualizarImagenPuesto($objPuesto->nid, $post_data, $session_cookie, $csrf_token);
										} else {
											//mensaje de error al fallar la autenticacion
											$data['success'] = false;
											$data['mensaje'] = $mensaje_error;
											$data['code'] = 406;
										}*/
									}

								} else {
									//mensaje de error al fallar la autenticacion
									$data['success'] = false;
									$data['mensaje'] = $mensaje_error;
									$data['code'] = 406;
								}

							}else{
								//mensaje de error al fallar la autenticacion
								$data['success'] = false;
								$data['mensaje'] = $mensaje_error;
								$data['code'] = 406;
							}
							
						}else{
							//mensaje de error al fallar la autenticacion
							$data['success'] = false;
							$data['mensaje'] = $mensaje_error;
							$data['code'] = 406;
						}							

					} else {
						//mensaje de error al fallar la autenticacion
						$data['success'] = false;
						$data['mensaje'] = $mensaje_error;
						$data['code'] = 406;
					}

				} else {
					//mensaje de error al fallar la autenticacion
					$data['success'] = false;
					$data['mensaje'] = $mensaje_error;
					$data['code'] = 406;
				}
				/*}*/

			} else {
				//mensaje de error al fallar la autenticacion
				$data['success'] = false;
				$data['mensaje'] = $auth_data['mensaje'];
				$data['code'] = 406;
			}
		}else{
			$data['success'] = false;
			$data['mensaje'] = 'vacio';
			$data['code'] = 406;
		}
		$data['response'] = $data;
		$this->load->view('user/user-response', $data);		
 	}

 	public function actualizarPuesto($nid_puesto){
 		$auth_data = $this->autenticacion();
 		if($this->input->post()){
 			//validar ingreso inicio de sesion
 			if($auth_data['valido']){
 				$csrf_token = $auth_data['csrf_token'];
				$session_cookie = $auth_data['session_cookie'];
				$request_url = base_url().'/rrhh/api/puestos/node/'.$nid_puesto; // .xml asks for xml data in response
				$post_data = $this->input->post(null, true);
				// cURL - utiliza el helper SevicioActualizar

				$info = $this->general->getJSON('/rrhh/api/puestos/puesto-detalle-blip?puesto-id='.$nid_puesto);
				
				//exit(var_dump($info));

				//si la fecha esta presente en el post_data no se realizara la consulta, solo se validara el formato

				/**** Validar campo fecha (requerido y formato) ******/
				$validacionFecha = true;
				if(isset($post_data['field_fecha_de_cierre_de_oferta']['und'][0]['value']['date'])){
					$fecha_despublicacion = (string)$post_data['field_fecha_de_cierre_de_oferta']['und'][0]['value']['date'];
					$fecha = $this->validarFecha($fecha_despublicacion);	
					$validacionFecha = $fecha['status'];
				} else {
					$fecha_cierre_oferta = '';
					foreach ($info['results'] as $key => $value) {
						$fecha_cierre_oferta = ($value['field_fecha_de_cierre_de_oferta']['value']);
					}

					$date = new DateTime($fecha_cierre_oferta);
					$formatedDate = (string)$date->format('m/d/Y');
					//exit(var_dump($formatedDate));
					$post_data['field_fecha_de_cierre_de_oferta'] = array(
															"und" => array(
																'0' => array(
																	'value' => array(
																		'date' => $formatedDate
																	)
																)
															)
														);
				}

				//exit(var_dump($post_data));

				if($validacionFecha){
					//actualizar imagen va al final
					//if(isset($post_data['imagen_puesto'])){
					$data = $this->actualizarImagenPuesto($nid_puesto, $post_data, $session_cookie, $csrf_token);
					//}

					/******* Validar jornadas*******/
					$jornadas = ObtenerListado('filtros', 'filtros-taxonomias-jornadas', $session_cookie, $csrf_token);
					$cod_jornada = 0;
					$jornada_valido = true;

					if(isset($post_data['field_tipo_de_jornada']['und'][0])){
						$cod_jornada = (string)$post_data['field_tipo_de_jornada']['und'][0];
						$jornada_valido = $this->validarEntidades($jornadas, $cod_jornada);
					}	

					if($jornada_valido){
						//****** validar carreras *******
						$carreras = ObtenerListado('filtros', 'filtros-entidades-carreras', $session_cookie, $csrf_token, false);
						$cod_carrera = 0;
						$carrera_valido = true;

						if(isset($post_data['field_carrera']['und'][0])){
							$cod_carrera = (string)$post_data['field_carrera']['und'][0];
							$carrera_valido = $this->validarEntidades($carreras, $cod_carrera);
						}	

						if($carrera_valido){

							//****** validar nivel academico *******
							$niveles_academicos = ObtenerListado('filtros', 'filtros-taxonomias-nivel-academico', $session_cookie, $csrf_token);
							$cod_nivel_academico = 0;
							$nivel_academico_valido = true;

							if(isset($post_data['field_nivel_academico_requerido']['und'][0])){
								$cod_nivel_academico = (string)$post_data['field_nivel_academico_requerido']['und'][0];
								$nivel_academico_valido = $this->validarEntidades($niveles_academicos, $cod_nivel_academico);
							}

							if($nivel_academico_valido){

								//****** validar nivel academico *******
								$idiomas = ObtenerListado('filtros', 'filtros-taxonomias-idiomas', $session_cookie, $csrf_token);
								$cod_idioma_0 =0;
								$cod_idioma_1 = 0;
								$idioma_0_valido = true;
								$idioma_1_valido = true;

								if(isset($post_data['field_idiomas_requeridos']['und'][0])){
									$cod_idioma_0 = (string)$post_data['field_idiomas_requeridos']['und'][0];
									if(isset($post_data['field_idiomas_requeridos']['und'][1])){
										$cod_idioma_1 = (string)$post_data['field_idiomas_requeridos']['und'][1];
									}
								}elseif(isset($post_data['field_idiomas_requeridos']['und'][1])){
									$cod_idioma_1 = (string)$post_data['field_idiomas_requeridos']['und'][1];
								}
								
								if($cod_idioma_0 != 0){
									$idioma_0_valido = $this->validarEntidades($idiomas, $cod_idioma_0);
								}

								if($cod_idioma_1 != 0){
									$idioma_1_valido = $this->validarEntidades($idiomas, $cod_idioma_1);
								}

								if(($idioma_0_valido == true) && ($idioma_1_valido == true)){

									$result = ServicioActualizar($request_url, $post_data, $session_cookie, $csrf_token);
									//exit(var_dump($result));
									if((int)$result['httpcode'] != 200){
										$error = $result['mensaje'];
										$data['success'] = false;
										$data['mensaje'] = $error;
										$data['code'] = (int)$result['httpcode'];
									} else {
										//el puesto fue agregado satisfactoramiente, ahora se editara el puesto para asociar la imagen
										$data['success'] = true;
										$data['mensaje'] = 'El puesto se ha actualizado satisfactoramiente';
										$data['code'] = 200;
									}																			

								} else {
									$data['success'] = true;
									$data['mensaje'] = 'El código del idioma ingresado no existe, por favor verifique';
									$data['code'] = 406;
								}
								
							} else {
								$data['success'] = false;
								$data['mensaje'] = 'El código del nivel académico ingresado no existe, por favor verifique';
								$data['code'] = 406;
							}

						} else {
							$data['success'] = false;
							$data['mensaje'] = 'El código de la carrera ingresado no existe, por favor verifique';
							$data['code'] = 406;
						}

					} else {
						$data['success'] = false;
						$data['mensaje'] = 'El código jornada ingresado no existe, por favor verifique';
						$data['code'] = 406;
					}
	 			}else {
	 				$data['success'] = false;
					$data['mensaje'] = $fecha['msg'];
					$data['code'] = 406;
	 			}

 			} else {
				//mensaje de error al fallar la autenticacion
				$data['success'] = false;
				$data['mensaje'] = $auth_data['mensaje'];
				$data['code'] = 406;
			}

			$data['response'] = $data;
			$this->load->view('user/user-response', $data);	
 		}
 	}

	public function obtenerDetalleAplicante($user_id){
		$data = $this->autenticacion();
		$csrf_token = $data['csrf_token'];
		$session_cookie = $data['session_cookie'];

		//validar que el aplicante a modificar el estado sea nacional
		$aplicantes_url = base_url('/rrhh/api/users/aplicantes_costa_rica/retrieve.xml?uid_aplicante='.$user_id);

		$obtener_aplicantes = consumirServicio($aplicantes_url, $session_cookie, $csrf_token);
		$data['response'] = $obtener_aplicantes;
		$this->load->view('user/user-response', $data);
	}

	public function ObtenerAplicantesCostaRica(){
		$data = $this->autenticacion();
		$csrf_token = $data['csrf_token'];
		$session_cookie = $data['session_cookie'];

		//validar que el aplicante a modificar el estado sea nacional
		$aplicantes_url = base_url('/rrhh/api/users/aplicantes-costa-rica-listado.xml');
		$obtener_aplicantes = consumirServicio($aplicantes_url, $session_cookie, $csrf_token);

		$data['response'] = $obtener_aplicantes->results;
		$this->load->view('user/user-response', $data);
	}

 	public function autenticacion(){
		$service_url = base_url('/rrhh/api/users/user/login.xml'); // .xml asks for xml 
		$xml = ServicioInicioSesion($service_url, $_POST);

		//exit(var_dump($xml));

		if(((string)$xml == 'Correo o contraseña inválida') || ((string)$xml == "El correo ingresado no existe o es incorrecto.") || ((string)$xml == "Missing required argument mail") || ((string)$xml == "Missing required argument pass")){
			return array('valido' => false, 'mensaje' => (string)$xml);
		} else {
			$session_cookie = (string)$xml->session_name.'='.(string)$xml->sessid;
			$csrf_token = ServicioObtenerToken($session_cookie);

			//exit(var_dump($csrf_token));

			$informacion_usuario = consumirServicio(base_url('/rrhh/api/users/user/'.(string)$xml->user->uid.'.xml'), $session_cookie);

			//exit(var_dump($informacion_usuario->roles));

			$rol = (string)$informacion_usuario->roles->item[1];
			$main = (string)$informacion_usuario->field_principal->und->item->value;
			if (isset($informacion_usuario->field_nombre_y_apellidos->und)){
				$nombre_completo = (string)$informacion_usuario->field_nombre_y_apellidos->und->item->value;
			}else{
				$nombre_completo = "Administrador";
			}
			$sesion = array('session_name' => (string)$xml->session_name,
						'sessid' => (string)$xml->sessid,
						'user_id' => (string)$xml->user->uid,
						'user_role' => $rol,
						'user_principal' => $main,
						'nombre' => $nombre_completo,
						'token' => $csrf_token,
						'mail' => (string)$xml->user->mail
						);
			//guardar sesion
			$this->session->set_userdata($sesion);
			return array('valido' => true, 'session_cookie' => $session_cookie, 'csrf_token' => $csrf_token);
		}
 	}

 	public function subirImagen($file_path, $file_name, $file_size, $csrf_token, $session_cookie){
		$filedata = array(
		    'filesize' => $file_size,
		    'filename' => $file_name,
		    'file' => 'public://uploads/'.$file_name,
		    'uid'  => $this->session->userdata('user_id')  // This should change it by the user who use the service.
		);

		$service_url = base_url('/rrhh/api/puestos/file.json'); // .xml asks for xml data in response
		
		$resp = ServicioGuardarArchivo($service_url, $session_cookie, $filedata, $csrf_token);
		return $resp;
	}

	protected function uploadFile(){
		$this->file_path_imagen = '';
		$this->file_name_imagen = '';
		$this->file_size_imagen = '';
		$status = false;
		$mensaje = 'La imagen se agrego satisfactoriamente';

		//exit(var_dump($_FILES));

		if (isset($_FILES['imagen_puesto'])){
			if($_FILES['imagen_puesto']['tmp_name'] != ''){
				$config['upload_path'] = './rrhh/sites/default/files/uploads/';
				$config['allowed_types'] = 'jpeg|gif|png|jpg';
				$config['encrypt_name'] = TRUE;
				$config['file_ext_tolower'] = TRUE;
				$this->upload->initialize($config);

				if ($this->upload->do_upload('imagen_puesto'))
				{
					$file_data_imagen = array('upload_data' => $this->upload->data());
					//iniciar sesion automaticamente despues de validar satisfactoriamente el registro del usuario					
					$file_path_imagen = $file_data_imagen['upload_data']['full_path'];
					$file_name_imagen = $file_data_imagen['upload_data']['file_name'];
					$file_size_imagen = $file_data_imagen['upload_data']['file_size'];
					$this->url_avatar = $file_path_imagen;

					//procesar imagen
					$config = array();
					$this->load->library('image_lib');
				    $config['image_library'] = 'gd2';
				    $config['source_image'] = $file_path_imagen;
				    $config['create_thumb'] = TRUE;
				    $config['maintain_ratio'] = TRUE;
				    $config['width']     = 175;
				    $config['height']   = 175;

				    $this->image_lib->clear();
				    $this->image_lib->initialize($config);
				    $this->image_lib->resize();

					//$this->guardarArchivoImagen($file_path_imagen, $file_name_imagen, $file_size_imagen);
					$this->file_path_imagen = $file_path_imagen;
					$this->file_name_imagen = $file_name_imagen;
					$this->file_size_imagen = $file_size_imagen;
					$status = true;
				} else {
					$mensaje = strip_tags($this->upload->display_errors());
				}
			}	
		} else {
			$mensaje = 'El campo imagen_puesto es obligatorio';
		}
		return array('status' => $status, 'mensaje' => $mensaje);
	}

	public function validarEntidades($listado, $obj){
		$return = false;
		foreach ($listado as $key => $value) {
			if($key == $obj){
				$return = true;
				break;
			}
		}
		return $return;
	}

	public function validarFecha($date){
		$split = array();
		if (preg_match ("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $date, $split))
		{
			if(checkdate($split[1],$split[2],$split[3]))
		    {
		      return array('status' => true, 'msg' => 'Correcto');
		    }
		    else
		    {
		      return array('status' => false, 'msg' => 'La fecha no es válida');
		    }
		}else{
			return array('status' => false, 'msg' => 'El formato fecha no es adecuado, debe ser mm/dd/YYYY');
		}
	}

	public function actualizarImagenPuesto($nid_puesto, $post_data, $session_cookie, $csrf_token){
		//se subira la imagen correspondiente
		$img = true;
		$img = $this->uploadFile();

		//exit(var_dump($img));
		if($img['status'] == true){
			$saveimg = $this->subirImagen($this->file_path_imagen, $this->file_name_imagen, $this->file_size_imagen, $csrf_token, $session_cookie);
			
			$objImagen = json_decode($saveimg[0]);
			$request_url = base_url().'rrhh/api/puestos/node/'. $nid_puesto.'.json';
			$puesto_data = array('field_imagen_puesto' => array(
								"und" => array(
									"0" => array(
										"fid" => $objImagen->fid
									)
								)
							),
							'field_fecha_de_cierre_de_oferta' => array(
								"und" => array(
									"0" => array(
										"value" => array(
											"date" => $post_data['field_fecha_de_cierre_de_oferta']['und'][0]['value']['date']
										)
									)
								)
							),
					   );	
			//exit(var_dump($user_data));
			// cURL - utiliza el helper SevicioActualizar
			$result = ServicioActualizar($request_url, $puesto_data, $session_cookie, $csrf_token);
			//exit(var_dump($result));
			//alterar la tabla file managed
			$this->File_managed->modificar($objImagen->fid, $this->file_name_imagen);
			$data['success'] = true;
			$data['mensaje'] = $result;
			$data['code'] = 200;
		} else {
			//mensaje de error al fallar el metodo para subir la imagen
			$data['success'] = false;
			$data['mensaje'] = $img['mensaje'];
			$data['code'] = 406;
		}
		return $data;
	}
}