<div class="w-section">
	<div class="w-container">
		<?php extract($info);?>
		<h1><?=$title?></h1> <span class="npuestos"><?=$total?> puestos disponibles</span>
		<p><?=$body?></p>

	</div>
</div>

<?php require_once 'bloques/filtrado_puestos.php';?>

<?php require_once 'bloques/historias-proyecto-destacado.php';?>

<?php require_once 'bloques/testimonios.php';?> 