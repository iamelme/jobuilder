
<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package jobuilder
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="section__title   t1 t-cnter">', '</h1>' ); ?>
	</header>

	<div class="page__content">
		<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'jobuilder' ),
				'after'  => '</div>',
			) );
		?>
	</div>

	<div class="message"></div>
	<div class="form-container">
		
		<form id="user-post" class="form">

			<?php wp_nonce_field( basename( __FILE__ ), 'user-submitted-inquiry'); ?>
			<div class="row">
				<div class="col col-md-6">
					<div class="form__group">
						<label class="form__label" for="user-name">Name</label>
						<input type="text" name="user-name" id="user-name"  class="important form__control">
					</div>
				</div>
				<div class="col col-md-6">
					<div class="form__group">
						<label class="form__label" for="user-email">E-mail</label>
						<input type="email" name="user-email" id="user-email"  class="important form__control">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col col-md-6">
					<div class="form__group">
						<label class="form__label" for="user-phone">Phone</label>
						<input type="text" name="user-phone" id="user-phone"  class="important form__control">
					</div>
				</div>
				<div class="col col-md-6">
					<div class="form__group">
						<label class="form__label" for="type">Subject</label>
						<select name="type" id="type" class="important form__control">
							<?php
								$terms = get_terms( 'type', array(
								    'hide_empty' => false,
								) );

								foreach($terms as $term) {
									echo '<option value="'. $term->name .'">' . $term->name .'</option>';
								}
							?>
						</select>

					</div>
				</div>
			</div>
			
			
			<div class="form__group">
				<label class="form__label" for="user-message">Message</label>
				<textarea name="user-message" id="user-message" cols="30" class="important form__control" ></textarea>
			</div>
			

			<div class="form__group">
				<div class="g-recaptcha" data-callback="recaptchaCallback" data-sitekey="6LemrzwUAAAAADVhbActKKR-wxaVhB5HEJTLWxNS"></div>
			</div>
			
			<input type="submit" id="user-submit-btn" class="btn btn-default" value="Submit" disabled>
		</form>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->



