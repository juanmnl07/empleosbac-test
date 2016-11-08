<div class="w-section aplicante-detalle">
    <div class="w-container">
    	<h1>Personas Registradas</h1>


        <?php if($this->session->userdata('aplicantes')['tipo'] == 'general'): ?>
           <a class="btn_atras" href="/admin/aplicantes/">Volver al listado</a>
        <?php else: ?>
            <a class="btn_atras" href="/admin/aplicantes/por-puesto/<?php echo $this->session->userdata('aplicantes')['id-puesto']?>">Volver al listado</a>
        <?php endif; ?>


    	<?php 
            $value_aplicante_anterior = 0;
            $value_aplicante_siguiente = 0;

            if(isset($aplicante_id)){
                $current_aplicante_key = array_search($aplicante_id, $lista_ids_aplicantes);
                if($current_aplicante_key!==null){
                    if($current_aplicante_key > 0){
                        $value_aplicante_anterior = $lista_ids_aplicantes[$current_aplicante_key-1];
                    }
                    if($current_aplicante_key < (count($lista_ids_aplicantes)-1)){
                        $value_aplicante_siguiente = $lista_ids_aplicantes[$current_aplicante_key+1];
                    }
                }
            }
            //var_export($lista_ids_aplicantes);
        ?>


        <div class="paginacion_detalle_aplicante">
        
        <div class="pagcontent">
            <?php if ($value_aplicante_anterior > 0){ ?>
                <a class="btn_aplicante_anterior" href="/admin/aplicantes/detalle/<?=$value_aplicante_anterior?>">Anterior</a>
            <?php }

            if ($value_aplicante_siguiente > 0){ ?>
                <a class="btn_aplicante_siguiente" href="/admin/aplicantes/detalle/<?=$value_aplicante_siguiente?>">Siguiente</a>
            <?php } ?>
        </div>

        
        </div>

    	

    		<h2><?php if (isset($informacion_aplicante->item->field_nombre_y_apellidos)) {
    				echo $informacion_aplicante->item->field_nombre_y_apellidos;
    			}?>
    		</h2>

    	<div class="w-row aplicante-detalle-wrapper">
    		<div class="w-col w-col-3 aplicante-detalle-sidebar">
    			<div class="aplicante-image">
    				<?php 
    					$imagen_perfil = "/rrhh/sites/default/files/pictures/avatar-no.jpg";

    					if(!empty($informacion_aplicante->item->field_imagen_perfil)){
				        	$imagen_perfil = str_replace("public://", '', (string)$informacion_aplicante->item->field_imagen_perfil);
				        	$imagen_perfil = str_replace(".jpg", '_thumb.jpg', $imagen_perfil);
				        	$imagen_perfil = '/rrhh/sites/default/files/uploads/'.$imagen_perfil;
				        }
    				?> 
    				<img style='width:100%;' src='<?=$imagen_perfil?>' />
    			</div>
    			<div class="aplicante-name"><p><?=$informacion_aplicante->item->field_nombre_y_apellidos;?></p></div>
    			<div class="aplicante-info-contacto"><strong>Información de contacto</strong>
                 
    				<!--<div class="aplicante-pais-trabajo">
    					<ul>
    						<?php 
    						if(isset($informacion_aplicante->item->field_pais_trabajar)){
    							foreach($informacion_aplicante->item->field_pais_trabajar->item as $key => $value){
	    							echo '<li>'.$value.'</li>';

	    						}
    						}
    						?>
    					</ul>
    				</div>-->
    				<div class="aplicante-nacionalidad"><p><?=$informacion_aplicante->item->field_nacionalidad;?></p></div>
    				<div class="aplicante-edad"><p>
    					<?php 
    						//fecha actual
    						if (isset($informacion_aplicante->item->field_fecha_de_nacimiento)){
    							$dia=date("d");
								$mes=date("m");
								$ano=date("Y");

								//fecha de nacimiento
								$fecha_nac = date_create_from_format('d/m/Y', $informacion_aplicante->item->field_fecha_de_nacimiento);

if($fecha_nac){
                                    $dianaz=$fecha_nac->format('j');
                                    $mesnaz=$fecha_nac->format('n');
                                    $anonaz=$fecha_nac->format('Y');
                                    
                                    //si el mes es el mismo pero el día inferior aun no ha cumplido años, le quitaremos un año al actual

                                    if (($mesnaz == $mes) && ($dianaz > $dia)) {
                                    $ano=($ano-1); }

                                    //si el mes es superior al actual tampoco habrá cumplido años, por eso le quitamos un año al actual

                                    if ($mesnaz > $mes) {
                                    $ano=($ano-1);}

                                    //ya no habría mas condiciones, ahora simplemente restamos los años y mostramos el resultado como su edad

                                    $edad=($ano-$anonaz);
                                    print $edad. " años";
                                }else{
                                    print $informacion_aplicante->item->field_fecha_de_nacimiento;
                                }

								
								
    						}
							
    					?>
    					</p>
    				</div>
    				<div class="aplicante-telefono"><p><?php if (isset($informacion_aplicante->item->field_telefono)){ echo $informacion_aplicante->item->field_telefono; }?></p></div>
    				<div class="aplicante-correo"><p><?php if (isset($informacion_aplicante->item->mail)){ echo '<a href="mailto:'.$informacion_aplicante->item->mail.'">'.$informacion_aplicante->item->mail.'</a>'; }?></p></div>

                    <div class="aplicante-estado-civil"><p><?php if (isset($informacion_aplicante->item->field_estado_civil)){ 
                        $value = (!empty($informacion_aplicante->item->field_estado_civil)) ? $informacion_aplicante->item->field_estado_civil : 'sin especificar';
                        echo $value; }?></p>
                    </div>
                    <div class="aplicante-discapacidad"><p><?php if (isset($informacion_aplicante->item->field_discapacidad)){ 
                        $value = (!empty($informacion_aplicante->item->field_discapacidad)) ? $informacion_aplicante->item->field_discapacidad : 'sin especificar';
                        echo $value; }?></p>
                    </div>

    			</div>
    			<div class="aplicante-estudios">
    				<strong>Estudios Académicos</strong>
    				<div class="aplicante-estudios-detalle">
    				    <b>Mayor grado académico </b>
	    					<?php if (isset($informacion_aplicante->item->field_nivel_academico)){ 
	    						echo '<p>'.$informacion_aplicante->item->field_nivel_academico.'</p>'; 
	    					}?>
	    				<b>Profesión u oficio </b>
	    					<?php if (isset($informacion_aplicante->item->field_profesion)){ 
	    						echo '<p>'.$informacion_aplicante->item->field_profesion.'</p>'; 
	    					}?>
	    			</div>
    			</div>
    			<div class="aplicante-idiomas">
    				<strong>Idiomas y porcentaje de manejo</strong>
    				<div class="aplicante-idiomas-detalle">
                        <ul>
    					<?php 
    						if(isset($informacion_aplicante->item->field_idiomas)){
    							foreach($informacion_aplicante->item->field_idiomas->item as $key => $value){
    								 							
	    							echo '<li><b>'.$value->Idioma->_title.'</b> <span>'.$value->Porcentaje->_markup.'%</span></li>';
                                    //print_r($value->Idioma->_title);
	    						}
    						}
    					?>
    					</ul>
	    			</div>
    			</div>
    			<div class="aplicante-areas-interes">
    				<strong>Áreas en las que desea laborar</strong>
    				<div class="aplicante-areas-interes-detalle">
                        <ul>
    					<?php 
    						if(isset($informacion_aplicante->item->field_carrera_para_aplicar)){
    							foreach($informacion_aplicante->item->field_carrera_para_aplicar->item as $key => $value){
    								 							
	    							echo '<li><p>'.$value.'</p></li>';

	    						}
    						}
    					?>
    					</ul>
	    			</div>
    			</div>

                <div class="aplicante-ha-trabajado-en-bac"><b>¿Ha trabajado en algún momento en BAC|Credomatic?</b> <?php if (isset($informacion_aplicante->item->field_trabajo_anteriormente_bac)){ 
                    $value = (!empty($informacion_aplicante->item->field_trabajo_anteriormente_bac)) ? $informacion_aplicante->item->field_trabajo_anteriormente_bac : 'sin especificar';
                    echo "<p>" . $value . "</p>"; }?>
                </div>

    			<div class="aplicante-paises-interes">
    				<strong>Paises donde quiere trabajar</strong>
    				<div class="aplicante-paises-interes-detalle">
    					<ul>
	    					<?php 
	    						if(isset($informacion_aplicante->item->field_pais_trabajar)){
	    							foreach($informacion_aplicante->item->field_pais_trabajar->item as $key => $value){
		    							echo '<li><p>'.$value.'</p></li>';

		    						}
	    						}
    						?>
    					</ul>
	    			</div>
    			</div>
    		</div>
    		<div class="w-col w-col-9">
   
            <div class="aplicante-detalle-content">    
    			<div class="aplicante-cualidades">
    				<h4>¿Cuales son sus cualidades como persona y trabajador?</h4>
    				<div class="aplicante-cualidades-detalle">
    					<p>
	    					<?php 
	    						if(isset($informacion_aplicante->item->field_cualidades)){
	    							echo $informacion_aplicante->item->field_cualidades;
	    						}
    						?>
    					</p>
	    			</div>
    			</div>
    			<div class="aplicante-ventaja-competitiva">
    				<h4>¿Por qué es una ventaja competitiva para BAC | Credomatic?</h4>
    				<div class="aplicante-ventaja-competitiva-detalle">
    					<p>
	    					<?php 
	    						if(isset($informacion_aplicante->item->field_ventaja_competitiva)){
	    							echo $informacion_aplicante->item->field_ventaja_competitiva;
	    						}
    						?>
    					</p>
	    			</div>
    			</div>
    			<?php
					if(!empty($informacion_aplicante->item->field_curriculum)){ 
                        $nameCurriculumArray = explode('/', $informacion_aplicante->item->field_curriculum);
                        $limit = count($nameCurriculumArray);
                        $curriculum = $nameCurriculumArray[$limit-1];
                        $pos = strpos($curriculum, '_.txt');
                        if($pos == true){
                            $curriculum = str_replace('_.txt', '', $curriculum);
                        } 
						$url_cv = '/rrhh/sites/default/files/uploads/'.$curriculum;
                        ?>
						<div class="aplicante-cv">
		    				<a href="<?=$url_cv;?>" download>Descargar Currículum Vitae</a>
		    			</div>

				<?php } ?>
                <hr>    
				<?php 
					if(isset($informacion_aplicante->item->field_elances)){ ?>
					<div class="aplicante-referencias">
						<h4>Mis sitios / Mis referencias </h4>
						<?php foreach($informacion_aplicante->item->field_elances->item as $key => $value){
							if(!strpos($value,"http://") and !strpos($value,"https://")){
								$formatted_url= "http://".$value;
								echo "<a href='".$formatted_url."' target='_blank'>".$value."</a><br />";
							}else{
								echo "<a href='".$value."' target='_blank'>".$value."</a><br />";
							}
							
						}
						?>
					</div>

				<?php } ?>
                <hr>




    		</div> 
            
            <p>&nbsp</p>

            <div class="puestos_aplicados">    
                <!-- puestos aplicados -->
                <?php if(isset($puestos_aplicados)){
                    echo $puestos_aplicados;
                }?>
            </div> 



    		</div>
    	</div>
    </div>
</div>
