<article class="work__item">
	<div class="work__thumb">
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail( 'large' ); ?></a>
	</div>

	<div class="work__content">
		<h2 class="t2 tc-red"><?php the_title(); ?></h2>
		<div class="">
			<?php 


				$client_name = get_post_meta( $post->ID, 'client_name', true);

			?>
				
			<?php if(!empty($client_name)): ?>
				<strong>Client Name</strong>
				<div><?php echo $client_name; ?></div>
			<?php endif; ?>

		</div>
		<?php
			the_excerpt();
		?>
		<div>
			<a href="<?php the_permalink(); ?>" class="btn btn-rounded btn-red btn-large" title="<?php the_title(); ?>">DISCOVER</a>
		</div>
	</div>

</article>