<div class="w-section">
	<div class="w-container">
		<?php extract($info);

		$id_historia=$nid;
		?>
		<h2 class="h1">Historias de <strong>Liderazgo</strong></h2>

			<?php

			/* imprimir esta variable solo sirve para ver errores que retorna la funcion cuanod se guarda un comentario */
				if ($resultado != ""){ ?>
					<div class="mensajes-comentarios">
						<?php 
						// Resultado 403 es para usuario denegado
						if ($resultado[1] == 403) {?>
							<div class="alert alert-danger">Lo Sentimos, debe registrarse en la plataforma para poder enviar su comentario. 
								Puede hacerlo en la página de <a href="/registro">Registro</a>. 
								Si ya posee una cuenta de usuario, entonces <a href="/ingreso">Inicie Sesión</a> para poder ingresar.</div>
						<?php } else if($resultado[1] == 200){ 
							// resultado 200 es para insersión existosa 
							?>
							<div class="alert alert-success">Su comentario se ha registrado correctamente</div>
						<?php } ?>
					</div>
				<?php } 
				
			 ?>
		
		
		<?php require_once 'bloques/filtrado_blog.php';?>

	</div>
</div>




<div class="w-section">

	<div class="ct_blog">
		<?php
			$img = '/public/images/noimg.png';
			if(isset($field_imagen)){
				$img = $field_imagen;
			}
		?>
		<img src="<?=$img ?>" style="display: block; margin: 0 auto;">
		<div class="w-container ct_title">
			<div class="blog-title-container">
				<h1><?=$title?>.</h1>
				<?php if(!is_array($field_pais) && $field_pais!=""){ ?>
					<p class="blog-pais"><?=$field_pais?></p>
				<?php }?>
				
				<p class="blog-date"><?=$created?></p>
				<?php if(is_array($field_autor)){
					$autor = "";
				}else{
					$autor="Por: ".$field_autor;
				} ?>
				<p class="blog-autor"><em> <?=$autor?></em></p>
			</div>
		</div>
	</div>
	<div class="w-container ct_blog_info">
		<?=$body?>
	</div>	
	
	<div class="w-container ct_blog_info_pie">
		<!--<div class="blog-tags">-->
		<?php require_once 'bloques/tags.php';?>
		<!--</div>-->


		<div class="w-row box_compartir">
			<div class="w-col w-col-7 box_compartir_info">
				<strong>Compartir</strong>
				<p>Comparte esta historia en tus redes sociales.</p>

			</div>
			<div class="w-col w-col-5 box_compartir_comp">
				<div class="btn_shared">
					<span class='st_linkedin_large' displayText='LinkedIn'></span>
					<span class='st_facebook_large' displayText='Facebook'></span>
					<span class='st_twitter_large' displayText='Tweet'></span>
					<span class='st_email_large' displayText='Email'></span>
				</div>
			</div>
		</div>



		<!--<div class="blog-historias-relacionadas">-->
		<?php require_once 'bloques/historias_relacionadas.php';?>
		<!--</div>-->
	
		<!--<div class="blog-comentarios">-->
		<?php require_once 'bloques/comentarios.php';?>
		<!--</div>-->
				

			
	</div>
</div>