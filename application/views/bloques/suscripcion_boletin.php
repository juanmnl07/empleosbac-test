<div class="w-section st-suscripcion-boletin">
	<div class="w-container">
		<h2 title="Buscar empleo en México y Centroamérica">Inscríbete a la Red Regional de <strong>Carreras BAC | Credomatic</strong></h2>
		<p>Regístrate junto a <strong>miles de colaboradores</strong> y amigos de BAC | Credomatic en toda la <strong>región</strong>, y mantente al tanto de las<br />
		<strong>oportunidades de trabajo</strong>, de los retos y logros de nuestra gente. </p>
		
		<div id="messages-webform" class="alert" style="display: none"></div>

				<?php 
					$hidden = array('webform_id' => 2);
					$attributes = array('class' => 'form-suscripcion-boletin', 'id' => 'form-suscripcion-boletin');
					echo form_open('inicio', $attributes, $hidden);
					$nombre_input = array(
					              'name'        => 'nombre',
					              'id'          => 'nombre',
					              'value'       => '',
					              'maxlength'   => '100',
					              'size'        => '50',
					              'placeholder' => 'Nombre'
					            );
					$correo_input = array(
					              'name'        => 'correo',
					              'id'          => 'correo',
					              'value'       => '',
					              'maxlength'   => '100',
					              'size'        => '50',
					              'placeholder' => 'Correo'
					            );
					$boton_enviar = array(
					    'name' => 'button',
					    'id' => 'boton-enviar',
					    'value' => 'Inscribirme',
					    'type' => 'submit',
					    'content' => 'Inscribirme'
					);					
				?>

		<div class="w-row row_suscripcion-boletin">
			<div class="w-col w-col-3"><?=form_input($nombre_input)?></div>
			<div class="w-col w-col-6"><?=form_input($correo_input)?></div>
			<div class="w-col w-col-3"><?=form_button($boton_enviar)?></div>
		</div>

		<?php echo form_close(); ?>
		<div id="loader-contacto" style="display: none; text-align: center; width: 100%;">
			<img src="public/images/loader.gif" />
		</div>		

		
	</div>

</div>