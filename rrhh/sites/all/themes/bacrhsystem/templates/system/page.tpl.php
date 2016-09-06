<?php

/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 */
?>
<header class="header" role="banner">
  <div class="w-section st_header">
    <div class="w-container ct_header">
      <a href="/" id="logo"><img class="logoimg" src="/public/images/logo.png"></a>
        <div class="topright">
        <?php 
          global $user;
          if($user->uid != 0){?>
            <div class="top-menu">              
              <a class="top-menu-admin-box" href="/admin/dashboard">
                <?php 
                    //obtener el nombre completo del usuario
                    $query = db_select('field_data_field_nombre_y_apellidos', 'fdfna');
                    $query->join('users', 'u', '(fdfna.entity_id = u.uid)');
                    $query->fields('fdfna', array('field_nombre_y_apellidos_value'));
                    $query->condition('u.uid', $user->uid,'=');
                    //$query->execute();
                    $result = $query->execute()->fetchAll();
                    $nombre_completo = '';
                    foreach ($result as $key => $value) {
                      $nombre_completo = $value->field_nombre_y_apellidos_value;
                    }
                 ?>
                Hola, <?php echo $nombre_completo; ?>
              </a>
              <div class="top-menu-admin">
                <a class="top-menu-publicar-puesto" href="/rrhh/node/add/puesto-vacante">Publicar un puesto</a>
                <a href="/rrhh/user/<?php echo $user->uid; ?>/edit">Mi perfil</a>
                <a class="top-menu-cerrar-sesion" href="/rrhh/user/logout">Cerrar sesión</a>   
              </div>
              <?php } else { ?>
              <div class="">
                <a href="/rrhh/user/login" class="">Ingresar</a>
              </div>              
            </div>
          <?php } ?>
        </div>
    </div>
  </div>

  <div class="header-admin-menu">
    <div class="w-section">
      <div class="w-container ct_menuadmin">
        <div class="titulo-bienvenida-menu-admin">
          <div class="menu-admin-box">
            <ul class="menu-admin">
              <?php if ((in_array('administrador regional', $user->roles))||((in_array('administrador país', $user->roles)))) {?>
                <li><a href="/admin/dashboard">Dashboard</a></li>
                <li><a href="/admin/puestos">Puestos de Trabajo</a></li>
                <li><a href="/admin/aplicantes">Personas Registradas</a></li>
              <?php } ?>
              <?php if ((in_array('administrador regional', $user->roles))){?>
              <li class="expand"><a href="#" class="w--current">Administrativo</a>
                <ul>
                  <li><a href="/rrhh/admin/people">Administradores</a></li>
                  <li><a href="/rrhh/admin/content">Contenidos</a></li>
                  <!--<li><a href="/webcache/clear">Borrar toda la cache</a></li>-->
                </ul>
              </li>
              <?php } else { 
                //verificar si el usuario pais es principal
                  if(in_array('administrador país', $user->roles)){
                    //$principal = field_get_items('user', $user, 'field_principal');
                    $query = db_select('field_data_field_principal', 'fdfp');
                    $query->join('users', 'u', '(fdfp.entity_id = u.uid)');
                    $query->fields('fdfp', array('field_principal_value'));
                    $query->condition('u.uid', $user->uid,'=');
                    //$query->execute();
                    $result = $query->execute()->fetchAll();
                    $principal_value = 0;
                    foreach ($result as $key => $value) {
                      $principal_value = $value->field_principal_value;
                    }
                    if($principal_value == 1){ ?>
                      <li class="expand"><a href="#" class="w--current">Administrativo</a>
                        <ul>
                          <li><a href="/rrhh/admin/people">Administradores</a></li>
                          <!--<li><a href="/rrhh/admin/content">Contenidos</a></li>-->
                          <!--<li><a href="/webcache/clear">Borrar toda la cache</a></li>-->
                        </ul>
                      </li>
                    <?php }
                  }
               }?>
            </ul>
          </div>
        </div>


        <div class="publicar-puesto-box">
          <a href="/rrhh/node/add/puesto-vacante">Publicar puesto de trabajo</a>
        </div>


        
      </div>
    </div>
  </div>

</header>

<?php if ($page['above_content']): ?>
  <section class="above-content">
    <?php print render($page['above_content']); ?>
  </section>
<?php endif; // end Above Content ?>
<?php 
  $roles = '';
  foreach ($user->roles as $key => $value) {
    $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
    $fixed = str_replace(' ', '-', strtr( $value, $unwanted_array ));
    $roles .= $fixed." ";
  }
?>
<div class="w-section">
  <div class="w-container">
    <?php 

      if ($breadcrumb):
        print str_replace('»', '/', $breadcrumb);
      endif;

    ?>
  </div>
</div>

<div class="main-content <?php echo $roles ?>">
    <div class="w-container">
      <!--<p>&nbsp</p>-->

      <?php
      //dpm($node);
      $tipo = '';
      $titulo_custom ="";
      $ruta = current_path();
      //var_export($ruta);
      if(isset($node)){
        if($node->type=='puesto_vacante'){
          $tipo = 'Puestos de trabajo';
        }elseif($node->type=='carrera'){
          $tipo = 'Áreas de trabajo';
        }elseif($node->type=='pais'){
          $tipo = 'País';
        }
      } else if(arg(0) == 'node' && arg(1) == 'add'){
            if(arg(2) == 'puesto-vacante'){
              $tipo = 'Puestos de trabajo';  
            }else if (arg(2) == 'carrera'){
              $tipo = 'Áreas de trabajo';
            }else if (arg(2) == 'pais'){
              $tipo = 'País';
            }
      }else if($ruta=="admin/people/create"){
        $tipo = "Administradores";
        $titulo_custom ="Crear Administrador";
      }else if(arg(0) == 'user' && arg(2) == 'edit'){
        $tipo = "Administradores";
        $titulo_custom ="Editar Administrador";
      }else if(arg(0)=="admin" && arg(1)=="content"){
        $tipo = "Administrador de Contenido";
        $titulo_custom ="Filtros de búsqueda";
      }else if(arg(0)=="admin" && arg(1)=="people"){
        $tipo = "Administradores";
        $titulo_custom ="Filtros de búsqueda";
        $enlace_add ='<ul class="action-links display_asv">
                        <li><a href="/rrhh/admin/people/create">Crear administrador</a></li>
                      </ul>';
      }

      echo '<h1>' . $tipo . '</h1>';
      

        /*$system_main_content = $page['content']['system_main']; 
            dpm($system_main_content);
        if(isset($system_main_content['#node_edit_form'])){
          if($system_main_content['#node_edit_form']){
            $nid = $system_main_content['#node_edit_form']['nid'];
            $contenido = node_load($nid);
            echo '<h1>'. $contenido->title .'</h1>';
          }
        }*/
      ?>


<?php //dpm($breadcrumb); ?>
    <?php if(isset($enlace_add)){ echo $enlace_add; }?>

    <?php if ($page['highlighted']): ?>
      <?php print render($page['highlighted']); ?>
    <?php endif; ?>

      <a id="main-content"></a>
    
      <div class="main" role="main">
        <?php print render($title_prefix); ?>
        <?php if ($titulo_custom!= ""){ ?><h2 class="title" id="page-title"><?php print $titulo_custom; ?></h2>
        <?php } else {  
              if ($title): ?>

                <h2 class="title" id="page-title"><?php print $title; ?></h2>
        <?php endif;  }?>
        <?php print render($title_suffix); ?>
         <?php if ($messages): ?>
          <div class="messages-wrapper">
            <div class="messages-content">
              <?php print $messages; ?>
            </div>
          </div>
          <?php endif; ?>
        <?php if ($tabs): ?>
          <?php print render($tabs); ?>

        <?php endif; ?>

        <?php print render($page['help']); ?>
       
        <?php if ($action_links): ?>

          <ul class="action-links">
            <?php print render($action_links); ?>
          </ul>
        <?php endif; ?>

        <div class="region-content">
          <?php print render($page['content']); ?>
        </div>


      </div>

    <?php if ($page['sidebar_first']): ?>
      <div id="sidebar-first" class="">
        <?php print render($page['sidebar_first']); ?>
      </div> <!-- /.section, /#sidebar-first -->
    <?php endif; ?>

    <?php if ($page['sidebar_second']): ?>
      <div id="sidebar-second" class="">
        <?php print render($page['sidebar_second']); ?>
      </div> <!-- /.section, /#sidebar-second -->
    <?php endif; ?>
  </div>
</div>

<?php if ($page['below_content']): ?>
  <section class="below-content">
    <?php print render($page['below_content']); ?>
  </section>
<?php endif; // end Below Content ?>

<footer class="footer" role="contentinfo">
  <div class="w-section st_footer">
    <div class="w-container ct_footer">
      <div class="w-row">
        <div class="w-col w-col-4">
          <p>UNA INICIATIVA DE</p>
          <img src="/public/images/logo_iniciativa1.png">
          <br /><br /><br />
          <img src="/public/images/logo_iniciativa2.png">
        </div>
        <div class="w-col w-col-4">
          <ul class="menu">
            <li><a href="/cultura-de-innovacion">Cultura de innovación</a></li>
            <li><a href="/carreras">Carreras con proyección regional</a></li>
            <li><a href="/historias">Historias de liderazgo</a></li>
            <li><a href="/presencia-regional">Presencia regional</a></li>
            <!--<li><a href="/galeria-multimedia">Galería multimedia</a></li>-->
            <li><a href="/puestos">Puestos disponibles</a></li>
          </ul>
        </div>
        <div class="w-col w-col-4 problema_tecnico">
          <a href="/contacto"><b>Contáctanos</b></a>
          <br /><br />
          <a href="mailto:info@empleosbaccredomatic.com?subject=Problema técnico en RH BAC | Credomatic" class="problema_tecnico">Si tienes algún problema técnico contáctanos &raquo;</a>
          <!--<p>BAC | Credomatic en la región</p>-->
          <br/>
          <br/>
          <div class="redes">
            <b>Síguenos</b>
            <!--<a href="#"><img src="/public/images/siguenos_fb.png"></a>-->
            <a href="https://www.linkedin.com/company/bac-credomatic-network?trk=biz-companies-cym" target="_blank"><img src="/public/images/siguenos_in.png"></a>
            <!--<a href="#"><img src="/public/images/siguenos_tw.png"></a>-->
          </div>
        </div>
        <!--<div class="w-col w-col-3">-->
          <!--<a href="/"><img src="/public/images/logo_footer.png"></a>-->
          
          
        <!--</div>-->
      </div>
    </div>
  </div>
</footer>