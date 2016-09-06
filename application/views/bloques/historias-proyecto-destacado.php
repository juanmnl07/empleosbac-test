<div class="w-section historias-proyecto-destacado-section">
	<div class="w-container">

		<h2>Imagínate innovando como ellos</h2>
		

		<div class="historias-proyecto-destacado-container">
			<?php 

				$proyecto_destacado = $this->cache->get('blog-proyecto-destacado-individual');
				if(!$proyecto_destacado){
					$proyecto_destacado = $this->general->getJSON('/rrhh/api/blog/blog-proyecto-destacado-individual.json');
					$this->cache->write($proyecto_destacado, 'blog-proyecto-destacado-individual');
				}

				$html = '';
				$colum = '';

				foreach($proyecto_destacado['results'] as $key => $value){
					extract($value);

					//var_export($body);

					
					$colum .= '<div class="historia_box">
									';

					if(isset($field_imagen)){
						$colum .= '<div class="w-col w-col-6">
										<div class="historia-image">
											<a href="/historias/'.$this->general->formatURL($title).'/'.$nid.'"><img src="'.$field_imagen.'" /></a>
										</div>

									</div>
									<div class="w-col w-col-6">';
					}else{
						$colum .=  '<div class="w-col w-col-12">';
					}
									
										
					$colum .= '			<div class="historia-title">
											<a href="/historias/'.$this->general->formatURL($title).'/'.$nid.'">'.$title.'.</a>
										</div>
										<div class="historia-descripcion">
											<p><em>"'.$body.'"</em></p>

											<p class="autor"><strong>'.$field_autor.' , BAC | Credomatic - '.$field_pais.'</strong></p>
										</div>

										<div class="historia-ver-mas">
											<a href="/historias/proyectos-innovadores">Historias: Proyectos Innovadores</a>
										</div>
									</div>
								</div>';

				}

				$html .= '<div class="w-row">'.$colum.'</div>';

				echo $html;
			?>
		</div>
	</div>
</div>