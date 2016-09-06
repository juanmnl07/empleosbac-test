<?php 

$slides = $this->cache->get('slider-todos');
if(!$slides){
	$slides = $this->general->getJSON('/rrhh/api/slider/slider-todos.json');
	$this->cache->write($slides, 'slider-todos');
}

?>
<div class="w-section">
	<div class="slider-wrapper">
		<ul class="slider-home">
				<?php
					
					foreach($slides['results'] as $key => $value){
						extract($value);
						echo '<li>
								<div class="slider-sombra">&nbsp</div>
								<img src="'.$field_imagen.'" />
								<div class="slider-caption">
									<h3 title="Vacantes de Empleo en Centroamérica y México">'.strip_tags($field_titulo_slide).'</h3>
									<div class="slider-text">'.$body.'</div>
									<a class="slider-boton" href="'.$field_link_boton.'">'.$field_texto_boton.'</a>
								</div>
						
							</li>';
					}
	            
	            ?>        
	        </ul>
	</div>
</div>