<div class="w-section st_otros_puestos">
	<div class="w-container ct_otros_puestos">

	<h2>Otros puestos disponibles en <?php echo $field_pais ?><span class="linea"></span></h2>
	
	<div class="otros-puestos-container">
		<ul class="otrospuestos">

			<?php 
				
				$otros_puestos = $this->cache->get('puesto-otros-pais-'.$pais_id.'-'.$nid);
				if(!$otros_puestos){
					$otros_puestos = $this->general->getJSON('/rrhh/api/puestos/otros-puestos-pais?pais[0]='.$pais_id.'&puesto-id=' . $nid);
					$this->cache->write($otros_puestos, 'puesto-otros-pais-'.$pais_id.'-'.$nid);
				}				
				
				$colum = '';
				$contador = 1;
				if($otros_puestos){

					foreach($otros_puestos['results'] as $key => $value){
						extract($value);
						
						
						$colum .= '<li><div class="otro-puesto-box">									
										
											<a class="otro-puesto-title" href="/puestos/'.$this->general->formatURL($title).'/'.$nid.'">'.$title.'</a>

											<p>'.$body.'</p>											
	
											<a class="otro-puesto-ver-mas" href="/puestos/'.$this->general->formatURL($title).'/'.$nid.'">Ver detalles</a>
										
									</div></li>';
						

						$contador++;
					}
				}else{

				}
				echo $colum;
				
			?>
			
		</ul>
	</div>


	</div>
</div>