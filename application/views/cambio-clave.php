<div class="w-section">
	<div class="w-container ct_recuperar">

		<?php 
        $class = "";
        $mensaje_resultado ="";
        if(!isset($mensaje)):
          $class = "hidden";
        else:
          $mensaje_resultado = $mensaje;
        endif;
     ?>
        <div id="messages-form-register" class="<?=$class;?>">
          <?php if(isset($mensaje)){ ?>
            <div class="alert <?=@$tipo_mensaje;?>">
              <?php echo $mensaje_resultado; ?>
            </div>
          <?php } ?>
        </div>

		<h1>Cambio Contraseña <span class="linea"></span></h1>
		
		<p>&nbsp</p>

		<?php 
			//$hidden = array('webform_id' => 522);
			$attributes = array('class' => 'form-cambiar-clave', 'id' => 'form-cambiar-clave');
			echo form_open('cambio-clave/'.$token, $attributes);
			$pass_input = array(
			              'name'        => 'pass',
			              'id'          => 'pass',
			              'value'       => '',
			              'maxlength'   => '100',
			              'size'        => '50',
			              'placeholder' => 'Ingrese su nueva clave',
			              'type' 		=> 'password',
			            );
			$pass_conf_input = array(
			              'name'        => 'conf-pass',
			              'id'          => 'conf-pass',
			              'value'       => '',
			              'maxlength'   => '100',
			              'size'        => '50',
			              'placeholder' => 'Confirmar nueva clave',
			              'type' 		=> 'password',
			            );
			$email = array(
			              'name'        => 'mail',
			              'id'          => 'mail',
			              'class'		=> 'hidden',
			              'value'       => @$email,
			              'maxlength'   => '100',
			              'size'        => '50',
			              'type' 		=> 'password',
			            );
			$boton_enviar = array(
			    'name' => 'button',
			    'id' => 'boton-cambiar-clave',
			    'value' => 'Crear nueva contraseña',
			    'type' => 'submit',
			    'content' => 'Crear nueva contraseña'
			);					
		?>

		<div id="messages-recuperar" class="alert" style="display: none"></div>

		<div class="w-row formrecuperar">
			<?=form_input($email)?>
			<div class="w-col w-col-4"><?=form_input($pass_input)?></div>
			<div class="w-col w-col-5"><?=form_input($pass_conf_input)?></div>
			<div class="w-col w-col-3"><?=form_button($boton_enviar)?></div>
		</div>
		<?=form_close()?>

		<p>&nbsp</p><p>&nbsp</p>

	</div>
</div>