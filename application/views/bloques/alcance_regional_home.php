<?php
	$listado_paises_colaboradores = $this->general->getJSON('/rrhh/api/paises/paises-colaboradores');
		
	$paises_array = array();

	foreach($listado_paises_colaboradores['results'] as $key => $value){
		extract($value);
		$paises_array[$nid] = $field_numero_de_colaboradores;
	}
?>
 <div class="w-section st-alcance-regional-bloque">

	<div class="w-container">
		<h2 title="Vacantes de empleo en México y Centroamérica">Alcance Regional <span class="linea"></span></h2>
		<p>Atendemos 666 direcciones regionales y somos más de 22.000 colaboradores desde México hasta Panamá.</p>
	</div>

 	<div class="st-alcance-regional-bloque-inner">
 		<div class="mapa-container-home">
			<div class="mapas-paises-hover-container">
				<div class="mapas-paises-hover-container-inner">
					<div class="mapas-paises-hover-costa-rica mapas-paises-hover">
						
					</div>
					<div class="mapas-paises-hover-panama mapas-paises-hover">
						
					</div>
					<div class="mapas-paises-hover-nicaragua mapas-paises-hover">
						
					</div>
					<div class="mapas-paises-hover-elsalvador mapas-paises-hover">
						
					</div>
					<div class="mapas-paises-hover-guatemala mapas-paises-hover">
						
					</div>
					<div class="mapas-paises-hover-honduras mapas-paises-hover">
						
					</div>
					<div class="mapas-paises-hover-mexico mapas-paises-hover">
						
					</div>
				</div>
			</div>
			<div class="tooltip-container">
				<div class="tooltip-container-inner">
					<div class="tooltip-costa-rica tooltip-pais-wrapper" data-pais="costa-rica">
						<a href="/presencia-regional/costa-rica/10" class="tooltip-titulo-pais">Costa Rica</a>
						<p class="tooltip-colaboradores-pais"><?=$paises_array[10];?><br /><span>colaboradores</span></p>
					</div>
					<div class="tooltip-panama tooltip-pais-wrapper" data-pais="panama">
						<a href="/presencia-regional/panama/11" class="tooltip-titulo-pais">Panamá</a>
						<p class="tooltip-colaboradores-pais"><?=$paises_array[11];?><br /><span>colaboradores</span></p>
					</div>
					<div class="tooltip-nicaragua tooltip-pais-wrapper" data-pais="nicaragua">
						<a href="/presencia-regional/nicaragua/9" class="tooltip-titulo-pais">Nicaragua</a>
						<p class="tooltip-colaboradores-pais"><?=$paises_array[9];?><br /><span>colaboradores</span></p>
					</div>
					<div class="tooltip-elsalvador tooltip-pais-wrapper" data-pais="elsalvador">
						<a href="/presencia-regional/el-salvador/8" class="tooltip-titulo-pais">El Salvador</a>
						<p class="tooltip-colaboradores-pais"><?=$paises_array[8];?><br /><span>colaboradores</span></p>
					</div>
					<div class="tooltip-guatemala tooltip-pais-wrapper" data-pais="guatemala">
						<a href="/presencia-regional/guatemala/6" class="tooltip-titulo-pais">Guatemala</a>
						<p class="tooltip-colaboradores-pais"><?=$paises_array[6];?><br /><span>colaboradores</span></p>
					</div>
					<div class="tooltip-honduras tooltip-pais-wrapper" data-pais="honduras">
						<a href="/presencia-regional/honduras/7" class="tooltip-titulo-pais">Honduras</a>
						<p class="tooltip-colaboradores-pais"><?=$paises_array[7];?><br /><span>colaboradores</span></p>
					</div>
					<div class="tooltip-mexico tooltip-pais-wrapper" data-pais="mexico">
						<a href="/presencia-regional/mexico/5" class="tooltip-titulo-pais">México</a>
						<p class="tooltip-colaboradores-pais"><?=$paises_array[5];?><br /><span>colaboradores</span></p>
					</div>
				</div>
			</div>		
			
		</div>
	</div>


	<div class="w-container ct_mas_carrera">
		<a class="mas-carreras-link" href="/puestos">Oportunidades disponibles por país</a>
	</div>


</div>