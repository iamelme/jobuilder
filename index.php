<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package jobuilder
 */

get_header(); ?>

	<section class="hero">
		<div class="hero__inner">
			
			<div class="hero__content">
				
				<h1 class="hero__title">BUILDING WITH <span class="tc-red">PRIDE</span></h1>
				<p class="hero__text">HOME IMPROVEMENT, RENOVATIONS &amp; REPAIR</p>

				<a href="contact" class="btn btn-rounded btn-white btn-large">GET IN TOUCH</a>

			</div>
	
		</div>

		<a href="#start" class="skip-link">&larr;</a>

		<div class="hero__info">
			<div class="row">
				<div class="col col-md-6">
					<div class="t4">EMAIL</div>
					<a href="mailto:<?php echo bloginfo('admin_email'); ?>" class=""><?php echo bloginfo('admin_email'); ?></a> 
				</div>
				<div class="col col-md-6 t-right">
					<div class="t4">PHONE</div>
					<a href="">33 333 333</a>
				</div>
			</div>
		</div>

		<div class="filter"></div>
	</section>


	<section class="section section--padded section--grey effects" id="start">
		<div class="section__inner t-cnter ">
			<h2 class="t4">WELCOME</h2>
			<h2 class="section__title section__title-ntop t1"><span class="tc-red">Why</span> choose us</h2>

			<div class="grid ">
				<div class="grid__item ">
					<div class="grid__item--inner">
						<svg class="icon icon-treats icon-quality">
						  	<use xlink:href="#icon-quality"></use>
						</svg>
						<div class="t3">Quality</div>
						<p>Lorem ipsum dolor sit amet. </p>
					</div>
				</div>
				<div class="grid__item">
					<div class="grid__item--inner">
						<svg class="icon icon-treats icon-flexible">
					  	<use xlink:href="#icon-flexible"></use>
						</svg>
						<div class="t3">Flexible</div>
						<p>Lorem ipsum dolor sit amet. </p>
					</div>
				</div>
				<div class="grid__item">
					<div class="grid__item--inner">
						<svg class="icon icon-treats icon-quick">
						  	<use xlink:href="#icon-quick"></use>
						</svg>
						<div class="t3">Quick</div>
						<p>Lorem ipsum dolor sit amet. </p>
					</div>
				</div>
			</div>
		</div>
	</section>




	<section class="section section--padded section--equipment effects">
		<div class="section__inner ">
			<div class="row">
				<div class="col col-md-6"></div>
				<div class="col col-md-6">
					<div class="col  toLeft">

						<?php

						    $your_query = new WP_Query( 'pagename=about' );

						    while ( $your_query->have_posts() ) : $your_query->the_post();
						        the_content();
						    endwhile;

						    wp_reset_postdata();
						?>
	

						<h2 class="section__title  t2"> Who we are</h2>

							<?php

						    $your_query = new WP_Query( 'pagename=about-us' );
						

						    	while ( $your_query->have_posts() ) : $your_query->the_post(); ?>

						        <?php the_excerpt(); ?>

								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="link link--white">READ MORE</a>

							<?php 
							    endwhile;

							    wp_reset_postdata();
						
							?>
					</div>
				</div>
			</div>
		</div>
	</section>


	<section class="section section--padded ">
		<div class="section__inner ">
			<h2 class="section__title t2"><span class="tc-red">What</span> we do</h2>

			<div class="row">
				<div class="col col-md-9">
					<div class="owl-carousel ">
						<?php 

							$args = [ 
							    'post_type'           => 'work',
							    'posts_per_page'      => 4
							];


							$query = new WP_Query( $args );

							if ( $query->have_posts() ) :
							 	

							    while ( $query->have_posts() ) :  $query->the_post();

						?>
					    <div class="item">
					    	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					    		<img class="owl-lazy " data-src="<?php the_post_thumbnail_url( array( 198, 278 ) ); ?>" alt="">
					    	</a>
					    	<h2 class="t4 item__title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
					    	<div class="item__content"><?php the_excerpt(); ?></div>
					    </div>

					    <?php 

								endwhile;
							    wp_reset_postdata();
							endif;

						?>


					</div>
				</div>
				<div class="col col-md-3 card work-more">
					<a href="work" class="card--link"><span>VIEW MORE</span></a>
				</div>
			</div>
		</div>
	</section>
	

	<script>
		document.addEventListener('DOMContentLoaded', (function(){

			let effectItems = document.querySelectorAll(".effects");

			function debounce(func, wait = 20, immediate = true) {
		      var timeout;
		      return function() {
		        var context = this, args = arguments;
		        var later = function() {
		          timeout = null;
		          if (!immediate) func.apply(context, args);
		        };
		        var callNow = immediate && !timeout;
		        clearTimeout(timeout);
		        timeout = setTimeout(later, wait);
		        if (callNow) func.apply(context, args);
		      };
		    };

			function checkItemSlide() {
				
				Array.prototype.map.call(effectItems, (el, idx) => {
					var scrollHalf = (window.scrollY + window.innerHeight) - el.offsetHeight / 2;

					console.log(el.offsetTop + " idx " +idx);

					if(scrollHalf > el.offsetTop ) {
						el.classList.add("effectActive");
					} else {
						el.classList.remove("effectActive");
					}
				});
			}

			window.addEventListener("scroll", debounce(checkItemSlide));


		})() );
	</script>


<?php
get_footer();
