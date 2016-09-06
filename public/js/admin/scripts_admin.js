$(document).ready(function(){


/*****************************************/
/*****************************************/



/*************** FILTRADO Puestos Admin ****************/
/*****************************************/
	
	var formfilterAdmin = $("#form_filtrado_puestos_admin");
	jQuery.fn.extend({
	  sendAjaxAdmin: function() {
		$(".as_tabs li").removeClass('selectopc');
        $(".tab-content").each(function (index){
        	var id = $(this).attr('id');
        	if($("#"+id+" input:checked" ).length > 0 || ($("#"+id+" input[type=text]").val() != '' && $("#"+id+" input[type=text]").val() != undefined)){
        		$(".as_tabs li[data-tab="+id+"]").addClass('selectopc');
        	}
        });

	  	$(".paginacionhtml").html('');
		var tabla = $(".filtro_puestos.filtro_puestos_admin tbody");  
		tabla.html('<tr style="height: 752px;"><td colspan="6" style="height: 752px;" valign="middle"><center><img src="/public/images/loader.gif" /></center></td></tr>');
		var fm = $(this);
		var form = fm[0];
		var formData = new FormData(form);

		$.ajax({
			method: "POST",
			url:"/ajax/queryFilterAdmin",
			data: formData,
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false
		})
		.done(function(data) {
			var html  = '';
			var pages = '';	
			var datos = data;
			//var metas = data.metadata;
			$.each(datos.items, function(i,item){
				//console.log(datos.items);

				var nombre_y_apellidos ="";
				var total_aplicantes = "0";

				if(datos.items[i].field_nombre_y_apellidos_value !== null ){
					nombre_y_apellidos = datos.items[i].field_nombre_y_apellidos_value;
				}

				if(datos.items[i].count_aplicantes !== null ){
					total_aplicantes = datos.items[i].count_aplicantes;
				}
				var cuerpo = "";
				if(datos.items[i].body_value !== null){
					var cuerpo = datos.items[i].body_value.replace(/<\/?[^>]+>|$/g, "");	
				}
				
				cuerpo = cuerpo.substr(0,70);
				html += '<tr>';
				if(total_aplicantes!="0"){
					//html += '<td><a href="/admin/aplicantes/por-puesto/'+datos.items[i].nid+'">'+datos.items[i].title+'</a></td>'; ####Ajustar cuando exista la funcionalidad de llevar al detalle de edicion del puesto
					//html += '<td><a target="_blank" href="/puestos/' + $.formatURL(datos.items[i].title)+'/'+datos.items[i].nid +'">'+datos.items[i].title+'</a> <a class="editar-nodo-link" href="/rrhh/node/'+datos.items[i].nid+'/edit/" target="_blank"></a></td>';
					html += '<td><a href="/rrhh/node/'+datos.items[i].nid+'/edit/">'+datos.items[i].title+'</a> <a class="editar-nodo-link" href="/rrhh/node/'+datos.items[i].nid+'/edit/" target="_blank"></a></td>';
				}else{
					//html += '<td>'+datos.items[i].title+'</td>';
					//html += '<td><a target="_blank" href="/puestos/' + $.formatURL(datos.items[i].title)+'/'+datos.items[i].nid +'">'+datos.items[i].title+'</a> <a class="editar-nodo-link" href="/rrhh/node/'+datos.items[i].nid+'/edit/" target="_blank"></a></td>';
					html += '<td><a href="/rrhh/node/'+datos.items[i].nid+'/edit/">'+datos.items[i].title+'</a> <a class="editar-nodo-link" href="/rrhh/node/'+datos.items[i].nid+'/edit/" target="_blank"></a></td>';
				}
				
				html += '<td>'+cuerpo+'</td>\
						<td>'+datos.items[i].pais_entidad_title+'</td>\
						<td>'+datos.items[i].field_fecha_de_cierre_de_oferta_value.replace(' 00:00:00','')+'</td>\
						<td>'+nombre_y_apellidos+'</td>';
						

				if(total_aplicantes!="0"){
					html += '<td><a href="/admin/aplicantes/por-puesto/'+datos.items[i].nid+'">'+total_aplicantes+'</a></td>';
				}else{
					html += '<td>'+total_aplicantes+'</td>';
				}

				var estado = "<div class='estado-inactivo'>Inactivo</div>";

					if (datos.items[i].status == "1"){
						estado = "<div class='estado-activo'>Activo</div>";
					}

					html +='<td>'+estado+'</td></tr>';
						
			});
			
			var i = parseFloat($('#inppage').val());
			var total = datos.total_pages;
			
			
			if(i>0){
				pages += '<li class="pg_first"><a href="javascript:void(0);" data-id="0">&laquo;</a></li>';	
			}
			pages += jQuery.pages({
				total: total,
				page: i
			});
			if(i<datos.total_pages){
				pages += '<li class="pg_last"><a href="javascript:void(0);" data-id="'+datos.total_pages+'">&raquo;</a></li>';
			}
			
			if(pages!=""){
				pages = '<ul class="paginacion paginacion-filtrado-admin">'+pages+'</ul>';
			}
			

			$(".paginacionhtml").html(pages);
			$(".infopaginacion-admin").html('<p>'+datos.display_start+'-'+datos.display_end+' de '+datos.total_results+' puestos disponibles</p>');
			tabla.html(html);

			$('.loader-general').css('display', 'none');

		
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			console.log(jqXHR);
			console.log(textStatus);
			console.log(errorThrown);			
			//alert('Error');
			$('.loader-general').css('display', 'none');
		})

		/*
		.always(function() {
			alert( "complete" );
		})*/;		  
	  }
	});

/*************** Ejecuta todo el ajax del dashboard ****************/
/*****************************************/
	
	var formfilterAdminDashboard = $("#form_filtrado_dashboard");
	jQuery.fn.extend({
	  sendAjaxAdminDashboard: function() {

		/*************** Ajax para la info general del dashboard ****************/
		/*****************************************/

		var contenedor_aplicantes = $(".dashboard-datos-generales-container .total-aplicantes-detalle");
		var contenedor_puestos = $(".dashboard-datos-generales-container .total-puestos-detalle");  
		var contenedor_personas = $(".dashboard-datos-generales-container .total-personas-detalle");    

		var fm = $(this);
		var form = fm[0];
		var formData = new FormData(form);	
			
					
		$.ajax({
			method: "POST",
			url:"/ajax/queryDashboardGeneralInfo",
			data: formData,
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false
		})
		.done(function(data) {
			var html  = '';
			var pages = '';	
			var datos = data;

			$(contenedor_puestos).html(datos.total_puestos);
			$(contenedor_personas).html(datos.total_personas);
			$(contenedor_aplicantes).html(datos.total_aplicantes);
			



			/*************** Ajax para la listado de puestos del dashboard ****************/
			/*****************************************/

			var tabla1 = $(".filtro_puestos.filtro_puestos_dashboard tbody");  
			tabla1.html('<tr style="height: 308px;"><td colspan="5" style="height: 308px;" valign="middle"><center><img src="/public/images/loader.gif" /></center></td></tr>');
							
			$.ajax({
				method: "POST",
				url:"/ajax/queryFilterAdminDashboard",
				data: formData,
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false
			})
			.done(function(data) {
				//console.log(data);
				var html  = '';
				var pages = '';	
				var datos = data;
				//var metas = data.metadata;
				$.each(datos.items, function(i,item){
					//console.log(datos.items);

					var total_aplicantes = "0";
					

					if(datos.items[i].count_aplicantes !== null ){
						total_aplicantes = datos.items[i].count_aplicantes;
					}
					
					html += '<tr>';
					if(total_aplicantes!="0"){
						//html += '<td><a href="/admin/aplicantes/por-puesto/'+datos.items[i].nid+'">'+datos.items[i].title+'</a><br /><span>'+datos.items[i].carrera_entidad_title+'</span></td>'; ####Ajustar cuando exista la funcionalidad de llevar al detalle de edicion del puesto
						//html += '<td><a target="_blank" href="/puestos/' + $.formatURL(datos.items[i].title)+'/'+datos.items[i].nid +'">'+datos.items[i].title+'</a><span>'+datos.items[i].carrera_entidad_title+'</span></td>';
						html += '<td><a href="/rrhh/node/'+datos.items[i].nid+'/edit/">'+datos.items[i].title+'</a><span>'+datos.items[i].carrera_entidad_title+'</span></td>';
					}else{
						//html += '<td>'+datos.items[i].title+'<br /><span>'+datos.items[i].carrera_entidad_title+'</span></td>';
						//html += '<td><a target="_blank" href="/puestos/' + $.formatURL(datos.items[i].title)+'/'+datos.items[i].nid +'">'+datos.items[i].title+'</a><span>'+datos.items[i].carrera_entidad_title+'</span></td>';
						html += '<td><a href="/rrhh/node/'+datos.items[i].nid+'/edit/">'+datos.items[i].title+'</a><span>'+datos.items[i].carrera_entidad_title+'</span></td>';
					}


					//var zona = datos.items[i].field_zona_value.substr(0,70);
					var date = new Date(datos.items[i].created * 1000);
					var year = date.getFullYear();
					var months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'];
					var month = months[date.getMonth()];
					var day = date.getDate();
					var fecha_creacion = day + ' de ' + month + ' del ' + year;



					html += '<td><strong>'+datos.items[i].pais_entidad_title+'</strong></td>\
							<td>'+fecha_creacion+'</td>';

					if(total_aplicantes!="0"){
						html += '<td><a href="/admin/aplicantes/por-puesto/'+datos.items[i].nid+'">'+total_aplicantes+'</a></td>';
					}else{
						html += '<td>'+total_aplicantes+'</td>';
					}

					var estado = "<div class='estado-inactivo'>Inactivo</div>";

					if (datos.items[i].status == "1"){
						estado = "<div class='estado-activo'>Activo</div>";
					}

					html +='<td>'+estado+'</td></tr>';
							
					
					
					tabla1.html(html);		
				});



				/*************** Ajax para la listado de personas del dashboard ****************/
				/*****************************************/
				/*var tabla2 = $(".filtro_puestos.tabla_personas_admin tbody");  
				tabla2.html('<tr style="height: 308px;"><td colspan="5" style="height: 308px;" valign="middle"><center><img src="/public/images/loader.gif" /></center></td></tr>');
				
				$.ajax({
					url:"/admin/listado/bitacora",			
				})
				.done(function(lista_estados) {
					
					


					$.ajax({
						method: "POST",
						url:"/ajax/queryPersonasDashboard",
						data: formData,
						dataType: 'json',
						cache: false,
						contentType: false,
						processData: false
					})
					.done(function(data) {
						var html  = '';
						
						var datos = data;
						if(datos.total_aplicantes == 0){
							tabla2.html('<tr style="height: 60px;"><td class="empty-table" colspan="5" style="height: 60px;" valign="middle"><center>No hay personas registradas para el país seleccionado</center></td></tr>');
						}else{
							//var metas = data.metadata;
						$.each(datos.items, function(i,item){
							//console.log(datos.items);

							//nombre de la persona
							html += '<tr class="persona-id-'+datos.items[i].uid+'"><td><a href="/admin/aplicantes/detalle/' +datos.items[i].uid +'">'+datos.items[i].field_nombre_y_apellidos_value+'</a></td>';
							
							//puesto
							if(datos.items[i].title !== null){
								html+= '<td><a target="_blank" href="/puestos/' + $.formatURL(datos.items[i].title)+'/'+datos.items[i].nid_puesto +'">'+datos.items[i].title+'</a></td>';
							}else{
								html += '<td></td>';
							}
							
							//nacionalidad
							html+= '<td>'+datos.items[i].name+'</td>';

							//estado
							if(datos.items[i].tid_estado !== null){
								
								var select = '<select id="select-cambia-estado-persona-dashboard" data-aplicante="'+datos.items[i].uid+'" data-puesto="'+datos.items[i].nid_puesto+'">';
								var option = '';
								

								for (var j = 0; j < lista_estados.item.length; j++) {
									var selected = '';
									
									if(lista_estados.item[j].tid == datos.items[i].tid_estado ){
										selected += 'selected';
									}
									option += '<option value="'+lista_estados.item[j].tid+'" '+selected+'>'+lista_estados.item[j].name+'</option>';
								};
								select += option+'</select><div class="loader" style="display: none;"></div>';
								html += '<td>'+select+'</td>';
							}else{
								html += '<td></td>';
							}
							
							
							//fecha
							var date = new Date(datos.items[i].created * 1000);
							var year = date.getFullYear();
							var months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'];
							var month = months[date.getMonth()];
							var day = date.getDate();
							var fecha_creacion = day + ' de ' + month + ' del ' + year;

							html += '<td>'+fecha_creacion+'</td></tr>';

							

							
									

							
							tabla2.html(html);		
						});
						}
						
						$('.loader-general').css('display', 'none');			
					
					
					
					})
					.fail(function(jqXHR, textStatus, errorThrown) {
						console.log(jqXHR);
						console.log(textStatus);
						console.log(errorThrown);			
						//alert('Error');
						$('.loader-general').css('display', 'none');	
					});
				})
				.fail(function(jqXHR, textStatus, errorThrown) {
					console.log(jqXHR);
					console.log(textStatus);
					console.log(errorThrown);			
					//alert('Error');
					$('.loader-general').css('display', 'none');	
				});	*/
			
			
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);			
				//alert('Error');
				$('.loader-general').css('display', 'none');	
			});
		
		
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			console.log(jqXHR);
			console.log(textStatus);
			console.log(errorThrown);			
			//alert('Error');
			$('.loader-general').css('display', 'none');	
		})

		
		/*.always(function() {
			
		})*/;	  


		//('.loader-general').css('display', 'none');
	  }
	});

/*************** Ejecuta todo el ajax del dashboard ****************/
/*****************************************/
	
	var formFilterAplicantes = $("#filtro-aplicante.filtro-aplicantes-general");
	jQuery.fn.extend({
	  sendAjaxAdminAplicantesGeneral: function() {	



		/*************** Ajax para la listado de puestos del dashboard ****************/
		/*****************************************/
		$(".paginacionhtml").html('');
		var tabla1 = $(".filtro_puestos_aplicados.tabla-aplicantes-general tbody");  
		tabla1.html('<tr style="height: 308px;"><td colspan="5" style="height: 308px;" valign="middle"><center><img src="/public/images/loader.gif" /></center></td></tr>');
		
		var fm = $(this);
		var form = fm[0];
		var formData = new FormData(form);

		$.ajax({
			method: "POST",
			url:"/ajax/queryFilterAdminAplicantesGeneral",
			data: formData,
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false
		})
		.done(function(data) {
			//console.log(data);
			var html  = '';
			var pages = '';	
			var datos = data;
			//var metas = data.metadata;

			if (datos.total_results>0){
				$.each(datos.items, function(i,item){
					//console.log(datos.items);

					var total_puestos = "0";
					

					if(datos.items[i].count_puestos !== null ){
						total_puestos = datos.items[i].count_puestos;
					}

					var imagen_perfil = "/rrhh/sites/default/files/pictures/avatar-no.jpg";

					if(datos.items[i].uri !== null){
			        	imagen_perfil = datos.items[i].uri.replace("public://", '');
			        	imagen_perfil = imagen_perfil.replace(".jpg", '_thumb.jpg');
			        	imagen_perfil = '/rrhh/sites/default/files/uploads/'+imagen_perfil;
				    }
					
					html += '<tr class="persona-id-'+datos.items[i].uid+'">';
					if(datos.items[i].field_nombre_y_apellidos_value !== null){
						
						html += '<td class="aplicante-nombre"><a href="/admin/aplicantes/detalle/'+ datos.items[i].uid +'"><img style="width:65px;" src="' + imagen_perfil +'" /></a><a href="/admin/aplicantes/detalle/' + datos.items[i].uid+'">'+datos.items[i].field_nombre_y_apellidos_value+'</a></td>';
					}else{

						html += '<td class="aplicante-nombre"><a href="/admin/aplicantes/detalle/'+ datos.items[i].uid +'"><img style="width:65px;" src="' + imagen_perfil +'" /></a><a href="/admin/aplicantes/detalle/' + datos.items[i].uid +'">'+datos.items[i].name+'</a></td>';
					}
					if(total_puestos>0){
						html += '<td class="aplicante-puestos-aplicados"><a href="javascript:void(0);"  data-popup-target="#popup_aplicantes" data-aplicante="' + datos.items[i].uid + '" class="ver-listado-puestos-aplicados"><b>' +total_puestos+ '</b></a><div class="listado-puestos-aplicados popup" id="popup_aplicantes"><div class="popup-body"><span class="popup-exit"></span><div class="popup-content">\
						<form id="form_puestos_por_aplicante_'+ datos.items[i].uid +'" class="form_puestos_por_aplicante"><input type="hidden" value="'+ datos.items[i].uid +'" name="uid" id="uid" /></form>\
						<table width="100%" border="0" cellpadding="2" cellspacing="1" class="filtro_puestos_aplicados tabla_puestos_aplicados_aplicante">\
						    <thead><tr><th>Puesto</th><th>Estado</th></tr></thead><tbody></tbody>\
						</table>\
						</div></div></div></td>';					
					}else{
						html += '<td class="aplicante-puestos-aplicados"><b>'+total_puestos+ '</b></td>';
					}

					
					var fechaActual = new Date()
					var diaActual = fechaActual.getDate();
					var mmActual = fechaActual.getMonth() + 1;
					var yyyyActual = fechaActual.getFullYear();
					FechaNac = datos.items[i].field_fecha_de_nacimiento_value.split("/");
					var edad = 0;

					/*se anadio este validador para comprobar que la fecha venga en el formato deseado*/
					if(FechaNac[0] && FechaNac[1] && FechaNac[2]){
						var diaCumple = FechaNac[0];
						var mmCumple = FechaNac[1];
						var yyyyCumple = FechaNac[2];
						//retiramos el primer cero de la izquierda
						if (mmCumple.substr(0,1) == 0) {
							mmCumple= mmCumple.substring(1, 2);
						}
						//retiramos el primer cero de la izquierda
						if (diaCumple.substr(0, 1) == 0) {
							diaCumple = diaCumple.substring(1, 2);
						}
						edad = yyyyActual - yyyyCumple;

						//validamos si el mes de cumpleaños es menor al actual
						//o si el mes de cumpleaños es igual al actual
						//y el dia actual es menor al del nacimiento
						//De ser asi, se resta un año
						if ((mmActual < mmCumple) || (mmActual == mmCumple && diaActual < diaCumple)) {
							edad--;
						}	
					}
					



					html += '<td>'+edad+'</td>';

					if(datos.items[i].nacionalidad_name!==null){
						html += '<td>'+datos.items[i].nacionalidad_name+'</td>';
					}else{
						html += '<td></td>';
					}

					var date = new Date(datos.items[i].created * 1000);
					var year = date.getFullYear();
					var months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'];
					var month = months[date.getMonth()];
					var day = date.getDate();
					var fecha_creacion = day + ' de ' + month + ' del ' + year;

					html += '<td>'+fecha_creacion+'</td></tr>';
					
							
					
					
					
					
					
					tabla1.html(html);		
				});

			}else{
				html += '<tr style="height: 60px;"><td colspan="5" style="height: 60px;" valign="middle"><center>No hay aplicantes que se ajusten al filtrado realizado</center></td></tr>'
				tabla1.html(html);
			}
			
			var i = parseFloat($('#inppage').val());
			var total = datos.total_pages;

			if(total>0){
				if(i>0){
					pages += '<li class="pg_first"><a href="javascript:void(0);" data-id="0">&laquo;</a></li>';	
				}
				pages += jQuery.pages({
					total: total,
					page: i
				});
				if(i<datos.total_pages){
					pages += '<li class="pg_last"><a href="javascript:void(0);" data-id="'+datos.total_pages+'">&raquo;</a></li>';
				}
				
				if(pages!=""){
					pages = '<ul class="paginacion paginacion-filtrado-aplicantes">'+pages+'</ul>';
				}
				

				$(".paginacionhtml").html(pages);
			}
			
			$('.loader-general').css('display', 'none');		
			
			
		
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			console.log(jqXHR);
			console.log(textStatus);
			console.log(errorThrown);			
			//alert('Error');
			$('.loader-general').css('display', 'none');	
		});
		
		
			  


		//('.loader-general').css('display', 'none');
	  }
	});
	
	var formFilterAplicantesPorPuesto = $("#filtro-aplicante.filtro-aplicantes-por-puesto");
	jQuery.fn.extend({
	  sendAjaxAdminAplicantesPuesto: function() {	



		/*************** Ajax para la listado de puestos del dashboard ****************/
		/*****************************************/
		$(".paginacionhtml").html('');
		var tabla1 = $(".filtro_puestos_aplicados.tabla-aplicantes-por-puesto tbody");  
		tabla1.html('<tr style="height: 308px;"><td colspan="5" style="height: 308px;" valign="middle"><center><img src="/public/images/loader.gif" /></center></td></tr>');
		
		var fm = $(this);
		var form = fm[0];
		var formData = new FormData(form);
		$.ajax({
			url:"/admin/listado/bitacora",			
		})
		.done(function(lista_estados) {
			$.ajax({
				method: "POST",
				url:"/ajax/queryFilterAdminAplicantesPuesto",
				data: formData,
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false
			})
			.done(function(data) {
				//console.log(data);
				var html  = '';
				var pages = '';	
				var datos = data;
				//var metas = data.metadata;

				if (datos.total_results>0){
					$.each(datos.items, function(i,item){
						//console.log(datos.items);

						var total_puestos = "0";
						

						var imagen_perfil = "/rrhh/sites/default/files/pictures/avatar-no.jpg";

						if(datos.items[i].uri !== null){
				        	imagen_perfil = datos.items[i].uri.replace("public://", '');
				        	imagen_perfil = imagen_perfil.replace(".jpg", '_thumb.jpg');
				        	imagen_perfil = '/rrhh/sites/default/files/uploads/'+imagen_perfil;
					    }
						
						html += '<tr class="persona-id-'+datos.items[i].uid+'">';
						if(datos.items[i].field_nombre_y_apellidos_value !== null){
							
							html += '<td class="aplicante-nombre"><a href="/admin/aplicantes/detalle/'+ datos.items[i].uid +'"><img style="width:65px;" src="' + imagen_perfil +'" /></a><a href="/admin/aplicantes/detalle/' + datos.items[i].uid+'">'+datos.items[i].field_nombre_y_apellidos_value+'</a></td>';
						}else{

							html += '<td class="aplicante-nombre"><a href="/admin/aplicantes/detalle/'+ datos.items[i].uid +'"><img style="width:65px;" src="' + imagen_perfil +'" /></a><a href="/admin/aplicantes/detalle/' + datos.items[i].uid +'">'+datos.items[i].name+'</a></td>';
						}
						if(datos.items[i].nivel_academico_taxonomy_name!==null){
							html += '<td class="aplicante-puestos-aplicados">'+datos.items[i].nivel_academico_taxonomy_name+'</td>';
						}else{
							html += '<td class="aplicante-puestos-aplicados"></td>';
						}

						
						var fechaActual = new Date()
						var diaActual = fechaActual.getDate();
						var mmActual = fechaActual.getMonth() + 1;
						var yyyyActual = fechaActual.getFullYear();
						FechaNac = datos.items[i].field_fecha_de_nacimiento_value.split("/");
						var edad = 0;
						/*se anadio este validador para comprobar que la fecha venga en el formato deseado*/
						if(FechaNac[0] && FechaNac[1] && FechaNac[2]){
							var diaCumple = FechaNac[0];
							var mmCumple = FechaNac[1];
							var yyyyCumple = FechaNac[2];
							//retiramos el primer cero de la izquierda
							if (mmCumple.substr(0,1) == 0) {
								mmCumple= mmCumple.substring(1, 2);
							}
							//retiramos el primer cero de la izquierda
							if (diaCumple.substr(0, 1) == 0) {
								diaCumple = diaCumple.substring(1, 2);
							}
							edad = yyyyActual - yyyyCumple;

							//validamos si el mes de cumpleaños es menor al actual
							//o si el mes de cumpleaños es igual al actual
							//y el dia actual es menor al del nacimiento
							//De ser asi, se resta un año
							if ((mmActual < mmCumple) || (mmActual == mmCumple && diaActual < diaCumple)) {
								edad--;
							}	
						}
						
						



						html += '<td>'+edad+'</td>';


						if(datos.items[i].min_fecha!==null){
							var date = new Date(datos.items[i].min_fecha * 1000);
							var year = date.getFullYear();
							var months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'];
							var month = months[date.getMonth()];
							var day = date.getDate();
							var fecha_aplicacion = day + ' de ' + month + ' del ' + year;

						
							html += '<td>'+fecha_aplicacion+'</td>';
						}else{
							html += '<td></td>';
						}

						//estado
						if(datos.items[i].tid_estado !== null){
							
							var select = '<select id="select-cambia-estado-persona-interno" class="listado-aplicantes-por-puesto" data-aplicante="'+datos.items[i].uid+'" data-puesto="'+datos.items[i].nid_puesto+'" data-estado="'+datos.items[i].tid_estado+'">';
							var option = '';
							

							for (var j = 0; j < lista_estados.item.length; j++) {
								var selected = '';
								
								if(lista_estados.item[j].tid == datos.items[i].tid_estado ){
									selected += 'selected';
								}
								option += '<option value="'+lista_estados.item[j].tid+'" '+selected+'>'+lista_estados.item[j].name+'</option>';
							};
							select += option+'</select><div class="loader" style="display: none;"></div>';
							html += '<td>'+select+'</td>';
						}else{
							html += '<td></td>';
						}

						
						
								
						
						
						
						
						
						tabla1.html(html);		
					});

				}else{
					html += '<tr style="height: 60px;"><td colspan="5" style="height: 60px;" valign="middle"><center>No hay aplicantes que se ajusten al filtrado realizado</center></td></tr>'
					tabla1.html(html);
				}
				
				var i = parseFloat($('#inppage').val());
				var total = datos.total_pages;

				if(total>0){
					if(i>0){
						pages += '<li class="pg_first"><a href="javascript:void(0);" data-id="0">&laquo;</a></li>';	
					}
					pages += jQuery.pages({
						total: total,
						page: i
					});
					if(i<datos.total_pages){
						pages += '<li class="pg_last"><a href="javascript:void(0);" data-id="'+datos.total_pages+'">&raquo;</a></li>';
					}
					
					if(pages!=""){
						pages = '<ul class="paginacion paginacion-filtrado-aplicantes">'+pages+'</ul>';
					}
					

					$(".paginacionhtml").html(pages);
				}
				
				$('.loader-general').css('display', 'none');		
				
				
			
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);			
				//alert('Error');
				$('.loader-general').css('display', 'none');	
			});
		
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			console.log(jqXHR);
			console.log(textStatus);
			console.log(errorThrown);			
			//alert('Error');
			$('.loader-general').css('display', 'none');	
		});	
			  


		//('.loader-general').css('display', 'none');
	  }
	});

	jQuery.fn.extend({
	  sendAjaxPuestosAplicadosPorAplicante: function() {	

	  	var tabla1 = $(".filtro_puestos_aplicados.tabla_puestos_aplicados_aplicante tbody");  
		tabla1.html('<tr style="height: 308px;"><td colspan="5" style="height: 308px;" valign="middle"><center><img src="/public/images/loader.gif" /></center></td></tr>');
		
		var fm = $(this);
		var form = fm[0];
		var formData = new FormData(form);
		$.ajax({
			url:"/admin/listado/bitacora",			
		})
		.done(function(lista_estados) {
			$.ajax({
				method: "POST",
				url:"/ajax/queryPuestosAplicadosPorAplicante",
				data: formData,
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false
			})
			.done(function(data) {
				//console.log(data);
				var html  = '';
				var datos = data;
				
				
					$.each(datos.items, function(i,item){
						//console.log(datos.items);
						//obtener el listado de la bitacora
						html +='<tr class="persona-id-'+datos.items[i].uid_aplicante+'">';
						html += '<td class="nombre-puesto-aplicado">'+datos.items[i].title+'<br/>'+datos.items[i].body_value.substr(0,70)+'</td>';
						//estado
						if(datos.items[i].tid_estado !== null){
							
							var select = '<select id="select-cambia-estado-persona-interno" class="popup-puestos-aplicados" data-aplicante="'+datos.items[i].uid_aplicante+'" data-puesto="'+datos.items[i].nid_puesto+'"  data-estado="'+datos.items[i].tid_estado+'">';
							var option = '';
							

							for (var j = 0; j < lista_estados.item.length; j++) {
								var selected = '';
								
								if(lista_estados.item[j].tid == datos.items[i].tid_estado ){
									selected += 'selected';
								}
								option += '<option value="'+lista_estados.item[j].tid+'" '+selected+'>'+lista_estados.item[j].name+'</option>';
							};
							select += option+'</select><div class="loader" style="display: none;"></div>';
							html += '<td class="estado-puesto-aplicado">'+select+'</td>';
						}else{
							html += '<td></td>';
						}
						
						html +="</tr>";

				});

				
				tabla1.html(html);
				
				
			})
				.fail(function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);			
			})
			
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			console.log(jqXHR);
			console.log(textStatus);
			console.log(errorThrown);			
		})
	  }
	});


	
	jQuery.extend({
		formatURL: function(str){

			var from = "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ", 
			    to   = "aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr",
			mapping = {};

			for(var i = 0, j = from.length; i < j; i++ )
				mapping[ from.charAt( i ) ] = to.charAt( i );

			var ret = [];
			for( var i = 0, j = str.length; i < j; i++ ) {
		    	var c = str.charAt( i );
		    	if( mapping.hasOwnProperty( str.charAt( i ) ) )
		        	ret.push( mapping[ c ] );
		    	else
		        	ret.push( c );
			}
			//return ret.join( '' ).replace( /[^-A-Za-z0-9]+/g, '-' ).toLowerCase();
			return ret.join( '' ).replace(/ /g, "-").toLowerCase().replace(/[^a-z0-9-]/g, "-").replace(/[-]+/g, "-");
		}
	});

	jQuery.extend({
		pages: function(d) {
			var pg = ''; var show = 5; var cnt = (d.page-2);
			if(d.total < 5){
				show = d.total+1;
				cnt = 0;
			}
			if(d.total == 5){
				show = d.total;
			}			
			if(d.page == 0){
				cnt = d.page;
			}
			if(d.page == 1){
				cnt = (d.page-1);
			}
								
			for(i=cnt;i<(show+cnt);i++){
				var current = '';
				if(i==d.page)
					current = 'class="current-page"';
				if(i <= d.total)
					pg += '<li '+current+'><a href="javascript:void(0);" data-id="'+i+'">'+(i+1)+'</a></li>';
			}
			return pg;			
		}
	});


//listado puestos aplicados por el usuario
	$(".ver-listado-puestos-aplicados").live("click",function(){
		var uid_aplicante = $(this).attr("data-aplicante");
		$('#form_puestos_por_aplicante_'+uid_aplicante).sendAjaxPuestosAplicadosPorAplicante();
	});

	


	$('[data-popup-target]').live('click',function () {
	  $('html').addClass('overlay');
	  var activePopup = $(this).attr('data-popup-target');
	  var wl = ($(window).width() - $(activePopup).outerWidth())/2;
      var ht = (($(window).height() - $(activePopup).outerHeight())/2)+$(window).scrollTop();
      console.log(wl);
      console.log(ht);
	  $(activePopup).css({top: ht, left: wl}).addClass('visible');
	  var iframe = $(activePopup + ' iframe');
	  if(iframe.length > 0){
	  	var src = $(iframe).attr('src');
	  	var ifr = iframe[0].contentWindow;
	  	ifr.postMessage('{"event":"command","func":"playVideo","args":""}','*');
	  }
	
	});
	
	$(document).live('keyup',function (e) {
	  if (e.keyCode == 27 && $('html').hasClass('overlay')) {
		  clearPopup();
	  }
	});
	
	$('.popup-exit').live('click',function () {
	  clearPopup();
	});
	
	$('.popup-overlay').live('click',function () {
	  clearPopup();
	});
	
	function clearPopup() {
	  $('.popup.visible').addClass('transitioning').removeClass('visible');
	  $('html').removeClass('overlay');

	  var iframe = $('.popup iframe');
	  if(iframe.length > 0){
	  	var ifr = iframe[0].contentWindow; console.log(ifr);
	  	ifr.postMessage('{"event":"command","func":"pauseVideo","args":""}','*');
	  }

	  setTimeout(function () {
		  $('.popup').removeClass('transitioning');
	  }, 200);
	}




	/* Para filtrado en la parte administrativa */


	/*$(formfilterAdmin).change(function(e) {
		e.preventDefault();
		$('#inppage').val('0');
		$(this).sendAjaxAdmin();
	});*/

	$(formfilterAdmin).submit(function(e) {
		e.preventDefault();
		//$(this).sendAjaxAdmin();
	});

	$("#form_filtrado_puestos_admin input[type='text']").keypress(function(e) {		
    	if(e.which == 13) {
			$(formfilterAdmin).sendAjaxAdmin();
		}
	});

	

	$("#form_filtrado_puestos_admin input[type='checkbox']").change(function(e) {
		e.preventDefault();
		$('#inppage').val('0');
		$(formfilterAdmin).sendAjaxAdmin();
	});


	$('.paginacion.paginacion-filtrado-admin li a').live('click', function(){
		var val = $(this).data('id');
		$('#inppage').val(val);
		$(formfilterAdmin).sendAjaxAdmin();
	});


	
	$('.filtrado-admin .orden').click(function(){
		$('#inppage').val('0');
		var val = $(this).data('id');
		$('#inporden').val(val);
		$(formfilterAdmin).sendAjaxAdmin();
	});
	
	$('.reset-admin').click(function(){
		$(formfilterAdmin)[0].reset();
		$(formfilterAdmin).find("input[type=checkbox]").each(function() { this.checked=false; });
		$(formfilterAdmin).sendAjaxAdmin();
	});	

	if($(".filtro_puestos_admin").length > 0){
		$(formfilterAdmin).sendAjaxAdmin();
	}	

		$('.filtrado-admin .mostrarfiltros').click(function(){
		var div = $(".filtrado");
		if(div.hasClass('fclose')){
			div.removeClass('fclose');
			div.addClass('fopen');
		}

	});

	$('.filtrado-admin .ocultarfiltros').click(function(){
		var div = $(".filtrado");
		if(div.hasClass('fopen')){
			div.removeClass('fopen');
			div.addClass('fclose');
		}
	});	


	if(($(".filtro_puestos_dashboard").length > 0) && ($(".dashboard-datos-generales-container").length > 0) && ($(".tabla_personas_admin").length > 0)){
		$(formfilterAdminDashboard).sendAjaxAdminDashboard();
	}

	if(($(".tabla-aplicantes-general").length > 0)){
		$(formFilterAplicantes).sendAjaxAdminAplicantesGeneral();
	}
	if(($(".tabla-aplicantes-por-puesto").length > 0)){
		$(formFilterAplicantesPorPuesto).sendAjaxAdminAplicantesPuesto();
	}		


	$(formFilterAplicantes).submit(function(e) {
		e.preventDefault();
		$('#inppage').val('0');
		$(formFilterAplicantes).sendAjaxAdminAplicantesGeneral();
	});

	$(formFilterAplicantesPorPuesto).submit(function(e) {
		e.preventDefault();
		$('#inppage').val('0');
		$(formFilterAplicantesPorPuesto).sendAjaxAdminAplicantesPuesto();
	});



	$('.paginacion.paginacion-filtrado-aplicantes li a').live('click', function(){
		var val = $(this).data('id');
		$('#inppage').val(val);
		if($('#filtro-aplicante').hasClass('filtro-aplicantes-general')){
			$(formFilterAplicantes).sendAjaxAdminAplicantesGeneral();
		}
		if($('#filtro-aplicante').hasClass('filtro-aplicantes-por-puesto')){
			$(formFilterAplicantesPorPuesto).sendAjaxAdminAplicantesPuesto();
		}
		
	});


	/*************** Ordenar columnas de tablas ****************/
/*****************************************/
	$(".filtro_puestos_admin a.table-order-filter").live('click', function(e){
		e.preventDefault();
		$('input#inp_field_orden').val($(this).attr('data-order-field'));
		$('.filtro_puestos_admin a.table-order-filter').parent('th').removeClass('filtro-asc filtro-desc');

		if($('input#inp_tipo_orden').val()=='asc'){
			$('input#inp_tipo_orden').val('desc');
			$(this).parent('th').addClass('filtro-desc');
		}else{
			$('input#inp_tipo_orden').val('asc');
			$(this).parent('th').addClass('filtro-asc');
		}
		$(formfilterAdmin).sendAjaxAdmin();
	});

	$(".tabla-aplicantes-general a.table-order-filter").live('click', function(e){
		e.preventDefault();
		$('input#inp_field_orden').val($(this).attr('data-order-field'));
		$('.tabla-aplicantes-general a.table-order-filter').parent('th').removeClass('filtro-asc filtro-desc');
		if($('input#inp_tipo_orden').val()=='asc'){
			$('input#inp_tipo_orden').val('desc');
			$(this).parent('th').addClass('filtro-desc');
		}else{
			$('input#inp_tipo_orden').val('asc');
			$(this).parent('th').addClass('filtro-asc');
		}
		$(formFilterAplicantes).sendAjaxAdminAplicantesGeneral();
	});

	$(".tabla-aplicantes-por-puesto a.table-order-filter").live('click', function(e){
		e.preventDefault();
		$('input#inp_field_orden').val($(this).attr('data-order-field'));
		$('.tabla-aplicantes-por-puesto a.table-order-filter').parent('th').removeClass('filtro-asc filtro-desc');

		if($('input#inp_tipo_orden').val()=='asc'){
			$('input#inp_tipo_orden').val('desc');
			$(this).parent('th').addClass('filtro-desc');
		}else{
			$('input#inp_tipo_orden').val('asc');
			$(this).parent('th').addClass('filtro-asc');
		}
		$(formFilterAplicantesPorPuesto).sendAjaxAdminAplicantesPuesto();
	});


	$(".tabla_personas_admin a.table-order-filter").live('click', function(e){
		e.preventDefault();
		//muestra el loader siempre que va a hacer un cambio
		$('.loader-general').css('display', 'block');

		$('input#inp_field_orden_personas').val($(this).attr('data-order-field'));
		$('.tabla_personas_admin a.table-order-filter').parent('th').removeClass('filtro-asc filtro-desc');
		if($('input#inp_tipo_orden_personas').val()=='asc'){
			$('input#inp_tipo_orden_personas').val('desc');
			$(this).parent('th').addClass('filtro-desc');
		}else{
			$('input#inp_tipo_orden_personas').val('asc');
			$(this).parent('th').addClass('filtro-asc');
		}
		$(formfilterAdminDashboard).sendAjaxAdminDashboard();
	});

	

	$(".filtro_puestos_dashboard a.table-order-filter").live('click', function(e){
		e.preventDefault();
		//muestra el loader siempre que va a hacer un cambio
		$('.loader-general').css('display', 'block');

		$('input#inp_field_orden_puestos').val($(this).attr('data-order-field'));
		$('.filtro_puestos_dashboard a.table-order-filter').parent('th').removeClass('filtro-asc filtro-desc');

		if($('input#inp_tipo_orden_puestos').val()=='asc'){
			$('input#inp_tipo_orden_puestos').val('desc');
			$(this).parent('th').addClass('filtro-desc');
		}else{
			$('input#inp_tipo_orden_puestos').val('asc');
			$(this).parent('th').addClass('filtro-asc');
		}
		$(formfilterAdminDashboard).sendAjaxAdminDashboard();
	});






	/*************** Actualiza estado de personas en un puesto en el Dashboard ****************/
/*****************************************/

	$('select#select-cambia-estado-persona-dashboard').live('change', function(){
		var nid_puesto = $(this).attr('data-puesto');
		var uid_aplicante = $(this).attr('data-aplicante');
		var tid_estado = $(this).val();
		$(this).parent().find( ".loader" ).css('display', 'block');
		$(this).parent().find( ".loader" ).html('<center><img src="/public/images/loader.gif" /></center>');
		//enviar los datos al controlador para actualizar los datos del estado
		$.ajax({
			url:'/admin/estado/aplicante/actualizar/'+uid_aplicante+'/'+nid_puesto+'/'+tid_estado,
		})
		.done(function(data) {
			$(".persona-id-"+uid_aplicante+" .loader").html("<div><p>El estado se actualizo satisfactoriamente</p><p><em>El mensaje se ocultara automáticamente</em></p></div>");
			
			setTimeout(function(){ 
				$(".persona-id-"+uid_aplicante+" .loader").css('display', 'none');
				$(".persona-id-"+uid_aplicante+" .loader").html('');
			 }, 5000);			
		});
	});

	/*************** Actualiza estado de personas en un puesto en el Dashboard ****************/
/*****************************************/

	$('select.listado-aplicantes-por-puesto').live('change', function(){
		var nid_puesto = $(this).attr('data-puesto');
		var uid_aplicante = $(this).attr('data-aplicante');		
		var tid_estado_original = $(this).attr('data-estado');
		var tid_estado = $(this).val();
		$(this).parent().find( ".loader" ).css('display', 'block');
		$(this).parent().find( ".loader" ).addClass('cambio-estado').html('<center><img src="/public/images/loader.gif" /></center>');
			
		//mensaje de advertencia
		var mensaje_adv = '';
		if(tid_estado == 28){
			mensaje_adv = '<p>Importante: Has seleccionado agregar al aplicante a la "Lista negra", las otras aplicaciones se actualizaran de la misma forma</p>';
		}else if (tid_estado_original == 28){
			mensaje_adv = '<p>Importante: Has seleccionado remover el estado "Lista negra", las otras aplicaciones se actualizaran a un estado anterior</p>';
		}

		//enviar los datos al controlador para actualizar los datos del estado
		$.ajax({
			url:'/admin/estado/aplicante/actualizar/'+uid_aplicante+'/'+nid_puesto+'/'+tid_estado,
		})
		.done(function(data) {
			
			$(".persona-id-"+uid_aplicante+" .loader.cambio-estado").html("<span class='close-cambio-estado' data-aplicante='"+uid_aplicante+"'>X</span><div class=''><p>El estado se actualizo satisfactoriamente</p>" + mensaje_adv + "</div>");
						
		});
	});


		/*************** Actualiza estado de puestos en un puesto en el Dashboard ****************/
/*****************************************/

	$('select.popup-puestos-aplicados').live('change', function(){
		var nid_puesto = $(this).attr('data-puesto');
		var uid_aplicante = $(this).attr('data-aplicante');
		var tid_estado_original = $(this).attr('data-estado');
		var tid_estado = $(this).val();
		$(this).parent().find( ".loader" ).css('display', 'block');
		$(this).parent().find( ".loader" ).addClass('cambio-estado').html('<center><img src="/public/images/loader.gif" /></center>');


		//mensaje de advertencia
		var mensaje_adv = '';
		if(tid_estado == 28){
			mensaje_adv = '<p>Importante: Has seleccionado agregar al aplicante a la "Lista negra", las otras aplicaciones se actualizaran de la misma forma</p>';
		}else if (tid_estado_original == 28){
			mensaje_adv = '<p>Importante: Has seleccionado remover el estado "Lista negra", las otras aplicaciones se actualizaran a un estado anterior</p>';
		}

		


		//enviar los datos al controlador para actualizar los datos del estado
		$.ajax({
			url:'/admin/estado/aplicante/actualizar/'+uid_aplicante+'/'+nid_puesto+'/'+tid_estado,
		})
		.done(function(data) {
					
		
			$(".persona-id-"+uid_aplicante+" .loader.cambio-estado").html("<span class='close-cambio-estado' data-aplicante='"+uid_aplicante+"'>X</span><div class=''><p>El estado se actualizo satisfactoriamente</p>" + mensaje_adv + "</div>");
			
			
			
						
		});
	});

	$('span.close-cambio-estado').live("click", function(){
		$(this).parent().css('display', 'none');
		$(this).parent().html('');
		var uid_aplicante = $(this).attr('data-aplicante');
		if($('#form_puestos_por_aplicante_'+uid_aplicante).length > 0){
			$('#form_puestos_por_aplicante_'+uid_aplicante).sendAjaxPuestosAplicadosPorAplicante();
		}
	});


	$('select#cambiar-estado').live('change', function(){
		var nid_puesto = $(this).attr('data-puesto');
		var uid_aplicante = $(this).attr('data-aplicante');
		var tid_estado = $(this).val();
		$(this).parent().append('<div class="loader a'+nid_puesto+'"><center><img src="/public/images/loader.gif" /></center></div>');
		//enviar los datos al controlador para actualizar los datos del estado
		$.ajax({
			url:'/admin/estado/aplicante/actualizar/'+uid_aplicante+'/'+nid_puesto+'/'+tid_estado,
		})
		.done(function(data) {
			console.log(data);
			$("#aplicante-"+uid_aplicante+" .loader.a"+nid_puesto+"").html('<p>El estado se actualizó satisfactoriamente <em>El mensaje se ocultara automáticamente</em> </p>');
			setTimeout(function(){ $("#aplicante-"+uid_aplicante+" .loader.a"+nid_puesto+"").addClass('hidden'); }, 6000);			
		})
	});


	/*************** Actualiza el pais en el dashboard del admin regional  ****************/
/*****************************************/


	$('.cambia-pais-container-dashboard select#cambia-pais-control-select').live('change', function(){
		//muestra el loader siempre que va a hacer un cambio
		$('.loader-general').css('display', 'block');

		var nid_pais = $(this).val();
		
		//enviar los datos al controlador para actualizar los datos del estado
		$.ajax({
			url:'/admin/usuario/cambia-pais/'+nid_pais,
		})
		.done(function(data) {
			$('input.pais').val(nid_pais);
			$(formfilterAdminDashboard).sendAjaxAdminDashboard();
		});
		

		
	});


	/*************** Actualiza el pais en todo el resto del sitio ****************/
/*****************************************/

	$('.cambia-pais-container-interno select#cambia-pais-control-select').live('change', function(){
		//muestra el loader siempre que va a hacer un cambio
		$('.loader-general').css('display', 'block');

		var nid_pais = $(this).val();
		$(formfilterAdmin).find("input[name='pais[]']").each(function() { this.checked=false; });
		$(formFilterAplicantes).find("input[name='pais[]']").each(function() { this.checked=false; });

		//enviar los datos al controlador para actualizar los datos del estado
		$.ajax({
			url:'/admin/usuario/cambia-pais/'+nid_pais,
		})
		.done(function(data) {
			if($('body').hasClass('vista-admin-aplicantes')){//se ejecuta solo en la parte de aplicantes
				$(formFilterAplicantes).find("input[name='pais[]']").each(function() { 
					if($(this).val()==nid_pais){
						this.checked=true;
					}

				});
					
				$(formFilterAplicantes).sendAjaxAdminAplicantesGeneral();
			}else if($('body').hasClass('vista-admin-puestos')){ //Se ejecuta solo en la parte de puestos
				$(formfilterAdmin).find("input[name='pais[]']").each(function() { 
					if($(this).val()==nid_pais){
						this.checked=true;
					}

				});

					
				$(formfilterAdmin).sendAjaxAdmin();
			}else{  // Se ejecuta si es otra pagina distinta de la principal de dashboard y la principal de aplicantes (ejemplo: detalle de apilcantes)

				$('.loader-general').css('display', 'none');
			}

			

		});
		

		
	});


	

});

