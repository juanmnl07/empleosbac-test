<?php

	$listado_carreras = $this->cache->get('carreras-todas');
	if(!$listado_carreras){
		$listado_carreras = $this->general->getJSON('/rrhh/api/carreras/carreras-todas.json');
		$this->cache->write($listado_carreras, 'carreras-todas');
	}


	$html = '';
	$colum = '';
	$cont_colum = 1;
	$cont_total = 1;
	$rtotal = count($listado_carreras['results']);
	foreach ($listado_carreras['results'] as $row) {
		extract($row);

		/*$colum .= '<div class="w-col w-col-[N]">
			<div class="carrera_box"><a href="/carreras/'.$this->general->formatURL($title).'/'.$nid.'">'.$title.'</a></div>
			</div>';*/
		  $colum .= '<div class="w-col w-col-[N] w-col-medium-6 w-col-small-6">
			<div class="carrera_box"><a href="/puestos?carrera='.$nid.'" title="Puesto disponible en '.$title.'">'.$title.'</a></div>
			</div>';		

		if($cont_colum == 4){
			$colum = str_replace("[N]", '3', $colum);
			$html .= '<div class="w-row row_carreras">'.$colum.'</div>';
			$colum = '';
			$cont_colum = 0;
		}


		if($rtotal == $cont_total and $cont_colum != 0){
			$nc = 12 / $cont_colum;
			$colum = str_replace("[N]", $nc, $colum);
			$html .= '<div class="w-row row_carreras">'.$colum.'</div>';
		}

		$cont_colum = $cont_colum + 1;
		$cont_total = $cont_total + 1;
	}

	echo $html;
?>
