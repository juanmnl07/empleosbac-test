<div class="w-section w-section-personas-dashboard">
	<div class="w-container">

		<h2>Últimos perfiles registrados</h2>


		<!--Ordenar por:  <a class="orden" href="javascript:void(0);" data-id="fecha">FECHA</a>  /  <a class="orden" href="javascript:void(0);" data-id="alfa">A-Z</a>-->
		<?php if(($this->session->userdata('user_role')=='administrador país') and ($this->session->userdata('pais_admin')==0)){ ?>
			<div class="alert alert-danger mensajes-comentarios">Lo sentimos. Su cuenta de administrador no tiene un país asignado para poder trabajar. 
				Por favor solicite al Administrador Regional de la plataforma que le asigne un país a su cuenta de usuario para así 
				poder mostrarle la información correspondiente.</div>
		<?php }else{ ?>
			<table width="100%" border="0" cellpadding="2" cellspacing="1" class="filtro_puestos  tabla_personas_admin">
			    <thead>
			    	<tr>
			    		<th width="240" class="sin_filtro"><a class="table-order-filter" data-order-field="nombre" href="javascript:void(0);">Nombre</a></th>
						<th width="240" class="sin_filtro"><a class="table-order-filter" data-order-field="puesto" href="javascript:void(0);">Puesto</a></th>
						<th width="200" class="sin_filtro"><a class="table-order-filter" data-order-field="nacion" href="javascript:void(0);">Nacionalidad</a></th>
						<th width="165" class="sin_filtro"><a class="table-order-filter" data-order-field="estado" href="javascript:void(0);">Estado</a></th>
						<th width="210" class="sin_filtro"><a class="table-order-filter" data-order-field="fecha_reg" href="javascript:void(0);">Fecha de Registro</a></th>
			        </tr>
			    </thead>
			    <tbody>
			    </tbody>
			</table>

		<?php } ?>
		
		
		<div class="ver-todos-puestos-admin">
			<a href="/admin/aplicantes/">Ver todos los perfiles registrados</a>
		</div>
		
	</div>

</div>