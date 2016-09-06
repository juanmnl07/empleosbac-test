<div class="w-section">
    <div class="w-container ct_registro formreg">
      
    <div class="contentform">
     <?php 
        $class = "";
        $mensaje_resultado ="";
        if(!isset($mensaje)):
          $class = "hidden";
        else:
          $mensaje_resultado = $mensaje;
        endif;
     ?>
        <div id="messages-form-puesto" class="<?=$class;?>">
          <?php if(isset($mensaje)){ ?>
            <div class="alert <?=$tipo_mensaje;?>">
              <?php echo $mensaje_resultado; ?>
            </div>
          <?php } ?>
        </div>

<?php 


$attributes = array('class' => 'form', 'id' => 'nuevo-puesto', 'enctype'=> "multipart/form-data");
echo form_open(($typeform=='editar'?'admin/puestos/editar/'.$nid:'admin/puestos/crear'), $attributes);

/************ MAIN PROFILE ************/
$titulo_input = array(
              'name'        => 'title',
              'id'          => 'titulo-puesto',
              'value'       => @$title,
              'maxlength'   => '100',
              'size'        => '50',
            );

$descripcion_input = array(
              'name'        => 'body'.($typeform=='nuevo'?'[und][0][value]':''),
              'id'          => 'descripcion-puesto',
              'value'       => @$description,
              'maxlength'   => '100',
              'size'        => '50',
              'type'        => 'textarea',
            );

$imagen_input = array(
              'name'        => 'files'.($typeform=='nuevo'?'[field_imagen_puesto_und_0]':''),
              'id'          => 'imagen-puesto',
              'value'       => '',
              'maxlength'   => '100',
              'size'        => '50',
              'type'        => 'file',
            );

$zona_input = array(
              'name'        => 'field_zona'.($typeform=='nuevo'?'[und][0][value]':''),
              'id'          => 'zona-puesto',
              'value'       => @$zona,
              'maxlength'   => '100',
              'size'        => '50',
            );

echo "<div id='datos-personales' class='paso'>";
echo '<h2>' . $titulo_pagina . ' Puesto<span class="linea"></span></h2>'; 

echo '<div class="label">';
echo form_label('Título','titulo');
echo form_input($titulo_input);
echo '</div>';

echo '<div class="label">';
echo form_label('Descripción','descripcion');
echo form_input($descripcion_input);
echo '</div>';

echo '<div class="label">';
echo form_label('Imagen', 'image-puesto');  
echo form_upload($imagen_input);
echo "</div>";

echo '<div class="label">';
echo form_label('Zona','zona');
echo form_input($zona_input);
echo '</div>';

$boton_enviar = array(
    'name' => 'button',
    'id' => 'boton-enviar',
    'value' => 'Guardar',
    'type' => 'submit',
    'content' => 'Guardar'
);
echo form_button($boton_enviar);
echo form_close(); ?>

  </div>
</div>
</div>