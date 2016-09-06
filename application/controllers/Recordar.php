<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Recordar extends CI_Controller {

    public function __construct()
    {
	    parent::__construct();
	    //$this->load->library('encryption');
	    $this->load->library('encrypt');
	    $this->load->helper('string');
	    $this->load->model('Cambio_clave');
	    //$this->load->library('email');
	    $this->load->library('My_PHPMailer');
	    $this->load->library('email');
	    //$this->output->cache(3600);
    }

 	public function index()
	{

		if($this->input->post()){
			//generar token
			$token = random_string('sha1', 16);
			$correo = $this->input->post('correo');
			//if($respuesta->results)
			//verificar existencia del correo electronico
			$url_service = base_url('/rrhh/api/users/aplicante_id.xml?mail='.$correo);
			$respuesta = consumirServicioSinToken($url_service);
			
			if(!empty($respuesta->results)){
				//almacenar los datos en el formulario
				$postdata = array('u_email' => $correo, 'token' => $token);
				$result = $this->Cambio_clave->insert_entry($postdata);
				if($result){
					//se inserto la informacion en la tabla
					//se enviara un correo electronico al usuario con el url de cambio de contraseña

					//preferencias
					/*$mail = new PHPMailer();

					//Luego tenemos que iniciar la validación por SMTP:
					$mail->IsSMTP();
					$mail->SMTPAuth = true;
					//$mail->SMTPDebug  = 2;
					$mail->Host = "mail.orbelink.com"; // SMTP a utilizar. Por ej. smtp.elserver.com
					$mail->Username = "soporte@orbelink.com"; // Correo completo a utilizar
					$mail->Password = "orbe.2016"; // Contraseña
					$mail->Port = 25; // Puerto a utilizar

					//Con estas pocas líneas iniciamos una conexión con el SMTP. Lo que ahora deberíamos hacer, es configurar el mensaje a enviar, el //From, etc.
					$mail->From = "reclutamientoregional@baccredomatic.com"; // Desde donde enviamos (Para mostrar)
					$mail->FromName = "Empleos BAC | Credomatic";

					//Estas dos líneas, cumplirían la función de encabezado (En mail() usado de esta forma: “From: Nombre <correo@dominio.com>”) de //correo.
					$mail->AddAddress($correo); // Esta es la dirección a donde enviamos
					$mail->IsHTML(true); // El correo se envía como HTML
					$mail->CharSet = 'UTF-8';
					$mail->Subject = 'Solicitud de cambio de contraseña'; // Este es el titulo del email.*/
					$body = '<img src="'.base_url().'/public/images/logo.gif" width="375" height="65"><br><br>
						<br /><br />
			        	<table>
				        	<tbody>
					        	<tr>
					        		<td>Has solicitado un cambio de contraseña.<br><br>Haga Clic en el siguiente enlace para continuar con el proceso.<br>
					        		<a href="'.base_url().'cambio-clave/'.$token.'">'.base_url().'cambio-clave/'.$token.'</a>

					        		<br>
					        		<br>
					        		<br>
									
									Si no has solicitado un cambio de contraseña de tu cuenta, entonces omita este mensaje.

					        		</td>
					        	</tr>
				        	</tbody>
			        	</table>'; // Mensaje a enviar

			        /*$mail->Body = $body;*/
			        //$mail->SMTPDebug  = 2;
					//$exito = $mail->Send();

					/*$ourMail = $correo;
					$headers = 'MIME-Version: 1.0' . "\r\n";
					$headers.= 'Content-type: text/html; charset=UTF-8' . "\r\n";
					$headers.= "From: Empleos BAC | Credomatic <reclutamientoregional@empleosbaccredomatic.com>\r\n";
					$headers.= "reply-to: reclutamientoregional@baccredomatic.com\r\n";
					$exito = mail($ourMail, "Solicitud de cambio de contraseña", $body, $headers);	*/

					$config['charset'] = 'UTF-8';
					$config['mailtype'] = 'html';
					$this->email->initialize($config);
					$this->email->from('reclutamientoregional@empleosbaccredomatic.com', 'Empleos BAC | Credomatic');
					$this->email->to($correo); 
					/*$this->email->cc('another@another-example.com'); 
					$this->email->bcc('them@their-example.com'); */

					$this->email->subject("Recuperación de contraseña \r\n");
					$this->email->message($body);

					//También podríamos agregar simples verificaciones para saber si se envió:
					if(!$this->email->send()){
						$data['tipo_mensaje'] = 'alert-danger';
						$data['mensaje'] = 'Lo sentimos, el correo no pudo ser enviado, intente más tarde.';
					} else {
						$data['tipo_mensaje'] = 'alert-success';
						$data['mensaje'] = 'Se ha enviado un correo electronico con instrucciones.';
					}
				}
			} else {
				$data['tipo_mensaje'] = 'alert-danger';
				$data['mensaje'] = 'El correo electrónico '.$correo.', no se encuetra registrado en nuestra base de datos.';
			}
		}
		$data['titulo'] = 'Recordar contraseña';
		$data['meta_desc'] = '';
		$data['meta_keywords'] = '';
		$data['vista']  = 'recordar';
		$this->breadcrumb->clear();
		$this->breadcrumb->add('Inicio', '/');
		$this->breadcrumb->add('Recordar contraseña');
		$this->load->view('index', $data);
	}

	//cambio de contraseña
	public function cambioClave($token = ''){
		//verificar que en la tabla exista un usuario con el email y el token como metodo de seguridad
		//al validar el procedimiento se muestra un formulario con el cambio de contraseña y se envia la informacion a Drupal para cambiar
		//buscar en la tabla de cambio_clave, el correo y el token para validar cambio
		//descifrar el correo
		//$descyphermail = $this->encryption->decrypt($u_mail);
		$deleted = false;
		if($this->input->post()){
			//cambio contraseña
			$url_service = base_url().'rrhh/api/users/change_password/retrieve.xml?u_email='.$this->input->post('mail').'&clave='.$this->input->post('pass').'&token='.$token;
			$result = consumirServicioSinToken($url_service);
			//exit(var_export($result));
			$status = (int)$result->status;
			if($status == 1){
				$data['tipo_mensaje'] = 'alert-success';
				$data['mensaje'] = 'La contraseña se ha cambiado satisfactoriamente';
				//borrar el token 
				$this->Cambio_clave->delete($token);
				$deleted = true;
			}
		}
		

		$u_email ='';
		if(!$deleted){	
			$result = $this->Cambio_clave->buscarUsuario($token);				
			if(empty($result)){
				$data['tipo_mensaje'] = 'alert-danger';
				$data['mensaje'] = 'Lo sentimos, la contraseña ya ha sido cambiada';
			}	else {
				$u_email = $result[0]->u_email;
			}
		}
		//cambio contraseña 
		//mostrar el formulario para cambio de contraseña
		$data['titulo'] = 'Cambiar contraseña';
		$data['meta_desc'] = '';
		$data['meta_keywords'] = '';
		$data['vista'] = 'cambio-clave';
		$data['email'] = $u_email;
		$data['token'] = $token;
		$this->breadcrumb->clear();
		$this->breadcrumb->add('Inicio', '/');
		$this->breadcrumb->add('Cambio contraseña');
		$this->load->view('index', $data);
	}	
}