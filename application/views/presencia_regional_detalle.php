<?php 
	extract($info);
	//var_export($info);


	$total_cola = "";
	$total_sucu = "";
	$total_clien = 0;
	$total_clien_emp = 0;
	$texto_premio = "";
	$desc_premio = "";
	$impacto_positivo = array();
	$string_videos ="";

	/* Keylor Mora - 03 marzo 2016
	
		se hizo este cambio especificamente a colaboradores y sucursales porque el cliente solicitó que para 
		Guatemala se colocara "Más de 3000", lo cual obligó a cambiar el campo de Drupal de Numero a Texto, y entonces
		aqui se valida si lo que viene es numero o no, y entonces aplica formateo numerico si corresponde o no.

	*/
	if(isset($field_numero_de_colaboradores) and !empty($field_numero_de_colaboradores)){
		if(is_numeric($field_numero_de_colaboradores)){
			
			$total_cola = 0;
			$total_cola = number_format($field_numero_de_colaboradores,0,",",".");

		}else{
			$total_cola = $field_numero_de_colaboradores;
		}
		
	}
	if(isset($field_numero_de_sucursales) and !empty($field_numero_de_sucursales)){
			
		if(is_numeric($field_numero_de_sucursales)){
			$total_sucu =0;
			$total_sucu = number_format($field_numero_de_sucursales,0,",",".");
			
		}else{
			$total_sucu = $field_numero_de_sucursales;
		}
	}
	if(isset($field_numero_de_clientes) and !empty($field_numero_de_clientes)){
		$total_clien += $field_numero_de_clientes;
	}
	if(isset($field_numero_clientes_empresa) and !empty($field_numero_clientes_empresa)){
		$total_clien_emp += $field_numero_clientes_empresa;
	}
	if(isset($field_texto_de_premio) and !empty($field_texto_de_premio)){
		$texto_premio .= $field_texto_de_premio;
	}
	if(isset($field_detalle_de_premio) and !empty($field_detalle_de_premio)){
		$desc_premio .= $field_detalle_de_premio;
	}

	$titulo_copia = $title;
	$nid_copia = $nid;

?>




<div class="w-section st-impacto-regional">
	<div class="w-container">
		<?php if($this->input->get('creado') == "true"){ ?>
			<div class="alert alert-success"><p>El país ha sido creado con éxito. Para editarlo, haga <a href="/rrhh/node/<?=$nid?>/edit">click aquí</a></p></div>
		<?php }

		if($this->input->get('editado') == "true"){ ?>
			<div class="alert alert-success"><p>El contenido de este país ha sido editado con éxito. Para volver a editarlo, haga <a href="/rrhh/node/<?=$nid?>/edit">click aquí</a></p></div>
		<?php }?>
        <h1><?=$title?><span class="linea"></span></h1>
        <a class="btn_atras" href="/presencia-regional">Regresar al mapa</a>
    </div>

    <div class="impacto-regional-detalle-imagen-top">
    	<?php 
    		if (isset($field_imagen) and !empty($field_imagen)){ ?>
				<img src="<?=$field_imagen?>" />
    		<?php }
    	?>
    </div>


    <div class="w-container" id="datos-numericos-pais">
        <h2>BAC | Credomatic <strong>en <?=$title?></strong></h2>

        <div class="impacto-regional-detalle-datos">
        	<div class="w-row arow2">

				<?php 
				if($texto_premio != ""){
					$w_col = 3;
					$w_col2 = "w-col-medium-6 w-col-small-6";
				}else{
					$w_col = 4;
					$w_col2 = "";
				}?>

        		<div class="w-col w-col-<?=$w_col?> <?=$w_col2?>">
        			<div class="boxcol">
        				<div class="tnumero bg1">
        					
								<span><?=$total_cola;?></span>
        					
								
        				</div>
        				<p class="tdesc">Colaboradores cambiando para bien la vida de miles de personas</p>
        			</div>
        		</div>


        		<div class="w-col w-col-<?=$w_col?> <?=$w_col2?>">
        			<div class="boxcol">
        				<div class="tnumero bg2">
        					<span><?=number_format($total_clien,0,",",".")?></span>
        				</div>
	        			<p class="tdesc">
	        				<?php 
	        				if ($nid_copia == 10){
	        					echo 'Clientes en todo el país (personas y empresas)';
	        				}elseif($nid_copia == 9 or $nid_copia == 5){
	        					echo 'Clientes a lo largo y ancho del país';
	        				}else{
	        					echo 'Personas clientes en todo el país; '. number_format($total_clien_emp,0,",",".") .' empresas clientes';
	        				}?>
	        			</p>
        			</div>
        		</div>


        		<div class="w-col w-col-<?=$w_col?> <?=$w_col2?>">
        			<div class="boxcol">
        				<div class="tnumero bg3">
        					<span><?=$total_sucu?></span>
        				</div>
        				<p class="tdesc">
        					<?php if ($nid_copia == 5){
        					echo 'Tarjetas emitidas hasta el año 2015';
        					}else{
        						echo 'Sucursales en el país';
        					}
        					?>
        				</p>
        			</div>
        		</div>	

				<?php if($texto_premio != ""){?>
				<div class="w-col w-col-<?=$w_col?> <?=$w_col2?>">
					<div class="boxcol">
						<div class="tnumero bg4">
							<span><?=$texto_premio?></span>
						</div>
						<p class="tdesc"><?=$desc_premio?></p>			
					</div>
				</div>
				<?php }?>

        	</div>
        </div>
    </div>
</div>
<div class="w-section st_imppos">    
	<?php if(isset($field_impacto_positivo) and !empty($field_impacto_positivo)){ ?>	

	    <div class="w-container ct_imppos"  id="impacto-positivo-pais">
	        <h2>¿Cómo <strong>impactamos positivamente</strong> la vida<br> de nuestros trabajadores?</h2>

	        <div clasS="impacto-positivo-container">
		        <?php 
		        	$contador = 1;
		        	foreach($field_impacto_positivo as $key => $value ){
		        		
		        		if (($contador%2) == 1){ ?>
							<div class="w-row row_imppos">
								<div class="w-col w-col-5 txtright">
									
									<?php if(isset($value['Titulo de Impacto']['#markup'])){ ?><h2><?=$value['Titulo de Impacto']['#markup']?></h2><?php } ?>
									<?php if(isset($value['Detalle de Impacto']['#markup'])){ ?><p><?=$value['Detalle de Impacto']['#markup']?></p><?php } ?>
								</div>						
								<div class="w-col w-col-7">
									<?php if(isset($value['Imágen Impacto']['#item'])){ 
										if(isset($value['Video ID (Youtube)']['#markup'])){ ?>
											<a class="video-link" data-popup-target="#popup_video<?=$contador?>"  href="javascript:void(0);">
												<img src="<?=str_replace('public://', '/rrhh/sites/default/files/', $value['Imágen Impacto']['#item']['uri'])?>" />
												<div class="video-bg"></div>
											</a>
											
											<?php $string_videos .= 
												'<div class="popup" id="popup_video'.$contador.'">
													<div class="popup-body">
													<span class="popup-exit"></span>
														<div class="popup-content">
															<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$value['Video ID (Youtube)']['#markup'].'?rel=0&showinfo=0&enablejsapi=1" frameborder="0" allowfullscreen></iframe>
														</div>
													</div>
												</div>'; 
											?>
										<?php } else{ ?>
											<img src="<?=str_replace('public://', '/rrhh/sites/default/files/', $value['Imágen Impacto']['#item']['uri'])?>" />
										<?php } 
									} ?>
								</div>
							</div>
		        <?php
		        		}else{ ?>
		        			<div class="w-row row_imppos">
		        				<div class="w-col w-col-7">
									<?php if(isset($value['Imágen Impacto']['#item'])){ 
										if(isset($value['Video ID (Youtube)']['#markup'])){ ?>
											<a class="video-link" data-popup-target="#popup_video<?=$contador?>"  href="javascript:void(0);">
												<img src="<?=str_replace('public://', '/rrhh/sites/default/files/', $value['Imágen Impacto']['#item']['uri'])?>" />
												<div class="video-bg"></div>
											</a>
											<?php $string_videos .= 
												'<div class="popup" id="popup_video'.$contador.'">
													<div class="popup-body">
													<span class="popup-exit"></span>
														<div class="popup-content">
															<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$value['Video ID (Youtube)']['#markup'].'?rel=0&showinfo=0&enablejsapi=1" frameborder="0" allowfullscreen></iframe>
														</div>
													</div>
												</div>'; 
											?>
										<?php } else{ ?>
											<img src="<?=str_replace('public://', '/rrhh/sites/default/files/', $value['Imágen Impacto']['#item']['uri'])?>" />
										<?php } 
									} ?>
								</div>
								<div class="w-col w-col-5 txtleft">
									
									<?php if(isset($value['Titulo de Impacto']['#markup'])){ ?><h2><?=$value['Titulo de Impacto']['#markup']?></h2><?php } ?>
									<?php if(isset($value['Detalle de Impacto']['#markup'])){ ?><p><?=$value['Detalle de Impacto']['#markup']?></p><?php } ?>
								</div>							
								
							</div>
					<?php
		        		}
		        		$contador += 1;
		    		} ?>
	    	</div>
	    </div>
	<?php } ?>


</div>


<?php
		/*

		Esto se hizo para que en Nicaragua salgan los mismos testimonios del home mientras envían contenido -
			Hecho por Keylor Mora
			15 enero 2016
		*/

		if($nid_copia==9){
			require_once 'bloques/testimonios.php';
		}else{
			require_once 'bloques/testimonios_presencia_regional.php';
		}
 ?>
<?php require_once 'bloques/bloque_parte_del_cambio.php';?>



<div class="w-section st-otros-paises">
	<div class="w-container">
		<?php 

			$otros_paises = $this->cache->get('paises-todos');
			if(!$otros_paises){
				$otros_paises = $this->general->getJSON('/rrhh/api/paises/paises-todos.json');
				$this->cache->write($otros_paises, 'paises-todos');
			}	


		?>

		<h2>El trabajo de BAC | Credomatic en <strong>otros países de la región</strong></h2>
    
    	<ul class="otros-paises">
			<?php
				
				foreach($otros_paises['results'] as $key => $value2){
					extract($value2);
					if($nid==$nid_copia){
						echo '<li><img src="'.$field_bandera_1.'" /></li>';
					}else{
						echo '<li><a href="/presencia-regional/'.$this->general->formatURL($title).'/'.$nid.'"><img src="'.$field_bandera.'" /></a></li>';
					}
				}
            
            ?>        
        </ul>


	</div>
</div>
<div class="submenu-paises">
	<ul class="submenu-paises-detalle">

		<li><a class="subm opt1" href="#datos-numericos-pais">BAC | Credomatic <br>en <?=$titulo_copia?></a></li>
		<li><a class="subm opt2" href="#impacto-positivo-pais">¿Cómo impactamos <br>positivamente la vida de <br>nuestros trabajadores?</a></li>
		<?php if((isset($testim['results'])) and (!empty($testim['results']))){?>
		<li><a class="subm opt3" href="#testimonios-pais-detalle">¿Por qué trabajar en <br>BAC | Credomatic?</a></li>
		<?php }?>
		<li><a class="subm opt4" href="#empleos-disponibles">Empleos disponibles <br>en <?=$titulo_copia?></a></li>

	</ul>
</div>
<?=$string_videos?>
<div class="popup-overlay"></div>