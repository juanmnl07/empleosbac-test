	<div class="w-section st_footer">
		<div class="w-container ct_footer">
			<div class="w-row">
				<div class="w-col w-col-4">
					<p>UNA INICIATIVA DE</p>
					<img src="/public/images/logo_iniciativa1.png">
					<br />
					<img src="/public/images/logo_iniciativa2.png">
				</div>
				<div class="w-col w-col-4">
					<ul class="menu">
						<li><a href="/cultura-de-innovacion">Cultura de innovación</a></li>
						<li><a href="/carreras">Carreras con impacto regional</a></li>
						<li><a href="/historias">Historias de liderazgo</a></li>
						<li><a href="/presencia-regional">Presencia regional</a></li>
						<!--<li><a href="/galeria-multimedia">Galería multimedia</a></li>-->
						<li><a href="/puestos">Puestos disponibles</a></li>
					</ul>
				</div>
				<div class="w-col w-col-4 problema_tecnico">
					<div class="w-row">
						<div class="w-col w-col-9">
							
							<a href="/contacto"><b>Contáctanos</b></a>
							<br /><br />
							<a href="mailto:info@empleosbaccredomatic.com?subject=Problema técnico en RH BAC | Credomatic" class="problema_tecnico">Si tienes algún problema técnico <br>contáctanos &raquo;</a>
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
						<div class="w-col w-col-3">
							<img src="/public/images/great-place-to-work.png">
						</div>
					</div>
				</div>
				<!--<div class="w-col w-col-3">-->
					<!--<a href="/"><img src="/public/images/logo_footer.png"></a>-->
					
					
				<!--</div>-->
			</div>
		</div>
	</div>
	<div class="loader-general" style="display: none;"></div>

	<!-- Google Fonts [ASYNC] -->
	<script type="text/javascript">
	WebFontConfig = {
		google: { families: [ 'Source+Serif+Pro:400,700,600', 'Roboto+Slab:400,700'] } };
		(function() {
			var wf = document.createElement('script');
			wf.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
			wf.type = 'text/javascript';
			wf.async = 'true';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(wf, s);
		})();
	</script>
	<link rel="stylesheet" type="text/css" href="/public/css/normalize.css">
	<link rel="stylesheet" type="text/css" href="/public/css/webflow.css">
	<!--<link href='https://fonts.googleapis.com/css?family=Source+Serif+Pro:400,700,600|Roboto+Slab:400,700' rel='stylesheet' type='text/css'>-->
	<link rel="stylesheet" type="text/css" href="/public/css/bac-credomatic.css">
	<link rel="stylesheet" type="text/css" href="/public/css/bac-desktop.css">
	<link rel="stylesheet" type="text/css" href="/public/css/bac-tablet.css">
	<link rel="stylesheet" type="text/css" href="/public/css/bac-movil.css">
	<!--<link rel="stylesheet" type="text/css" href="/public/css/jquery-ui.structure.css">
	<link rel="stylesheet" type="text/css" href="/public/css/jquery-ui.theme.css">
	<link rel="stylesheet" type="text/css" href="/public/css/jquery-ui.css">-->
	<link rel="stylesheet" type="text/css" href="/public/css/jquery-ui.structure.min.css">
	<link rel="stylesheet" type="text/css" href="/public/css/jquery-ui.theme.min.css">
	<link rel="stylesheet" type="text/css" href="/public/css/jquery-ui.min.css">
	<link rel="stylesheet" type="text/css" href="/public/lib/bxslider/jquery.bxslider.min.css">
	
	
	<script type="text/javascript" src="/public/js/jquery-1.11.3.min.js"></script>

	<script type="text/javascript" src="/public/lib/bxslider/jquery.bxslider.min.js"></script>
	<script type="text/javascript" src="/public/js/jquery-migrate-1.2.1.min.js"></script>
	<!--<script type="text/javascript" src="/public/js/jquery-ui.js"></script>-->
	<script type="text/javascript" src="/public/js/jquery-ui.min.js"></script>

  	<?php if(isset($js)){ ?>
    	<!-- custom js for each view -->
  		<script type="text/javascript" src="/public/js/<?php echo $js ?>.js"></script>
  	<?php } ?>

	<script type="text/javascript" src="/public/js/scripts.js"></script>

	<?php if ($isAdminSide){ ?>
		
		<script type="text/javascript" src="/public/js/admin/scripts_admin.js"></script>
	<?php } ?>


	<script type="text/javascript" src="/public/js/modernizr.js"></script>

  	<script type="text/javascript" src="/public/js/webflow.js"></script>
  	<!--[if lte IE 9]><script src="/public/js/placeholders.min.js"></script><![endif]-->

	<?php //if (!$isAdminSide){
			if($this->uri->segment(1)!='admin'){ ?>
		<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
		<script type="text/javascript">stLight.options({publisher: "eea7c747-b399-4c41-97ef-0db93d2410e9", doNotHash: false, doNotCopy: false, hashAddressBar: false, onhover:false});</script> 
	<?php } ?>
	<noscript><div class="noscript">Para disfrutar de una experiencia completa, active JavaScript en el navegador.</div></noscript>
    
    <?php /*if($this->session->userdata('isAdmin') == true){ ?>
		<p><a href="/webcache/clear">Borrar toda la cache</a> - <a href="/webcache/clear/<?=base64_encode(uri_string())?>">Borrar cache de está página</a></p>
    <?php }*/ ?>
	</body>
</html>