<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package jobuilder
 */

?>

<?php 


	$client_name = get_post_meta( $post->ID, 'client_name', true);

?>

<aside class="sidebar">
	
	<h2 class="sidebar__title t3">PROJECT DETAIL</h2>
	
	<?php if(!empty($client_name)): ?>
		<strong>Client Name</strong>
		<div><?php echo $client_name; ?></div>
	<?php endif; ?>


	<p><strong>Share:</strong></p>
	<div class="social">
		<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($current_url); ?>&t=<?php the_title(); ?>" class="social__item facebook" target="_blank" title="Share on Facebook">
			<svg  class="icon icon-facebook">
			  	<use xlink:href="#icon-facebook"></use>
			</svg>
		</a>
		<a href="https://twitter.com/share?url=<?php echo urlencode($current_url); ?>&text=<?php the_title(); ?>" class="social__item twitter" target="_blank" title="Share on Twitter">
			<svg  class="icon icon-twitter">
			  	<use xlink:href="#icon-twitter"></use>
			</svg>
		</a>
		<a href="https://plus.google.com/share?url=<?php echo urlencode($current_url); ?>" class="social__item google" target="_blank" title="Share on Google+">
			<svg  class="icon icon-google-plus">
			  	<use xlink:href="#icon-google-plus"></use>
			</svg>
		</a>
		<a href="mailto:?subject=<?php the_title(); ?>&amp;body=View our work here <?php echo urlencode($current_url); ?>" class="social__item mail"  title="Share on Email">
			<svg  class="icon icon-mail-envelope-closed">
			  	<use xlink:href="#icon-mail-envelope-closed"></use>
			</svg>
		</a>
	</div>


</aside>

<div class="content">
	
	<article class="single">
	

		<div class="single__header">
			
		</div>

		<div class="single__content">
			<?php the_content(); ?>
		</div>


		<footer class="single__footer">
			<?php jobuilder_entry_footer(); ?>
		</footer>
	</article>
</div>


<script>
	'user strict';


	let parentGal = document.querySelectorAll('.gallery');


	parentGal.forEach((el,i)=>{
		let galleryLink = el.getElementsByTagName('a');
		

		function setAttributes(el, attrs) {
			for(var key in attrs) {
				el.setAttribute(key, attrs[key]);
			}
		}


		for(var x = 0; x < galleryLink.length; x++) {

			let galCaption = galleryLink[x].parentNode.nextElementSibling;

			setAttributes(galleryLink[x], {'data-lightbox' : el.id, 'class' : 'gallery__link', 'data-title' : galCaption != null ? galCaption.innerHTML : ''} );
		}

	});

</script>