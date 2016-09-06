<?php

$entidades = $this->general->getJSON('/rrhh/api/filtros/filtros-entidades.json');


$checkbox_carrera     = ''; $checkbox_carrera2     = '';
$checkbox_pais        = ''; $checkbox_pais2        = '';


$idcarrera = 1;
$idpais = 1;


foreach($entidades['results'] as $key => $value){
	extract($value);
	switch($node_type){
		case 'carrera':
			$check = '';
			$id = $this->input->get('carrera');
			if(isset($id) and $id == $nid){
				$check = 'checked="checked" ';
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
			if ($this->session->userdata('pais_admin')!=0){
				$id_pais = $this->session->userdata('pais_admin');
				if(isset($id_pais) and $id_pais == $nid){
					$check = 'checked="checked" ';
				}
			}
			$htmlpais = '
			<div class="dcheckbox">
			<input type="checkbox" '.$check.'  name="pais[]" id="pais'.$nid.'" value="'.$nid.'">
			<label class="w-form-label" for="pais'.$nid.'">'.$title.'</label></div>';
			if($idpais == 1){
				$checkbox_pais .= $htmlpais; $idpais = 0;
			}else{
				$checkbox_pais2 .= $htmlpais; $idpais = 1;
			}			
		break;		
	}
}


$checkbox_estado1 ='<div class="dcheckbox">
			<input type="checkbox" name="estado[]" id="estado-publicado" value="1">
			<label class="w-form-label" for="estado-publicado">Publicado</label></div>';
$checkbox_estado2 ='<div class="dcheckbox">
			<input type="checkbox" name="estado[]" id="estado-no-publicado" value="0">
			<label class="w-form-label" for="estado-no-publicado">No Publicado</label></div>';


?>


<div class="w-section">
	<div class="w-container">

		<h1>Puestos de Trabajo</h1>

		
		<ul class="action-links display_asv">
        	<li><a href="/rrhh/node/add/puesto-vacante">Crear puestos de trabajo</a></li>
        </ul>		
		
		<h2 class="title" id="page-title">Puestos de trabajo creados</h2>

		<div class="filtrado filtrado-admin fopen">
			
			<div class="as_tabs_content">


			<div class="w-row">
				<div class="w-col w-col-3">

					<a class="mostrarfiltros" href="javascript:void(0);">Filtrar por:</a>

					<ul class="as_tabs">
						<li class="tab-link current" data-tab="tab-1">Palabra clave <span>&nbsp</span></li>
						<?php if($this->session->userdata('user_role')!='administrador país'){?>
							<li class="tab-link" data-tab="tab-2">País <span>&nbsp</span></li>
						<?php }?>						
			            <?php #if(!isset($id)){?>
						<li class="tab-link" data-tab="tab-3">Carreras <span>&nbsp</span></li>
			            <?php #}?>
						<li class="tab-link" data-tab="tab-4">Estado<span>&nbsp</span></li>
						<li class="tab-link" data-tab="tab-5">Administrador <span>&nbsp</span></li>
					</ul>


				</div>
				<div class="w-col w-col-9">

					<div class="as_content">
						

						<form id="form_filtrado_puestos_admin">
							<div id="tab-1" class="tab-content current">
								<p>Entre más filtros utilices más detallada será tu búsqueda.</p>
								<span class="spaninput"><input type="text" name="termino" placeholder="Palabras claves"></span><br /><br />

								<p><em>*Escriba la palabra clave a buscar y presione la tecla "Enter" para hacer el filtrado</em></p>

							</div>
							<?php if($this->session->userdata('user_role')=='administrador país'){?>
								<input type="hidden" id="pais" name="pais" value="<?=$this->session->userdata('pais_admin');?>" />
							<?php }else{ ?>
								<div id="tab-2" class="tab-content">
									<div class="w-row">
										<div class="w-col w-col-6"><?=$checkbox_pais?></div>
										<div class="w-col w-col-6"><?=$checkbox_pais2?></div>
									</div>								
								</div>
							<?php }?>
							
							<div id="tab-3" class="tab-content">
								<div class="w-row">
									<div class="w-col w-col-6"><?=$checkbox_carrera?></div>
									<div class="w-col w-col-6"><?=$checkbox_carrera2?></div>
								</div>
							</div>
							<div id="tab-4" class="tab-content">
								<div class="w-row">
									<div class="w-col w-col-6"><?=$checkbox_estado1?></div>
									<div class="w-col w-col-6"><?=$checkbox_estado2?></div>
								</div>
							</div>			
							<div id="tab-5" class="tab-content">
								<p>Escriba el nombre del Administrador cuyos puestos creados desea buscar</p>
								<span class="spaninput"><input type="text" name="admin" placeholder="Nombre del Administrador" /></span><br /><br />

								<p><em>*Digíte el nombre del administrador y presione la tecla "Enter" para hacer el filtrado</em></p>							
							</div>	

							<input type="hidden" id="inppage" name="page" value="0" />
							<input type="hidden" id="items-per-page" name="items_per_page" value="15" />
			                <input type="hidden" id="inp_field_orden" name="field_orden" value="nombre" />
			                <input type="hidden" id="inp_tipo_orden" name="tipo_orden" value="asc" />
						</form>


					</div>

				</div>
			</div>
			<div class="optionfiltros">
				<a class="reset-admin" href="javascript:void(0);">Deshacer filtros</a>
				<a class="ocultarfiltros" href="javascript:void(0);">Ocultar filtros</a>
			</div>

			</div>
		

		</div> 

		

		<!--Ordenar por:  <a class="orden" href="javascript:void(0);" data-id="fecha">FECHA</a>  /  <a class="orden" href="javascript:void(0);" data-id="alfa">A-Z</a>-->
		<?php if(($this->session->userdata('user_role')=='administrador país') and ($this->session->userdata('pais_admin')==0)){ ?>
			<div class="alert alert-danger mensajes-comentarios">Lo sentimos. Su cuenta de administrador no tiene un país asignado para poder trabajar. 
				Por favor solicite al Administrador Regional de la plataforma que le asigne un país a su cuenta de usuario para así 
				poder mostrarle la información correspondiente.</div>
		<?php }else{ ?>
			<table width="100%" border="0" cellpadding="2" cellspacing="1" class="filtro_puestos  filtro_puestos_admin">
			    <thead>
			    	<tr>
			    		<th class="sin_filtro"><a class="table-order-filter" data-order-field="nombre" href="javascript:void(0);">Nombre</a></th>
			    		<th width="120">Descripción</th>
			            <th  class="sin_filtro"><a class="table-order-filter"  data-order-field="pais" href="javascript:void(0);">País</a></th>
			            <th  class="sin_filtro"><a class="table-order-filter"  data-order-field="fecha-cierre" href="javascript:void(0);">Fecha de Cierre</a></th>
			            <th  class="sin_filtro"><a class="table-order-filter"  data-order-field="admin" href="javascript:void(0);">Administrador</a></th>
			            <th  class="sin_filtro"><a  class="table-order-filter" data-order-field="cant_aplicantes" href="javascript:void(0);">Cantidad de Aplicantes</a></th>
			            <th class="sin_filtro"><a class="table-order-filter" data-order-field="estado_puesto" href="javascript:void(0);">Estado</a></th>
			        </tr>
			    </thead>
			    <tbody>
			    </tbody>
			</table>
			<div class="paginacionhtml paginacionhtml-admin"></div>
			<div class="infopaginacion-admin">&nbsp;</div>

		<?php } ?>
		
		
		
	</div>

</div>