<div class="w-section">
	<div class="w-container">

		<h2>Últimos puestos publicados</h2>

		<!--Ordenar por:  <a class="orden" href="javascript:void(0);" data-id="fecha">FECHA</a>  /  <a class="orden" href="javascript:void(0);" data-id="alfa">A-Z</a>-->
		<?php if(($this->session->userdata('user_role')=='administrador país') and ($this->session->userdata('pais_admin')==0)){ ?>
			<div class="alert alert-danger mensajes-comentarios">Lo sentimos. Su cuenta de administrador no tiene un país asignado para poder trabajar. 
				Por favor solicite al Administrador Regional de la plataforma que le asigne un país a su cuenta de usuario para así 
				poder mostrarle la información correspondiente.</div>
		<?php }else{ ?>
			<table width="100%" border="0" cellpadding="2" cellspacing="1" class="filtro_puestos  filtro_puestos_dashboard ">
			    <thead>
			    	<tr>
			    		<th width="300" class="sin_filtro"><a class="table-order-filter" data-order-field="desc_puesto" href="javascript:void(0);">Descripción</a></th>
						<th width="300" class="sin_filtro"><a class="table-order-filter" data-order-field="pais" href="javascript:void(0);">País</a></th>
						<th class="sin_filtro"><a class="table-order-filter" data-order-field="fecha_pub" href="javascript:void(0);">Publicación</a></th>
						<th><a class="table-order-filter" data-order-field="aplicantes" href="javascript:void(0);">Aplicantes</a></th>
						<th width="125" class="sin_filtro"><a class="table-order-filter" data-order-field="estado_puesto" href="javascript:void(0);">Estado</a></th>
			        </tr>
			    </thead>
			    <tbody>
			    </tbody>
			</table>

		<?php } ?>
		
		
		<div class="ver-todos-puestos-admin">
			<a href="/admin/puestos/">Ver todos los puestos</a>
		</div>
		
	</div>

</div>