<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package jobuilder
 */

get_header(); ?>

	<section class="section section--padded ">
		<div class="section__inner">
			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'contact' );

				the_meta();

			endwhile; // End of the loop.
			?>

		</div>
	</section>

<?php
get_footer();
