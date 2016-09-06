<div class="w-section">
	<div class="w-container ct_recuperar">

		<h1>¿Olvidaste tu contraseña? <span class="linea"></span></h1>
		
		<p>&nbsp</p><p>&nbsp</p>
		<p>Recuperar contraseña</p>
		<p>&nbsp</p>

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
		<p>&nbsp</p>


		<?php 
			$hidden = array('webform_id' => 522);
			$attributes = array('class' => 'form-recuperar-clave', 'id' => 'form-recuperar-clave2');
			echo form_open('recordar', $attributes, $hidden);
			$correo_input = array(
			              'name'        => 'correo',
			              'id'          => 'correo',
			              'value'       => '',
			              'maxlength'   => '100',
			              'size'        => '50',
			              'placeholder' => 'Correo Electrónico'
			            );
			$boton_enviar = array(
			    'name' => 'button',
			    'id' => 'boton-enviar',
			    'value' => 'Recuperar',
			    'type' => 'submit',
			    'content' => 'Recuperar'
			);					
		?>

		<div id="messages-recuperar" class="alert" style="display: none"></div>

		<div class="w-row formrecuperar">
			<div class="w-col w-col-2">&nbsp</div>
			<div class="w-col w-col-5"><?=form_input($correo_input)?></div>
			<div class="w-col w-col-3"><?=form_button($boton_enviar)?></div>
			<div class="w-col w-col-2">&nbsp</div>
		</div>
		<?=form_close()?>

		<p>&nbsp</p><p>&nbsp</p>

	</div>
</div>
<?php require_once 'bloques/bloque_parte_del_cambio.php'; ?>