<?php
if($listado_aplicantes=="general"){
	$entidades = $this->general->getJSON('/rrhh/api/filtros/filtros-entidades.json');

	$checkbox_carrera     = ''; 
	$checkbox_pais        = ''; 

	foreach($entidades['results'] as $key => $value){
		extract($value);
		switch($node_type){
			case 'carrera':
				$check = '';			
				
				$htmlcarrera = '
				<div class="dcheckbox">
				<input type="checkbox" '.$check.' name="carrera[]" id="carrera'.$nid.'" value="'.$nid.'">
				<label class="w-form-label" for="carrera'.$nid.'">'.$title.'</label></div>';

				
				$checkbox_carrera .= $htmlcarrera; 			
					
				

			break;
			case 'pais':
				$check = '';
				if ($this->session->userdata('pais_admin')!=0){
					$id_pais = $this->session->userdata('pais_admin');
					if(isset($id_pais) and $id_pais == $nid){
						$check = 'checked="checked" ';
					}
				}			

				$htmlpais = '
				<div class="dcheckbox">
				<input type="checkbox" '.$check.' name="pais[]" id="pais'.$nid.'" value="'.$nid.'">
				<label class="w-form-label" for="pais'.$nid.'">'.$title.'</label></div>';
				
					$checkbox_pais .= $htmlpais; 
						
			break;		
		}
	}
}

$taxonomias = $this->general->getJSON('/rrhh/api/filtros/filtros-taxonomias-admin-aplicantes.json');


$checkbox_preparacion = ''; 
$checkbox_genero      = '';
$checkbox_estado	= '' ;





foreach($taxonomias['results'] as $key => $value){
	extract($value);
	switch($taxonomy_vocabulary_machine_name){
		
		case 'nivel_academico':
			

			$htmlpreparacion = '
			<div class="dcheckbox">
			<input type="checkbox"  name="preparacion[]" id="preparacion'.$tid.'" value="'.$tid.'">
			<label class="w-form-label" for="preparacion'.$tid.'">'.$name.'</label></div>';
			
				$checkbox_preparacion .= $htmlpreparacion; 		
		break;
		case 'estado':
			

			$htmlestado = '
			<div class="dcheckbox">
			<input type="checkbox"  name="estado[]" id="estado'.$tid.'" value="'.$tid.'">
			<label class="w-form-label" for="estado'.$tid.'">'.$name.'</label></div>';
			
				$checkbox_estado .= $htmlestado; 		
		break;
		
	}
}




$checkbox_genero ='<div class="dcheckbox">
			<input type="checkbox" name="genero[]" id="genero-f" value="femenino">
			<label class="w-form-label" for="genero-f">Femenino</label></div>
			<div class="dcheckbox">
			<input type="checkbox" name="genero[]" id="genero-m" value="masculino">
			<label class="w-form-label" for="genero-m">Masculino</label></div>';



?>

<h3>Filtros</h3>
<div class="filtros-aplicante-wrapper">
	<form id="filtro-aplicante" class="filtro-aplicantes-<?=$listado_aplicantes?>" method="post">
		<input type="submit" class="btns" value="Filtrar" />
		<?php if($listado_aplicantes == 'general'){?>
			<div class="filtros-aplicante-carrera">
				<h4>Carrera de interés</h4>
				<div class="filtros-aplicante-carrera-checks">
					<?=$checkbox_carrera;?>
				</div>
			</div>
		<?php } ?>
		<?php if($listado_aplicantes == 'general'){
				if($user_role=='administrador regional'){?>
					<div class="filtros-aplicante-pais">
						<h4>País de Interés</h4>
						<div class="filtros-aplicante-pais-checks">
							<?=$checkbox_pais;?>
						</div>
					</div>
			<?php }else{ 
					if($this->session->userdata('pais_admin')>0){?>
						<input type="hidden" id="pais" name="pais" value="<?=$this->session->userdata('pais_admin');?>" />
					<?php	} 
				
			} 
		} ?>

		<div class="filtros-aplicante-preparacion">
			<h4>Preparación Académica</h4>
			<div class="filtros-aplicante-preparacion-checks">
				<?=$checkbox_preparacion;?>
			</div>
		</div>
		<?php if($listado_aplicantes=='por-puesto'){ ?>
			<div class="filtros-aplicante-estado">
				<h4>Estado</h4>
				<div class="filtros-aplicante-estado-checks">
					<?=$checkbox_estado;?>
				</div>
			</div>
		<?php } ?>


		<!--<div class="filtros-aplicante-idiomas">
			<h4>Idiomas</h4>
			<div class="filtros-aplicante-idiomas-checks">
				<?=$checkbox_idioma;?>
			</div>
		</div>-->

		<div class="filtros-aplicante-genero">
			<h4>Género</h4>
			<div class="filtros-aplicante-genero-checks">
				<?=$checkbox_genero;?>
			</div>
		</div>
		<input type="hidden" id="inppage" name="page" value="0" />		
		<input type="hidden" id="items-per-page" name="items_per_page" value="10" />
		<input type="hidden" id="inp_field_orden" name="field_orden" value="nombre" />
		<input type="hidden" id="inp_tipo_orden" name="tipo_orden" value="asc" />
		<?php if($listado_aplicantes=='por-puesto'){ ?>
			<input type="hidden" id="nid_puesto" name="nid_puesto" value="<?=$nid_puesto?>" />
		<?php } ?>
		<input type="submit" class="btns" value="Filtrar" />

	</form>
	
</div>

