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
            <div class="top-menu">
              <div class="top-menu-admin-box">
                <?php 
                    global $user;
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
              </div>
              <div class="top-menu-admin">
                <a class="top-menu-publicar-puesto" href="/rrhh/node/add/puesto-vacante">Publicar un puesto</a>
                <a href="/admin/dashboard">Mi perfil</a>
                <a class="top-menu-cerrar-sesion" href="/cerrar-sesion">Cerrar sesión</a>   
              </div>    
            </div>
        </div>
    </div>
  </div>

  <div class="header-admin-menu">
    <div class="w-section">
      <div class="w-container ct_menuadmin">
        <div class="titulo-bienvenida-menu-admin">
          <div class="menu-admin-box">
            <ul class="menu-admin">
              <li><a href="/admin/dashboard/">Dashboard</a></li>
              <?php if ((in_array('administrador regional', $user->roles))||((in_array('administrador país', $user->roles)))) {?>
                <li><a href="/admin/puestos/">Puestos de Trabajo</a></li>
              <?php } ?>
              <li><a href="/admin/aplicantes/">Personas Registradas</a></li>
              <?php if ((in_array('administrador regional', $user->roles))){?>
                <li><a href="/webcache/clear">Borrar toda la cache</a></li>
              <?php } ?>
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

<div class="main-content">
    <div class="w-container">
      <p>&nbsp</p>
      <h1>Administradores</h1>
    <?php /*if ($breadcrumb): ?>
      <?php print $breadcrumb; ?>
    <?php endif;*/ ?>

    <?php if ($page['highlighted']): ?>
      <?php print render($page['highlighted']); ?>
    <?php endif; ?>

      <a id="main-content"></a>
      <div class="main" role="main">
        <?php print render($title_prefix); ?>
        <?php if ($title): ?><h2 class="title" id="page-title"><?php print $title; ?></h2><?php endif; ?>
        <?php print render($title_suffix); ?>

        <?php if ($tabs): ?>
          <?php print render($tabs); ?>

        <?php endif; ?>

        <?php print render($page['help']); ?>

        <?php if ($action_links): ?>
          <ul class="action-links">
            <?php print render($action_links); ?>
          </ul>
        <?php endif; ?>

        <?php print render($page['content']); ?>

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
        <div class="w-col w-col-3">
          <a href="/"><img src="/public/images/logo_footer.png"></a>
        </div>
        <div class="w-col w-col-3">
          <ul class="menu">
            <li><a href="/cultura-de-innovacion">Cultura de innovación</a></li>
            <li><a href="/carreras">Carreras con proyección regional</a></li>
            <li><a href="/historias">Historias de liderazgo</a></li>
            <li><a href="/precensia-regional">Presencia regional</a></li>
            <!--<li><a href="/galeria-multimedia">Galería multimedia</a></li>-->
            <li><a href="/puestos">Puestos disponibles</a></li>
          </ul>
        </div>
        <div class="w-col w-col-3">
          <a href="/contacto"><b>Contáctanos</b></a>
          <br /><br />
          <p>BAC credomatic en la región</p>
          <br />
          <div class="redes">
            <b>Síguenos</b>
            <!--<a href="#"><img src="/public/images/siguenos_fb.png"></a>-->
            <a href="https://www.linkedin.com/company/bac-credomatic-network?trk=biz-companies-cym" target="_blank"><img src="/public/images/siguenos_in.png"></a>
            <!--<a href="#"><img src="/public/images/siguenos_tw.png"></a>-->
          </div>
        </div>
        <div class="w-col w-col-3">
          <p>UNA INICIATIVA DE</p>
          <img src="/public/images/logo_iniciativa1.png">
          <br /><br /><br />
          <img src="/public/images/logo_iniciativa2.png">
        </div>
      </div>
    </div>
  </div>
</footer>



