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
	
	<h2 class=" t3">PROJECT DETAIL</h2>
	
	<?php if(!empty($client_name)): ?>
		<strong>Client Name</strong>
		<div><?php echo $client_name; ?></div>
	<?php endif; ?>


</aside>

<div class="content">
	
	<article class="single">
	

		<div class="single__header">
			<h2 class="t1"><?php the_title(); ?></h2>
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

			setAttributes(galleryLink[x], {"data-lightbox" : el.id, "data-title" : galCaption != null ? galCaption.innerHTML : ''} );
		}

	});

</script>