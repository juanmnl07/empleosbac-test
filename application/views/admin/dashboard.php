<div class="w-section">
	<div class="w-container">

		<div class="w-row dashboard-datos-generales-container">

				<?php if(($this->session->userdata('user_role')=='administrador regional')){ 
					$cambiaPais = '<div class="cambia-pais-container cambia-pais-container-dashboard">';
					ob_start();
					require_once 'bloques/cambia_pais_control.php';
					$cambiaPais .= ob_get_clean();
					$cambiaPais .= '</div>';			
				 }else{
				 	$cambiaPais = '';
				 }?>

			<div class="w-col w-col-3 w-col-medium-6 w-col-small-6" style="<?=$cambiaPais==''?'width:12%':''?>">
				<?php echo $cambiaPais;?>
			<form id="form_filtrado_dashboard">
			
				<?php if(($this->session->userdata('pais_admin')!==null)){?>
					<input type="hidden" id="pais" class="pais" name="pais" value="<?=$this->session->userdata('pais_admin');?>" />
				<?php } ?>
				<input type="hidden" id="inp_field_orden_puestos" name="field_orden_puestos" value="fecha_pub" />
				<input type="hidden" id="inp_tipo_orden_puestos" name="tipo_orden_puestos" value="desc" />
				<input type="hidden" id="inp_field_orden_personas" name="field_orden_personas" value="fecha_reg" />
				<input type="hidden" id="inp_tipo_orden_personas" name="tipo_orden_personas" value="desc" />							
				<input type="hidden" id="items-per-page" name="items_per_page" value="5" />
			</form>	
		
			</div>
			<div class="w-col w-col-3 w-col-medium-6 w-col-small-6 binfo">
				<div class="boxdatos">
					<div class="total-puestos-detalle ntotal"></div>
					<div class="total-puestos-label"><p>Puestos Publicados</p></div>
				</div>
			</div>
			<div class="w-col w-col-3 w-col-medium-6 w-col-small-6 binfo">
				<div class="boxdatos">
					<div class="total-aplicantes-detalle ntotal"></div>
					<div class="total-puestos-label"><p>Aplicantes a los <br/>puestos publicados</p></div>
				</div>
			</div>
			<div class="w-col w-col-3 w-col-medium-6 w-col-small-6 binfo">
				<div class="boxdatos">
					<div class="total-personas-detalle ntotal"></div>
					<div class="total-puestos-label"><p>Personas Registradas</p></div>
				</div>
			</div>									
		</div>
		
		
	</div>

</div>

<?php require_once 'bloques/dashboard_puestos_admin.php';?>

<div class="w-section">
	<div class="w-container divicion"> 
	</div>
</div>

<?php require_once 'bloques/dashboard_personas_registradas.php';?>

<div class="w-section">
	<div class="w-container">
		<p>&nbsp</p><p>&nbsp</p><p>&nbsp</p>
	</div>
</div>
