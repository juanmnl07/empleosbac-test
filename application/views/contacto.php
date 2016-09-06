<div class="w-section st-contact">
	<div class="w-container">

		<h1 title="Oferta de puestos de trabajo en México y Centroamérica" class="h1-form-contacto">Contáctanos
			<span class="linea"></span>
		</h1>
		
		<h2 class="h2-form-contacto">Formulario de Contacto</h2>
		
		<div class="w-row row_carreras">
			
			<div class="w-col w-col-5">

				
				
		          
		        <div id="messages-webform" class="alert" style="display: none">
		          
		        </div>
		        
				
				<?php 
					$hidden = array('webform_id' => 1);
					$attributes = array('class' => 'form-contacto', 'id' => 'form-contacto');
					echo form_open('contacto', $attributes, $hidden);
					
					$nombre_input = array(
					              'name'        => 'nombre',
					              'id'          => 'nombre',
					              'value'       => '',
					              'maxlength'   => '100',
					              'size'        => '50',
					              'style'       => 'width:100%',
					              'placeholder' => 'Nombre'
					            );
					$correo_input = array(
					              'name'        => 'correo',
					              'id'          => 'correo',
					              'value'       => '',
					              'maxlength'   => '100',
					              'size'        => '50',
					              'style'       => 'width:100%',
					              'placeholder' => 'Correo'
					            );
					$pais_options = array(
								  'default'  => '- País a contactar -',
				                  'Costa Rica'  => 'Costa Rica',
				                  'Panama'    => 'Panamá',
				                  'Nicaragua'   => 'Nicaragua',
				                  'El Salvador' => 'El Salvador',
				                  'Guatemala' => 'Guatemala',
				                  'Honduras' => 'Honduras',
				                  'Mexico' => 'México',
	                );
					$pais_select_attr = 'id="pais"';

					$telefono_input = array(
					              'name'        => 'telefono',
					              'id'          => 'telefono',
					              'value'       => '',
					              'maxlength'   => '100',
					              'size'        => '50',
					              'style'       => 'width:100%',
					              'placeholder' => 'Teléfono'
					            );
					$comentario_input = array(
					              'name'        => 'comentario',
					              'id'          => 'comentario',
					              'value'       => '',					              
					              'style'       => 'width:100%',
					              'placeholder' => 'Comentarios'
					            );

					echo form_input($nombre_input);

					echo form_input($correo_input);
					?>
					<div class="contact-pais-select-wrapper">
						<?php echo form_dropdown('pais', $pais_options, 'default', $pais_select_attr);	?>
					</div>
					<?php
					echo form_input($telefono_input);

					echo form_textarea($comentario_input);

					$boton_enviar = array(
					    'name' => 'button',
					    'id' => 'boton-enviar',
					    'value' => 'Enviar mensaje',
					    'type' => 'submit',
					    'content' => 'Enviar mensaje'
					);

					echo form_button($boton_enviar);

					echo form_close(); ?>
					<div id="loader-contacto" style="display: none; text-align: center; width: 100%;"><img src="public/images/loader.gif" /></div>


			</div>

			<div class="w-col w-col-7">
				<div class="mapa-container">
					<div class="mapas-paises-hover-container">
						<div class="mapas-paises-hover-container-inner">
							<div class="mapas-paises-hover-costa-rica mapas-paises-hover">
								
							</div>
							<div class="mapas-paises-hover-panama mapas-paises-hover">
								
							</div>
							<div class="mapas-paises-hover-nicaragua mapas-paises-hover">
								
							</div>
							<div class="mapas-paises-hover-elsalvador mapas-paises-hover">
								
							</div>
							<div class="mapas-paises-hover-guatemala mapas-paises-hover">
								
							</div>
							<div class="mapas-paises-hover-honduras mapas-paises-hover">
								
							</div>
							<div class="mapas-paises-hover-mexico mapas-paises-hover">
								
							</div>
						</div>
					</div>
					<div class="tooltip-container">
						<div class="tooltip-container-inner">
							<div class="tooltip-costa-rica tooltip-pais-wrapper" data-pais="costa-rica">
								<a href="javascript:void(0);" class="tooltip-pais">Costa Rica</a>
							</div>
							<div class="tooltip-panama tooltip-pais-wrapper" data-pais="panama">
								<a href="javascript:void(0);" class="tooltip-pais">Panamá</a>
							</div>
							<div class="tooltip-nicaragua tooltip-pais-wrapper" data-pais="nicaragua">
								<a href="javascript:void(0);" class="tooltip-pais">Nicaragua</a>
							</div>
							<div class="tooltip-elsalvador tooltip-pais-wrapper" data-pais="elsalvador">
								<a href="javascript:void(0);" class="tooltip-pais">El Salvador</a>
							</div>
							<div class="tooltip-guatemala tooltip-pais-wrapper" data-pais="guatemala">
								<a href="javascript:void(0);" class="tooltip-pais">Guatemala</a>
							</div>
							<div class="tooltip-honduras tooltip-pais-wrapper" data-pais="honduras">
								<a href="javascript:void(0);" class="tooltip-pais">Honduras</a>
							</div>
							<div class="tooltip-mexico tooltip-pais-wrapper" data-pais="mexico">
								<a href="javascript:void(0);" class="tooltip-pais">México</a>
							</div>
						</div>
					</div>
					
					<div class="popup-container"><a href="#" id="close_popup">X</a>
						<div class="mapa-contacto-pais-titulo"></div>
						<div class="mapa-contacto-pais-direccion mapa-contacto-pais-detalle"></div>
						<div class="mapa-contacto-pais-telefono mapa-contacto-pais-detalle"></div>
						<div class="mapa-contacto-pais-correo mapa-contacto-pais-detalle"></div>
					</div>
				</div>

			</div>

		</div>
		
		
		

		
	</div>

</div>
<?php require_once 'bloques/bloque_parte_del_cambio.php';?>