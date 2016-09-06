<div class="w-section st-impacto-regional">
	<div class="w-container">
        <h1 title="Vacantes de trabajo en Centroamérica y México">¿Dónde te gustaría <strong>trabajar</strong>?<span class="linea"></span></h1><br>
        <p>Sobrepasamos las 600 sucursales a nivel regional y somos más de 22.000 colaboradores, desde México hasta Panamá. Forma parte de nuestros equipos y colabora para ayudar a que nuestros clientes tengan un mejor futuro.</p>
    </div>
</div>
<?php
	
	$listado_paises_nombres = $this->cache->get('paises-nombres');
	if(!$listado_paises_nombres){
		$listado_paises_nombres = $this->general->getJSON('/rrhh/api/paises/paises-nombres');
		$this->cache->write($listado_paises_nombres, 'paises-nombres');
	}	
		
	$paises_array = array();
	$total_cola = 0;
	$total_sucu = 0;
	$total_clien = 0;
	$total_clien_emp = 0;
	$total_cola_inclu = 0;

	foreach($listado_paises_nombres['results'] as $key => $value){
		extract($value);
		$paises_array[$nid] = $title;
		if(isset($field_numero_de_colaboradores) and !empty($field_numero_de_colaboradores)){
			$total_cola += $field_numero_de_colaboradores;
		}
		if(isset($field_numero_colaboradores_inclu) and !empty($field_numero_colaboradores_inclu)){
			$total_cola_inclu += $field_numero_colaboradores_inclu;
		}
		if(isset($field_numero_de_sucursales) and !empty($field_numero_de_sucursales)){
			$total_sucu += $field_numero_de_sucursales;
		}
		if(isset($field_numero_de_clientes) and !empty($field_numero_de_clientes)){
			$total_clien += $field_numero_de_clientes;
		}
		if(isset($field_numero_clientes_empresa) and !empty($field_numero_clientes_empresa)){
			$total_clien_emp += $field_numero_clientes_empresa;
		}

	}
?>
<?php require_once 'bloques/presencia_regional_mapa.php';?>

<div class="w-section st-impacto-regional-datos-numericos">
	<div class="w-container"><br>
		<h2>BAC | Credomatic como una <strong>opción sólida para desarrollar tu carrera</strong></h2><br>
		<div class="arow">
			<div class="acol"><div class="boxcol"><div class="tnumero bg1"><span>666 <?/*=number_format($total_sucu,0,",",".")*/?></spa></div><p class="tdesc">Sucursales (agencias) en toda la región</p></div></div>
			<div class="acol"><div class="boxcol"><div class="tnumero bg2"><span>2.075.363<?/*=number_format($total_clien,0,",",".")*/?></spa></div><p class="tdesc">Personas cliente</p></div></div>
			<div class="acol"><div class="boxcol"><div class="tnumero bg3"><span>98.961<?/*=number_format($total_clien_emp,0,",",".")*/?></spa></div><p class="tdesc">Empresas cliente</p></div></div>
			<div class="acol"><div class="boxcol"><div class="tnumero bg4"><span>22.102<?/*=number_format($total_cola,0,",",".")*/?></spa></div><p class="tdesc">Trabajadores que hacen crecer a la región</p></div></div>
			<div class="acol last"><div class="boxcol"><div class="tnumero bg5"><span>200<?/*=number_format($total_cola_inclu,0,",",".")*/?></spa></div><p class="tdesc">Colaboradores que forman parte de nuestros programas de inclusión</p></div></div>
		</div>
	</div>
</div>


<?php require_once 'bloques/bloque_parte_del_cambio.php';?>