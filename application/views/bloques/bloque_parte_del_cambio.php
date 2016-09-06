<?php

$entidades = $this->cache->get('filtros-entidades');
if(!$entidades){
	$entidades = $this->general->getJSON('/rrhh/api/filtros/filtros-entidades.json');
	$this->cache->write($entidades, 'filtros-entidades');
}

$taxonomias = $this->cache->get('filtros-taxonomias');
if(!$taxonomias){
	$taxonomias = $this->general->getJSON('/rrhh/api/filtros/filtros-taxonomias.json');
	$this->cache->write($taxonomias, 'filtros-taxonomias');
}





$options_carrera     = array(0 => 'Carrera'); 
$options_pais        = array(0 => 'País');


foreach($entidades['results'] as $key => $value){
	extract($value);
	switch($node_type){
		case 'carrera':
			$options_carrera[$nid] = $title;/*'<option value="'.$nid.'" id="carrera-'.$nid.'">'.$title.'</value>';*/
		break;
		case 'pais':
			$options_pais[$nid] = $title;/*'<option value="'.$nid.'" id="pais-'.$nid.'">'.$title.'</value>';		*/
		break;		
	}
}
 ?>

 <div class="bloque-se-parte-del-cambio w-section" id="empleos-disponibles">
 	<div class="bloque-se-parte-del-cambio-inner">
 		<h2>Sé parte <span>del cambio</span></h2>
		<?php 
					
					$attributes = array('class' => 'form-parte-del-cambio', 'id' => 'form-parte-del-cambio' , 'method' => 'get');
					echo form_open('puestos', $attributes);
					
					
					
					$pais_se_parte_del_cambio_select_attr = 'id="pais-select-se-parte-del-cambio"';

					$carrera_se_parte_del_cambio_select_attr = 'id="carrera-select-se-parte-del-cambio"';

					
					?>
					<div class="se-parte-del-cambio-carrera-select-wrapper">
						<?php echo form_dropdown('carrera', $options_carrera, 0, $carrera_se_parte_del_cambio_select_attr);	?>
					</div>
					<div class="se-parte-del-cambio-pais-select-wrapper">
						<?php 
							if (isset($nid_copia)){
								echo form_dropdown('pais', $options_pais, $nid_copia, $pais_se_parte_del_cambio_select_attr);
							}else{
								echo form_dropdown('pais', $options_pais, 0, $pais_se_parte_del_cambio_select_attr);
							}
						?>
					</div>
					
					<?php
					
					$boton_enviar = array(
					    'id' => 'boton-ver-puestos',
					    'type' => 'submit',
					    'content' => 'Ver todos los puestos disponibles'
					);

					?>
					<div class="se-parte-del-cambio-button-wrapper"> 
						<?php echo form_button($boton_enviar); ?>
					</div>

						
					<?php echo form_close(); ?>	
		
 	</div>
 </div>