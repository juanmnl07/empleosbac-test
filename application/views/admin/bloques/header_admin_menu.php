<div class="header-admin-menu">
	<div class="w-section">
		<div class="w-container ct_menuadmin">

		
		
	
			<div class="titulo-bienvenida-menu-admin">
				<?php if($vista=='admin/dashboard'){?>
					<div class="titulo-bienvenida">
						Hola, <b><?=$info_admin['name']?></b>
					</div>
				<?php } ?>

				<div class="menu-admin-box">
					<ul class="menu-admin">
						<li><a href="/admin/dashboard">Dashboard</a></li>
						<?php if (($user_role=='administrador regional')||($user_role=='administrador país')){?>
							<li><a href="/admin/puestos">Puestos de Trabajo</a></li>
							<li><a href="/admin/aplicantes">Personas Registradas</a></li>
						<?php } ?>
						<?php if ($user_role=='administrador regional' || $user_principal == 1){?>
							<!--<li><a href="/admin/estadisticas/">Estadísticas</a></li>-->
							<li class="expand"><a href="#">Administrativo</a>
								<ul>
									<li><a href="/rrhh/admin/people">Administradores</a></li>
									<li><a href="/rrhh/admin/content">Contenidos</a></li>
									<!--<li><a href="/webcache/clear">Borrar toda la cache</a></li>-->
								</ul>
							</li>
						<?php } ?>

					</ul>

				</div>
			</div>
			
			<?php if($this->uri->segment(1)=='admin'){?>
				<div class="publicar-puesto-box">
					<a href="/rrhh/node/add/puesto-vacante">Publicar puesto de trabajo</a>
				</div>
			<?php } ?>



			<?php if($vista!='admin/dashboard'){
				if(($this->session->userdata('user_role')=='administrador regional')){ ?>
					<div class="cambia-pais-container cambia-pais-container-interno">
						<?php require_once 'cambia_pais_control.php';?>
					</div>
									
				<?php } 
			} ?>

		</div>

	</div>
</div>