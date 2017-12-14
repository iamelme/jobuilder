<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package jobuilder
 */

get_header(); ?>

	<section class="section section--grey">
		<div class="section__inner">
			<?php the_breadcrumb(); ?>
		</div>
	</section>

	<section class="section section--long section--">
		<div class="section__inner">

			<?php 
			global $wp;
			$current_url = home_url(add_query_arg(array(),$wp->request));


			?>
<!-- http://themebubble.com/demo/adios/portfolio/gopro-recorder/ -->

			<div class="single__thumb">
				<?php the_post_thumbnail(); ?>
			</div>

			<div class="main">

				<!-- <aside class="sidebar">
					<div class="social">
						<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($current_url); ?>&t=<?php the_title(); ?>" class="social__item facebook" target="_blank" title="Share on Facebook">Facebook</a>
						<a href="https://twitter.com/share?url=<?php echo urlencode($current_url); ?>&text=<?php the_title(); ?>" class="social__item twitter" target="_blank" title="Share on Twitter">Twitter</a>
						<a href="https://plus.google.com/share?url=<?php echo urlencode($current_url); ?>" class="social__item google" target="_blank" title="Share on Google+">Google+</a>
						<a href="mailto:?subject=<?php the_title(); ?>&amp;body=View our work here <?php echo urlencode($current_url); ?>" class="social__item mail"  title="Share on Email">Email</a>
					</div>
				</aside> -->


					<?php
					while ( have_posts() ) : the_post();

						get_template_part( 'template-parts/content', get_post_type() );

						// the_post_navigation();

					endwhile; // End of the loop.
					?>
			
				
			</div>

			
			
			
			

		</div>
	</section>
<?php
get_footer();
