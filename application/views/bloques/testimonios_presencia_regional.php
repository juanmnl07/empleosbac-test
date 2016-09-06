<?php 
$paramametro_pais ="";
if (isset($nid_copia) and !empty($nid_copia)){
	$paramametro_pais = "?pais-id=".$nid_copia;
}

$testim = $this->cache->get($this->general->formatURL('testimonios-todos-'.$paramametro_pais));
if(!$testim){
	$testim = $this->general->getJSON('/rrhh/api/testimonios/testimonios-todos.json'.$paramametro_pais); 
	$this->cache->write($testim, $this->general->formatURL('testimonios-todos-'.$paramametro_pais));
}


if((isset($testim['results'])) and (!empty($testim['results']))){
	?>
	<div class="w-section st_testimonios" id="testimonios-pais-detalle">
	    <div class="w-container ct_testimonios">
	    
	    	<h3>¿Por qué trabajar en <strong>BAC | Credomatic</strong></h3>
	    
	    	<ul class="testimonios">
				<?php
					
					foreach($testim['results'] as $key => $value){
						extract($value);
						$autor = '';
						$puesto_autor = '';
						if(isset($field_autor) and !is_array($field_autor)){
							$autor = $field_autor;
						}
						if(isset($field_puesto_autor) and !is_array($field_puesto_autor)){
							$puesto_autor = ' / ' . $field_puesto_autor;
						}					
						echo '<li>

							<div class="testim_content">
								<div class="body">'.$body.'</div>
								<div class="autor">
									<p>'.$autor.$puesto_autor.'</p>
								</div>
								
							</div>
						
						</li>';
					}
	            
	            ?>        
	        </ul>
	    </div>
	</div>
<?php } ?>