<div class="w-section">
	<div class="w-container ct_detalle_puesto">
		<?php 
			extract($info);
			//exit(var_export($info));
			$nid_puesto_actual=$nid;
			$puesto_aplicado = false;

			$carrera = "";
			if (isset($field_carrera) and !empty($field_carrera)){  
				$carrera = $field_carrera; 
			}
			$pais = "";
			if (isset($field_pais) and !empty($field_pais)){  
				$pais = $field_pais; 
			}
			$zona = "";
			if (isset($field_zona) and !empty($field_zona)){  
				$zona = $field_zona; 
			}
			$fecha_cierre = "";
			if (isset($field_fecha_de_cierre_de_oferta) and !empty($field_fecha_de_cierre_de_oferta)){  
				$fecha_cierre = $field_fecha_de_cierre_de_oferta; 
			}

			$tipo_jornada = array();
			if (isset($field_tipo_de_jornada) and !empty($field_tipo_de_jornada)){  
				$tipo_jornada = $field_tipo_de_jornada; 
			}

			$idiomas = array();
			if (isset($field_idiomas_requeridos) and !empty($field_idiomas_requeridos)){  
				$idiomas = $field_idiomas_requeridos; 
			}

			$nivel_academico = "";
			if (isset($field_nivel_academico_requerido) and !empty($field_nivel_academico_requerido)){  
				$nivel_academico = $field_nivel_academico_requerido; 
			}

			if($this->session->userdata('session_name') !== null  and $this->session->userdata('sessid')!== null){
				$session_cookie = $this->session->userdata('session_name').'='.$this->session->userdata('sessid');

				if ($this->session->userdata('user_id')!==null){

					$user_id = $this->session->userdata('user_id');
					
					if($this->session->userdata('isAdmin')!== null and ($this->session->userdata('isAdmin') == false)){
						$url = base_url('rrhh/api/users/puestos_aplicados_total/retrieve.xml?uid_aplicante='.$user_id);
						$puestos_aplicados = consumirServicioSinToken( $url, $session_cookie);
						
						if(isset($puestos_aplicados) and (!empty($puestos_aplicados))){
							foreach ($puestos_aplicados as $key => $value) {
								
								if($nid_puesto_actual==$value->nid_puesto){

									$puesto_aplicado = true;
									$fecha_aplicacion = $value->fecha;
								}
							}
						}
					}


				}
				
			}
			
			

		?>
		<?php if($status==0){?>
			<div class="alert alert-warning"><p>Este puesto de trabajo NO tiene estado "Publicado" y no está visible a los usuarios anónimos o aplicantes del sitio web. Para cambiar el estado de este puesto, haga <a href="/rrhh/node/<?=$nid?>/edit">click aquí</a></p></div>
		<?php } else if($this->input->get('creado') == "true"){ ?>
			<div class="alert alert-success"><p>El puesto ha sido creado con éxito. Para editarlo, haga <a href="/rrhh/node/<?=$nid?>/edit">click aquí</a></p></div>
		<?php } else if($this->input->get('editado') == "true"){ ?>
			<div class="alert alert-success"><p>El puesto ha sido editado con éxito. Para volver a editarlo, haga <a href="/rrhh/node/<?=$nid?>/edit">click aquí</a></p></div>
		<?php }?>
		
		<h1><?=$title?><span class="linea"></span></h1>
		<?php if ($show_edit==true){ ?>
			<a class="btn-editar-puesto" href="/rrhh/node/<?=$nid?>/edit">Editar Puesto</a>
		<?php } ?>
		<div class="publicado"><p>Publicado: <?=$created?></p></div>

		<div class="w-row">
			<div class="w-col w-col-8 detalle_puesto">
				<?php if(isset($field_imagen_puesto) and !empty($field_imagen_puesto)){?>
				<img id="img_detalle_puesto" src="<?=$field_imagen_puesto?>"><br><br>
				<?php }?>
				<?php if(isset($body) and !empty($body)){?>
				<?=$body?>
				<?php }?>
				
				<?php if($puesto_aplicado==true) { ?>
					<div class="puesto-aplicado-msg">Tú aplicaste a este puesto <span>el <?=date('d/m/Y', (int)$fecha_aplicacion);?></span><a class="btn_desaplicar" href="javascript:void(0);" data-evento="click" data-nombre="Click al botón de des aplicar al puesto" data-popup-target="#popup_aplicar">Desaplicar</a></div>
				<?php } else {?>
					<a class="btn_aplicar" href="javascript:void(0);" data-evento="click" data-nombre="Click al botón de Aplicar al puesto" data-popup-target="#popup_aplicar">Aplicar</a>
				<?php } ?>
				<br><br>

				<div class="w-row box_compartir">
					<div class="w-col w-col-7 box_compartir_info">
						<strong>Compartir</strong>
						<p>Permite que otras personas conozcan este puesto de trabajo.</p>

					</div>
					<div class="w-col w-col-5 box_compartir_comp">
						<div class="btn_shared">
							<span class='st_linkedin_large' displayText='LinkedIn'></span>
							<span class='st_facebook_large' displayText='Facebook'></span>
							<span class='st_twitter_large' displayText='Tweet'></span>
							<span class='st_email_large' displayText='Email'></span>
						</div>

					</div>
				</div>


				<br><br>				

				<a class="btn_atras" href="/puestos">Regresar a puestos disponibles</a>				

			</div>
			<div class="w-col w-col-4 detalle_puesto_info">

				<div class="info_puesto_box">
					<div class="ipb_icon iinfo">&nbsp</div>
					<div class="idatos">
						<b>País</b> <?=@$pais;?><br />
						<b>Zona</b> <?=@$zona;?><br />
						<b>Carrera</b> <?=$carrera;?> <br />
						<b>Oferta cierra el</b> <?=@$fecha_cierre;?><br />						
					</div>
				</div>
				<div class="info_puesto_box">
					<div class="ipb_icon ijornada">&nbsp</div>
					<div class="idatos">
						<b>Jornada laboral</b><br />
						<?php
						foreach ($tipo_jornada as $row) {
							echo $row . '<br />';
						}?>
					</div>
				</div>
				<div class="info_puesto_box">
					<div class="ipb_icon iidioma">&nbsp</div>
					<div class="idatos">
						<b>Idiomas Requeridos</b><br />
						<?php $fidiomas = '';
						foreach ($idiomas as $row) {
							$fidiomas .= $row . ', ';
						} echo substr($fidiomas, 0, -2); ?>
					</div>
				</div>
				<div class="info_puesto_box">
					<div class="ipb_icon iacademico">&nbsp</div>
					<div class="idatos">
						<b>Nivel Académico Requerido</b><br />
						<?=$nivel_academico;?>						
					</div>
				</div>

				<?php if($puesto_aplicado==true) { 
					 ?>
					<div class="puesto-aplicado-msg">Tú aplicaste a este puesto <span>el <?=date('d/m/Y', (int)$fecha_aplicacion);?></span><a class="btn_desaplicar" href="javascript:void(0);" data-evento="click" data-nombre="Click al botón de des aplicar al puesto" data-popup-target="#popup_aplicar">Desaplicar</a></div>
				<?php } else {?>
					<a class="btn_aplicar" data-evento="click" data-nombre="Click al botón de Aplicar al puesto" href="javascript:void(0);" data-popup-target="#popup_aplicar">Aplicar</a>
				<?php } ?>
				

			</div>			
			
		</div>


	<div class="popup" id="popup_aplicar">
        <div class="popup-body">
        	<span class="popup-exit <?=$this->session->userdata('sessid')!=''?"after-logged":""?>"></span>
        	<div class="popup-content">
				<div>
					<div id="forularioAjax"></div>
				<?php $hidden = "hidden"; ?>
				<?php 
					  /*if($this->session->userdata('sessid') == ''):
						require_once 'user/login-ajax.php';
				      else:
				      	//aplicar al puesto
				      	echo "<span id='logueado'></span>";
					  endif;*/
				?>
				<div id="mensaje-despues-inicio-sesion" class='<?php echo $hidden ?>'>&nbsp</div>

				</div>

        	</div>
        </div>
    </div>
    <div class="popup-overlay <?=$this->session->userdata('sessid')!=''?"after-logged":""?>"></div>

	</div>
</div>


<?php require_once 'bloques/otros_puestos.php';?>