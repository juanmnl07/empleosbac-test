<?php 

if ($this->session->registro==1){ ?>
  <script>ga('send', 'event', 'Registro', 'Registro Exitoso', urlactual);</script>
<?php } $this->session->registro = 0; ?>


<div class="w-section">
    <div class="w-container ct_registro formreg">
		<div id="info-perfil">
      <h1>Mi Cuenta <span class="linea"></span></h1>
      <div id="imagen-nombre">
        <?php if($imagen_perfil == ''){
            $class_foto = "avatar";
            $imagen_perfil = 'pictures/avatar-no.jpg';
          } else {
            $class_foto = "custom";
            $imagen_perfil = 'uploads/'.$imagen_perfil;
          }
        ?>
        <div class="foto <?php echo $class_foto ?>" style="background-image: url('<?php echo base_url() ?>/rrhh/sites/default/files/<?php echo $imagen_perfil ?>')">&nbsp</div>
        <div class="nombre-completo">
          <p>Hola, <strong><?php echo $nombre_apellidos ?></strong></p>
        </div>  
      </div>	
      <p class="pie">En tu cuenta puedes editar tus datos personales, educación, experiencia y currículum vitae, además de ver los puestos a los que has aplicado.</p>		
		</div>
    <div id="puestos-aplicados">
      <?php 
          if(isset($puestos_aplicados)){ ?>
      <h2 class="titulo-puestos-aplicados">Puestos a los que has aplicado</h2>
      <p class="info">Por políticas de BAC | Credomatic solo puedes aplicar a 3 puestos diferentes al mismo tiempo.</p>
      <table width="100%" border="0" cellpadding="2" cellspacing="1" class="filtro_puestos filtro_puestos_aplicados">
        <thead>
          <tr>
              <th>Descripción</th>
              <th>Carrera</th>
              <th>País</th>
              <th>Aplicado</th>
              <th>Información adicional</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            foreach ($puestos_aplicados as $key => $value) {
              foreach ($value as $key2 => $value2) {
                //exit(var_export($value2));
                $url = base_url().'/rrhh/api/users/puestos_aplicados/retrieve?uid_aplicante=' . $this->session->userdata('user_id') . '&nid_puesto=' . $value2->Nid . '.xml';
                $fecha = consumirServicioSinToken($url, $session_cookie);
                $fecha = (string)$fecha->item->fecha;
                echo "<tr>";
                  echo "<td class='puesto-aplicado-".$value2->Nid."'><a href='/puestos/". $this->general->formatURL($value2->title) ."/".$value2->Nid."'>".$value2->title."</a></td>";
                  echo "<td width='300px' class='carrara-puesto-aplicado-".$value2->nid_carrera."'><a href='#'>".$value2->titulo_carrera."</a></td>";
                  echo "<td class='pais-puesto-aplicado-".$value2->nid_pais."'><a href='#'>".$value2->titulo_pais."</a></td>";
                  echo "<td width='230px' class='fecha-puesto-aplicado'>". traducirMes(date('d F Y', $fecha)) ."<a class='btn_desaplicar' data-id-puesto='".$value2->Nid."' data-evento='click' data-nombre='Click al botón de des aplicar al puesto' href='javascript:void(0);' data-popup-target='#popup_aplicar'>Desaplicar</a></td>";
                  echo "<td class='ver-mas-puestos'><a href='/puestos?carrera=".$value2->nid_carrera."&pais=".$value2->nid_pais."'>Ver puestos similares</a></td>";
                echo "</tr>";
              }
            } ?>
        </tbody>
    </table>
    <?php } else {?>
      <p class="info-vacio">¿Aún no has aplicado a ningún puesto?</p>
    <?php } ?>
    <a href="puestos" class="sin-aplicar">Puestos Disponibles</a>
    </div>
    <div id="editar-perfil">
      <h2 class="titulo">Editar mis datos</h2>
    </div>
		<?php
		$typeform = 'perfil';
    $correo_actual = $this->session->userdata('mail');
    $id_user = $this->session->userdata('user_id');
		require_once 'form_registro_cuenta.php';
		?>
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
</div>

<div class="submenu-lateral">
  <ul class="submenu-lateral-detalle">

    <li><a class="subm opt1" href="#puestos-aplicados">Mis puestos aplicados</a></li>
    <li><a class="subm opt2" href="#editar-perfil">Editar mis datos</a></li>
    

  </ul>
</div>