<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package jobuilder
 */

get_header(); ?>

	<section class="section ">
		<div class="section__inner">
			<!-- <?php the_breadcrumb(); ?> -->


		</div>
	</section>

	<section class="section section--long section--padded">
		<div class="section__inner">

			<?php 
			global $wp;
			$current_url = home_url(add_query_arg(array(),$wp->request));


			?>
<!-- http://themebubble.com/demo/adios/portfolio/gopro-recorder/ -->



			<!-- <div class="single__thumb">
				<?php the_post_thumbnail( 'full' ); ?>
			</div> -->

			<h1 class="t1 tc-red"><?php the_title(); ?></h1>

			

			<div class="main">



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
