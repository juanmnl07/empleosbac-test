<?php 
    $class = "";
    $error_message ="";
    if(!isset($errorlogin)):
      $class = "hidden";
    else:
      $error_message = $errorlogin;
    endif;
 ?>
<div class="messages <?php echo $class ?>">
  <div class="error message">
    <?php echo $error_message ?>
  </div>
</div>

<div class="formlogin">

<?php 
  
  if(!isset($classform)){
    $classform = 'form-login';
  }

$attributes = array('class' => $classform, 'id' => $idform);
echo form_open(base_url(uri_string()), $attributes);
$email_input = array(
              'name'        => 'mail',
              'id'          => 'correo',
              'value'       => '',
              'maxlength'   => '100',
              'placeholder' => 'Correo Electronico',
            );
$pass_input = array(
              'name'        => 'pass',
              'id'          => 'clave',
              'value'       => '',
              'maxlength'   => '100',
              'placeholder' => 'Contraseña',
              'type'        => 'password'
            );

echo form_input($email_input);

echo form_input($pass_input);


?>


<!--<input type="checkbox" name="recordarme" id="recordarme"> <label for="recordarme">Recordarme</label>-->


<?php

$boton_enviar = array(
    'name' => 'button',
    'id' => 'boton-enviar',
    'type' => 'submit',
    'content' => 'Ingresar'
);

echo form_button($boton_enviar);

echo form_close(); ?>

<div class="formloginlinks"><a href="/registro">Registrarte</a> &nbsp&nbsp | &nbsp&nbsp <a href="/recordar">¿Olvidaste tu contraseña?</a></div>