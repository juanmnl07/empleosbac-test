<?php

#$entidades = $this->general->getJSON('/rrhh/api/filtros/filtros-entidades.json');
#$taxonomias = $this->general->getJSON('/rrhh/api/filtros/filtros-taxonomias.json');

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

$checkbox_carrera     = ''; $checkbox_carrera2     = '';
$checkbox_pais        = ''; $checkbox_pais2        = '';
$checkbox_jornada     = ''; $checkbox_jornada2     = '';
$checkbox_preparacion = ''; $checkbox_preparacion2 = '';
$checkbox_idioma      = ''; $checkbox_idioma2      = '';

$idcarrera = 1;
$idpais = 1;
$idjornada = 1;
$idacademico = 1;
$ididioma = 1;

//filtrado:
$selected_country = "";
$selected_carrera = "";

foreach($entidades['results'] as $key => $value){
	extract($value);
	switch($node_type){
		case 'carrera':
			$check = '';
			$id = $this->input->get('carrera');
			if(isset($id) and $id == $nid){
				$check = 'checked="checked" ';
				$selected_carrera = $title;
			}
			$htmlcarrera = '
			<div class="dcheckbox">
			<input type="checkbox" '.$check.' name="carrera[]" id="carrera'.$nid.'" value="'.$nid.'">
			<label class="w-form-label" for="carrera'.$nid.'">'.$title.'</label></div>';

			if($idcarrera == 1){
				$checkbox_carrera .= $htmlcarrera; $idcarrera = 0;
			}else{
				$checkbox_carrera2 .= $htmlcarrera; $idcarrera = 1;
			}


		break;
		case 'pais':
			$check = '';
			$id = $this->input->get('pais');
			if(isset($id) and $id == $nid){
				$check = 'checked="checked" ';
				$selected_country = $title;
			}

			$htmlpais = '
			<div class="dcheckbox">
			<input type="checkbox" '.$check.' name="pais[]" id="pais'.$nid.'" value="'.$nid.'">
			<label class="w-form-label" for="pais'.$nid.'">'.$title.'</label></div>';
			if($idpais == 1){
				$checkbox_pais .= $htmlpais; $idpais = 0;
			}else{
				$checkbox_pais2 .= $htmlpais; $idpais = 1;
			}			
		break;		
	}
}

foreach($taxonomias['results'] as $key => $value){
	extract($value);
	switch($taxonomy_vocabulary_machine_name){
		case 'jornada':
			$htmljornada = '
			<div class="dcheckbox">
			<input type="checkbox" name="jornada[]" id="jornada'.$tid.'" value="'.$tid.'">
			<label class="w-form-label" for="jornada'.$tid.'">'.$name.'</label></div>';
			if($idjornada == 1){
				$checkbox_jornada .= $htmljornada; $idjornada = 0;
			}else{
				$checkbox_jornada2 .= $htmljornada; $idjornada = 1;
			}				
		break;
		case 'nivel_academico':
			$htmlpreparacion = '
			<div class="dcheckbox">
			<input type="checkbox" name="preparacion[]" id="preparacion'.$tid.'" value="'.$tid.'">
			<label class="w-form-label" for="preparacion'.$tid.'">'.$name.'</label></div>';
			if($idacademico == 1){
				$checkbox_preparacion .= $htmlpreparacion; $idacademico = 0;
			}else{
				$checkbox_preparacion2 .= $htmlpreparacion; $idacademico = 1;
			}				
		break;
		case 'idiomas':
			$htmlidioma = '
			<div class="dcheckbox">
			<input type="checkbox" name="idioma[]" id="idioma'.$tid.'" value="'.$tid.'">
			<label class="w-form-label" for="idioma'.$tid.'">'.$name.'</label></div>';
			if($ididioma == 1){
				$checkbox_idioma .= $htmlidioma; $ididioma = 0;
			}else{
				$checkbox_idioma2 .= $htmlidioma; $ididioma = 1;
			}			
		break;		
	}
}


?>
<div class="w-section st_filtrado">
	<div class="w-container ct_filtrado">

		<div class="total_puestos">
			<span class='mayuscula'>
				<?php
			
				$tpuestos = $this->cache->get('puestos-todos-fecha');
				if(!$tpuestos){
					$tpuestos = $this->general->getJSON('/rrhh/api/puestos/puestos-todos-fecha.json');
					$this->cache->write($tpuestos, 'puestos-todos-fecha');
				}

				$count = $tpuestos['metadata']['total_results'] . ' Puestos disponibles';
				$filter_detail = "Pais: ".$selected_country . ", Carrera: ".$selected_carrera;
				if($selected_country == ""){
					$filter_detail = "Carrera: ".$selected_carrera;	
				} elseif($selected_carrera == "") {
					$filter_detail = "Pais: ".$selected_country;
				}
				$get_values = $this->input->get();
				if (empty($get_values)){
					echo $count;	
				}else{
					echo $filter_detail;
				}
				?>
			</span>
		</div>

		<div class="filtrado fopen">
			
			<div class="as_tabs_content">


			<div class="w-row">
				<div class="w-col w-col-3">

					<a class="mostrarfiltros" href="javascript:void(0);">Filtrar por:</a>

					<ul class="as_tabs">
						<li class="tab-link current" data-tab="tab-1">Palabra clave <span>&nbsp</span></li>
						<li class="tab-link" data-tab="tab-2">País <span>&nbsp</span></li>
			            <?php #if(!isset($id)){?>
						<li class="tab-link" data-tab="tab-3">Carreras <span>&nbsp</span></li>
			            <?php #}?>
						<li class="tab-link" data-tab="tab-4">Preparación Académica <span>&nbsp</span></li>
						<li class="tab-link" data-tab="tab-5">Tipo de jornada <span>&nbsp</span></li>
					</ul>


				</div>
				<div class="w-col w-col-9">

					<div class="as_content">

						<form id="form_filtrado">
							<div id="tab-1" class="tab-content current">
								<span class="spaninput"><input type="text" name="termino" placeholder="Palabras claves"></span>

							</div>
							<div id="tab-2" class="tab-content">
								<div class="w-row">
									<div class="w-col w-col-6"><?=$checkbox_pais?></div>
									<div class="w-col w-col-6"><?=$checkbox_pais2?></div>
								</div>								
							</div>
							<div id="tab-3" class="tab-content">
								<div class="w-row">
									<div class="w-col w-col-6"><?=$checkbox_carrera?></div>
									<div class="w-col w-col-6"><?=$checkbox_carrera2?></div>
								</div>
							</div>
							<div id="tab-4" class="tab-content">
								<div class="w-row">
									<div class="w-col w-col-6"><?=$checkbox_preparacion?></div>
									<div class="w-col w-col-6"><?=$checkbox_preparacion2?></div>
								</div>								
			                     
			                     <strong>Idioma</strong>
								<div class="w-row">
									<div class="w-col w-col-6"><?=$checkbox_idioma?></div>
									<div class="w-col w-col-6"><?=$checkbox_idioma2?></div>
								</div>			                     
			                       
							</div>			
							<div id="tab-5" class="tab-content">
								<div class="w-row">
									<div class="w-col w-col-6"><?=$checkbox_jornada?></div>
									<div class="w-col w-col-6"><?=$checkbox_jornada2?></div>
								</div>									
							</div>	

							<input type="hidden" id="inppage" name="page" value="0" />
			                <input type="hidden" id="inporden" name="orden" value="fecha" />
						</form>


					</div>

				</div>
			</div>
			<div class="optionfiltros">
				<a class="reset" href="javascript:void(0);">Deshacer filtros</a>
				<a class="ocultarfiltros" href="javascript:void(0);">Ocultar filtros</a>
			</div>

			</div>
		

		</div>

		

		<!--Ordenar por:  <a class="orden" href="javascript:void(0);" data-id="fecha">FECHA</a>  /  <a class="orden" href="javascript:void(0);" data-id="alfa">A-Z</a>-->

		<div class="infopaginacion">&nbsp;</div>

		<table width="100%" border="0" cellpadding="2" cellspacing="1" class="filtro_puestos filtro_puestos_front">
		    <thead>
		    	<tr>
		    		<th>Descripción</th>
		    		<th>Carrera</th>
		            <th>País</th>
		            <th>Publicación</th>
		        </tr>
		    </thead>
		    <tbody>
		    </tbody>
		</table>
		<div class="paginacionhtml"></div>
    </div>
</div>