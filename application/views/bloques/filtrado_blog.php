<?php


$taxonomias = $this->cache->get('blog-categorias-blog');
if(!$taxonomias){
	$taxonomias = $this->general->getJSON('/rrhh/api/blog/categorias-blog.json');
	$this->cache->write($taxonomias, 'blog-categorias-blog');
}


$select_cat_blog  = '';
$select_options ='';
foreach($taxonomias['results'] as $key => $value){
	extract($value);

		
	$select_options .= '
	<li class="cat-blog-'.$tid.'"><a href="/historias/categoria/'.$this->general->formatURL($name).'/'.$tid.'">'.$name.'</a></li>';				


	
}

$select_cat_blog = '<ul id="lista-cat-blog" class="ulclose">
'.$select_options.'</ul>';


?>
<div class="filtrado-blog">
	<div class="w-row">
		<div class="w-col w-col-1">
			<p>Filtrar por:</p>
		</div>
		<div class="w-col w-col-3">
			<div class="filtro-categorias">
				<a href="javascript:void(0)" class="categoria-list"><?php $categoria = (isset($categoria)) ? $categoria : "Categorias"; echo $categoria; ?> <span>&nbsp</span></a>
				<?php echo $select_cat_blog; ?>
			</div>
		</div>
		<div class="w-col w-col-8">	
			<form id="filtro-blog-form" method="get" action="/historias">
				<input type="text" name="buscar" id="buscar" placeholder="Buscar"/><span>&nbsp</span>
				<input type="submit" id="inputbuscar" value="Buscar">
			</form>
		</div>

	</div>
</div>
