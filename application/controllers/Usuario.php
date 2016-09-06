<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

	private $url_curriculum;
	private $url_avatar;

	private $file_path_imagen, $file_name_imagen, $file_size_imagen;
	private $file_path, $file_name, $file_size;

    public function __construct()
    {
	    parent::__construct();
	    $this->load->library('upload');
	    $this->load->library('user_agent');
	    $this->load->library('emailverify');
	    $this->load->library('validate_email');
	    $this->load->model('Aplicante_estado');
	    //$this->output->cache(3600);
    }

    //inicio de sesion
 	public function index(){

 		if ($this->session->has_userdata('session_name')){
			if($this->session->userdata('user_role')=='aplicante'){
				$this->session->set_userdata('isAdmin', false);
				redirect('micuenta');
			}else if(($this->session->userdata('user_role')=='administrador regional') or ($this->session->userdata('user_role')=='administrador país') or ($this->session->userdata('user_role') =='administrador junior')){
				$this->session->set_userdata('isAdmin', true);
				redirect('admin/dashboard');	
			} 			
 		}


 		$data['titulo'] = 'Ingresar a mi cuenta';
		//validar el ingreso del usuario
		if($this->input->post()){
			$service_url = base_url('/rrhh/api/users/user/login.xml'); // .xml asks for xml data in response
			$post_data = $this->input->post(null, true);
			$xml = ServicioInicioSesion($service_url, $post_data);
			
			//validar la cantidad de elementos de retorno 
			//si es 0, usualmente se trata de un error de inicio de session
			if(count($xml) <= 0){
				$mensaje_error = (string)$xml;
				$this->breadcrumb->clear();
				$this->breadcrumb->add('Inicio', '/');
				$this->breadcrumb->add('Inicio Sesión');
				$data['errorlogin'] = $mensaje_error;
			} else {
				
				$session_cookie = (string)$xml->session_name.'='.(string)$xml->sessid;
				$csrf_token = ServicioObtenerToken($session_cookie);
				$informacion_usuario = consumirServicio(base_url('/rrhh/api/users/user/'.(string)$xml->user->uid.'.xml'), $session_cookie);
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

				if($this->session->userdata('user_role')=='aplicante'){
					$this->session->set_userdata('isAdmin', false);
					redirect('micuenta');
					
				}else if(($this->session->userdata('user_role')=='administrador regional') or ($this->session->userdata('user_role')=='administrador país') or ($this->session->userdata('user_role') =='administrador junior')){
					$this->session->set_userdata('pais_admin', 0);

					if(($this->session->userdata('user_role')=='administrador país') or ($this->session->userdata('user_role') =='administrador junior')){
						if(isset($informacion_usuario->field_pais_trabajar->und)){
							$pais_admin = (int)$informacion_usuario->field_pais_trabajar->und->item->target_id;
							$this->session->set_userdata('pais_admin', $pais_admin);						
						}				
					}
					$this->session->set_userdata('isAdmin', true);
					redirect('admin/dashboard');
					
				}
				
			}
		}

		$this->breadcrumb->clear();
		$this->breadcrumb->add('Inicio', '/');
		$this->breadcrumb->add('Inicio Sesión');
		$data['vista'] = 'user/login-page';
		$this->load->view('index', $data);
	}	

	//registro
	public function registro(){
		//validar el ingreso del usuario
		$session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
        $csrf_token = ServicioObtenerToken($session_cookie);

		if ($this->session->has_userdata('session_name')){
			if($this->session->userdata('user_role')=='aplicante'){				
				redirect('micuenta');
			}else if(($this->session->userdata('user_role')=='administrador regional') or ($this->session->userdata('user_role')=='administrador país') or ($this->session->userdata('user_role') =='administrador junior')){
				redirect('admin/dashboard');	
			} 			
 		}

		if($this->input->post()){

			$error = '';

			$error = $this->uploadAvatar();
			if($error == ''){
				if($_FILES['curriculum']['tmp_name'] != ''){
					$error = $this->uploadCurriculum();
				}else{
					$error = 'El campo <b>(Currículum)</b> es obligatorio';
				}		
			}
			
			if($error == ''){
				$service_url = base_url('/rrhh/api/users/user/register.xml');
				$post_data = $this->input->post(null, true);
				$xml = ServicioInsertar($service_url, $session_cookie, $post_data);
				if(isset($xml->form_errors)){
					$error = (string)$xml->form_errors->mail;
				}
				if($error == ''){
					//crear un registro en la tabla aplicante_estado
					$uid_aplicante = $xml->uid;
					$this->Aplicante_estado->agregar(array(
						'uid_aplicante' => $uid_aplicante,
						'tid_estado' => 27,
						'modified' => time(),
					));
					$this->iniciarSesionPrimeraVez($this->input->post('mail'), $this->input->post('pass[pass1]'));
					$this->guardarArchivoImagen($this->file_path_imagen, $this->file_name_imagen, $this->file_size_imagen);
					$this->guardarArchivo($this->file_path, $this->file_name, $this->file_size, 'field_curriculum');										
					redirect('micuenta');
				}else{
					$this->deleteImgCurr();
					$data['mensaje'] = $error;
					$data['tipo_mensaje'] = 'alert-danger';
				}						

			}else{
				$this->deleteImgCurr();
				$data['mensaje'] = $error;
				$data['tipo_mensaje'] = 'alert-danger';
			}

		}

		$data['is_mobile'] = false;
		if ($this->agent->is_mobile()){
			$data['is_mobile'] = true;
		}

		$data['titulo'] = 'Registrarme';

		$this->breadcrumb->clear();
		$this->breadcrumb->add('Inicio', '/');
		$this->breadcrumb->add('Registro');

		//si el usuario no ha hecho submit en el formulario de registro, se mostrara el formulario
		$data['idiomas'] = $this->ObtenerListadoPaises();
		//estado civil
		$data['estados_civiles'] = ObtenerListado('filtros', 'filtros-taxonomias-estado-civil', $session_cookie, $csrf_token);
		//hago el unset de la taxonomía "Sin específicar" para que no esté disponible a los usuarios.
		unset($data['estados_civiles'][92]);
		

		//discapacidad
		$data['discapacidades'] = ObtenerListado('filtros', 'filtros-taxonomias-discapacidad', $session_cookie, $csrf_token);
		//hago el unset de la taxonomía "Sin específicar" para que no esté disponible a los usuarios.
		unset($data['discapacidades'][91]);

		//ha trabajado anteriormente para BAC
		$data['trabajo_anteriormente_bac'] = ObtenerListado('filtros', 'filtros-taxonomias-trab-anteriormente-bac', $session_cookie, $csrf_token);
		//hago el unset de la taxonomía "Sin específicar" para que no esté disponible a los usuarios.
		unset($data['trabajo_anteriormente_bac'][93]);


		//desea recibir informacion
		$data['envio_de_informacion_options'] = ObtenerListado('filtros', 'filtros-taxonomias-envio-informacion', $session_cookie, $csrf_token);
		


		//obtener los niveles academicos
		$data['niveles_academicos'] = consumirServicio(base_url('/rrhh/api/filtros/filtros-taxonomias-nivel-academico.xml'), $session_cookie);
		$data['vista'] = 'user/registerform';
		//custom javascript for the view registrationform
		$data['js'] = "registration";

		$this->load->view('index', $data);	
	}		

	protected function deleteImgCurr(){

		@unlink($this->url_curriculum);
		$ext = pathinfo($this->url_avatar, PATHINFO_EXTENSION);
		$dirname = dirname($this->url_avatar);
		$basename = basename($this->url_avatar, '.'.$ext); 
		$thumb_avatar = $dirname . '/' . $basename . '_thumb.' . $ext; 
		@unlink($this->url_avatar);
		@unlink($thumb_avatar);	

	}

	protected function uploadCurriculum(){
		$this->file_path = '';
		$this->file_name = '';
		$this->file_size = '';
		if($_FILES['curriculum']['name'] != ''){
			$config['upload_path'] = './rrhh/sites/default/files/uploads/';
			$config['allowed_types'] = 'docx|doc|pdf'; /* docx|doc|pdf */
			$config['encrypt_name'] = TRUE;
			$config['file_ext_tolower'] = TRUE;
			$this->upload->initialize($config);

			if ($this->upload->do_upload('curriculum'))
			{
				$file_data = array('upload_data' => $this->upload->data());
				//iniciar sesion automaticamente despues de validar satisfactoriamente el registro del usuario					
				$file_path = $file_data['upload_data']['full_path'];
				$file_name = $file_data['upload_data']['file_name'];
				$file_size = $file_data['upload_data']['file_size'];
				$this->url_curriculum = $file_path;
				//$this->guardarArchivo($file_path, $file_name, $file_size, 'field_curriculum');
				$this->file_path = $file_path;
				$this->file_name = $file_name;
				$this->file_size = $file_size;

				return '';
			}else{
				return '<b>(Currículum)</b> ' . $this->upload->display_errors('','');			
			}
		}	

	}
	
	protected function uploadAvatar(){

		$this->file_path_imagen = '';
		$this->file_name_imagen = '';
		$this->file_size_imagen = '';

		if($_FILES['imagen']['tmp_name'] != ''){
			$config['upload_path'] = './rrhh/sites/default/files/uploads/';
			$config['allowed_types'] = 'jpeg|gif|png|jpg';
			$config['encrypt_name'] = TRUE;
			$config['file_ext_tolower'] = TRUE;
			$this->upload->initialize($config);

			if ($this->upload->do_upload('imagen'))
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
				return '';

			}else{
				return '<b>(Fotografía)</b> ' . $this->upload->display_errors('','');
			}
		}	
	}

	//profile
	public function perfil(){

		if($this->session->userdata('session_name') == ''){
			redirect('ingreso');
		}

		$data['titulo'] = 'Mi Cuenta';
		$session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
		$csrf_token = ServicioObtenerToken($session_cookie);

		if($this->input->post()){	
			// REST Server URL
			$request_url = base_url('/rrhh/api/users/user/'. $this->session->userdata('user_id'));
			//$user_data = $this->input->post(null, true);

			//exit(var_export($this->input->post()));
			/*$data['response'] = $this->input->post();
			$this->load->view('user/user-response', $data);*/

			//preestablecer los datos de los idiomas debido a que esta sujeto a un tamaño especifico, se validara si el usuario ha seleccionado mas idiomas dinamicamente
			$idiomas = array();
			for ($i=0; $i < 5; $i++) { 
				if(($this->input->post('field_idioma-'.$i) !== null) && ($this->input->post('field_porcentaje-'.$i) !== null)) {
					$idiomas [] = array("field_idioma" => $this->input->post('field_idioma-'.$i),
										"field_porcentaje" => $this->input->post('field_porcentaje-'.$i)
									   );
				} else {
					$idiomas [] = array("field_idioma" => '_none',
										"field_porcentaje" => ''
									   );
				}
			}

			$carreras = array();
			foreach ($this->input->post() as $key => $value) {
				if($key == 'field_carrera_para_aplicar'){
					foreach ($value as $key2 => $value2) {
						foreach ($value2 as $value3) {
							$carreras[$value3] = $value3;
						}
					}
				}
			}

			$envio_informacion_sin_especificar = 97;
			$envio_informacion_whatsapp = NULL;
			$envio_informacion_correo = NULL;
			$envio_informacion_sms = NULL;

			if(!empty($this->input->post()["field_envio_de_informacion"]["und"])){
				$envio_informacion_sin_especificar = NULL;
				$envio_informacion_whatsapp = $this->input->post('field_envio_de_informacion[und][96]');
				$envio_informacion_correo = $this->input->post('field_envio_de_informacion[und][95]');
				$envio_informacion_sms = $this->input->post('field_envio_de_informacion[und][94]');
				
			}

			$user_data = array('current_pass' => $this->input->post('current_pass'), 
							   'pass' => $this->input->post('pass[pass1]'),
							   'mail' => $this->input->post('mail'),
							   "field_nombre_y_apellidos" => array(
										"und" => array(
											"0" => array(
												"value" => $this->input->post('field_nombre_y_apellidos')
											)
										)
									),
							   "field_fecha_de_nacimiento" => array(
										"und" => array(
											"0" => array(
												"value" => $this->input->post('field_fecha_de_nacimiento')
											)
										)
									),
							    "field_telefono" => array(
										"und" => array(
											"0" => array(
												"value" => $this->input->post('field_telefono')
											)
										)
									),
							    "field_profesion" => array(
										"und" => array(
											"0" => array(
												"value" => $this->input->post('field_profesion')
											)
										)
									),
							    "field_cualidades" => array(
										"und" => array(
											"0" => array(
												"value" => $this->input->post('field_cualidades')
											)
										)
									),
							    "field_ventaja_competitiva" => array(
										"und" => array(
											"0" => array(
												"value" => $this->input->post('field_ventaja_competitiva')
											)
										)
									),
							    "field_genero" => array(
										"und" => array(
											"0" => $this->input->post('field_genero')
										)
									),

							    "field_estado_civil" => array(
										"und" => array(
											"0" => $this->input->post('field_estado_civil')
										)
									),
							    "field_envio_de_informacion" => array(
										"und" => array(
											"0" => $this->input->post('field_envio_de_informacion')
										)
									),
							    "field_envio_de_informacion" => array(
										"und" => array(
											"95" => $envio_informacion_correo,
											"97" => $envio_informacion_sin_especificar,
											"94" => $envio_informacion_sms,
											"96" => $envio_informacion_whatsapp,
										)
									),

							    "field_discapacidad" => array(
										"und" => array(
											"0" => $this->input->post('field_discapacidad')
										)
									),

							    "field_trabajo_anteriormente_bac" => array(
										"und" => array(
											"0" => $this->input->post('field_trabajo_anteriormente_bac')
										)
									),

							    "field_nivel_academico" => array(
										"und" => array(
											"0" => $this->input->post('field_nivel_academico')
										)
									),
							    "field_nacionalidad" => array(
										"und" => array(
											"0" => $this->input->post('field_nacionalidad')
										)
									),
							    "field_pais_trabajar" => array(
										"und" => array(
											"5" => $this->input->post('field_pais_trabajar[und][5]'),
											"6" => $this->input->post('field_pais_trabajar[und][6]'),
											"7" => $this->input->post('field_pais_trabajar[und][7]'),
											"8" => $this->input->post('field_pais_trabajar[und][8]'),
											"9" => $this->input->post('field_pais_trabajar[und][9]'),
											"10" => $this->input->post('field_pais_trabajar[und][10]'),
											"11" => $this->input->post('field_pais_trabajar[und][11]'),
										)
									),
							    "field_idiomas" => array(
							    		"und" => array(
							    			"0" => array(
							    				"field_idioma" => array(
							    					"und" => array(
							    						"0" => $idiomas[0]['field_idioma']
							    					)
							    				),
							    				"field_porcentaje" => array(
							    					"und" => array(
							    						"0" => array(
							    							"value" => $idiomas[0]['field_porcentaje']
							    						)
							    					)
							    				),
							    			),
							    			"1" => array(
							    				"field_idioma" => array(
							    					"und" => array(
							    						"0" => $idiomas[1]['field_idioma']
							    					)
							    				),
							    				"field_porcentaje" => array(
							    					"und" => array(
							    						"0" => array(
							    							"value" => $idiomas[1]['field_porcentaje']
							    						)
							    					)
							    				),
							    			),
							    			"2" => array(
							    				"field_idioma" => array(
							    					"und" => array(
							    						"0" => $idiomas[2]['field_idioma']
							    					)
							    				),
							    				"field_porcentaje" => array(
							    					"und" => array(
							    						"0" => array(
							    							"value" => $idiomas[2]['field_porcentaje']
							    						)
							    					)
							    				),
							    			),
							    			"3" => array(
							    				"field_idioma" => array(
							    					"und" => array(
							    						"0" => $idiomas[3]['field_idioma']
							    					)
							    				),
							    				"field_porcentaje" => array(
							    					"und" => array(
							    						"0" => array(
							    							"value" => $idiomas[3]['field_porcentaje']
							    						)
							    					)
							    				),
							    			),
							    			"4" => array(
							    				"field_idioma" => array(
							    					"und" => array(
							    						"0" => $idiomas[4]['field_idioma']
							    					)
							    				),
							    				"field_porcentaje" => array(
							    					"und" => array(
							    						"0" => array(
							    							"value" => $idiomas[4]['field_porcentaje']
							    						)
							    					)
							    				),
							    			)
							    		)
							    	),
									"field_elances" => array(
										"und" => array(
											"0" => array(
												"value" => $this->input->post('field_elances[und][0][value]')
											),
											"1" => array(
												"value" => $this->input->post('field_elances[und][1][value]')
											),
											"2" => array(
												"value" => $this->input->post('field_elances[und][2][value]')
											),
											"3" => array(
												"value" => $this->input->post('field_elances[und][3][value]')
											),
											"4" => array(
												"value" => $this->input->post('field_elances[und][4][value]')
											)
										)
									),
									"field_carrera_para_aplicar" => array(
										"und" => $carreras
									),
							   );


			// cURL
			$result = ServicioActualizar($request_url, $user_data, $session_cookie, $csrf_token);


			$httpcode = $result['httpcode'];
			$mensaje = $result['mensaje'];

			//agregar el archivo curriculum en el directorio uploads
			/*
			$config['upload_path'] = './rrhh/sites/default/files/uploads/';
			$config['allowed_types'] = 'docx|doc|pdf|jpg';
			$config['encrypt_name'] = TRUE;
			$this->load->library('upload', $config);

			if ($this->upload->do_upload('curriculum')){
				$file_data = array('upload_data' => $this->upload->data());
				//iniciar sesion automaticamente despues de validar satisfactoriamente el registro del usuario					
				$file_path = $file_data['upload_data']['full_path'];
				$file_name = $file_data['upload_data']['file_name'];
				$file_size = $file_data['upload_data']['file_size'];
				$this->guardarArchivo($file_path, $file_name, $file_size, 'field_curriculum');
			}	

			
			if ($this->upload->do_upload('imagen')){
				$file_data_imagen = array('upload_data' => $this->upload->data());
				//iniciar sesion automaticamente despues de validar satisfactoriamente el registro del usuario					
				$file_path_imagen = $file_data_imagen['upload_data']['full_path'];
				$file_name_imagen = $file_data_imagen['upload_data']['file_name'];
				$file_size_imagen = $file_data_imagen['upload_data']['file_size'];

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

				$this->guardarArchivoImagen($file_path_imagen, $file_name_imagen, $file_size_imagen);
			}
			*/


			$error = '';
			$pathupload = './rrhh/sites/default/files/uploads/';

			
			$error = $this->uploadAvatar();	
			
			
			if($error == ''){
				$saveimg = $this->guardarArchivoImagen($this->file_path_imagen, $this->file_name_imagen, $this->file_size_imagen);
				if($saveimg['httpcode'] == 200){
					$file_avatar = $pathupload.$this->input->post('avatar_actual');
					$ext_avatar = pathinfo($this->input->post('avatar_actual'), PATHINFO_EXTENSION);
					$basename_avatar = basename($file_avatar, '.'.$ext_avatar); 
					$thumb_avatar = $pathupload . '' . $basename_avatar . '_thumb.' . $ext_avatar; 
					@unlink($file_avatar);
					@unlink($thumb_avatar);		
				}
			}else{
				//$this->deleteImgCurr();
				$data['mensaje2'] = $error;
				$data['tipo_mensaje2'] = 'alert-danger';				
			}

			$error = $this->uploadCurriculum();
			

			if($error == ''){
				$savecur = $this->guardarArchivo($this->file_path, $this->file_name, $this->file_size, 'field_curriculum');
				if($savecur['httpcode'] == 200){
					$file_cur = $pathupload.$this->input->post('curriculum_actual');
					@unlink($file_cur);					
				}									
			}else{
				//$this->deleteImgCurr();
				$data['mensaje2'] = $error;
				$data['tipo_mensaje2'] = 'alert-danger';
			}



			
			//validar el codigo html devuelto
			if($httpcode == 200){
				$success = "Los datos se han actualizado satisfactoriamente";
				$data['mensaje'] = $success;
				$data['tipo_mensaje'] = 'alert-success';
				//actualizar el correo en la sesion si este fue cambiado
				$this->session->set_userdata('mail', $this->input->post('mail'));
			} else if($httpcode == 406) {
				$error = "Lo sentimos, la contraseña ingresada como su contraseña actual ha sido incorrecta y no se ha podido guardar la nueva contraseña";
				//$xml = new SimpleXMLElement($mensaje);
				$data['mensaje'] = $error;
				$data['tipo_mensaje'] = 'alert-danger';
			} else{
				$error = "Ha orurrido un error";
				//$xml = new SimpleXMLElement($mensaje);
				$data['mensaje'] = $error;
				$data['tipo_mensaje'] = 'alert-danger';
			}
			/*if(!empty($this->consultarPuestosAplicados()->results->item)){
				$data['puestos_aplicados'] = $this->consultarPuestosAplicados()->results;
			}*/

		} else {

			/*
			$service_url = 'http://bac.cr/rrhh/api/users/perfil.xml'; // .xml asks for xml data in response
			// consumir recurso
			$xml = consumirServicio($service_url, $session_cookie, $csrf_token); 
			//extraer la informacion del profile
			$item0 = $xml->results->item[0];

			//exit(var_dump($session_cookie  ."-". $csrf_token));


			//obtener el nombre del archivo
			$nameCurriculumArray = explode('/', $item0->field_curriculum);
			$limit = count($nameCurriculumArray);
			$curriculum = $nameCurriculumArray[$limit-1];
			$pos = strpos($curriculum, '_.txt');
			if($pos == true){
				$curriculum = str_replace('_.txt', '', $curriculum);
			} 

			$nameImagenPerfilArray = explode('/', $item0->field_imagen_perfil);
			$limit = count($nameImagenPerfilArray);
			$imagenPerfil = $nameImagenPerfilArray[$limit-1];
			$imagenPerfil = str_replace('.jpg', '_thumb.jpg', $imagenPerfil);
			//$pos = strpos($imagenPerfil, '_.txt');
			//if($pos == true){
			//	$imagenPerfil = str_replace('_.txt', '', $curriculum);
			//}
			$data['avatar'] = $imagenPerfil;
			$data['telefono'] = (string)$item0->field_telefono;
			$data['fecha_nacimiento'] = (string)$item0->field_fecha_de_nacimiento;
			$data['nombre_apellidos'] = (string)$item0->field_nombre_y_apellidos;
			$data['correo'] = (string)$item0->mail;
			$data['genero'] = (string)$item0->field_genero;
			$data['nacionalidad'] = (string)$item0->field_nacionalidad;
			$data['carreras'] = $item0->field_carrera_para_aplicar->item;
			$data['paises'] = $item0->field_pais_trabajar->item;
			$data['curriculum'] = $curriculum;
			$data['grado_academico_elegido'] = (string)$item0->field_nivel_academico->tid;
			$data['profesion'] = (string)$item0->field_profesion;
			$data['cualidades'] = (string)$item0->field_cualidades;
			$data['ventaja'] = (string)$item0->field_ventaja_competitiva;
			$data['idiomas_selecionados'] = $item0->field_idiomas;
			$data['enlaces'] = $item0->field_elances;
			$data['imagen_perfil'] = $imagenPerfil;
			//si el usuario no ha hecho submit en el formulario de registro, se mostrara el formulario
			$data['idiomas'] = $this->ObtenerListadoPaises();
			$data['session_cookie'] = $session_cookie;
			$data['csrf_token'] = $csrf_token;
			//puestos aplicados
			if(!empty($this->consultarPuestosAplicados()->results->item)){
				$data['puestos_aplicados'] = $this->consultarPuestosAplicados()->results;
			}

			*/

		}


		//validar si la sesion en Drupal ha sido cerrada
		$session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
	    $token = $this->session->userdata('token');
	    $url = base_url('/rrhh/api/users/obtener-user-id.xml');
	    $result = consumirServicio($url, $session_cookie, $token);
	    //var_export($result);
	    $idusuario = (string)@$result->results->item->uid['0'];
	    if($idusuario == '' or $this->session->userdata('user_id') != $idusuario){
	    	redirect('usuario/sess_destroy');
	    }else{
			$service_url = base_url('/rrhh/api/users/perfil.xml'); // .xml asks for xml data in response
			// consumir recurso
			$xml = consumirServicio($service_url, $session_cookie, $csrf_token);
			//extraer la informacion del profile
			$item0 = $xml->results->item[0];


			$mensaje_campos_incompletos ="";

			$nameCurriculumArray = explode('/', $item0->field_curriculum);
			$limit = count($nameCurriculumArray);
			$curriculum = $nameCurriculumArray[$limit-1];
			$pos = strpos($curriculum, '_.txt');
			if($pos == true){
				$curriculum = str_replace('_.txt', '', $curriculum);
			} 

			//exit(var_export($item0));
			$nameImagenPerfilArray = explode('/', $item0->field_imagen_perfil);
			$limit = count($nameImagenPerfilArray);
			$imagenPerfil = $nameImagenPerfilArray[$limit-1];
			$data['avatar'] = $imagenPerfil;
			$ext = pathinfo($imagenPerfil, PATHINFO_EXTENSION);
			$imagenPerfil = str_replace('.'.$ext, '_thumb.'.$ext, $imagenPerfil);



			//VAlidaciones de campos
			if(empty($item0->field_estado_civil) || $item0->field_estado_civil->tid==92){
				$mensaje_campos_incompletos.="<li>El campo de Estado Civil en el Paso 1 no ha sido completado aún.</li>";
				
			}
			if(empty($item0->field_discapacidad) || $item0->field_discapacidad->tid==91){
				$mensaje_campos_incompletos.="<li>El campo de Discapacidad en el Paso 1 no ha sido completado aún.</li>";
				
			}
			if(empty($item0->field_trabajo_anteriormente_bac) || $item0->field_trabajo_anteriormente_bac->tid==93){
				$mensaje_campos_incompletos.="<li>El campo de \"¿Ha trabajado anteriormente el BAC|Credomatic?\" en el Paso 4 no ha sido completado aún.</li>";
				
			}
			/*if(empty($item0->field_profesion) || $item0->field_profesion==""){
				$mensaje_campos_incompletos.="<li>El campo de \"Profesión\" en el Paso 2 no ha sido completado aún.</li>";
				
			}*/
			

			if(empty($item0->field_imagen_perfil) ){
				$mensaje_campos_incompletos.="<li>Aún no se ha subido una fotografía para el perfil</li>";
				
			}

			if(empty($item0->field_pais_trabajar)){
				$mensaje_campos_incompletos.="<li>No ha indicado en cuales países le interesa trabajar. Puede hacerlo en el paso 3 del formulario</li>";
				
			}

			if(empty($item0->field_carrera_para_aplicar)){
				$mensaje_campos_incompletos.="<li>No ha indicado en cuales carreras dentro de nuestra empresa le interesa trabajar.</li>";
				
			}

			if(empty($item0->field_curriculum)){
				$mensaje_campos_incompletos.="<li>No ha subido un Curriculum Vitae aún. Puede hacerlo en el paso 4.</li>";
				
			}

			if(empty($item0->field_elances)){
				$mensaje_campos_incompletos.="<li>No ha brindado ningún link de referencia para conocer más sobre su perfil como una red social o sitio web de empleos. Puede hacerlo en el paso 4 en el campo \"Referencias\".</li>";
				
			}

			foreach ($item0->field_pais_trabajar->item as $key => $value) {
				if($value=='Costa Rica'){
					if(empty($item0->field_envio_de_informacion) || $item0->field_envio_de_informacion->tid == 97){
						$mensaje_campos_incompletos.="<li>No nos ha indicado cómo le gustaría que le enviaramos más información sobre puestos de trabajo y otros temas de su interés. Puede hacerlo en el paso 4 del formulario de registro.</li>";
					}
					
				}
			}


			$data['telefono'] = (string)$item0->field_telefono;
			$data['fecha_nacimiento'] = (string)$item0->field_fecha_de_nacimiento;
			$data['nombre_apellidos'] = (string)$item0->field_nombre_y_apellidos;
			$data['correo'] = (string)$item0->mail;
			$data['genero'] = (string)$item0->field_genero;
			$data['estado_civil'] = (string)$item0->field_estado_civil->tid;
			$data['discapacidad'] = (string)$item0->field_discapacidad->tid;
			$data['nacionalidad'] = (string)$item0->field_nacionalidad;
			$data['field_trabajo_anteriormente_bac'] = (string)$item0->field_trabajo_anteriormente_bac->tid;
			$data['carreras'] = $item0->field_carrera_para_aplicar->item;
			$data['paises'] = $item0->field_pais_trabajar->item;
			$data['curriculum'] = $curriculum;
			$data['grado_academico_elegido'] = (string)$item0->field_nivel_academico->tid;
			$data['profesion'] = (string)$item0->field_profesion;
			$data['cualidades'] = (string)$item0->field_cualidades;
			$data['ventaja'] = (string)$item0->field_ventaja_competitiva;
			$data['idiomas_selecionados'] = $item0->field_idiomas;
			$data['idiomas'] = $this->ObtenerListadoPaises();
			$data['enlaces'] = $item0->field_elances;
			$data['imagen_perfil'] = $imagenPerfil;
			$data['envio_de_informacion'] = $item0->field_envio_de_informacion;
			$data['mensaje_campos_incompletos'] = $mensaje_campos_incompletos;
			$data['session_cookie'] = $session_cookie;
			$data['csrf_token'] = $csrf_token;		

			if(!empty($this->consultarPuestosAplicados()->results->item)){
				$data['puestos_aplicados'] = $this->consultarPuestosAplicados()->results;
			}		

			$data['is_mobile'] = false;
			if ($this->agent->is_mobile()){
				$data['is_mobile'] = true;
			}

			$this->breadcrumb->clear();
			$this->breadcrumb->add('Inicio', '/');
			$this->breadcrumb->add('Mi cuenta', 'micuenta');
			$this->breadcrumb->add('Datos Personales');


			$data['estados_civiles'] = ObtenerListado('filtros', 'filtros-taxonomias-estado-civil', $session_cookie, $csrf_token);
			unset($data['estados_civiles'][92]);
			//discapacidad
			$data['discapacidades'] = ObtenerListado('filtros', 'filtros-taxonomias-discapacidad', $session_cookie, $csrf_token);
			unset($data['discapacidades'][91]);
			//ha trabajado anteriormente para BAC
			$data['trabajo_anteriormente_bac'] = ObtenerListado('filtros', 'filtros-taxonomias-trab-anteriormente-bac', $session_cookie, $csrf_token);
			unset($data['trabajo_anteriormente_bac'][93]);

			//desea recibir informacion
			$data['envio_de_informacion_options'] = ObtenerListado('filtros', 'filtros-taxonomias-envio-informacion', $session_cookie, $csrf_token);
		
			$data['niveles_academicos'] = consumirServicio(base_url('/rrhh/api/filtros/filtros-taxonomias-nivel-academico.xml'), $session_cookie);
			$data['vista'] = 'user/micuenta';
			$this->load->view('index', $data);
		}
	}

	//Dashboard para administradores
	public function dashboard(){

	    $session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
	    $token = $this->session->userdata('token');
	    $url = base_url('/rrhh/api/users/obtener-user-id.xml');
	    $result = consumirServicio($url, $session_cookie, $token);
	    $idusuario = (string)@$result->results->item->uid['0'];
	    if($idusuario == '' or $this->session->userdata('user_id') != $idusuario){
	    	redirect('usuario/sess_destroy');
	    }
	    if(($this->session->userdata('user_role')!="administrador regional") and ($this->session->userdata('user_role')!="administrador país") and ($this->session->userdata('user_role')!="administrador junior")){
			$this->general->noPermitido();
		}
	    //establece la variable en general de nuevo por si el administrador ingresa a un detalle de aplicante desde aquí. 
	    $this->session->set_userdata('aplicantes', array(
														'tipo' => 'general'
														) );

		$data['titulo'] = 'Dashboard';

		$this->breadcrumb->clear();
		$this->breadcrumb->add('Inicio', '/');
		$this->breadcrumb->add('Dashboard');

		/*$session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
		$csrf_token = ServicioObtenerToken($session_cookie);*/

		/*$service_url = 'http://bac.cr/rrhh/api/users/perfil.xml';*/ // .xml asks for xml data in response
		// consumir recurso
		/*$xml = consumirServicio($service_url, $session_cookie, $csrf_token);*/
		//extraer la informacion del profile
		/*$item0 = $xml->results->item[0];*/
		//exit(var_export($xml));
		/*$nombre_completo = (string)$item0->field_nombre_y_apellidos;*/
		
		/*$data['info_admin'] = array('name'=>$nombre_completo);
		$data['user_role'] = $this->session->userdata('user_role');*/

		

		/*if(($data['user_role']=='administrador regional') or ($data['user_role']=='administrador país') or ($data['user_role']=='administrador junior')){
			$data['isAdminSide'] = true;
		}*/
		
		$data['vista'] = 'admin/dashboard';
		$this->load->view('index', $data);
	}

	//cerrar sesion del usuario
	public function cerrarSesion(){
		if ($this->session->has_userdata('session_name')){
			$service_url = base_url('/rrhh/api/users/user/logout.xml'); // .xml asks for xml data in response
		
			$session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
			$csrf_token = ServicioObtenerToken($session_cookie);
			// set up the request
			$xml = ServicioCerrarSesion($service_url, $session_cookie, $csrf_token);
			//var_export($xml);
			/*$xml2 = CerrarSessionDrupal();
			
			exit(var_export($xml2));*/
			//validar si ha salido de la sesion
			if(((string)$xml == '1') || ((string)$xml == '0')){
				$this->limpiarSesion();
				redirect('/ingreso');
			}
			$data['response'] = (string)$xml;
			$this->load->view('user/user-response', $data);
		}else{
			redirect('/ingreso');
		}
	}

	public function sess_destroy(){
		$this->limpiarSesion();
		redirect('/ingreso');		
	}
	
	//limpiar toda la informacion del usuario
	public function limpiarSesion(){
		
		$this->session->sess_destroy();
	}

	public function iniciarSesionPrimeraVez($mail = '', $pass = ''){
		$service_url = base_url('/rrhh/api/users/user/login.xml'); // .xml asks for xml data in response
		$post_data = array(
		  'mail' => $mail,
		  'pass' => $pass,
		);
		// set up the request
		$xml = ServicioInicioSesion($service_url, $post_data);		
		//validar la cantidad de elementos de retorno 
		//si es 0, usualmente se trata de un error de inicio de session
		if(count($xml) != 0){
			$session_cookie = (string)$xml->session_name.'='.(string)$xml->sessid;
			//exit(var_export($session_cookie));
			$csrf_token = ServicioObtenerToken($session_cookie);
			$informacion_usuario = consumirServicio(base_url('rrhh/api/users/user/'.(string)$xml->user->uid.'.xml'), $session_cookie);
			$rol = (string)$informacion_usuario->roles->item[1];
			$main = (string)$informacion_usuario->field_principal->und->item->value;
			//session name
			$sesion = array('session_name' => (string)$xml->session_name,
							'sessid' => (string)$xml->sessid,
							'user_id' => (string)$xml->user->uid,
							'user_role' => $rol,
							'user_principal' => $main,
							'token' => $csrf_token,
							'mail' => (string)$xml->user->mail,
							'isAdmin' => false);
			
			$this->session->set_userdata($sesion);	
			$this->session->registro = 1;
			//redirect('micuenta');
		}
	}

	public function guardarArchivo($file_path, $file_name, $file_size, $field){
		$filedata = array(
		    'filesize' => $file_size,
		    'filename' => $file_name,
		    //'file' => $file_path,
		    'file' => 'public://curriculum/'.$file_name,
		    //'filepath' => 'public://curriculum/'.$file_name,
		    'uid'  => $this->session->userdata('user_id')  // This should change it by the user who use the service.
		);

		$session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
		$csrf_token = ServicioObtenerToken($session_cookie);
		$service_url = base_url('/rrhh/api/users/file.xml'); // .xml asks for xml data in response
		
		$xml = ServiciouploadFile($service_url, $session_cookie, $filedata, $csrf_token);

		if(isset($xml->fid)){
			$fid = (string)$xml->fid;

			$request_url = base_url('/rrhh/api/users/user/'. $this->session->userdata('user_id'));

			

			$user_data = array($field => array(
										"und" => array(
											"0" => array(
												"fid" => $fid
											)
										)
									),
							   );			
			//actualizar aplicante
			return ServicioActualizar($request_url, $user_data, $session_cookie, $csrf_token);
		}
	}

	public function guardarArchivoImagen($file_path, $file_name, $file_size){
		$filedata = array(
		    'filesize' => $file_size,
		    'filename' => $file_name,
		    //'file' => $file_path,
		    'file' => 'public://curriculum/'.$file_name,
		    //'filepath' => 'public://curriculum/'.$file_name,
		    'uid'  => $this->session->userdata('user_id')  // This should change it by the user who use the service.
		);

		$session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
		$csrf_token = ServicioObtenerToken($session_cookie);
		$service_url = base_url('/rrhh/api/users/file.xml'); // .xml asks for xml data in response
		
		$xml = ServiciouploadFile($service_url, $session_cookie, $filedata, $csrf_token);

		if(isset($xml->fid)){
			$fid = (string)$xml->fid;
			$request_url = base_url('/rrhh/api/users/user/'. $this->session->userdata('user_id'));
			$user_data = array('field_imagen_perfil' => array(
										"und" => array(
											"0" => array(
												"fid" => $fid
											)
										)
									),
							   );			
			//actualizar aplicante
			return ServicioActualizar($request_url, $user_data, $session_cookie, $csrf_token);
		}
	}

	public function ObtenerListadoPaises(){
		$service_url = base_url('/rrhh/api/filtros/filtros-taxonomias-idiomas.xml'); // .xml asks for xml data in response
		// set up the request
		$session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
		$csrf_token = ServicioObtenerToken($session_cookie);

		// set up the request
		$curl = curl_init($service_url);
		//curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'X-CSRF-Token: ' .$csrf_token)); // Accept JSON response
		curl_setopt($curl, CURLOPT_HEADER, FALSE);  // Ask to not return Header
		//curl_setopt($curl, CURLOPT_COOKIE, "$session_cookie"); // use the previously saved session
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		//curl_setopt($curl, CURLOPT_FAILONERROR, TRUE);
		curl_setopt($curl, CURLOPT_VERBOSE, true); // output to command line
		$response = curl_exec($curl);
		curl_close($curl);
		$xml = new SimpleXMLElement($response);

		$idiomas = array();
		//$data['response'] = $xml->results->item[0]->name;
		foreach ($xml->results->item as $key) {
			$idiomas[(string)$key[0]->tid] = (string)$key[0]->name;
		}
		return $idiomas;	
	}

	public function obtenerSesion(){
		$csrf_token = trim($this->obtenerToken());
		$this->session->set_userdata('token', $csrf_token);
		$sesion = $this->session->userdata();

		$sesion_data_flat = "";
		foreach ($sesion as $key => $value) {
			$sesion_data_flat .= $value.",";
		}

		//$sesion = json_encode($sesion);
		$data['response'] = $sesion_data_flat;
		$this->load->view('user/user-response', $data);	
	}

	//inicio de sesion por ajax
	public function inicioSesionAjax(){

		$dato = array();
		if($this->input->post()){
			$service_url = base_url('/rrhh/api/users/user/login.xml'); // .xml asks for xml data in response
			$post_data = $this->input->post(null, true);
			$xml = ServicioInicioSesion($service_url, $post_data);
			
			
			//validar la cantidad de elementos de retorno 
			//si es 0, usualmente se trata de un error de inicio de session
			if(count($xml) <= 0){
				$mensaje_error = (string)$xml;
				$dato['errorlogin'] = $mensaje_error;
				$dato['success'] = false;
			} else {
				//session name
				/*$sesion = array('session_name' => (string)$xml->session_name,
								'sessid' => (string)$xml->sessid,
								'user_id' => (string)$xml->user->uid);*/
				if(isset($xml->user->field_nombre_y_apellidos->und)){
					$nombre_completo = (string)$xml->user->field_nombre_y_apellidos->und->item->value;
				} else{
					$nombre_completo = "Administrador";
				}
				
				$rol = (string)$xml->user->roles->item[1];
				$main = (string)$xml->user->field_principal->und->item->value;

				$session_cookie = (string)$xml->session_name.'='.(string)$xml->sessid;
				$csrf_token = ServicioObtenerToken($session_cookie);
				
				$sesion = array('session_name' => (string)$xml->session_name,
								'sessid' => (string)$xml->sessid,
								'user_id' => (string)$xml->user->uid,
								'user_role' => $rol,
								'user_principal' => $main,
								'nombre' => $nombre_completo,
								'mail' => (string)$xml->user->mail,
								'token' => $csrf_token);

				$this->session->set_userdata($sesion);

				if($this->session->userdata('user_role')=='aplicante'){
					$this->session->set_userdata('isAdmin', false);
					$dato['cuenta'] = 'micuenta';
				}else if(($this->session->userdata('user_role')=='administrador regional') or ($this->session->userdata('user_role')=='administrador país') or ($this->session->userdata('user_role') =='administrador junior')){
					$this->session->set_userdata('pais_admin', 0);

					if(($this->session->userdata('user_role')=='administrador país') or ($this->session->userdata('user_role') =='administrador junior')){
						//exit(var_export($xml));
						if(isset($xml->user->field_pais_trabajar->und)){
							$pais_admin = (int)$xml->user->field_pais_trabajar->und->item->target_id;
							$this->session->set_userdata('pais_admin', $pais_admin);
						}else{
							$this->session->set_userdata('pais_admin', 0);
						}						
					}
					$this->session->set_userdata('isAdmin', true);
					$dato['cuenta'] = 'admin/dashboard';
				}
				$dato['success'] = true;
			}
		}
		$data['response'] = $dato;
		$this->load->view('user/user-response', $data);
	}

	//aplicar a puesto
	public function aplicarPuesto($id_puesto){

	    $session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
	    $token = $this->session->userdata('token');
	    $url = base_url('/rrhh/api/users/obtener-user-id.xml');
	    $result = consumirServicio($url, $session_cookie, $token);
	    $idusuario = (string)@$result->results->item->uid['0'];
	   // var_export($this->session->userdata('user_id'));exit();
	    if($this->session->userdata('user_id') != NULL){

			$info = array(
				'url'    => 'users/puestos_aplicados_total/retrieve',
				'datos'  => array(
					'uid_aplicante'   => $this->session->userdata('user_id')
				)
			);
			$datos = $this->general->getData($info);
			$cantidad_puestos_aplicados = count($datos);

			if($cantidad_puestos_aplicados < 3){

				//$session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
				$csrf_token = ServicioObtenerToken($session_cookie);

				// Obtener todos los puestos aplicados por el aplicante
				$puestos_aplicados_url = base_url('/rrhh/api/users/perfil-puestos-aplicados.xml');
				$puestos_aplicados = consumirServicio($puestos_aplicados_url, $session_cookie, $csrf_token);

				$user_data = array("field_puesto" => array(
											"und" => array()
										),
								   );
				$listado_puestos = array();
				foreach ($puestos_aplicados->results->item as $value) {
					if(!empty($value)){
						//$values[] = $value[0]->Nid;
						$listado_puestos[(string)$value[0]->Nid] = (string)$value[0]->Nid;
					}
				}

				$user_data["field_puesto"]["und"] = $listado_puestos;
				//buscar entre el listado de puestos aplicados, si ya aplico
				if(in_array($id_puesto, $listado_puestos)) {
					$data['success'] = false;
					$data['code'] = 1;
				} else {

					$user_data["field_puesto"]["und"][$id_puesto] = $id_puesto;			
					// REST Server URL
					$request_url = base_url('/rrhh/api/users/user/'. $this->session->userdata('user_id'));
					$result = ServicioActualizar($request_url, $user_data, $session_cookie, $csrf_token);
					$httpcode = $result['httpcode'];
					$mensaje = $result['mensaje'];
					if($httpcode == 200){
						$data['success'] = true;
					} else {
						$data['success'] = false;
						$data['error'] = $mensaje;
						$data['code'] = $httpcode;
					}
				}
			}else{
				$data['success'] = false;
				$data['error'] = '<br> <b>Haz llegado al límite de puestos a aplicar.</b><br>Por políticas de BAC | Credomatic solo puedes aplicar a 3 puestos diferentes.<br><br>';
				$data['code'] = 406;			
			}
	    }
	    $data['response'] = $data;
		$this->load->view('user/user-response', $data);
	}

	//desaplicar a puesto
	public function desaplicarPuesto($id_puesto){

	    $session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
	    $token = $this->session->userdata('token');
	    $url = base_url('/rrhh/api/users/obtener-user-id.xml');
	    $result = consumirServicio($url, $session_cookie, $token);
	    $idusuario = (string)@$result->results->item->uid['0'];
	   
	   	//validar si la sesion continua abierta
	    if($this->session->userdata('user_id') != NULL){

			$csrf_token = ServicioObtenerToken($session_cookie);

			// Obtener todos los puestos aplicados por el aplicante
			$puestos_aplicados_url = base_url('/rrhh/api/users/perfil-puestos-aplicados.xml');
			$puestos_aplicados = consumirServicio($puestos_aplicados_url, $session_cookie, $csrf_token);

			$user_data = array("field_puesto" => array(
										"und" => array()
									),
							   );
			$listado_puestos = array();
			foreach ($puestos_aplicados->results->item as $value) {
				if(!empty($value)){
					//$values[] = $value[0]->Nid;
					$listado_puestos[(string)$value[0]->Nid] = (string)$value[0]->Nid;
				}
			}
			$user_data["field_puesto"]["und"] = $listado_puestos;
			
			//buscar entre el listado de puestos aplicados, si ya aplico
			if(in_array($id_puesto, $listado_puestos)) {
				$estadoPuestoAplicante = consultarEstadoAplicante($idusuario, $id_puesto, $session_cookie);
				$data['estadoPuestoAplicante'] = $estadoPuestoAplicante->item->name;

				if (($estadoPuestoAplicante->item->name == 'No leido') || ($estadoPuestoAplicante->item->name == 'Leido') || ($estadoPuestoAplicante->item->name == 'Lista Negra')){
					unset($user_data["field_puesto"]["und"][$id_puesto]);
					// REST Server URL
					$request_url = base_url('/rrhh/api/users/user/'. $this->session->userdata('user_id'));
					$result = ServicioActualizar($request_url, $user_data, $session_cookie, $csrf_token);
					
					$httpcode = $result['httpcode'];
					$mensaje = $result['mensaje'];
					if($httpcode == 200){
						$data['success'] = true;
						/*Eliminar el estado del puesto si este estaba como leido*/
						if (($estadoPuestoAplicante->item->name == 'No leido') || ($estadoPuestoAplicante->item->name == 'Leido')){
							reiniciarEstadoAplicante($idusuario, $id_puesto, $session_cookie);
						}
					} else {
						$data['success'] = false;
						$data['error'] = $mensaje;
						$data['code'] = $httpcode;
					}
				}else if ($estadoPuestoAplicante->item->name == 'Pre seleccionado'){
					$data['success'] = false;
					$data['error'] = '<br> <b>Lo sentimos, actualmente tu solicitud para aplicar a este puesto esta en periodo de selección, por lo tanto no es posible des aplicar a este puesto</b><br><br>';
					$data['code'] = 406;
				}else if ($estadoPuestoAplicante->item->name == 'Contratado'){
					$data['success'] = false;
					$data['error'] = '<br> <b>Lo sentimos, has sido contratado para este puesto, por lo tanto no es posible des aplicar a este puesto</b><br><br>';
					$data['code'] = 406;
				}												
			} else {
				$data['success'] = false;
				$data['error'] = '<br> <b>Ya has desaplicado este puesto anteriormente</b><br><br>';
				$data['code'] = 406;
			}
	    }
	    $data['response'] = $data;
		$this->load->view('user/user-response', $data);
	}

	//extraer puestos aplicados
	public function consultarPuestosAplicados(){
		$session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
		$csrf_token = ServicioObtenerToken($session_cookie);

		// Obtener todos los puestos aplicados por el aplicante
		$puestos_aplicados_url = base_url('/rrhh/api/users/perfil-puestos-aplicados-full.xml');
		$puestos_aplicados = consumirServicio($puestos_aplicados_url, $session_cookie, $csrf_token);
		return $puestos_aplicados;
		//exit(var_export($puestos_aplicados));
	}


	public function cambiaPaisSession($nid_pais){
 		$this->session->set_userdata('pais_admin', $nid_pais);
 	}

 	public function verificarDisponibilidadEmail($email){
 		$url_service = "/rrhh/api/users/validate_email/retrieve?u_email=".$email;
 		$result = consumirServicioSinToken($url_service);
 		$data['response'] = $result;
		$this->load->view('user/user-response', $data);
 	}

 	public function consultarEstadoSesion(){
 		$session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');
	    $token = $this->session->userdata('token');
	    $url = base_url('/rrhh/api/users/obtener-user-id.xml');
	    $result = consumirServicio($url, $session_cookie, $token);
	    $idusuario = (string)@$result->results->item->uid['0'];
	    $estado = 1;
	    if($idusuario == '' or $this->session->userdata('user_id') != $idusuario){
	    	$estado = 0;
	    }
	    $data['response'] = $data = array('estado' => $estado);
		$this->load->view('user/user-response', $data);
 	}

 	public function obtenerFormularioInicioSesionAjax(){
 		//$data['vista'] = 'user/login-ajax';
		$this->load->view('user/login-ajax');
 	}

 	//Validador y verificador de direccion de correo
 	public function verificarValidarCorreoElectronico(){
 		$email = $this->input->get()['email'];
 		//$this->emailverify->debug_on = true;
 		$this->emailverify->local_user = 'reclutamientoregional';
 		$this->emailverify->local_host = 'empleosbaccredomatic.com';
		$valido = false;
		if ($this->emailverify->verify($email)){
	      if($this->session->userdata('validacion_email')){
	        $this->session->unset_userdata('validacion_email');
	      }
			$valido = true;
		}
		$data['response'] = $data = array('valido' => $valido);
		$this->load->view('user/user-response', $data);	
 	}
}
