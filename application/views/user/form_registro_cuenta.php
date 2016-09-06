<div class="w-section">
    <div class="w-container ct_registro formreg <?=$typeform?>">
      
      <div id="navegacion-registro" class="navegacion">
        <div id="navegacion-registro-inner" class="inner"><div class="linenav">&nbsp</div>
          <a data-id="datos-personales" href="#" class="pasoactivo">
            <p class="numero-paso">1</p>
            <p class="titulo-paso">Datos<br> personales</p>
          </a>
          <a data-id="educacion" href="#">
            <p class="numero-paso">2</p>
            <p class="titulo-paso">Educación</p>
          </a>
          <a data-id="intereses" href="#">
            <p class="numero-paso">3</p>
            <p class="titulo-paso">Intereses</p>
          </a>
          <a data-id="curriculum" href="#">
            <p class="numero-paso">4</p>
            <p class="titulo-paso">Currículum</p>
          </a>
        </div>
      </div>


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
        <div id="messages-form-register" class="<?=$class;?>">
          <?php if(isset($mensaje)){ ?>
            <div class="alert <?=@$tipo_mensaje;?>">
              <?php echo $mensaje_resultado; ?>
            </div>
          <?php } ?>
        </div>


     <?php 
        $class2 = "";
        $mensaje_resultado2 ="";
        if(!isset($mensaje2)):
          $class2 = "hidden";
        else:
          $mensaje_resultado2 = $mensaje2;
        endif;
     ?>
        <div id="messages-form-register" class="<?=$class2;?>">
          <?php if(isset($mensaje2)){ ?>
            <div class="alert <?=@$tipo_mensaje2;?>">
              <?php echo $mensaje_resultado2; ?>
            </div>
          <?php } ?>
        </div>

<?php 


$attributes = array('class' => 'form', 'id' => $typeform, 'enctype'=> "multipart/form-data");
echo form_open(($typeform=='perfil'?'micuenta':'registro'), $attributes);

echo '<input type="text" class="hidden" name="avatar_actual" value="'.@$avatar.'" />';


/************ MAIN PROFILE ************/
$nombre_apellidos_input = array(
              'name'        => 'field_nombre_y_apellidos'.($typeform=='register'?'[und][0][value]':''),
              'id'          => 'nombre-apellidos',
              'value'       => @$nombre_apellidos,
              'maxlength'   => '100',
              'size'        => '50',
              /*'style'       => 'width:50%',*/
            );

/*$paises = array(
                  'CR'  => 'Costa Rica',
                );*/

$generos = array(
                  'femenino'  => 'Femenino',
                  'masculino'  => 'Masculino',
                );


$fecha_nacimiento_input = array(
              'name'        => 'field_fecha_de_nacimiento'.($typeform=='register'?'[und][0][value]':''),
              'id'          => 'fecha-nacimiento',
              'class'       => 'datepicker',
              'value'       => @$fecha_nacimiento,
              'maxlength'   => '100',
              'size'        => '50',
              /*'style'       => 'width:50%',*/
              'enable'      => 'false'
            );

$telefono_input = array(
              'name'        => 'field_telefono'.($typeform=='register'?'[und][0][value]':''),
              'id'          => 'telefono',
              'value'       => @$telefono,
              'maxlength'   => '100',
              'size'        => '50',
              /*'style'       => 'width:50%',*/
            );

$email_input = array(
              'name'        => 'mail',
              'id'          => 'correo',
              'value'       => @$correo,
              'maxlength'   => '100',
              'size'        => '50',
              /*'style'       => 'width:50%',*/
              'type'        => 'email',
              'class'       => $typeform,
              'data'        => @$correo_actual
            );

$actual_pass_input = array(
              'name'        => 'current_pass',
              'id'          => 'clave_actual',
              'value'       => '',
              'maxlength'   => '100',
              'size'        => '50',
              'style'       => 'width:50%',
              'type'        => 'password'
            );


$pass_input = array(
              'name'        => 'pass[pass1]',
              'id'          => 'clave',
              'value'       => '',
              'maxlength'   => '100',
              'size'        => '50',
              /*'style'       => 'width:50%',*/
              'type'        => 'password'
            );

$pass_conf_input = array(
              'name'        => 'pass[pass2]',
              'id'          => 'clave-conf',
              'value'       => '',
              'maxlength'   => '100',
              'size'        => '50',
              /*'style'       => 'width:50%',*/
              'type'        => 'password'
            );

/************** APLICANTE PROFILE ***************/

$niveles_academicos_options = array();
foreach ($niveles_academicos->results->item as $key) {
  $niveles_academicos_options[(string)$key->tid] = (string)$key->name;
}

$porcentaje_input = array(
              'name'        => 'field_idiomas[und][0][field_porcentaje][und][0][value]',
              'id'          => 'porcentaje',
              'value'       => '',
              'maxlength'   => '100',
              'size'        => '50',
              /*'style'       => 'width:50%',*/
              'type'        => "number",
              'min'         =>  "0"
            );

$profesion_input = array(
              'name'        => 'field_profesion'.($typeform=='register'?'[und][0][value]':''),
              'id'          => 'profesion',
              'value'       => @$profesion,
              'maxlength'   => '100',
              'size'        => '50',
              /*'style'       => 'width:100%',*/
            );

$enlace_input = array(
              'name'        => 'field_elances[und][0][value]',
              'id'          => 'enlace',
              'value'       => '',
              'maxlength'   => '100',
              'size'        => '50',
              /*'style'       => 'width:100%',*/
            );

$cualidades_input = array(
              'name'        => 'field_cualidades'.($typeform=='register'?'[und][0][value]':''),
              'id'          => 'cualidades',
              'value'       => @$cualidades,
              'rows'        => '10',
              'cols'        => '10',
              'style'       => 'width:100%',
              'type'        => 'textarea',
              'maxlength'   => '800',
            );

$ventaja_input = array(
              'name'        => 'field_ventaja_competitiva'.($typeform=='register'?'[und][0][value]':''),
              'id'          => 'ventaja',
              'value'       => @$ventaja,
              'rows'        => '10',
              'cols'        => '10',
              'style'       => 'width:100%',
              'type'        => 'textarea',
              'maxlength'   => '800',
            );
/*upload file - curriculo*/
$curriculo_input = array(
              'name'        => 'curriculum',
              'id'          => 'edit-profile-aplicante-field-curriculum-und-0-upload',
              'class'       => 'form-file',
              'value'       => '',
              'size'        => '22',
              'type'        => 'file'
            );

$foto_input = array(
              'name'        => 'imagen',
              'id'          => 'foto-perfil',
              'class'       => 'form-file',
              'value'       => '',
              'size'        => '22',
              'type'        => 'file'
            );

$descrption = '';
  if($is_mobile){
    $descrption = '<div class="description-cv alert alert-warning">* Algunas versiones de Android pueden presentar problemas por un tema de sistema operativo al momento de guardar el CV y la imagen, por lo que se recomienda hacer el registro o actualización desde una computadora</div>';
  }
  if(isset($mensaje_campos_incompletos )){
    if($mensaje_campos_incompletos != ""){
      echo '<div class="alert alert-warning"><span>Hay campos sin completar en su perfil:</span><br /><ul>'.$mensaje_campos_incompletos.'</ul></div>';
    }
  }

echo "<div id='datos-personales' class='paso'>";
echo '<h2>Datos Personales <span class="linea"></span></h2>'; 


echo $descrption;



echo '<div class="label">';
echo form_label('Nombre y Apellidos','nombre-apellidos');
echo form_input($nombre_apellidos_input);
echo '</div>';

echo '<div class="label">';
echo form_label('Nacionalidad','nacionalidad');
//echo form_dropdown('profile_main[field_nacionalidad][und]', $paises, 'large');
echo country_dropdown('field_nacionalidad'.($typeform=='register'?'[und]':''), 'nacinalidad', 'dropdown col_12_16', @($nacionalidad?$nacionalidad:'CR'), array(), '');
echo '</div>';

echo '<div class="label">';
echo form_label('Fecha de Nacimiento','fecha-nacimiento');
echo form_input($fecha_nacimiento_input);
echo '</div>';

echo '<div class="label">';
echo form_label('Genero','genero');
echo form_dropdown('field_genero'.($typeform=='register'?'[und]':''), $generos, @($genero?$genero:'large'));
echo '</div>';

echo '<div class="label">';
echo form_label('Estado Civil','estados_civiles');
echo form_dropdown('field_estado_civil'.($typeform=='register'?'[und]':''), $estados_civiles, @($estado_civil?$estado_civil:'large'));
echo '</div>';

echo '<div class="label">';
echo form_label('Teléfono','telefono');
echo form_input($telefono_input);
echo '</div>';


echo '

<div class="campofile input-tooltip-wrapper">
  <label>Subir Fotografía</label>
  <div class="labelfile">
    <input id="uploadFileImagen" disabled="disabled" />
    <div class="fileUpload">
        <span>Explorar</span>
        <input id="imagen" name="imagen" type="file" class="form-file" />
    </div> 
  </div>
  <a class="f_ayuda tooltip-form-register" href="javascript:void(0);" data-field="user-photo">
  <div class="tooltip-form-register-detail" data-field="user-photo">La imagen debe ser en formato .jpg; No debe sobrepasar los 2MB de peso.</div></a>
</div>

';


#echo '<div class="label">';
#echo form_label('Imagen');  
#echo form_upload($foto_input);
#echo "</div>";


$msg_mail = '

<script>window.onload = function() {  validarVerificarEmail(1,"Hemos verificado que el correo registrado no es válido. Para poder continuar tienes que ingresar un nuevo correo.");  }</script>

';

if(@$correo){
  if($this->session->userdata('validacion_email') == $correo){
    echo $msg_mail;
  }else{
    if (!$this->emailverify->verify($correo)){
      $this->session->set_userdata('validacion_email', $correo);
      echo $msg_mail;
    }
  }
}
echo '<div class="label">';
echo form_label('Correo Electrónico','email');
echo form_input($email_input);
/*if($typeform == 'perfil'){
  echo '<input type="hidden" value="'.$id_user.'"/>';
}*/
echo '</div>';

echo '<div class="label">';
echo form_label('Discapacidad','discapacidades');
echo form_dropdown('field_discapacidad'.($typeform=='register'?'[und]':''), $discapacidades, @($discapacidad?$discapacidad:'large'));
echo '</div>';

/*echo '<div id="loader-correo" class="hidden" style="text-align: center; width: 100%;"><span>Verificando Correo Electronico... </span><img src="public/images/loader.gif" /></div>';*/





if(isset($correo)){

  echo "<h3>Contraseña</h3>";
  echo '<div class="label">';
  echo form_label('Actual','pass');
  echo form_input($actual_pass_input);
  echo '</div>';

  echo '<div class="label">';
  echo form_label('Nueva','pass');
  echo form_input($pass_input);
  echo '</div>';

  echo '<div class="label">';
  echo form_label('Confirmar nueva contraseña','confpass');
  echo form_input($pass_conf_input);
  echo '</div>';

}else{

  echo '<div class="label">';
  echo form_label('Definir contraseña','pass');
  echo form_input($pass_input);
  echo '</div>';

  echo '<div class="label">';
  echo form_label('Confirmar contraseña','confpass');
  echo form_input($pass_conf_input);
  echo '</div>';

}

if($typeform!='perfil'){
  /*echo '<a data-id="educacion" class="siguiente" href="#" style="float: right; margin-top: 40px;">Siguiente</a>';
} else {*/
  echo '<a data-id="educacion" class="siguiente" href="#">Siguiente</a>';
}
echo '</div>';
/*APLICANTE*/
/*Grado Academico*/

echo "<div id='educacion' class='paso hidden'>";
echo '<h2>Educación <span class="linea"></span></h2>'; //encabezado paso #2


echo '<h3>Estudios académicos</h3>';

echo '<div class="label">';
echo form_label('Máximo Grado Académico','grado-academico');
echo form_dropdown('field_nivel_academico'.($typeform=='register'?'[und]':''), $niveles_academicos_options, @($grado_academico_elegido)?$grado_academico_elegido:'secundaria');
echo '</div>';

echo '<div class="label profesion hidden">';
echo form_label('Profesion','profesion');
echo form_input($profesion_input);
echo '</div>';

echo '<h3>Idiomas y porcentaje de manejo</h3>';
echo "<div id='idiomas'>";

$porcentajes = array('10' => '10%',
                     '20' => '20%',
                     '30' => '30%',
                     '40' => '40%',
                     '50' => '50%',
                     '60' => '60%',
                     '70' => '70%',
                     '80' => '80%',
                     '90' => '90%',
                     '100' => '100%');

if(isset($correo)){

  if(isset($idiomas_selecionados)){
    $contador_idiomas = 0;  
    foreach (@$idiomas_selecionados as $key) {
      foreach ($key as $key2) {
        $idioma = strtolower((string)$key2->Idioma->_options->entity->tid);
        $porcentaje = (string)$key2->Porcentaje->_markup;
        $porcentaje_input = array(
            'name'        => 'field_porcentaje-'.$contador_idiomas,
            /*'id'          => 'porcentaje',*/
            /*'value'       =>  $porcentaje,*/
            /*'maxlength'   => '100',*/
            /*'size'        => '50',*/
            /*'style'       => 'width:50%',*/
            /*'type'        => "number",*/
            /*'min'         => "0"*/
          );
        echo "<div class='idioma'>";
          echo '<label>Idiomas</label>';
          switch ($idioma) {
            case '1':
              echo '<div class="label-idioma">';
                echo '<label>Español</label>';
              echo '</div>';
              break;
            
            case '2':
              echo '<div class="label-idioma">';
                echo '<label>Inglés</label>';
              echo '</div>';
              break;
          }
          echo form_dropdown(array('name' => 'field_idioma-'.$contador_idiomas, 'class' => 'hidden'), $idiomas, $idioma);
          //echo form_label('Porcentaje','porcentaje');
          echo form_dropdown($porcentaje_input, $porcentajes, $porcentaje); 
         // echo form_input($porcentaje_input);
        echo "</div>";
        $contador_idiomas++;
      }
    }
  }




}else{

  echo "<div class='idioma'>";
  echo '<label>Idiomas</label>';
  echo '<div class="label-idioma">';
    echo '<label>Inglés</label>';
  echo '</div>';
  echo form_dropdown(array('name'=>'field_idiomas[und][0][field_idioma][und]','class'=>'hidden select-idioma'), $idiomas, '2');
  echo form_dropdown(array('name'=>'field_idiomas[und][0][field_porcentaje][und][0][value]', 'class' => 'select-idioma'), $porcentajes, 'large');  
  echo "</div>";

  echo "<div class='idioma'>";
  echo '<label>Idiomas</label>';
  echo '<div class="label-idioma">';
    echo '<label>Español</label>';
  echo '</div>';
  echo form_dropdown(array('name'=>'field_idiomas[und][1][field_idioma][und]','class'=>'hidden'), $idiomas, '1');
  echo form_dropdown(array('name'=>'field_idiomas[und][1][field_porcentaje][und][0][value]', 'class' => 'select-idioma'), $porcentajes, 'large');  
  echo "</div>";

}

echo "<span id='contador' class='hidden'></span>";
echo "</div>";
//echo "<div id='mas-idioma-registro' class='mas-idioma'><a href='#'>Agregar Idioma</a></div>";

if($typeform!='perfil'){
  /*echo '<a data-id="datos-personales" class="atras" href="#" style="float: left; margin-top: 40px; clear:none;">Atrás</a>';
  echo '<a data-id="intereses" class="siguiente" href="#" style="float: right; margin-top: 40px; clear:none;">Siguiente</a>';
} else {*/
  echo '<a data-id="intereses" class="siguiente" href="#">Siguiente</a>';
}

echo '</div>';

echo "<div id='intereses' class='paso hidden'>";
echo '<h2>Intereses <span class="linea"></span></h2>'; //encabezado paso #3

echo '<h3>Intereses</h3>';

echo form_label('Paises donde deseas trabajar','pais-donde-trabajar', array('class'=>'labelbold'));

if(isset($paises)){
  echo "<div id='paises' class='hidden'>";
  foreach ($paises as $key2 => $value2) {
    echo "<label class='pais-aplicado'>".$value2."</label>";
  }
  echo "</div>";
}

echo "<div id='paises-registro'>";
/* sera llenado automaticamente con ajax */
echo "</div>";



echo form_label('Áreas en las que deseas laborar','area-donde-trabajar', array('class'=>'labelbold'));

if(isset($carreras)){
  echo "<div id='carreras' class='hidden'>";
  foreach ($carreras as $key => $value) {
    echo "<label class='carrera-aplicado'>".$value."</label>";
  }
  echo "</div>";
}

echo "<div id='areas-registro'>";
/* sera llenado automaticamente con ajax */ 
echo "</div>

<div class='cualidades-input-wrapper input-tooltip-wrapper'>";

echo form_label('¿Cuáles son tus cualidades como persona y trabajador?','cualidades');
echo '<a class="f_ayuda tooltip-form-register" data-field="user-cualidades" href="javascript:void(0)">
  <div class="tooltip-form-register-detail" data-field="user-cualidades">Danos una breve descripción de tus cualidades personales y laborales.</div></a>';
echo form_textarea($cualidades_input);

echo '<br ><br ><br ><br ></div><div class="ventaja-input-wrapper input-tooltip-wrapper">';

if($typeform!='perfil'){
  
}
echo form_label('¿Por qué eres una ventaja competitiva para BAC | Credomatic?','ventajas');
echo '<a class="f_ayuda tooltip-form-register" data-field="user-ventajas" href="javascript:void(0)">
  <div class="tooltip-form-register-detail" data-field="user-ventajas">Danos una breve descripción del por qué consideras que eres una ventaja competitiva para BAC | Credomatic</div></a>
  </div>';
echo form_textarea($ventaja_input);

if($typeform!='perfil'){
  /*echo '<a data-id="educacion" class="atras" href="#" style="float: left; margin-top: 40px; clear:none;">Atrás</a>';
  echo '<a data-id="curriculum" class="siguiente" href="#" style="float: right; margin-top: 40px; clear:none;">Siguiente</a>';  
  //echo '<a data-id="curriculum" class="siguiente" href="#" style="float: right; margin-top: 55px;">Siguiente</a>';
} else {*/
  echo '<a data-id="curriculum" class="siguiente" href="#">Siguiente</a>';
}


echo '</div>';

echo "<div id='curriculum' class='paso hidden'>";
echo '<h2>Currículum <span class="linea"></span></h2>'; //encabezado paso #3

echo '<h3>Registrar tu currículum vitae</h3>';
echo "<div id='subir-curriculum'>";

  $descrption2 = '';
  if($is_mobile){
    $descrption2 = '<span class="description-cv">* Algunas versiones de Android pueden presentar problemas por un tema de sistema operativo al momento de guardar el CV por lo que se recomienda hacer el registro desde una computadora</span>';
  }

  if(@$curriculum != ''){

    echo "<h3 class='titulo-curriculum'>Tu currículum</h3>";
    echo '<input type="text" class="hidden" name="curriculum_actual" value="'.@$curriculum.'" />';
    echo "<a class='descargar-curriculum' target='_blank' href='/rrhh/sites/default/files/uploads/".$curriculum."'>Descargar</a>";
  }

  echo '<div class="campofile input-tooltip-wrapper curriculum">
<label class="full">Subir Archivo CV</label>
<div class="labelfile width-90">
<input id="uploadFile" disabled="disabled" />
<div class="fileUpload">
    <span>Explorar</span>
    <input id="edit-profile-aplicante-field-curriculum-und-0-upload" name="curriculum" type="file" class="form-file" required accept="application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document" />
</div> 
</div>
  <a class="f_ayuda tooltip-form-register" data-field="user-cv" href="javascript:void(0)">
  <div class="tooltip-form-register-detail" data-field="user-cv">El archivo puede ser subido en formatos .pdf, .doc y .docx</div></a>'.$descrption2.'</div>
';
/*
echo '<h3>¿Has trabajado anteriormente en BAC|Credomatic?</h3>';
echo "<div id='has-trabajado-anteriormente-en-bac'>";
echo form_dropdown('field_trabajo_anteriormente_bac'.($typeform=='register'?'[und]':''), $trabajo_anteriormente_bac);
echo "</div'>";*/

echo '<h3>¿Has trabajado anteriormente en BAC|Credomatic?</h3>';
echo '<div class="label trabajo_anteriormente_en_bac">';
echo form_dropdown('field_trabajo_anteriormente_bac'.($typeform=='register'?'[und]':''), $trabajo_anteriormente_bac, @($field_trabajo_anteriormente_bac?$field_trabajo_anteriormente_bac:'large'));
echo '</div>';


  #echo form_label('Subir Archivo CV');  
  #echo form_upload($curriculo_input);
echo "</div>";

echo '<h3>Referencias</h3>';
echo '<label>Indica un sitio de referencia para conocer más tu perfil</label>';
echo "<div id='enlaces'>";
  echo "<div class='enlaces input-tooltip-wrapper'>";

  if(isset($enlaces)){
    $enlaces_contador = 0;
    foreach (@$enlaces as $key) {
      foreach ($key as $key2) {
        $enlace_input = array(
                'name'        => 'field_elances[und]['.$enlaces_contador.'][value]',
                'id'          => 'enlace',
                'value'       => (string)$key2,
                'maxlength'   => '100',
                'size'        => '50',
                'data-id-enlace' => $enlaces_contador,
              );
        echo '<div class="input-group active">';
          echo form_input($enlace_input);
          echo '<span class="input-group-remove">X</span>';
        echo '</div>';
        $enlaces_contador++;
      }
    }
    if($enlaces_contador == 0){
      echo '<div class="input-group active">';
        echo form_input($enlace_input);
        echo '<span class="input-group-remove">X</span>';
      echo '</div>';
    }
  } else {
    echo '<div class="input-group active">';
      echo form_input($enlace_input);
      echo '<span class="input-group-remove">X</span>';
    echo '</div>';
  }

  echo '</div>
  <a class="f_ayuda tooltip-form-register" data-field="user-ref" href="javascript:void(0)">
  <div class="tooltip-form-register-detail" data-field="user-ref">Puedes agregar links de sitios con más información sobre tu perfil, como blogs o redes sociales como LinkedIn</div></a>
  ';
  echo "<span id='contador' class='hidden'></span>";
echo "</div>";

echo "<div id='mas-enlace-registro' class='mas-enlace'><a href='#'>Agregar Nuevo URL</a></div>";



echo '<div class="envio-informacion-box"><h3>¿Desea recibir información por alguno de estos medios?</h3>';
echo '<div class="envio_de_informacion"><div class="w-col w-col-6">';
//echo form_dropdown('field_envio_de_informacion'.($typeform=='register'?'[und]':''), $envio_de_informacion_options, @($envio_de_informacion?$envio_de_informacion:'large'));

//exit(var_dump($envio_de_informacion));
  $envioInfo = array();
if(isset($envio_de_informacion)){
  foreach ($envio_de_informacion as $key => $value) {
    foreach ($value->item as $key2 => $value2) {
      $envioInfo[] = (string)$value2->tid;
    }
  }
}

foreach ($envio_de_informacion_options as $key => $value) {
  if($value != 'Sin especificar'){
    $checked = FALSE;
    if(in_array($key, $envioInfo))
      $checked = TRUE;

    $dataEnvioInfo = array(
        'name'          => 'field_envio_de_informacion[und]['.$key.']',
        'id'            => 'field_envio_de_informacion_'.$key,
        'value'         => $key,
        'checked'       => $checked,
      );

    echo '<div class="boxlabel">'.form_checkbox($dataEnvioInfo).form_label($value, 'field_envio_de_informacion_'.$key).'</div>';
  }
}

echo '</div></div>
<p class="leyenda-envio-info">Esta opción es válida solamente para personas que estén aplicando a puestos en Costa Rica y el medio que elija será utilizado solamente para enviar información cuando sea requerido sobre el proceso.</p></div>';


if($typeform=='perfil'){
  /*echo '<a data-id="intereses" class="atras" href="#" style="float: left; margin-top: 40px;">Atrás</a>';*/
  $boton_enviar = array(
      'name' => 'button',
      'id' => 'boton-enviar',
      'value' => 'Actualizar',
      'type' => 'submit',
      'data-id' => 'paso1',
      /*'content' => 'Actualizar',*/
      'style' => 'background-color: #FF9500;overflow: hidden;margin-top: 100px;'
  );
  echo "</div>";
  echo form_input($boton_enviar);

} else {
  $boton_enviar = array(
      'name' => 'button',
      'id' => 'boton-enviar',
      'value' => 'Guardar',
      'type' => 'submit',
      /*'content' => 'Guardar',*/
  );
  echo form_input($boton_enviar);
  echo "</div>";
}

echo form_close(); ?>
</div>

</div>
</div>
