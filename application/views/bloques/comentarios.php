<div class="comentarios">

	<h3>Comentarios</h3>
	
	<div class="comentarios-inner">
		<?php 

			$comentarios = $this->cache->get('blog-comentarios-'.$id_historia);
			if(!$comentarios){
				$comentarios =  $this->general->getJSON('/rrhh/api/blog/comentarios-blog.json?blog-id='.$id_historia);
				$this->cache->write($comentarios, 'blog-comentarios-'.$id_historia);
			}

			if (isset($comentarios['results'])){
				$contador = 1;
				foreach($comentarios['results'] as $key=>$value){
					extract($value);
					?>
					<div class="w-row comentario comentario-item-<?=$contador?> comentario-id-<?=$cid?>">
						<div class="autor_fecha w-col w-col-2">
							<span>
								<?php 
									/* SE hace esta validación ya que si un usuario no existe o no tiene nombre, el view retorna un array y entonces 
									muestra errores */

								if (!is_array($field_nombre_y_apellidos)){?>
									<div class="comentario-autor"><?=$field_nombre_y_apellidos?></div>
								<?php } ?>
								<div class="comentario-fecha"><?=$created?></div>
							</span>
						</div>
						<div class="comentario-texto w-col w-col-10"><?=$comment_body?></div>
					</div>

					<?php 
					$contador += 1;

				}

			}
			

		?>
	</div>

	<?php 
	  if($this->session->userdata('sessid') == ''): ?>
		<a id="inicio-sesion-ajax" href="javascript:void(0);" data-popup-target="#popup_comentar">Inicia sesión para comentar</a>
      <?php else:
      	//aplicar al puesto
      	echo "<div class=\"comentarios-form\">			
				<h3>Deja tu comentario</h3>
				<div class=\"comentario-form-wrapper\">
					<form id=\"comentario-form\" method=\"post\">
						<textarea name=\"comment-body\" id=\"comment-body\" rows=\"4\" cols =\"50\"></textarea>
						<input id=\"send\" type=\"submit\" value=\"Enviar\" />
					</form>
				</div>
			</div>";
	  endif;
	?>

	<div class="popup" id="popup_comentar">
        <div class="popup-body">
        	<span class="popup-exit"></span>
        	<div class="popup-content">

				<div>
				<?php $hidden = "hidden"; ?>
					<?php if($this->session->userdata('sessid') == ''):  
							require_once(__DIR__.'/../user/login-ajax-comment.php');
						endif;
					?>
					<div id="mensaje-despues-inicio-sesion" class='<?php echo $hidden ?>'>&nbsp</div>
				</div>
        	</div>
        </div>
    </div>
    <div class="popup-overlay"></div>
	
</div>