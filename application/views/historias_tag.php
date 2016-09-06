<div class="w-section st_blog_listado">
	<div class="w-container">


		<h1>Historias de liderazgo  - Tag: <?php echo $nombre_categoria; ?></h1>
		
		<?php require_once 'bloques/filtrado_blog.php';?>

		<div class="articulos-listado-normal">
			<?php

			$html = '';
			$colum = '';
			$cont_colum = 1;
			$cont_total = 1;
			$rtotal = count($listado_normal['results']);


			foreach ($listado_normal['results'] as $row) {
				extract($row);

				$colum .= '<div class="w-col w-col-[N]">
								<div class="articulo-box">';

				if (isset($field_imagen)){
					$colum .= '<div class="articulo-imagen">
										<a href="/historias/'.$this->general->formatURL($title).'/'.$nid.'"><img src="'.$field_imagen.'" /></a>
								</div>';
				}

				$colum .= '<div class="articulo-cat">'.$field_categoria_blog[0].'</div>

									<div class="articulo-title">
										<a href="/historias/'.$this->general->formatURL($title).'/'.$nid.'">'.$title.'.</a>
									</div>
									<div class="articulo-body">
										'.$body.'
									</div>
								</div>
							</div>';

				if($cont_colum == 3){
					$last = '';
					if($rtotal == $cont_total){
						$last = 'wr-last';
					}

					$colum = str_replace("[N]", '4', $colum);
					$html .= '<div class="w-row '.$last.'">'.$colum.'</div>';
					$colum = '';
					$cont_colum = 0;
				}


				if($rtotal == $cont_total and $cont_colum != 0){
					$nc = 12 / $cont_colum;
					$colum = str_replace("[N]", $nc, $colum);
					$html .= '<div class="w-row">'.$colum.'</div>';
				}

				$cont_colum = $cont_colum + 1;
				$cont_total = $cont_total + 1;
			}

			echo $html;

			/* Estructura para paginación */

			$paginas_totales=$listado_normal['metadata']['total_pages'];
			$pagina_actual=$listado_normal['metadata']['current_page'];
			$valor_inicial=$listado_normal['metadata']['current_page']-2;
			$html_paginas = "";

			if ($paginas_totales>0){
				if($pagina_actual>0){
					$html_paginas .= '<li><a href="/historias/tag/'.$url_categoria.'/'.$id_categoria.'">&laquo;</a></li>';	
				}
				
				$paginas_por_mostrar=5;

				if($paginas_totales<=$paginas_por_mostrar){
					$paginas_por_mostrar=$paginas_totales+1;
					$valor_inicial=0;
				}

				if($pagina_actual==0){
					$valor_inicial=$pagina_actual;
				}

				if($pagina_actual==1){
					$valor_inicial=($pagina_actual-1);
				}

				for($i=$valor_inicial;$i<($paginas_por_mostrar+$valor_inicial);$i++){
					$clase_current_page = '';
					if($i==$pagina_actual)
						$clase_current_page = 'class="current-page"';
					if($i <= $paginas_totales){
						if($i==0){
							$html_paginas .= '<li '.$clase_current_page.'><a href="/historias/tag/'.$url_categoria.'/'.$id_categoria.'">'.($i+1).'</a></li>';
						}else{
							$html_paginas .= '<li '.$clase_current_page.'><a href="/historias/tag/'.$url_categoria.'/'.$id_categoria.'?pagina='.($i+1).'">'.($i+1).'</a></li>';
						}											
					}
				}

				if($pagina_actual<$paginas_totales){
					$html_paginas .= '<li><a href="/historias/tags/'.$url_categoria.'/'.$id_categoria.'?pagina='.($paginas_totales+1).'">&raquo;</a></li>';
				}
				?>

				<div class="paginacion-blog">
					<ul class="paginacion paginacion-blog"><?php echo $html_paginas; ?></ul>

				</div>

			<?php	

			}
			?>
			

			

		</div>

	</div>
</div>