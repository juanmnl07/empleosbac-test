<!DOCTYPE html>
<html lang="es"><!--manifest="/cache.webcache"-->
<head>
	<meta charset="utf-8">
	<title><?=$titulo?></title>
	<meta name="description" content="<?php if (isset($meta_desc)){print $meta_desc;}?>">
	<meta name="keywords" content="<?php if (isset($meta_keywords)){print $meta_keywords;}?>">
	<meta name="author" content="Orbelink">	
	<base href="<?=current_url()?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="/public/images/favicon.png" />

<!--<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '', 'auto'); /*UA-74299152-1*/
  ga('send', 'pageview');

  var urlactual = document.URL.replace( /#.*/, "");
	urlactual = urlactual.replace( /\?.*/, "");

</script>-->
</head>
<body class="<?php if($this->uri->segment(1)=='admin'){ echo 'admin-section'; } echo ' vista-'.$this->general->formatURL($vista); ?>" >

<!-- Google Tag Manager --> <!--<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-WS4Q4P" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript> <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': 
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], 
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src= 
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f); 
})(window,document,'script','dataLayer','GTM-WS4Q4P');</script> --><!-- End Google Tag Manager -->

	<div class="w-section st_header">
		<div class="w-container ct_header">
			<a href="/" id="logo"><img alt="Buscar empleo en Centroamérica y México" class="logoimg" src="/public/images/logo.png"></a>
			<?php if($isAdminSide==true){ ?>

				<div class="topright">
					<?php if($this->session->userdata('sessid') != ''):?>
						<div class="content_top_menu">
							<div class="top-menu">
								<a class="top-menu-admin-box" href="/admin/dashboard">
									Hola, <?=$info_admin['name']?>
								</a>

								<div class="top-menu-admin">
									<a class="top-menu-publicar-puesto" href="/rrhh/node/add/puesto-vacante">Publicar un puesto</a>
									<a href="/rrhh/user/<?=$this->session->userdata('user_id');?>/edit">Mi perfil</a>
									<a class="top-menu-cerrar-sesion" href="/cerrar-sesion">Cerrar sesión</a>   
								</div>		
							</div>
						</div>
					<?php endif; ?>
					<?php if($this->uri->segment(1)!='admin'){?>
						<a href="javascript:void(0);" class="btnmenu"><div class="w-icon-nav-menu"></div></a>
					<?php } ?>
				</div>

			<?php }else{ ?>

				<div class="topright">
					<a href="/puestos" class="carreras_disp">Puestos disponibles</a> 
					<?php if($this->session->userdata('sessid') != ''):?>
						<a href="/micuenta">Mi cuenta</a>				
						<span>|</span>
						<a href="/cerrar-sesion">Cerrar sesión</a>                
					<?php else: ?>
						<a href="/ingreso" class="btn_ingresar">Ingresar</a>
						<span>|</span>
						<a class="btn-registro" href="/registro">Registrarme</a>
					<?php endif; ?>
					<a href="javascript:void(0);" class="btnmenu"><div class="w-icon-nav-menu"></div></a>
				</div>
				
			<?php } ?>

				<div class="menusidebar">
					<a href="/" id="logosidebar"><img alt="Buscar empleo en Centroamérica y México" class="logoimg" src="/public/images/logo_menu.png"></a>
					<div class="dlogin">
					<?php if($this->session->userdata('sessid') != ''):?>
						<a href="/micuenta">Mi cuenta</a>				
						<span>|</span>
						<a href="/cerrar-sesion">Cerrar sesión</a>                
					<?php else: ?>
						<a href="/ingreso" class="btn_ingresar">Ingresar</a>
						<span>|</span>
						<a href="/registro">Registrarme</a>
					<?php endif; ?>
					</div>
					<ul>
						<li><a href="/cultura-de-innovacion"><strong>Cultura</strong> de innovación</a></li>
						<li><a href="/carreras"><strong>Carreras</strong> con impacto regional</a></li>
						<li><a href="/historias"><strong>Historias</strong> de liderazgo</a></li>
						<li><a href="/presencia-regional"><strong>Presencia</strong> regional</a></li>
						<!--<li><a href="/galeria-multimedia"><strong>Galería</strong> multimedia</a></li>-->
						<li><a href="/puestos"><strong>Puestos</strong> disponibles</a></li>
						<li><a href="/contacto">Contáctanos</a></li>
					</ul>
				</div>
			

			<div class="formloginpopup formclose">
				<?php
				if($this->session->userdata('sessid') == ''){
					require_once 'user/login-popup.php';
				}
				?>
			</div>

		</div>
	</div>

	<?php
	//if($isAdminSide){ 
	if($this->uri->segment(1)=='admin'){
		require_once 'admin/bloques/header_admin_menu.php';

	}else{
		$ctl = $this->router->fetch_class();
		if($ctl != $this->router->default_controller and $ctl != 'carreras' and $ctl != 'puestos'){?>

			<div class="w-section st_llamado_carreras">
		    	<div class="w-container ct_llamado_carreras">
		    		<p>Carreras disponibles en BAC | Credomatic</p><a href="/carreras"><strong>Ver más</strong> carreras</a>
		    	</div>
			</div>

	<?php }else{?>

			<div class="w-section lineatop">&nbsp</div>

	<?php }
	}?>

	<div class="w-section">
		<div class="w-container">
		<div class="breadcrumb"><?php echo $this->breadcrumb->show(); ?></div>
		<?php if(/*(!$isAdminSide) and */($vista != 'inicio')){ ?>
				<a class="shared st_sharethis_large" href="javascript:void(0);"></a>
		<?php } ?>

		<?php /* $this->output->enable_profiler(TRUE);  */?>

		</div>
	</div>