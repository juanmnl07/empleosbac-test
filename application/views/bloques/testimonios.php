<?php

$testim = $this->cache->get('testimonios-home');
if(!$testim){
	$testim = $this->general->getJSON('/rrhh/api/testimonios/testimonios-home.json');
	$this->cache->write($testim, 'testimonios-home');
}

?>
<div class="w-section st_testimonios">
    <div class="w-container ct_testimonios">
    
    	<h3>En BAC | Credomatic puedes alcanzar tus metas,<br> mientras trabajas con gente talentosa</h3>
    
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