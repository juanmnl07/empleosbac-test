<div class="historias-relacionadas">
	<h3>Historias Relacionadas</h3>

	<?php
		
		$historias_relacionadas = $this->cache->get('blog-historias-relacionadas-'.$field_categoria_blog[0]['tid'].'-'.$nid);
		if(!$historias_relacionadas){
			$historias_relacionadas = $this->general->getJSON('/rrhh/api/blog/blog-historias-relacionadas.json?categoria-id[0]='.$field_categoria_blog[0]['tid'].'&blog-id='.$nid);
			$this->cache->write($historias_relacionadas, 'blog-historias-relacionadas-'.$field_categoria_blog[0]['tid'].'-'.$nid);
		}

		if (isset($historias_relacionadas['results'])){ ?>

				<?php 

				$contador=1;

				foreach($historias_relacionadas['results'] as $key => $value){ 
					extract($value);/* historia-relacionada-id-<?=$nid ?>*/?>

					<div class="w-row historia-relacionada">
						<div class="w-col w-col-2 historia-relacionada-image">
							<?php if(isset($field_imagen)){ ?>
								<a href="/historias/<?=$this->general->formatURL($title) ?>/<?=$nid?>"><img src="<?=$field_imagen?>" /></a>
							<?php } ?>
						</div>
						<div class="w-col w-col-10">
							<div class="historia-relacionada-texto hrl-<?=$contador?>">
								<a href="/historias/<?=$this->general->formatURL($title)?>/<?=$nid?>"><?=$title?>.</a>
								<?=$body?>
							</div>
						</div>
					</div>

				<?php $contador +=1;
				 } ?>


		<?php }
		
	?>
</div>