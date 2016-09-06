<div class="tags">
	<strong>TAGS</strong>

	<?php
		
		$tags = $this->cache->get('blog-id-'.$nid);
		if(!$tags){
			$tags = $this->general->getJSON('/rrhh/api/blog/tags.json?blog-id='.$nid); 
			$this->cache->write($tags, 'blog-id-'.$nid);
		}

		if (isset($tags['results'])){ ?>

				<?php 

				$contador=1;

				foreach($tags['results'] as $key => $value){ 
					extract($value);?>

					<span class="tag-<?=$contador?> tag-id-<?=$tid ?>">
						<a href="/historias/tag/<?=$this->general->formatURL($name) ?>/<?=$tid?>"><?=$name?></a>
					</span>

				<?php $contador +=1;
				 } ?>

	

		<?php }
		
	?>
</div>