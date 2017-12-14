<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package jobuilder
 */

get_header(); ?>

	<section class="section section--long section--padded">
		<div class="section__inner">
			<h1 class="section__title  t1 t-cnter">Our Works</h1>
			<div class="work">
				<?php

					$currentPage = ( get_query_var('paged') ) ? get_query_var('paged') : 1;


					$args = [ 

					    'post_type'           	=> 'work',
			    		'order'   				=> 'DESC',	
			    		'paged' 				=> $currentPage
					];



					$query = new WP_Query( $args );
				
					if ( $query->have_posts() ) :	
	
					while ( $query->have_posts() ) :  $query->the_post();

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content-archive' );

					endwhile; ?>

					
			</div>

					<div class="paginate">
						<div class="paginate__inner">
							<?php 
							    echo paginate_links(array(
								'total' 	=> $query->max_num_pages,
								'prev_text' => __('&larr;'),
								'next_text' => __('&rarr;'),
								));
							?>
						</div>
					</div>	
				<?php

				 wp_reset_postdata();

				else :



					get_template_part( 'template-parts/content', 'none' );

				endif; ?>
			
		</div>
	</section>

<?php
get_footer();
