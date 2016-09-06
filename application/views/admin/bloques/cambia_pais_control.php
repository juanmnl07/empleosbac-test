<?php

$entidades = $this->general->getJSON('/rrhh/api/filtros/filtros-entidades-paises.json');

$select_paises ="";
$htmlpais ="";
foreach($entidades['results'] as $key => $value){
	extract($value);
	$selected ="";
	if(($this->session->userdata('pais_admin')!==null) and ($this->session->userdata('pais_admin')!=0)){
			$pais_actual = $this->session->userdata('pais_admin');			
			if(isset($pais_actual) and $pais_actual == $nid){
				$selected = 'selected="selected" ';
			}
			
	}
	$htmlpais .= '<option value="'.$nid.'" '.$selected.'>'.$title.'</option>';
}

$select_paises = '<select id="cambia-pais-control-select"><option value="0">- Todos -</option>'.$htmlpais.'</select>';

?>

<div class="cambia-pais-control">
	<p>¿Cuál país desea ver?:</p>
	<?=$select_paises?>	

</div>