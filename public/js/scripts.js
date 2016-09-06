// Font size automático
fontsize = function () {	
		$(".tnumero").each(function (index){ 
            var fontSize = $(this).find('span').width() * 0.30;
            $(this).find('span').css('font-size', fontSize);
        });	
};
//$(window).resize(fontsize);
//$(document).ready(fontsize);

$(document).ready(function(){

/*****************************************/
/*****************************************/

/***************** MENU ******************/
/*****************************************/

	$('.btnmenu').click(function(){
	  	if($(".overlaymenu").length == 0){
	  		$("body").append('<div class="overlaymenu"></div>');
	  	}				
		var menu = $('.menusidebar');
		$(".overlaymenu").fadeTo( "fast", 0.5);
		menu.animate({right:'0px'});
	});
 	$("body").mouseup(function(){ 
		var menu = $('.menusidebar');
  		$(".overlaymenu").fadeTo( "fast", 0.0, function() {
  			$(this).remove();
  		});
		menu.animate({right:'-350px'});
    });

/*****************************************/
/*****************************************/

var urlactual = document.URL.replace( /#.*/, "");
urlactual = urlactual.replace( /\?.*/, "");

		/*Google Analytics Evento Scroll*/
		var times = 0;
		$(window).scroll(function(){
			var bottom = $(window).height() + $(window).scrollTop();
			var height = $(document).height();
			var percentage = Math.round(100*bottom/height);
			if(percentage > 50 && times==0){
				times=times + 1;
				//ga('send', 'event', 'Scroll', '50%', urlactual);
				//dataLayer.push({'event': 'Scroll'});
				console.log("aqui");
			}
		});
		
		/*Google Analytics Evento Segundos*/
		setTimeout(function(){
			//ga('send', 'event', 'T>30s', 'Tiempo mayor a 30 segundos', urlactual);
		},30000);


	$("a[href^='/puestos']").on('click',function(){
		//ga('send', 'event', 'Click', 'Puestos disponibles', urlactual);
	});		
	$("a[href^='/registro']").on('click',function(){
		//ga('send', 'event', 'Click', 'Registrarme', urlactual);
	});	
	$(".btn_aplicar").on('click',function(){
		//ga('send', 'event', 'Click', 'Click al botón de Aplicar al puesto', urlactual);
	});		


	$(window).scroll(function(){
	    scrolls = $(window).scrollTop();

	    if($(".vista-impacto-regional-detalle").length > 0){
		    var ini = $(".impacto-regional-detalle-imagen-top").position();
		    ini = ini.top;
		    var fin = $("#empleos-disponibles").position();
		    fin = fin.top;
		    if (scrolls > ini && scrolls < (fin+100)) { 
		       $(".submenu-paises").addClass('opensub');
		    } else {
		       $(".submenu-paises").removeClass('opensub');
		    }

		    if($("#datos-numericos-pais").length >0 ){
		    	var sub1 = $("#datos-numericos-pais").position();
		    	sub1 = sub1.top;
		    }
		    if($("#impacto-positivo-pais").length >0 ){
		    	var sub2 = $("#impacto-positivo-pais").position();
		    	sub2 = sub2.top;
			}

		    if($("#testimonios-pais-detalle").length >0 ){
		    	var sub3 = $("#testimonios-pais-detalle").position();
		    	sub3 = sub3.top;
			}

			if($("#empleos-disponibles").length >0 ){
		    	var sub4 = $("#empleos-disponibles").position();
		    	sub4 = sub4.top;
		    }    	    

		    if(scrolls >= sub1){
		    	$(".subm").removeClass('activ');
		    	$(".opt1").addClass('activ');
		    }
		    if(scrolls >= sub2){
		    	$(".subm").removeClass('activ');
		    	$(".opt2").addClass('activ');
		    }
		    if(scrolls >= sub3){
		    	$(".subm").removeClass('activ');
		    	$(".opt3").addClass('activ');
		    }	    	    
		    if(scrolls >= sub4){
		    	$(".subm").removeClass('activ');
		    	$(".opt4").addClass('activ');
		    }
		}
		if($(".vista-user-micuenta").length > 0){

		    var ini = $("#imagen-nombre").position();
		    ini = ini.top;
		    var fin = $("#boton-enviar").position();
		    fin = fin.top;
		    if (scrolls > (ini-300) && scrolls < (fin-200)) { 
		       $(".submenu-lateral").addClass('opensub');
		    } else {
		       $(".submenu-lateral").removeClass('opensub');
		    }

		    var sub1 = $("#puestos-aplicados").position();
		    sub1 = sub1.top;
		    var sub2 = $("#editar-perfil").position();
		    sub2 = sub2.top;

		    if(scrolls >= sub1){
		    	$(".subm").removeClass('activ');
		    	$(".opt1").addClass('activ');
		    }
		    if(scrolls >= sub2){
		    	$(".subm").removeClass('activ');
		    	$(".opt2").addClass('activ');
		    }			
		}

	});


function extension(fname) {
    try {
        var pos = fname.lastIndexOf(".");
        var strlen = fname.length;
        if (pos != -1 && strlen != pos + 1) {
            var ext = fname.split(".");
            var len = ext.length;
            var extension = ext[len - 1].toLowerCase();
        } else {
            extension = "No extension found";
        }
    }
    catch (errr)
    { }
    return extension;
}


if($("#edit-profile-aplicante-field-curriculum-und-0-upload").length > 0){
	$("#edit-profile-aplicante-field-curriculum-und-0-upload").change(function(){
		var file = $(this).val();
		var ext = extension(file)
    switch (ext) {
	    case 'pdf':
	    case 'doc':
	    case 'docx':
	    	$("#uploadFile").val(file);
	      break;
	    default:
	      alert('Formato de archivo no válido.');
    }
	});
}
if($("#imagen").length > 0){
	$("#imagen").change(function(){
		$("#uploadFileImagen").val($(this).val());
	});
}


/*

					if($('#messages-webform').hasClass('alert-danger')){
						$('#messages-webform').removeClass('alert-danger');
						
					}
					$('#messages-webform').addClass('alert-success');
					mensaje = '¡Muchas Gracias!. Ha sido registrado en nuestra base de datos para que reciba información sobre ofertas laborales en BAC Credomatic.<br /><br /><a href="javascript:void(0);" id="volver-formulario-suscripcion">&laquo Volver al Formulario</a>';
					$('#messages-webform').css('display', 'block');	
					$('#messages-webform').html(mensaje);
				

*/



	$( ".subm" ).click(function(e) {
		e.preventDefault();
		$(".subm").removeClass('activ');
		$(this).addClass('activ');
	});

/********** RECUPERAR CLAVE **************/
/*****************************************/


	$( "#form-recuperar-clave" ).submit(function(e) {
		var msg = $('#messages-recuperar');
		msg.css('display', 'none').removeClass('alert-danger').removeClass('alert-success');
		var btn = $("#form-recuperar-clave #boton-enviar");
		e.preventDefault();
		var fm = $(this);
		var form = fm[0];
		var formData = new FormData(form);				

		btn.css({'background-image':'url(/public/images/loader_red.gif)'});

		$.ajax({
		    method: "POST",
			url: "ajax/formSubmit",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
		    error:function (jqXHR, textStatus, errorThrown) {
		      	msg.addClass('alert-danger').html(errorThrown).css('display', 'block');	
		    	btn.css({'background-image':'url()'});
		    },
		    success: function (data) { console.log(data);
		    	if(data[0] == 1){
		    		msg.addClass('alert-success').html('Se ha enviado un correo para restablecer la contraseña').css('display', 'block');
		    	}else{
		    		msg.addClass('alert-danger').html(data[0]).css('display', 'block');	
		    	}
				btn.css({'background-image':'url()'});
		  	}	
		});
	}); 



	$( "#form-recuperar-clave2 #boton-enviar" ).click(function(e) {
		e.preventDefault();
		desmarcarCamposRequeridos();
		if(validateEmail($("#form-recuperar-clave2 input#correo").val()) == false) {
			mostrarMensajeError('Por favor, ingrese una dirección de correo electrónico válido');
			errorCampo("#form-recuperar-clave2 input#correo");
			return false;
		}
		$( "#form-recuperar-clave2" ).submit();
	});





	$( "#form-cambiar-clave #boton-cambiar-clave" ).click(function(e) {
		e.preventDefault();
		desmarcarCamposRequeridos();

		if($("#form-cambiar-clave input#pass").val() == ""){
	
			mostrarMensajeError('El campo Definir contraseña es requerido');
			errorCampo("#form-cambiar-clave input#pass");
			return false;
		}

		if($("#form-cambiar-clave input#conf-pass").val() == ""){
		
			mostrarMensajeError('El campo Confirmar contraseña es requerido');
			errorCampo("#form-cambiar-clave input#conf-pass");
			return false;
		}	


		if($("#form-cambiar-clave input#conf-pass").val() != $("#form-cambiar-clave input#pass").val()){
			mostrarMensajeError('El campo contraseña y la confirmación de la contraseña no son iguales');
			errorCampo("#form-cambiar-clave input#pass");
			errorCampo("#form-cambiar-clave input#conf-pass");
			return false;
		}
		$( "#form-cambiar-clave" ).submit();

		

	});






/************** TOUCH MENU ***************/
/*****************************************/
	
   /* $(document.body).bind("touchmove", function(e) {
      e.preventDefault();
      var touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
      //CODE GOES HERE
      console.log(touch.pageY+' '+touch.pageX);
	});*/


	var s_mx = 0, m_mx = 0, e_mx = 0, rc = -350, opac = 0;
	
	$(document).delay(200).bind("touchstart touchmove touchend", function(e) {
	  //Disable scrolling by preventing default touch behaviour
	  //console.log(e.type);
	  //e.preventDefault();
	  var orig = e.originalEvent;
	  var x = orig.changedTouches[0].pageX;
	  var y = orig.changedTouches[0].pageY;

		if($(".bx-controls").length > 0){
			if($(".bx-controls").hasClass('disabled')){
				x = 0;
			}
		}
	  
	  if(e.type == 'touchstart'){
	  	s_mx = x;
	  	rc = parseInt($(".menusidebar").css('right'));
	  }
	  if(e.type == 'touchmove'){
	  	m_mx = x;
	  	var mresult = s_mx - x;
	  	
	      
		  if((mresult > 50 || mresult < -50) && mresult != 0){

		  	if(mresult <= 100){/* && mresult >= -100*/
			  	if($(".overlaymenu").length == 0){
			  		$("body").append('<div class="overlaymenu"></div>');
			  	}		  		
		  		opac = Math.round(((mresult / 10) / 2));
		  		console.log(opac);
		  		$(".overlaymenu").css({opacity: '.'+opac});
		  	}


		  	
		  	if(rc == 0 && mresult < 0){
		  		$(".menusidebar").css({right: (rc + mresult+50)});
		  	}
		  	if(rc == -350 && mresult > 0){
		  		$(".menusidebar").css({right: (rc + mresult-50)});
		  	}		  	
		  }

		 //console.log(rc + ' :: ' + x + ' :: ' + mresult);
	  }
	  if(e.type == 'touchend'){
	  	
	  	e_mx = x;
		  var result = s_mx - e_mx;
		  if(result != 0){
			  if(result <= -150){
			  	if(result <= -150){
			  		$(".overlaymenu").fadeTo( "fast", 0.0, function() {
			  			$(this).remove();
			  		});
			  		$(".menusidebar").animate({right: '-350px'});
			  	}else{
			  		$(".overlaymenu").fadeTo( "fast", 0.5);
			  		$(".menusidebar").animate({right: '0px'});
			  	}
			  	 
			  }else{
			  	if(result >= 150){
			  		$(".overlaymenu").fadeTo( "fast", 0.5);
			  		$(".menusidebar").animate({right: '0px'});
			  	}else{
			  		$(".overlaymenu").fadeTo( "fast", 0.0, function() {
			  			$(this).remove();
			  		});
			  		$(".menusidebar").animate({right: '-350px'});
			  	}
			  	 
			  }
		  }

	  }	  


	  // Move a div with id "rect"
	  
	  //$(".menusidebar").css({right: -x});
	});

/*****************************************/
/*****************************************/



/************ TABS FILTRADO **************/
/*****************************************/

	$('ul.as_tabs li').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('ul.as_tabs li').removeClass('current');
		$('.tab-content').removeClass('current');

		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
	});
	
/*****************************************/
/*****************************************/


/********* SELECT FILTRADO BLOG ***********/
/*****************************************/

	$('.categoria-list').click(function(){
		var ul = $("#lista-cat-blog");
		if(ul.hasClass('ulopen')){
			ul.slideUp('fast');
			ul.addClass('ulclose');
			ul.removeClass('ulopen');
		}else{
			ul.slideDown('fast');
			ul.addClass('ulopen');
			ul.removeClass('ulclose');
		}
	});
	
/*****************************************/
/*****************************************/


/********* FORM LOGIN POPUP ***********/
/**************************************/

	$('.btn_ingresar').click(function(e){
		e.preventDefault();
		var box = $(".formloginpopup");
		if(box.hasClass('formclose')){
			box.addClass('formopen');
			box.removeClass('formclose');
		}
	});

	$('.closeformlogin').click(function(){
		var box = $(".formloginpopup");
		if(box.hasClass('formopen')){
			$(".messages").addClass('hidden');
			box.addClass('formclose');
			box.removeClass('formopen');
		}
	});	
	
/*****************************************/
/*****************************************/



/*************** FILTRADO ****************/
/*****************************************/
	
	var formfilter = $("#form_filtrado");
	jQuery.fn.extend({
	  sendAjax: function() {

		$(".as_tabs li").removeClass('selectopc');
        $(".tab-content").each(function (index){
        	var id = $(this).attr('id');
        	if($("#"+id+" input:checked" ).length > 0 || ($("#"+id+" input[type=text]").val() != '' && $("#"+id+" input[type=text]").val() != undefined)){
        		$(".as_tabs li[data-tab="+id+"]").addClass('selectopc');
        	}
        });

	  	$(".paginacionhtml").html('');
		var tabla = $(".filtro_puestos.filtro_puestos_front tbody");  
		tabla.html('<tr><td colspan="4"><center><img src="/public/images/loader.gif" /></center></td></tr>');
		
		var fm = $(this);
		var submitted = fm.serialize();
		var submittedArray = fm.serializeArray();
		var form = fm[0];
		var formData = new FormData(form);				
		$.ajax({
			method: "POST",
			url:"/ajax/queryFilter",
			data: formData,
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false
		})
		.done(function(data) {
		var count_carrera_selected = occurrences(submitted,'carrera');
		var count_pais_selected = occurrences(submitted,'pais');
		var pais_id = 0;
		var carrera_id = 0;
		for (var i = 0; i < submittedArray.length; i++) {
			if(submittedArray[i].name == 'pais[]'){
				var pais_id = submittedArray[i].value;
			}
			if(submittedArray[i].name == 'carrera[]'){
				var carrera_id = submittedArray[i].value;
			}
		};

		var filter_details = "<span class='mayuscula'> " + data.metadata.total_results + " puestos disponibles </span>";
		var pais = $("label[for='pais"+pais_id+"']").text();
		var carrera = $("label[for='carrera"+carrera_id+"']").text();
		if ((count_carrera_selected == 1) && (count_pais_selected == 1)){
			filter_details = "<span>Filtros aplicados: País " + pais + ", Carrera " + carrera + " </span>";
		} else if ((count_pais_selected == 1) && (count_carrera_selected > 1)){
			filter_details = "<span>Filtros aplicados: País " + pais + ", " + count_carrera_selected + " Carreras </span>";
		} else if ((count_carrera_selected == 1) && (count_pais_selected > 1)){
			filter_details = "<span>Filtros aplicados: " + count_pais_selected + " Paises, Carrera " + carrera + " </span>";
		} else if ((count_pais_selected < 1) && (count_carrera_selected > 1)){
			filter_details = "<span>Filtros aplicados: " + count_carrera_selected + " Carreras </span>";
		} else if ((count_carrera_selected < 1) && (count_pais_selected > 1)){
			filter_details = "<span>Filtros aplicados: " + count_pais_selected + " Paises </span>";
		} else if ((count_carrera_selected == 1) && (count_pais_selected < 1)){
			filter_details = "<span>Filtros aplicados: Carrera " + carrera + " </span>";
		} else if ((count_carrera_selected < 1) && (count_pais_selected == 1)){
			filter_details = "<span>Filtros aplicados: País " + pais + " </span>";
		} else if((count_carrera_selected > 1) && (count_pais_selected > 1)){
			filter_details = "<span>Filtros aplicados: " + count_pais_selected + " Paises, " + count_carrera_selected + " Carreras </span>";
		}
		$(".total_puestos").html(filter_details);
		var html  = '';
		var pages = '';	
		var datos = data.results;
		var metas = data.metadata;
		$.each(datos, function(i,item){
			html += '<tr>\
					<td><a href="/puestos/'+datos[i].url+'/'+datos[i].nid+'">'+datos[i].title+'</a></td>\
					<td>'+datos[i].field_carrera+'</td>\
					<td>'+datos[i].field_pais+'</td>\
					<td>'+datos[i].created+'</td>\
					</tr>';
		});
		
		var i = parseFloat($('#inppage').val());
		var total = metas.total_pages;
		var total_results = metas.total_results;

		if(total_results > 0){

			if(i>0){
				pages += '<li class="pg_first"><a href="javascript:void(0);" data-id="0">&laquo;</a></li>';	
			}
			pages += jQuery.pages({
				total: total,
				page: i
			});
			if(i<metas.total_pages){
				pages += '<li class="pg_last"><a href="javascript:void(0);" data-id="'+metas.total_pages+'">&raquo;</a></li>';
			}

			pages = '<ul class="paginacion paginacion-filtrado">'+pages+'</ul>';

			$(".paginacionhtml").html(pages);
			$(".infopaginacion").html('<p>'+metas.display_start+'-'+metas.display_end+' de '+metas.total_results+' puestos disponibles</p>');
			tabla.html(html);
			//$(".filtro_puestos.filtro_puestos_front").removeClass('hidden');
		} else {
			$(".infopaginacion").html('<p>'+metas.total_results+' puestos disponibles</p>');
			//ocultamos la tabla
			tabla.html('<tr><td colspan="4"><center>No se encontraron resultados.</center></td></tr>');
			//$(".filtro_puestos.filtro_puestos_front").addClass('hidden');

		}
		
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			console.log(jqXHR);
			console.log(textStatus);
			console.log(errorThrown);			
			alert('Error');
		})
		/*.always(function() {
			alert( "complete" );
		});*/		  
	  }
	});


	/*jQuery.extend({
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
	});*/

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

	/* Para Filtrado Normal enel Front*/
	
	$(formfilter).change(function(e) {
		$('#inppage').val('0');
		$(this).sendAjax();
	});
	$(formfilter).submit(function(e) {
		e.preventDefault();
		$(this).sendAjax();
	});
	$('.paginacion.paginacion-filtrado li a').live('click', function(){
		$("html, body").animate({ scrollTop: $(".filtro_puestos").offset().top-50}, 1000);
		var val = $(this).data('id');
		$('#inppage').val(val);
		$(formfilter).sendAjax();
	});
	
	$('.orden').click(function(){
		$('#inppage').val('0');
		var val = $(this).data('id');
		$('#inporden').val(val);
		$(formfilter).sendAjax();
	});
	
	$('.reset').click(function(){
		$(formfilter)[0].reset();
		$(formfilter).find("input[type=checkbox]").each(function() { this.checked=false; });
		$(formfilter).sendAjax();
	});	
	
	if($(".filtro_puestos_front").length > 0){
		$(formfilter).sendAjax();
	}



					

	$('.mostrarfiltros').click(function(){
		var div = $(".filtrado");
		if(div.hasClass('fclose')){
			div.removeClass('fclose');
			div.addClass('fopen');
			$('.mostrarfiltros').css("background-image", "url('/public/images/ocultar_filtros.png')");
		}

	});

	$('.ocultarfiltros').click(function(){
		var div = $(".filtrado");
		if(div.hasClass('fopen')){
			div.removeClass('fopen');
			div.addClass('fclose');
			$('.mostrarfiltros').css("background-image", "url('/public/images/arrow_filtrado.png')");
		}
	});	
	
	
/*****************************************/
/*****************************************/

/** Function count the occurrences of substring in a string;
 * @param {String} string   Required. The string;
 * @param {String} subString    Required. The string to search for;
 * @param {Boolean} allowOverlapping    Optional. Default: false;
 * @author Vitim.us http://stackoverflow.com/questions/4009756/how-to-count-string-occurrence-in-string/7924240#7924240
 */
function occurrences(string, subString, allowOverlapping) {

    string += "";
    subString += "";
    if (subString.length <= 0) return (string.length + 1);

    var n = 0,
        pos = 0,
        step = allowOverlapping ? 1 : subString.length;

    while (true) {
        pos = string.indexOf(subString, pos);
        if (pos >= 0) {
            ++n;
            pos += step;
        } else break;
    }
    return n;
}

/************** TESTIMONIOS **************/
/*****************************************/
	var testim = $('.testimonios');
	/*if(testim.length > 0){
		$.getScript( "/public/lib/bxslider/jquery.bxslider.min.js", function( data, textStatus, jqxhr ) {
			if($("#bxslidercss").length <= 0){
				$('<link/>', {
				   id:  'bxslidercss',
				   rel: 'stylesheet',
				   type: 'text/css',
				   href: '/public/lib/bxslider/jquery.bxslider.min.css'
				}).appendTo('body');
			}
			$(testim).bxSlider({
				infiniteLoop: false,
				hideControlOnEnd: true,
				pager: false,
				adaptiveHeight: true
			});			
		});
	}*/

	$(testim).bxSlider({
		infiniteLoop: true,
		hideControlOnEnd: true,
		pager: false,
		adaptiveHeight: true,
		autoStart: true,
		auto: true,
		pause: 15000
	});	

/*****************************************/
/*****************************************/



/************ OTROS PUESTOS **************/
/*****************************************/
	var otrospuestos = $('.otrospuestos');
	/*if(otrospuestos.length > 0){
		$.getScript( "/public/lib/bxslider/jquery.bxslider.min.js", function( data, textStatus, jqxhr ) {
			if($("#bxslidercss").length <= 0){
				$('<link/>', {
				   id:  'bxslidercss',
				   rel: 'stylesheet',
				   type: 'text/css',
				   href: '/public/lib/bxslider/jquery.bxslider.min.css'
				}).appendTo('body');
			}
			$(otrospuestos).bxSlider({
				controls: false,
				minSlides: 3,
				maxSlides: 3,
				moveSlides: 3,
				slideWidth: 300

			});			
			  //console.log( data );
		});
	}*/

	var cantslid = 3;
	if(window.screen.width <= 767){
		cantslid = 2;
	}
	if(window.screen.width <= 479){
		cantslid = 1;
	}
	$(otrospuestos).bxSlider({
		controls: false,
		minSlides: cantslid,
		maxSlides: cantslid,
		moveSlides: cantslid,
		slideWidth: 300,
		responsive: true

	});		

/*****************************************/
/*****************************************/



/***************** POPUP *****************/
/*****************************************/

   	var wt = false;
	/*if($(window).width() < 991){
		$("#popup-industrial").removeClass('popup');
		$(".btn").removeAttr("data-popup-target").attr('href', '#popup-industrial');
		wt = true;
	}*/
	$('[data-popup-target]').click(function () {
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
	
	$(document).keyup(function (e) {
	  if (e.keyCode == 27 && $('html').hasClass('overlay')) {
		  clearPopup();
	  }
	});
	
	$('.popup-exit').click(function () {
	  clearPopup();
	});
	
	$('.popup-overlay').click(function () {
	  clearPopup();
	});
	
	function clearPopup() {
	  var iframe = $('.popup.visible iframe');
	  $('.popup.visible').addClass('transitioning').removeClass('visible');
	  $('html').removeClass('overlay');
	  
	  if(iframe.length > 0){
	  	var ifr = iframe[0].contentWindow; console.log(ifr);
	  	ifr.postMessage('{"event":"command","func":"pauseVideo","args":""}','*');
	  }

	  setTimeout(function () {
		  $('.popup').removeClass('transitioning');
	  }, 200);
	}	

/*****************************************/
/*****************************************/



	/*$( "#formulario-perfil" ).submit(function(e) {
		e.preventDefault();
		var fm = $(this);
		var form = fm[0];
		var formData = new FormData(form);				
		$.ajax({
			method: "POST",
			url:"http://bac.cr/ajax/getform",
			data: formData,
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false
		})
		.done(function(data) {
			alert( data.ajax );
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			console.log(jqXHR);
			console.log(textStatus);
			console.log(errorThrown);			
			alert('Error');
		})
		.always(function() {
			//alert( "complete" );
		});
	});*/

	/* FORMULARIO INICIO DE SESION */
	/*$( "#perfil-siguiente-paso1" ).on("click", function() {
				
		var jqxhr = $.post( "usuario/obtenerSesion", function(data) {
		    
		    var obj = data.split(",")
			token = obj[4];
			user_id = obj[3];

			console.log(token);

		    var info = {
			  "pass": "Higure111",
	        };

			$.ajax({
				type:'put',
				url:"http://bac.cr/rrhh/api/users/user/" + user_id + ".json",
				data:info,
				dataType: 'json',
				beforeSend: function (request) {
			        request.setRequestHeader("X-CSRF-Token", token);
			    },
			})
			.done(function(data) {
				//reedirigir al profile del user
				alert( data );
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);			
				mostrarMensajeError(errorThrown);
			})
			.always(function() {
				//alert( "complete" );
			});
		})
		  .fail(function() {
		    alert( "error" );
		  });

	});		*/

	/* FORMULARIO DE REGISTRO */

	// Obtain session token.	

	$( ".login-form-ajax" ).live('submit',function(e) {
		var id = $(this).attr('id');
		e.preventDefault();
		var fm = $(this);
		var form = fm[0];
		var formData = new FormData(form);				

		$("#mensaje-despues-inicio-sesion").removeClass('hidden');
		$('#mensaje-despues-inicio-sesion').html('<p>&nbsp</p><p>&nbsp;</p><center><img src="/public/images/loader.gif" /></center>');

		$.ajax({
		    method: "POST",
			url:"/usuario/inicioSesionAjax",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
		    error:function (jqXHR, textStatus, errorThrown) {
		       alert(errorThrown);
		       $("#mensaje-despues-inicio-sesion").addClass('hidden');
		    },
		    success: function (data) {

				if(data.success == false){
					$(".popup-content .messages").removeClass('hidden');
					$(".popup-content .messages .error.message").html('<p>'+data.errorlogin+'</p>');
					$("#mensaje-despues-inicio-sesion").addClass('hidden');
				} else {
					$("body").append("<span id='logueado'>&nbsp</span>");
					$('.popup-exit').addClass("after-logged");
					$('.popup-overlay').addClass("after-logged");
					if (id == 'login-form-ajax-aplicar'){
						$.aplicarPuesto();
					} else {
						$(".contentformlogin").addClass("hidden");
						$('#mensaje-despues-inicio-sesion').html('<p class="success message">Has iniciado sesión satisfactoriamente</p>');
					}
				}
		  	}	
		});
	}); 

	$( "#login-form" ).submit(function(e) {
		var btn = $(".formloginpopup #boton-enviar");
		e.preventDefault();
		var fm = $(this);
		var form = fm[0];
		var formData = new FormData(form);				

		btn.css({'background-image':'url(/public/images/loader_red.gif)'});

		$.ajax({
		    method: "POST",
			url:"/usuario/inicioSesionAjax",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
		    error:function (jqXHR, textStatus, errorThrown) {
		       alert(errorThrown);
		       btn.css({'background-image':'url()'});
		    },
		    success: function (data) { console.log(data);
				if(data.success == true){
					//location.reload();
					document.location = '/'+data.cuenta;
				}else{
					$(".formloginpopup .messages").removeClass('hidden');
					$(".formloginpopup .messages .error").html('<p>'+data.errorlogin+'</p>');
					btn.css({'background-image':'url()'});
				}
				//
		  	}	
		});
	}); 

	$(".btn_aplicar").on('click', function(){
		$.aplicarPuesto(true, null);
	});

	$(".btn_desaplicar").on('click', function(){
		var idPuesto = null;
		//funcionalidad para desaplicar un puesto por medio de la tabla con los puestos aplicados
		if((typeof $(this).attr('data-id-puesto') !== typeof undefined) && ($(this).attr('data-id-puesto') !== false)){
			idPuesto = $(this).attr('data-id-puesto');
		}
		$.aplicarPuesto(false, idPuesto);
	});


	jQuery.extend({
		aplicarPuesto: function(aplicar, idPuesto) {
			/*if(document.getElementById('logueado')){
				
			}*/
			$("#mensaje-despues-inicio-sesion").removeClass('hidden');
			$('#mensaje-despues-inicio-sesion').html('<p>&nbsp</p><p>&nbsp;</p><center><img src="/public/images/loader.gif" /></center>');
					
			$.ajax({
			    method: "GET",
				url:"/usuario/consultarEstadoSesion/",
				cache: false,
				contentType: false,
				processData: false,
			    error:function (jqXHR, textStatus, errorThrown) {
			       alert(errorThrown);
			    },
			    success: function (data) {
			    	if(data.estado == 1){
			    		//si la sesion esta activa
			    		var pathArray = window.location.pathname.split( '/' );
			    		var id_puesto = pathArray[3]; //obtener el id del puesto por medio de la url
			    		if(idPuesto != null){
					    	id_puesto = idPuesto; //se remplaza el id del puesto por medio del parametro
						}

						console.log(id_puesto);

						/*validar aplicacion o desaplicacion a un puesto*/
						var url = 'aplicarPuesto';
						if(aplicar == false){
							url = 'desaplicarPuesto';
						}

						$.ajax({
						    method: "GET",
							url:"/usuario/" + url + "/" + id_puesto,
							cache: false,
							contentType: false,
							processData: false,
						    error:function (jqXHR, textStatus, errorThrown) {
						       alert(errorThrown);
						    },
						    success: function (data) { 
						    	$('#mensaje-despues-inicio-sesion').removeClass('hidden');
						    	//console.log(data);
						    	if($(".contentformlogin").length > 0){
						    		$(".contentformlogin").addClass("hidden");
						    	}
						    	console.log(data);
						    	console.log(data.debug);
						    	var mensaje = '';
						    	if(data.success == false){
						    		if(data.url != undefined){
						    			window.location.href = ''+data.url+'';
						    		}
						    		if(data.code == 1){
						    			//mensaje indicando que ya aplico al puesto
						    			mensaje = 'Ya has aplicado para este puesto';

						    			if(aplicar == false){
											mensaje = 'No tienes más puestos asignados';						    				
						    			}

						    			$('#mensaje-despues-inicio-sesion').html('<p>&nbsp</p><p class="error message">'+ mensaje +'<br><br></p>');
 
						    		}else if (data.code == 406){
						    			$('#mensaje-despues-inicio-sesion').html('<p class="error message">'+data.error+'</p>\
						    				<div class="sharediv"><span>¡Comparte esto con tus amigos! </span> <a class="shared" id="shared1" href="javascript:void(0);"></a></div>');
						    			//setInterval(function(){ location.reload(); }, 4000);
										stLight.options({
											publisher:'eea7c747-b399-4c41-97ef-0db93d2410e9', doNotHash: false, doNotCopy: true, hashAddressBar: false
										});						    			
										stWidget.addEntry({
											"service":"sharethis",
											"element":document.getElementById('shared1'),
											"url":window.location.href,
											"title":"He aplicado al puesto " + document.title,
											"type":"large",
											"text":"",
											"image":$('#img_detalle_puesto').attr('src'),
											"summary":""											
										});						    			
						    		}
						    	}else{

						    		mensaje = '<h3>Has aplicado con <strong>éxito</strong> al puesto</h3>\
												<p>Muchas gracias por querer formar parte de la familia BAC | Credomatic.</p><p>&nbsp</p>\
												<p>Recuerda que en tu <a href="/micuenta" target="_blank" class="red">Cuenta</a> puedes actualizar tus datos personales y hoja de vida, así como verificar los puestos a los que has aplicado.</p>\
												<div class="sharediv"><span>¡Comparte esto con tus amigos! </span> <a class="shared" id="shared1" href="javascript:void(0);"></a></div>';

										if(aplicar == false){
											mensaje = '<h3>Has desaplicado exitosamente al puesto</h3>\<p>Recuerda que en tu <a href="/micuenta" target="_blank" class="red">Cuenta</a> puedes actualizar tus datos personales y hoja de vida, así como verificar los puestos a los que has aplicado.</p>\
														<div class="sharediv"><span>¡Comparte esto con tus amigos! </span> <a class="shared" id="shared1" href="javascript:void(0);"></a></div>';
										}

						    		//ga('send', 'event', '	Aplicó a un puesto', 'El usuario aplicó a un puesto exitosamente', urlactual);
/*dataLayer.push({
'Aplico puesto satisfactoriamente':'value',
'event':'aplico-puesto'
});*/
																					
									$('#mensaje-despues-inicio-sesion').html(mensaje);
										//setInterval(function(){ location.reload(); }, 4000);
										stLight.options({
											publisher:'eea7c747-b399-4c41-97ef-0db93d2410e9', doNotHash: false, doNotCopy: true, hashAddressBar: false
										});
										stWidget.addEntry({
											"service":"sharethis",
											"element":document.getElementById('shared1'),
											"url":window.location.href,
											"title":"He aplicado al puesto " + document.title,
											"type":"large",
											"text":"",
											"image":$('#img_detalle_puesto').attr('src'),
											"summary":"" 											  
										});											
									
						    	}					
						  	}	
						});


					}else{
						$("#mensaje-despues-inicio-sesion").addClass('hidden');
						//si la sesion no esta activa, se procede a extraer el formulario de ajax
						$.ajax({
						    method: "GET",
							url:"/usuario/obtenerFormularioInicioSesionAjax/",
							cache: false,
							contentType: false,
							processData: false,
						    error:function (jqXHR, textStatus, errorThrown) {
						       alert(errorThrown);
						    },
						    success: function (data) {
						    	$('#forularioAjax').html(data);
						    }
						});
					}
			    }
			});			
		}
	});


	$('.popup-exit.after-logged').live('click', function(){
		location.reload();
	});
	$(document).keyup(function (e) {
	  if (e.keyCode == 27 && $('.popup-overlay').hasClass('after-logged')) {
		  location.reload();
	  }
	});
	$('.popup-overlay.after-logged').live('click', function(){
	  location.reload();
	});


	/*consultar las carreras*/
	if($(".form").length > 0){

		$.datepicker.formatDate( "dd-mm-yy" );
		 $.datepicker.regional['es'] = {
	                closeText: 'Cerrar',
	                prevText: '&#x3c;Ant',
	                nextText: 'Sig&#x3e;',
	                currentText: 'Hoy',
	                monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
	                'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
	                monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
	                'Jul','Ago','Sep','Oct','Nov','Dic'],
	                dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
	                dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
	                dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
	                weekHeader: 'Sm',
	                dateFormat: 'dd/mm/yy',
	                firstDay: 1,
	                isRTL: false,
	                showMonthAfterYear: false,
	                yearSuffix: ''};
	        $.datepicker.setDefaults($.datepicker.regional['es']);

		$(function() {
	       $( ".datepicker" ).datepicker({ 
	       	changeYear: true,
	       	yearRange: '-50:-18', // specifying a hard coded year range
	       });
	    });

		//llenar las opciones de carreras
		$.ajax({
			url:"/rrhh/api/filtros/filtros-entidades-carreras.json",
		})
		.done(function(data) {
			
			var colm1 = ''; var colm2 = ''; var cl = 1;

			for (var i = 0; i < data.results.length; i++) {
				var checked = '';
				var nid = data.results[i].nid;
				var title = data.results[i].title;

				$(".carrera-aplicado").each(function(){
					var carrera_aplicado = $(this).text();
					if(title == carrera_aplicado){
						checked = true;
					}					
				});

				var inched = '';
				if(checked == true){
					inched = 'checked="checked"';
				}

				var checkbox = '<div class="boxlabel"><input type="checkbox" '+inched+' name="field_carrera_para_aplicar[und]['+ nid +']" value="'+ nid +'" id="edit-profile-aplicante-field-carrera-und-'+ nid +'"><label for="edit-profile-aplicante-field-carrera-und-'+ nid +'">'+ title +'</label></div>';
				if(cl == 1){
					cl = 0;
					colm1 += checkbox;
				}else{
					cl = 1;
					colm2 += checkbox;
				}
			};

			var html = '<div class="w-row">\
			<div class="w-col w-col-6">'+colm1+'</div>\
			<div class="w-col w-col-6">'+colm2+'</div>\
		</div>';

			$("#areas-registro").append(html);


		})

		//llenar las opciones de los paises para trabajar
		$.ajax({
			url:"/rrhh/api/filtros/filtros-entidades-paises.json",
		})
		.done(function(data) {

			var colm1 = ''; var colm2 = ''; var cl = 1;

			for (var i = 0; i < data.results.length; i++) {
				var checked = '';
				var nid = data.results[i].nid;
				var title = data.results[i].title;

				$(".pais-aplicado").each(function(){
					var pais_aplicado = $(this).text();
					if(title == pais_aplicado){
						checked = true;
					}					
				});

				var inched = '';
				if(checked == true){
					inched = 'checked="checked"';
				}

				var checkbox = '<div class="boxlabel"><input type="checkbox" '+inched+' name="field_pais_trabajar[und]['+ nid +']" value="' + nid + '" id="edit-profile-aplicante-field-pais-trabajar-und-'+ nid +'"><label for="edit-profile-aplicante-field-pais-trabajar-und-'+ nid +'">' + title + '</label></div>';
				if(cl == 1){
					cl = 0; colm1 += checkbox;
				}else{
					cl = 1; colm2 += checkbox;
				}

			};

			var html = '<div class="w-row">\
			<div class="w-col w-col-6">'+colm1+'</div>\
			<div class="w-col w-col-6">'+colm2+'</div>\
		</div>';

			$("#paises-registro").append(html);
		})
		//detectar los clicks en el boton atrás
		$(".form .paso .atras").on("click", function(){
			var paso = $(this).data("id");
			$(".navegacion a").removeClass("pasoactivo");

			$(".paso").addClass("hidden");
			$("#"+paso).removeClass("hidden");
			$(".navegacion a[data-id="+paso+"]").addClass("pasoactivo");
			$("html, body").animate({ scrollTop: $("#"+paso).offset().top }, 1000);
			//document.location.href = "/micuenta#"+paso;				
		});
		//detectar los clicks en el boton siguiente y navegacion
		$(".form .paso .siguiente, .navegacion a").on("click", function(){
			var paso = $(this).data("id");
			//validar el paso para activar el siguiente que le corresponde
			ocultarMensajeError();
			desmarcarCamposRequeridos();
			
			$(".navegacion a").removeClass("pasoactivo");
			
			switch(paso){
				case 'datos-personales':
					$(".paso").addClass("hidden");
					$("#"+paso).removeClass("hidden");
					$(".navegacion a[data-id="+paso+"]").addClass("pasoactivo");

				break;
				case 'educacion':
					if (validarPasoRegistro('paso1') == false){
						//ga('send', 'event', 'Registro', 'Llegó al paso 2 del formulario de registro', urlactual);
                                                /*dataLayer.push({
						'Llegó al paso 2 del formulario de registro':'value',
						'event':'registro paso 2'
						});*/
						$(".paso").addClass("hidden");
						$("#"+paso).removeClass("hidden");
						$(".navegacion a[data-id="+paso+"]").addClass("pasoactivo");
						animateTopMove(paso);
						
					} else {
						$(".paso").addClass("hidden");
						$("#datos-personales").removeClass("hidden");
						$(".navegacion a[data-id=datos-personales]").addClass("pasoactivo");
					}
				break;
				case 'intereses':
					if (validarPasoRegistro('paso1') != false){
						$(".paso").addClass("hidden");
						$("#datos-personales").removeClass("hidden");
						$(".navegacion a[data-id=datos-personales]").addClass("pasoactivo");
						break;
					}				
					if (validarPasoRegistro('paso2') == false){
						//ga('send', 'event', 'Registro', 'Llegó al paso 3 del formulario de registro', urlactual);
                                                /*dataLayer.push({
						'Llegó al paso 3 del formulario de registro':'value',
						'event':'registro paso 3'
						});*/
						$(".paso").addClass("hidden");
						$("#"+paso).removeClass("hidden");
						$(".navegacion a[data-id="+paso+"]").addClass("pasoactivo");
							
						animateTopMove(paso);
					}else {
						$(".paso").addClass("hidden");
						$("#educacion").removeClass("hidden");
						$(".navegacion a[data-id=educacion]").addClass("pasoactivo");
					}
				break;
				case 'curriculum':
					if (validarPasoRegistro('paso1') != false){
						$(".paso").addClass("hidden");
						$("#datos-personales").removeClass("hidden");
						$(".navegacion a[data-id=datos-personales]").addClass("pasoactivo");
						break;
					}
					if (validarPasoRegistro('paso2') != false){
						$(".paso").addClass("hidden");
						$("#educacion").removeClass("hidden");
						$(".navegacion a[data-id=educacion]").addClass("pasoactivo");
						break;
					}										
					if (validarPasoRegistro('paso3') == false){
						//ga('send', 'event', 'Registro', 'Llegó al paso 4 del formulario de registro', urlactual);

                                                /*dataLayer.push({
						'Llegó al paso 4 del formulario de registro':'value',
						'event':'registro paso 4'
						});*/

						$(".paso").addClass("hidden");
						$("#"+paso).removeClass("hidden");
						$(".navegacion a[data-id="+paso+"]").addClass("pasoactivo");
						
						if ($('input[name="field_pais_trabajar[und][10]"]').is(':checked')){
							$('.envio-informacion-box').css('display', 'block');
						}
						if (!$('input[name="field_pais_trabajar[und][10]"]').is(':checked')){
							$('.envio-informacion-box').css('display', 'none');
							var bandera_envio = false;
							$('.envio_de_informacion select option').each(function(){
								if($(this).attr('selected')=="selected"){
									bandera_envio=true;
								}
							});
							if(!bandera_envio){
								$('.envio_de_informacion select option[value="97"]').attr('selected','selected');
							}
							
						}
						animateTopMove(paso);
					}else {
						$(".paso").addClass("hidden");
						$("#intereses").removeClass("hidden");
						$(".navegacion a[data-id=intereses]").addClass("pasoactivo");
					}				
				break;				
			}

			//var paso_position = $("#"+paso).offset().top-100;
			
			//$("html, body").animate({ scrollTop: paso_position }, 1000);
			//document.location.href = "/micuenta#"+paso;	
		});

		$('#register #boton-enviar').click(function(e){
			e.preventDefault();
			if($(".formreg input#edit-profile-aplicante-field-curriculum-und-0-upload").val() != ""){
				$(this).prop( "disabled", true).val('Guardando.').css({'background-image':'url(/public/images/loader_red.gif)','text-align':'left', 'padding-left': '30px'});
				$('#register').submit();
//dataLayer.push({'Registro satisfactorio' : 'value','event' : 'registro final'});
			}else{
				mostrarMensajeError('El campo currículum es requerido');
				errorCampo(".formreg input#uploadFile");
			}
		});

		$('#perfil #boton-enviar').click(function(e){
			var btn = $(this);
			e.preventDefault();
			var paso = $(this).data("id");
			if(!validarPasoRegistro(paso)){


				var email = $(".contentform input#correo");
				var currentEmail = email.attr('data'); 
				if(currentEmail != email.val() && $(".contentform input#clave_actual").val() == ''){
					$.msgBox({type: "prompt",
						title: "Está actualización requiere el ingreso de tu contraseña actual.",
						opacity: 0.6,
						inputs: [
						{ header: "<b>Contraseña</b>", type: "password", name: "clave" }],
						buttons: [{ value: "Continuar" }],
						success: function (result, values) { 
							$(values).each(function (index, input) {
								if(input.name == 'clave'){
									$(".contentform input#clave_actual").val(input.value);
								}
							});
							btn.prop( "disabled", true).val('Guardando.').css({'background-image':'url(/public/images/loader_nar.gif)','text-align':'left', 'padding-left': '30px'});
							$('#perfil').submit();
						}
					});
				}else{
					btn.prop( "disabled", true).val('Guardando.').css({'background-image':'url(/public/images/loader_nar.gif)','text-align':'left', 'padding-left': '30px'});
					$('#perfil').submit();
				}






			}

		});

		$('#register #datos-personales input[type="text"], #register #datos-personales input[type="password"], #register #datos-personales input[type="email"]').on("keypress",function(e){
			var code = e.keyCode || e.which;			
		    if (code == 13) {		        
		        $('#register.form #datos-personales .siguiente').click();
		        e.preventDefault();
		        return false;
		    }
		});
	
		$('#register #educacion input[type="text"]').on("keypress",function(e){
			var code = e.keyCode || e.which;			
		    if (code == 13) {		        
		        $('#register.form #educacion .siguiente').click();
		        e.preventDefault();
		        return false;
		    }
		});

		


		//buscar el contador de elementos en el idioma
		var contador = $("#idioma").length;
		$("#contador").html(contador);
	}

	/* Hacer scroll en cada paso cuando se haga enter*/
	function animateTopMove(paso){
		var paso_position = $("#"+paso).offset().top-20;
		$("html, body").animate({ scrollTop: paso_position }, 1000);
	}
	function nombre_valido(valor) {
	    var reg = /^([a-z ñáéíóú]{5,60})$/i;
	    if (reg.test(valor)) return true;
	    else return false;
	}
	
	//validador para el correo electronico
	/*$('.contentform #correo').blur(function(){
		validarVerificarEmail();
	});*/


	
	


/*$(".form input#correo").on( "focusout", function() {
	validarVerificarEmail();
});*/

$(".form input#correo").change(function() {
  validarVerificarEmail(0, 0);
});


loadAsync('public/lib/msgbox/styles/msgBoxLight.css', 'css');
loadAsync('public/lib/msgbox/scripts/jquery.msgBox.js', 'js');

function loadAsync(url, type, callback) {
	var s;
	var r = false;
	switch (type) {
	case 'css':
	s = document.createElement('link');
	s.rel = 'stylesheet';
	s.type = 'text/css';
	s.href = url;
	break;
	case 'js':
	s = document.createElement('script');
	s.type = 'text/javascript';
	s.src = url;
	break;
	}
	s.async = true;
	if (callback && typeof callback === "function") {
	s.onload = s.onreadystatechange = function () {
	if (!r && (!this.readyState || this.readyState == 'complete')){
	 r = true;
	 callback();
	}
	};
	}
	document.getElementsByTagName('body')[0].appendChild(s);
}	


function isValidDate(dateString)
	{
	    // First check for the pattern
	    if(!/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(dateString))
	        return false;

	    // Parse the date parts to integers
	    var parts = dateString.split("/");
	    var day = parseInt(parts[0], 10);
	    var month = parseInt(parts[1], 10);
	    var year = parseInt(parts[2], 10);

	    // Check the ranges of month and year
	    if(year < 1000 || year > 3000 || month == 0 || month > 12)
	        return false;

	    var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

	    // Adjust for leap years
	    if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
	        monthLength[1] = 29;

	    // Check the range of the day
	    return day > 0 && day <= monthLength[month - 1];
	}


	/*funcion para validar pasos en el registro del usuario*/
	function validarPasoRegistro(paso){
		//validacion de espacios vacios

		var error_campo = false;
		switch(paso){
			case 'paso1':
				//validar paso 1
				if(!nombre_valido($(".contentform input#nombre-apellidos").val())){
					error_campo = true;
					mostrarMensajeError('Ingrese un nombre válido');
					errorCampo(".contentform input#nombre-apellidos");
				}else if($(".contentform input#nombre-apellidos").val() == ""){
					error_campo = true;
					mostrarMensajeError('El campo Nombre y Apellidos es requerido');
					errorCampo(".contentform input#nombre-apellidos");
				}else if($("input#fecha-nacimiento").val() == ""){
					error_campo = true;
					mostrarMensajeError('El campo Fecha de nacimiento es requerido');
					errorCampo(".contentform input#fecha-nacimiento");
				}else if(isValidDate($("input#fecha-nacimiento").val())==false){
					error_campo = true;
					mostrarMensajeError('El campo Fecha de nacimiento es no posee el formato requerido. El formato correcto es dd/mm/yyyy');
					errorCampo(".contentform input#fecha-nacimiento");
				}else if($(".contentform input#telefono").val() == ""){
					error_campo = true;
					mostrarMensajeError('El campo telefono es requerido');
					errorCampo(".contentform input#telefono");
				}else /*if(($(".contentform input#uploadFileImagen").val() == "") && ($("form.form").attr('id') != 'perfil' )){
					error_campo = true;
					mostrarMensajeError('El campo fotografía es requerido');
					errorCampo(".contentform input#uploadFileImagen");
				}else*/ if($(".contentform input#correo").val() == ""){
					error_campo = true;
					mostrarMensajeError('El campo correo es requerido');
					errorCampo(".contentform input#correo");
				}else{
					/*error_campo = validarVerificarEmail();*/
					if(error_campo == false){
						if(($(".contentform input#clave_actual").length == 0) || ($(".contentform input#clave_actual").val() != '')){
							if($(".contentform input#clave").val() == ""){
								error_campo = true;
								mostrarMensajeError('El campo Definir contraseña es requerido');
								errorCampo(".contentform input#clave");
							}else if($(".contentform input#clave-conf").val() == ""){
								error_campo = true;
								mostrarMensajeError('El campo Confirmar contraseña es requerido');
								errorCampo(".contentform input#clave-conf");
							}else if($(".contentform input#clave-conf").val() != $(".contentform input#clave").val()){
								error_campo = true;
								mostrarMensajeError('El campo contraseña y la confirmación de la contraseña no son iguales');
								errorCampo(".contentform input#clave");
								errorCampo(".contentform input#clave-conf");
							}
						}
					}
				}
				return error_campo;

			break;
			case 'paso2':
				//validar paso 2
				if (!$(".label.profesion").hasClass("hidden")){
					if($(".contentform input#profesion").val() == ""){
						error_campo = true;
						mostrarMensajeError('El campo Profesion es requerido');
						errorCampo(".contentform input#profesion");
					}
				}
				if(error_campo == false){
					$('#perfil #boton-enviar').data('id', 'paso3');
				}				
				return error_campo;
			break;
			case 'paso3':
				//$( "#formulario-registro .paso #siguiente-paso2" ).trigger( "click" );
				if($(".contentform textarea#cualidades").val() == ""){
					error_campo = true;
					mostrarMensajeError('El campo "¿Cuáles son tus cualidades como persona y trabajador?" es requerido');
					errorCampo(".contentform textarea#cualidades");
				}else if($(".contentform textarea#ventaja").val() == ""){
					error_campo = true;
					mostrarMensajeError('El campo "¿Por qué eres una ventaja competitiva para BAC | Credomatic?" de nacimiento es requerido');
					errorCampo(".contentform textarea#ventaja");
				}
				return error_campo;
			break;
			/*case 'paso4':
				//$( "#formulario-registro .paso #siguiente-paso3" ).trigger( "click" );
			break;*/
		}
	}

	$("select[name='field_nivel_academico[und]']").on('change', function(){
		var valor = $(this).val();
		if ((valor == 6) || (valor == 7) || (valor == 8) || (valor == 9) || (valor == 10)){
			$(".label.profesion").removeClass("hidden");
		} else {
			$(".label.profesion").addClass("hidden");
		}
	});

	$("select[name='field_nivel_academico']").on('change', function(){
		var valor = $(this).val();
		if ((valor == 6) || (valor == 7) || (valor == 8) || (valor == 9) || (valor == 10)){
			$(".label.profesion").removeClass("hidden");
		} else {
			$(".label.profesion").addClass("hidden");
		}
	});

	var valor = $("select[name='field_nivel_academico']").val();
	if ((valor == 6) || (valor == 7) || (valor == 8) || (valor == 9) || (valor == 10)){
		$(".label.profesion").removeClass("hidden");
	} else {
		$(".label.profesion").addClass("hidden");
	}

	function desmarcarCamposRequeridos(){
		$('input').css("border","none");
		$('textarea').css("border","none");
	}

	function mostrarMensajeError(mensaje){ console.log(mensaje);
		$("#messages-form-register").removeClass("hidden");
		$("#messages-form-register").html('<div class="alert alert-danger">'+mensaje+'</div>');
		/*$("#messages-form-register .alert").addClass('alert-danger');*/
		$("html, body").animate({ scrollTop: $('#messages-form-register').offset().top-20 }, 1000);

		/*$(".success.message").addClass("hidden");
		$("#messages-form-register").removeClass("hidden");
		$("#messages-form-register").html('<div class="alert alert-danger">'+mensaje+'</div>');
		$("html, body").animate({ scrollTop: $('#messages-form-register').offset().top }, 1000);*/

	}

	function ocultarMensajeError(){
		if(!$("#messages-form-register").hasClass("hidden")){
			$("#messages-form-register").addClass("hidden");
		}		
	}

	function ocultarLoaderCorreo(){
		var estado = false;
		if(!$("#loader-correo").hasClass('hidden')){
			$("#loader-correo").addClass('hidden');
		}
		return estado;
	}

	function mostrarLoaderCorreo(){
		var estado = true;
		//window.setTimeout(function() {
			if($("#loader-correo").hasClass('hidden')){
				$("#loader-correo").removeClass('hidden');
			}
		//}, 0);
		return estado;
	}

	//mas idiomas
	$(".mas-idioma a").on("click", function(){
		var ident = $("form#perfil").length;
		//console.log(identificador);
		//obtener los idiomas
		var options = '';
		$.ajax({
			url:"/rrhh/api/filtros/filtros-taxonomias-idiomas.json",
		})
		.done(function(data) {
			var jsonstring = JSON.stringify(data);
			var obj = $.parseJSON(jsonstring);
			for (var i = 0; i < obj.results.length; i++) {
				options += "<option value=" + obj.results[i].tid + ">" + obj.results[i].name + "</option>"
			};
			var contador = $("#contador").text();

			var namei = 'field_idiomas[und]['+ contador +'][field_idioma][und]';
			var namep = 'field_idiomas[und]['+ contador +'][field_porcentaje][und][0][value]';

			if(ident > 0){
				namei = 'field_idioma-' + contador;
				namep = 'field_porcentaje-' + contador;
			}
			var idioma_markup = '';
				idioma_markup = '<div class="idioma">\
				<label>Idiomas</label>\
				<select name="'+namei+'">' + options + '</select>\
				<select name="'+namep+'" class="porcentaje">\
					<option value="10">10%</option>\
				    <option value="20">20%</option>\
				    <option value="30">30%</option>\
				    <option value="40">40%</option>\
				    <option value="50">50%</option>\
				    <option value="60">60%</option>\
				    <option value="70">70%</option>\
				    <option value="80">80%</option>\
				    <option value="90">90%</option>\
				    <option value="100">100%</option>\
				</select>\
				</div>';
			$("#idiomas").append(idioma_markup);		
			contador++;
			$("#contador").html(contador);
		})	

	});



	
	

	/*$("#telefono").keydown(function (e) {
       validarNumeros(e);
    });

	function validarNumeros(e){
		 // Allow: backspace, delete, tab, escape, enter and .
	    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
	         // Allow: Ctrl+A, Command+A
	        (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
	         // Allow: home, end, left, right, down, up
	        (e.keyCode >= 35 && e.keyCode <= 40)) {
	             // let it happen, don't do anything
	             return;
	    }
	    // Ensure that it is a number and stop the keypress
	    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
	        e.preventDefault();
	    }
    }*/

	//Filtro de Blog
	$("#filtro-blog-form input").keypress(function(event) {
	    if (event.which == 13) {
	        event.preventDefault();
	        $("#filtro-blog-form").submit();
	    }
	});




	/* Contact Form */

	$('#form-contacto').submit(function(event) {

        // get the form data
        // there are many ways to get this data using jQuery (you can use the class or id also)
       
        var form_completo = true;
        var mensaje = "";

        $('#form-contacto input').css('border', 'none');
        $('#form-contacto .contact-pais-select-wrapper').css('border', 'none');
        $('#form-contacto textarea').css('border', 'none');

        if($("#form-contacto input#nombre").val()==""){
        	mensaje = mensaje + "<li>El cambo de Nombre se encuentra vacío</li>";
        	var form_completo = false;
        	$('#form-contacto input#nombre').css('border','1px solid red');
        	if(!$('#messages-webform').hasClass('alert-danger')){
        		$('#messages-webform').addClass('alert-danger');
        	}
        }
        if($('#form-contacto input#correo').val()==""){
        	mensaje = mensaje + "<li>El cambo de Correo se encuentra vacío</li>";
        	var form_completo = false;
        	$('#form-contacto input#correo').css('border','1px solid red');
        	if(!$('#messages-webform').hasClass('alert-danger')){
        		$('#messages-webform').addClass('alert-danger');
        	}
        }else if(validateEmail($('#form-contacto input#correo').val())==false){
        	mensaje = mensaje + "<li>No se ha insertado un correo electrónico correcto.</li>";
        	var form_completo = false;
        	$('#form-contacto input#correo').css('border','1px solid red');
        	if(!$('#messages-webform').hasClass('alert-danger')){
        		$('#messages-webform').addClass('alert-danger');
        	}
        }

        if($('#form-contacto select#pais option:selected').val()=="default"){
        	mensaje = mensaje + "<li>Debe seleccionar un País a contactar de la lista</li>";
        	var form_completo = false;
        	$('#form-contacto .contact-pais-select-wrapper').css('border','1px solid red');
        	if(!$('#messages-webform').hasClass('alert-danger')){
        		$('#messages-webform').addClass('alert-danger');
        	}
        }
        if($('#form-contacto input#telefono').val()==""){
        	mensaje = mensaje + "<li>El cambo de Teléfono se encuentra vacío</li>";
        	var form_completo = false;
        	$('#form-contacto input#telefono').css('border','1px solid red');
        	if(!$('#messages-webform').hasClass('alert-danger')){
        		$('#messages-webform').addClass('alert-danger');
        	}
        }
        if($('#form-contacto textarea#comentario').val()==""){
        	mensaje = mensaje + "<li>El cambo de Comentario se encuentra vacío</li>";
        	var form_completo = false;
        	$('#form-contacto textarea#comentario').css('border','1px solid red');
        	if(!$('#messages-webform').hasClass('alert-danger')){
        		$('#messages-webform').addClass('alert-danger');
        	}
        }

        if(form_completo==true){
        	var fm = $(this);
			var form = fm[0];
			var formData = new FormData(form);

			console.log(formData);
	        mensaje = "";      

	        $("#loader-contacto").show();
	        $.ajax({
				method: "POST",
				url:"/ajax/webformSubmit",
				//data: $(this).serialize(),
				data: formData,
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false
			})
			.done(function(data) {
					//ga('send', 'event', 'Envío', 'Contacto', urlactual);

                                        /*dataLayer.push({
					'Envío formulario de contacto':'value',
					'event':'Envío Contacto'
					});*/

					console.log(data);
					$('#form-contacto').css('display', 'none');

					if($('#messages-webform').hasClass('alert-danger')){
						$('#messages-webform').removeClass('alert-danger');
						
					}
					$('#messages-webform').addClass('alert-success');
					mensaje = 'Su mensaje ha sido enviado exitosamente<br /><br /><a href="javascript:void(0);" id="volver-formulario-contacto">&laquo Volver al Formulario</a>';
					$('#messages-webform').css('display', 'block');	
					$('#messages-webform').html(mensaje);
				
					
				
				
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);			
				mensaje = 'Su mensaje no se ha podido enviar. Por favor intentelo más tarde';
				$('#messages-webform').css('display', 'block');	
				$('#messages-webform').html(mensaje);

				
			})
			.always(function(){
				$("#loader-contacto").hide();
			});
		  
        }else{
        	mensaje = 'Lo sentimos. Se presentaron los siguientes problemas: <br /><br /><ul>'+mensaje+'</ul>';
        	$('#messages-webform').css('display', 'block');	
			$('#messages-webform').html(mensaje);
        }
       
        
		


		// stop the form from submitting the normal way and refreshing the page
        event.preventDefault();

    });

	$('#volver-formulario-contacto').live('click', function(){
		if ($('#form-contacto').css('display')=='none'){
			$('#form-contacto').css('display', 'block');
			$('#form-contacto').find('input[type="text"]').val("");
			$('#form-contacto').find('textarea').val("");
			$('#form-contacto').find('select option:selected').val("default");
		}

		if ($('#messages-webform').css('display')=='block'){
			$('#messages-webform').css('display', 'none');
		}
		

	});


	/* Suscripción al Boletín  Form */

	$('#form-suscripcion-boletin').submit(function(event) {

        // get the form data
        // there are many ways to get this data using jQuery (you can use the class or id also)
        
        var form_completo = true;
        var mensaje = "";

        $('#form-suscripcion-boletin input').css('border', 'none');

        if($("#form-suscripcion-boletin input#nombre").val()==""){
        	mensaje = mensaje + "<li>El cambo de Nombre se encuentra vacío</li>";
        	var form_completo = false;
        	$('#form-suscripcion-boletin input#nombre').css('border','1px solid red');
        	if(!$('#messages-webform').hasClass('alert-danger')){
        		$('#messages-webform').addClass('alert-danger');
        	}
        }
        if($('#form-suscripcion-boletin input#correo').val()==""){
        	mensaje = mensaje + "<li>El cambo de Correo se encuentra vacío</li>";
        	var form_completo = false;
        	$('#form-suscripcion-boletin input#correo').css('border','1px solid red');
        	if(!$('#messages-webform').hasClass('alert-danger')){
        		$('#messages-webform').addClass('alert-danger');
        	}
        }else if(validateEmail($('#form-suscripcion-boletin input#correo').val())==false){
        	mensaje = mensaje + "<li>No se ha insertado un correo electrónico correcto.</li>";
        	var form_completo = false;
        	$('#form-suscripcion-boletin input#correo').css('border','1px solid red');
        	if(!$('#messages-webform').hasClass('alert-danger')){
        		$('#messages-webform').addClass('alert-danger');
        	}
        }

        
        if(form_completo==true){
        	var fm = $(this);
			var form = fm[0];
			var formData = new FormData(form);
	        mensaje = "";      

	        $("#loader-contacto").show();
	        $.ajax({
				method: "POST",
				url:"/ajax/webformSubmit",
				//data: $(this).serialize(),
				data: formData,
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false
			})
			.done(function(data) {
					//ga('send', 'event', 'Envío', 'Boletín', urlactual);

                                        /*dataLayer.push({
					'Envío formulario de boletín':'value',
					'event':'Envío boletín'
					});*/

					console.log(data);
					$('#form-suscripcion-boletin').css('display', 'none');

					if($('#messages-webform').hasClass('alert-danger')){
						$('#messages-webform').removeClass('alert-danger');
						
					}
					$('#messages-webform').addClass('alert-success');
					mensaje = '¡Muchas Gracias!. Ha sido registrado en nuestra base de datos para que reciba información sobre ofertas laborales en BAC | Credomatic.<br /><br /><a href="javascript:void(0);" id="volver-formulario-suscripcion">&laquo Volver al Formulario</a>';
					$('#messages-webform').css('display', 'block');	
					$('#messages-webform').html(mensaje);
				
					
				
				
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);			
				mensaje = 'Su mensaje no se ha podido enviar. Por favor intentelo más tarde';
				$('#messages-webform').css('display', 'block');	
				$('#messages-webform').html(mensaje);

				
			})
			.always(function(){
				$("#loader-contacto").hide();
			});
		  
        }else{
        	mensaje = 'Lo sentimos. Se presentaron los siguientes problemas: <br /><br /><ul>'+mensaje+'</ul>';
        	$('#messages-webform').css('display', 'block');	
			$('#messages-webform').html(mensaje);
        }
       
        
		


		// stop the form from submitting the normal way and refreshing the page
        event.preventDefault();

    });

	$('#volver-formulario-suscripcion').live('click', function(){
		if ($('#form-suscripcion-boletin').css('display')=='none'){
			$('#form-suscripcion-boletin').css('display', 'block');
			$('#form-suscripcion-boletin').find('input[type="text"]').val("");
		}

		if ($('.messages').css('display')=='block'){
			$('.messages').css('display', 'none');
		}
		

	});




	/* Manejo de Mapa de Países en Contacto
	*/


	var paises_info = {
		"costa-rica" : {
			"informacion_pais": '<div class="mapa-contacto-pais-titulo">Costa Rica</div>\
	<div class="mapa-contacto-pais-direccion mapa-contacto-pais-detalle">\
		Centro Corporativo Plaza Roble\
		Terrazas B, Piso No. 3\
		Guachipelín, Escazú\
		San José, Costa Rica</div>\
	<div class="mapa-contacto-pais-telefono mapa-contacto-pais-detalle">(506) 2502-8326</div>\
	<div class="mapa-contacto-pais-correo mapa-contacto-pais-detalle"><a href="mailto:reclutamientoth@credomatic.com">reclutamientoth@credomatic.com</a><br/>\
	<a href="mailto:reclutamientoregional@baccredomatic.com">reclutamientoregional@baccredomatic.com</a></div>\
	<a class="btns paisinfo" href="/presencia-regional/costa-rica/10">Más de BAC | Credomatic <br>en Costa Rica</a>'
	
		},
		"panama" : {
			"informacion_pais": '<div class="mapa-contacto-pais-titulo">Panamá</div>\
	<div class="mapa-contacto-pais-direccion mapa-contacto-pais-detalle">\
		 Calle Aquilino de la Guardia\
   		 Edificio Galerías Balboa\
   	     Piso No. 2, Oficina # 36\
	     Panamá\
		</div>\
	<div class="mapa-contacto-pais-telefono mapa-contacto-pais-detalle">(507) 206-2700</div>\
	<div class="mapa-contacto-pais-correo mapa-contacto-pais-detalle"><a href="mailto:recursoshumanos@pa.bac.net">recursoshumanos@pa.bac.net</a></div>\
	<a class="btns paisinfo" href="/presencia-regional/panama/11">Más de BAC | Credomatic <br>en Panamá</a>'
		},
		"nicaragua" : {
			"informacion_pais": '<div class="mapa-contacto-pais-titulo">Nicaragua</div>\
	<div class="mapa-contacto-pais-direccion mapa-contacto-pais-detalle">\
		Km. 4.5 carretera a Masaya\
		Edificio Pellas, piso no. 5\
		Managua </div>\
	<div class="mapa-contacto-pais-telefono mapa-contacto-pais-detalle">(505) 2274-4444 ext. 5870</div>\
	<div class="mapa-contacto-pais-correo mapa-contacto-pais-detalle"><a href="mailto:tuempleo@bac.com.ni">tuempleo@bac.com.ni</a></div>\
	<a class="btns paisinfo" href="/presencia-regional/nicaragua/9">Más de BAC | Credomatic <br>en Nicaragua</a>'
		},
		"elsalvador" : {
			"informacion_pais": '<div class="mapa-contacto-pais-titulo">El Salvador</div>\
	<div class="mapa-contacto-pais-direccion mapa-contacto-pais-detalle">\
		55 Avenida Sur, entre Alameda Roosevelt y Av. Olímpica\
		Edificio A. 1er Nivel\
		San Salvador</div>\
	<div class="mapa-contacto-pais-telefono mapa-contacto-pais-detalle">(503) 2298-1855</div>\
	<div class="mapa-contacto-pais-correo mapa-contacto-pais-detalle"><a href="mailto:seleccion@sv.credomatic.com">seleccion@sv.credomatic.com</a></div>\
	<a class="btns paisinfo" href="/presencia-regional/el-salvador/8">Más de BAC | Credomatic <br>en El Salvador</a>'
		},
		"guatemala" : {
			"informacion_pais": '<div class="mapa-contacto-pais-titulo">Guatemala</div>\
	<div class="mapa-contacto-pais-direccion mapa-contacto-pais-detalle">\
		Avenida Petapa 38-39, Zona 12\
		 Edificio BAC Credomatic\
		Guatemala</div>\
	<div class="mapa-contacto-pais-telefono mapa-contacto-pais-detalle">(502) 2361-0909</div>\
	<div class="mapa-contacto-pais-correo mapa-contacto-pais-detalle"><a href="mailto:seleccionpersonal@credomatic.com.gt">seleccionpersonal@credomatic.com.gt</a></div>\
	<a class="btns paisinfo" href="/presencia-regional/guatemala/6">Más de BAC | Credomatic <br>en Guatemala</a>'
		},
		"honduras" : {
			"informacion_pais": '<div class="mapa-contacto-pais-titulo">Honduras</div>\
	<div class="mapa-contacto-pais-titulo2 mapa-contacto-pais-detalle"><strong>Tegucigalpa</strong></div>\
	<div class="mapa-contacto-pais-direccion mapa-contacto-pais-detalle">\
		Distrito Central, Boulevard Suyapa, \
		frente a Emisoras Unidas</div>\
	<div class="mapa-contacto-pais-telefono mapa-contacto-pais-detalle">(504) 2553-4444</div>\
	<div class="mapa-contacto-pais-correo mapa-contacto-pais-detalle"><a href="mailto:tuempleobac@baccredomatic.hn">tuempleobac@baccredomatic.hn</a></div>\
	<div class="mapa-contacto-pais-titulo2 mapa-contacto-pais-detalle"><strong>San Pedro Sula</strong></div>\
	<div class="mapa-contacto-pais-direccion mapa-contacto-pais-detalle">\
		Edificio Construmall  Piso No. 2, \
		Santa Mónica Fase # 3. Colonia Colombia, Sector El Playón, junto\
		a Hospital Militar </div>\
	<div class="mapa-contacto-pais-telefono mapa-contacto-pais-detalle">(504) 2553-4444</div>\
	<div class="mapa-contacto-pais-correo mapa-contacto-pais-detalle"><a href="mailto:tuempleosps@baccredomatic.hn">tuempleosps@baccredomatic.hn</a></div>\
	<a class="btns paisinfo" href="/presencia-regional/honduras/7">Más de BAC | Credomatic <br>en Honduras</a>'
		},
		"mexico" : {
			"informacion_pais": '<div class="mapa-contacto-pais-titulo">México</div>\
	<div class="mapa-contacto-pais-direccion mapa-contacto-pais-detalle">\
		Avenida Lázaro Cárdenas 3590\
		Colonia Jardines de los Arcos\
		Guadalajara, Jalisco\
		Código Postal 44500</div>\
	<div class="mapa-contacto-pais-telefono mapa-contacto-pais-detalle">(52) 33 38 80 3780 ext. 5202</div>\
	<div class="mapa-contacto-pais-correo mapa-contacto-pais-detalle">\
	<a href="mailto:omorones@credomatic.com">omorones@credomatic.com</a>\
	<a href="mailto:ohuertah@credomatic.com">ohuertah@credomatic.com</a>\
	<a href="mailto:kmartinezp@credomatic.com">kmartinezp@credomatic.com</a>\
	</div>\
	<a class="btns paisinfo" href="/presencia-regional/mexico/5">Más de BAC | Credomatic <br>en México</a>'
			
		},
	};

	

	$('.vista-contacto .tooltip-pais-wrapper').hover(function(){
		var pais_selected = $(this).attr('data-pais');
		$('.mapas-paises-hover-container .mapas-paises-hover.mapas-paises-hover-'+pais_selected).css('opacity', 1);
		//$('.mapas-paises-hover-container .mapas-paises-hover.mapas-paises-hover-'+pais_selected).show('fast');
		//$('.popup-container').css('opacity', 1);
		$('.popup-container').slideDown('fast');
		$('.popup-container').html(paises_info[pais_selected]['informacion_pais']);
		/*$('.popup-container .mapa-contacto-pais-direccion').html(paises_info[pais_selected]['direccion']);
		$('.popup-container .mapa-contacto-pais-telefono').html(paises_info[pais_selected]['telefono']);
		$('.popup-container .mapa-contacto-pais-correo').html('<a href="mailto:'+paises_info[pais_selected]['correo']+'">'+paises_info[pais_selected]['correo']+'</a>');*/
	},function(){
		var pais_selected = $(this).attr('data-pais');
		$('.mapas-paises-hover-container .mapas-paises-hover.mapas-paises-hover-'+pais_selected).css('opacity', 0);
		//$('.mapas-paises-hover-container .mapas-paises-hover.mapas-paises-hover-'+pais_selected).show('fast');
		//$('.popup-container').css('opacity', 0);
	});
	$("#close_popup").click(function(){
		$('.popup-container').slideUp('fast');
	});


	

	/************** SLIDER DEL HOME **************/
/*****************************************/
	var slider = $('.slider-home');
	if(slider.length > 0){
		
		/*$.getScript( "/public/lib/bxslider/jquery.bxslider.min.js", function( data, textStatus, jqxhr ) {
			if($("#bxslidercss").length <= 0){
				$('<link/>', {
				   id:  'bxslidercss',
				   rel: 'stylesheet',
				   type: 'text/css',
				   href: '/public/lib/bxslider/jquery.bxslider.min.css'
				}).appendTo('body');
			}

			$(slider).bxSlider({
				infiniteLoop: false,
				hideControlOnEnd: true,
				pager: false,
				adaptiveHeight: true
			});			

		});*/
		$(slider).bxSlider({
			infiniteLoop: false,
			hideControlOnEnd: true,
			pager: false,
			adaptiveHeight: true,
			responsive: true
		});	
	}

//agregar campo adicional para las referencias con base en el ultimo del formulario
	$("#mas-enlace-registro a").on("click", function(){

		//verificar si hay enlaces ocultos "eliminados" por el usuario
		var enlaces_ocultos = $(".input-group.hidden").length;
		if(enlaces_ocultos > 0){	
			var contador = 0;
			$(".input-group.hidden").each(function(e){
				contador++;
				if(contador == enlaces_ocultos){
					$(this).removeClass("hidden");
					$(this).addClass("active");
					$(".enlaces").append($(this));
				}
			});
		} else {
			var enlaces_count = $('#enlaces .enlaces input').length;
			if(enlaces_count < 5){
				$('#enlaces .enlaces').append('<div class="input-group active"><input type="text" name="field_elances[und][' + enlaces_count + '][value]" value="" id="enlace" maxlength="100" size="50" style="border: none;"><span class="input-group-remove">X</span></div>');
			}
		}
	});



	/*****************************************/
	/*****************************************/

	/************** Mapa DEL HOME **************/
	/*****************************************/

	$('.vista-inicio .tooltip-pais-wrapper').hover(function(){
		var pais_selected = $(this).attr('data-pais');
		$('.mapas-paises-hover-container .mapas-paises-hover.mapas-paises-hover-'+pais_selected).css('opacity', 1);
		
	},function(){
		var pais_selected = $(this).attr('data-pais');
		$('.mapas-paises-hover-container .mapas-paises-hover.mapas-paises-hover-'+pais_selected).css('opacity', 0);
		
	});
	
	/*****************************************/
	/*****************************************/

/*****************************************/
/*****************************************/
	


	/************** Tooltip para formulario de Registro **************/
	/*****************************************/


	$('.tooltip-form-register').hover(function(){
		var id_tooltip_register = $(this).attr('data-field');

		$('.tooltip-form-register-detail[data-field="'+id_tooltip_register+'"]').show('fast');

	}, function(){
		var id_tooltip_register = $(this).attr('data-field');

		$('.tooltip-form-register-detail[data-field="'+id_tooltip_register+'"]').hide('fast');
	});


	/*****************************************/
	/*****************************************/

	/************** Mapa DE IMPACTO REGIONAL **************/
	/*****************************************/

	$('.st-impacto-regional-mapa-bloque .tooltip-pais-wrapper').hover(function(){
		var pais_selected = $(this).attr('data-pais');
		$('.mapas-paises-hover-container .mapas-paises-hover.mapas-paises-hover-'+pais_selected).css('opacity', 1);
		
	},function(){
		var pais_selected = $(this).attr('data-pais');
		$('.mapas-paises-hover-container .mapas-paises-hover.mapas-paises-hover-'+pais_selected).css('opacity', 0);
		
	});
	
	/*****************************************/
	/*****************************************/

/*****************************************/
/*****************************************/

  /********** remove references registration/edit profile ***************/
  $('.input-group-remove').live('click', function(){
  	
  	var total_elementos = parseInt($('.enlaces .input-group.active').length); //cuantos elementos hay en total
  	var id_enlace = parseInt($(this).parent().find('input').attr('data-id-enlace')); //buscar dentro del elemento el identificador
  	var enlace = $(this).parent().find('input');

  	id_enlace += 1;
  	//si la comparacion entre el total de elementos es igual al el identificador mas 1, se ocultara el elemento respectivo y se asignara como vacio
  	/*if(total_elementos == id_enlace){
	  	eliminarEnlace(enlace);
	} else {*/
		//de lo contarario se recorrera los inputs
		var diferencia = (total_elementos - id_enlace);
		//diferencia es la cantidad de recorridos
		var id_enlace_remplazar = id_enlace;
		var id_numero_objetivo = (id_enlace - 1);
		for (var i = 0; i < diferencia; i++) {
			console.log(id_enlace_remplazar+':'+id_numero_objetivo);
			$("input[data-id-enlace='"+ id_enlace_remplazar +"']").attr('name','field_elances[und]['+ id_numero_objetivo +'][value]');
			$("input[data-id-enlace='"+ id_enlace_remplazar +"']").attr("data-id-enlace", id_numero_objetivo);
			id_enlace_remplazar++;
			id_numero_objetivo++;
		};
	/*}*/
	eliminarEnlace(enlace, total_elementos - 1);
  });
	
  function eliminarEnlace(obj, num){
  		obj.attr("value","");
  		obj.parent().removeClass('active');
	  	obj.parent().addClass('hidden');
	  	obj.attr('name','field_elances[und]['+ num +'][value]');
	  	obj.attr('data-id-enlace', num);
  }
	
});

function detectmob() { 
	 if( navigator.userAgent.match(/Android/i)
	 || navigator.userAgent.match(/webOS/i)
	 || navigator.userAgent.match(/iPhone/i)
	 || navigator.userAgent.match(/iPad/i)
	 || navigator.userAgent.match(/iPod/i)
	 || navigator.userAgent.match(/BlackBerry/i)
	 || navigator.userAgent.match(/Windows Phone/i)
	 ){
	    return true;
	  }
	 else {
	    return false;
	  }
}


function validateEmail(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);
}

function errorCampo(campo){
	$(campo).css("border","1px solid red").focus();
}

function validarVerificarEmail(autoGuardado,msgtitulo) 
{

	/*function validarVerificarEmail(autoGuardado=null){*/

	var email = $(".contentform input#correo");
		var btn_perfil = $('#perfil #boton-enviar');
		var btn_regist = $(".form#register input#boton-enviar");
		if(btn_perfil.length > 0){
			btn_perfil.prop( "disabled", true).val('Verificando').css({'background-image':'url(/public/images/loader_nar.gif)','text-align':'left', 'padding-left': '30px'});
		}
		if(btn_regist.length > 0){
			btn_regist.prop( "disabled", true).val('Verificando').css({'background-image':'url(/public/images/loader_red.gif)','text-align':'left', 'padding-left': '30px'});
		}

	if(email.val() == ""){

		mostrarMensajeError('El campo correo es requerido');
		errorCampo(email);

	} else {

		email.prop( "disabled", true).css({'background-image':'url(/public/images/verificando-email.gif)'});
		
		$.ajax({
			url: "/verificar-validar-correo?email=" + email.val(),
		    error:function (jqXHR, textStatus, errorThrown) {
                            email.prop( "disabled", false).css({'background-image':'url()'});
		    	alert( errorThrown );
		    },
		    success: function (data) { 

				if(data.valido == false){

					errorCampo(email);
						var titulo = 'El correo que ha ingresado no existe, favor verifique. Para poder continuar tienes que ingresar un correo válido.';
						if(msgtitulo !== 0){
							titulo = msgtitulo;
						}

						$.msgBox({type: "prompt",
							title: titulo,
							opacity: 0.6,
							inputs: [
							{ header: "<b>Correo electrónico</b>", type: "text", name: "mail", "value": email.val() }],
							buttons: [{ value: "Validar" }],
							success: function (result, values) { 
								$(values).each(function (index, input) {
									if(input.name == 'mail'){
										email.val(input.value);
									}
								});
								validarVerificarEmail(autoGuardado, 0);
							}
						});
				} else {
					
					var typeform = email.attr('class');
					var currentEmail = email.attr('data');
					$.ajax({
						url:"/rrhh/api/users/validate_email/retrieve.json?u_email=" + email.val(),
					}).done(function(data2) {
						//validar estado
						//si el tipo de formulario es 'perfil se validara a excepcion del correo actual del usuario'
						if(data2.encontrado == true){
							if((typeform == 'perfil') && (currentEmail != email.val())){
								mostrarMensajeError('Estimado usuario: el correo que utilizaste ya ha sido registrado. Puedes elegir otro correo');
								errorCampo(".contentform input#correo");
							}else if(typeform == 'register'){

								errorCampo(email);
								$.msgBox({type: "prompt",
									title: "Este correo ya ha sido registrado. Puedes elegir otro correo o <a href=\"recordar\" class=\"enlace-recordar\">recuperar tu contraseña.</a>",
									opacity: 0.6,
									inputs: [
									{ header: "<b>Correo electrónico</b>", type: "text", name: "mail", "value": email.val() }],
									buttons: [
									{ value: "Validar" }],
									success: function (result, values) {
										$(values).each(function (index, input) {
											if(input.name == 'mail'){
												email.val(input.value);
											}
										});
										validarVerificarEmail(autoGuardado, 0);
									}
								});
							}
						}
					}).always(function(){
			
						if(autoGuardado == 1){
							btn_perfil.trigger( "click" );
							btn_perfil.prop( "disabled", true).val('Guardando.').css({'background-image':'url(/public/images/loader_nar.gif)','text-align':'left', 'padding-left': '30px'});
						}
						email.css('border','none');
						email.prop( "disabled", false).css({'background-image':'url()'});
					});
				}

		  	}, complete: function(){

		  		if(btn_perfil.length > 0){
		  			btn_perfil.prop( "disabled", false).val('Actualizar').css({'background-image':'url()','text-align':'center', 'padding-left': '0'});
		  		}
		  		if(btn_regist.length > 0){
		  			btn_regist.prop( "disabled", false).val('Guardar').css({'background-image':'url()','text-align':'center', 'padding-left': '0'});
		  		}

		  	}

		});

	}

}

