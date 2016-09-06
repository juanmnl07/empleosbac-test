<div class="w-section st_bloque_historias">
	<div class="w-container ct_bloque_historias">

		<h2>Historias de <strong>Liderazgo</strong> <span class="linea"></span></h2>
		<p><strong>Historias de los verdaderos héroes detrás</strong> de los retos y logros de BAC | Credomatic.</p>
		<p>&nbsp;</p>

		<div class="historias-container">
			<?php 

				$articulos_blog = $this->cache->get('blog-todos-home');
				if(!$articulos_blog){
					$articulos_blog = $this->general->getJSON('/rrhh/api/blog/blog-todos-home.json');
					$this->cache->write($articulos_blog, 'blog-todos-home');
				}

				$html = '';
				$colum = '';
				$cont_colum = 0;

				if(!empty($articulos_blog['results'])){
					foreach($articulos_blog['results'] as $key => $value){
						extract($value);

						//var_export($body);

						
						$colum .= '<div class="w-col w-col-[N]">
										<div class="historia_box">';

						if(isset($field_imagen)){
							$colum .= '<div class="historia-image">
												<a href="/historias/'.$this->general->formatURL($title).'/'.$nid.'"><img src="'.$field_imagen.'" /></a>
											</div>';
						}
						
						$colum .= '			<div class="historia-title">
												<a href="/historias/'.$this->general->formatURL($title).'/'.$nid.'">'.$title.'</a>
											</div>
											<div class="historia-descripcion">
												<p>'.$body.'</p>
											</div>

											<a class="historia-ver-mas" href="/historias/'.$this->general->formatURL($title).'/'.$nid.'">Ver historia</a>
										</div>
									</div>';

						$cont_colum = $cont_colum + 1;

					}

					$nc = 12 / $cont_colum;
					$colum = str_replace("[N]", $nc, $colum);

					$html .= '<div class="w-row">'.$colum.'</div><a href="/historias" class="mas_historias">Más historias</a>';
				}
				echo $html;
			?>
		</div>
	</div>
</div>