<div class="w-section">
    <div class="w-container ct_aplicantes">
    	<?php if($listado_aplicantes == 'general'){?>
	    	<h1>Candidatos Generales</h1>
	    	<h2>Candidatos generales registrados en el sistema <span class="cant-aplicantes"><?=$total_aplicantes_registrados;?> aplicantes registrados</span></h2>
    	<?php }else{ ?>
			<h1>Personas Registradas</h1>
	    	<h2 class="titulo-puesto-administrativo"><?=$nombre_puesto_con_formato;?> <span class="cant-aplicantes"><?=$total_aplicantes_registrados;?> aplicantes registrados</span>
    	<?php } ?></h2>
    	<div class="w-col-3 listado-aplicantes-filtro">
			<div class="ct_listado-aplicantes-filtro">
    		<?php require_once 'bloques/filtrado_aplicantes.php';?>
			</div>
		</div>
		<div class="w-col-9 listado-aplicantes">
			<table width="100%" border="0" cellpadding="2" cellspacing="1" class="filtro_puestos_aplicados tabla-aplicantes-<?=$listado_aplicantes?>" data-id-autor="<?php echo (isset($autor)) ? $autor : '' ?>" data-id-admin="<?php echo (isset($admin_id)) ? $admin_id : '' ?>">
			    <thead>
			      <tr>
			          <th width="260" class="sin_filtro"><a class="table-order-filter" data-order-field="nombre" href="javascript:void(0);">Nombre</a></th>
			          <?php if($listado_aplicantes == 'general'){?>				         
							<th widht="100" class="sin_filtro"><a class="table-order-filter" data-order-field="puestos_apli" href="javascript:void(0);">Puestos aplicados</a></th>
							<!--<th width="75"><a class="table-order-filter" data-order-field="edad" href="javascript:void(0);">Edad</a></th>-->
							<th width="75">Edad</th>
							<th width="101" class="sin_filtro"><a class="table-order-filter" data-order-field="nacion" href="javascript:void(0);">Nacionalidad</a></th>
							<th width="185" class="sin_filtro"><a class="table-order-filter" data-order-field="fecha_reg" href="javascript:void(0);">Fecha de registro</a></th>
			          <?php } else { ?>
				          <th><a class="table-order-filter" data-order-field="nivel" href="javascript:void(0);">Nivel</a></th>			          
				          <!--<th>Edad</th>-->
				          <th><a class="table-order-filter" data-order-field="edad" href="javascript:void(0);">Edad</a></th>			          
				          <th><a class="table-order-filter" data-order-field="cuando_ap" href="javascript:void(0);">Cuando aplicó</a></th>
				          <th><a class="table-order-filter" data-order-field="estado" href="javascript:void(0);">Estado</a></th>
				          <!--<?php if($admin_id == $autor){ ?>
				          	<th>Descartar <br/> Postulante</th>
				          <?php } ?>-->
			          <?php }  ?>
			      </tr>
			    </thead>
			   <tbody>
			
			    </tbody>
			</table>

			<div class="paginacionhtml"></div>
		</div>
		<div class="popup-overlay"></div>

	</div>
</div>