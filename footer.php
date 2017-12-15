<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package jobuilder
 */

?>
	
	<footer class="footer">
		<div class="footer__inner">
			<a href="<?php echo home_url(); ?>" class="branding">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo5.png" style="max-height: 50px; margin-top: 1px" alt="">
			</a>
		</div>
		<div class="footer__inner">
			<div class="row">
				<div class="col col-md-4 footer__inner-left">
					<h4 class="t4">Location</h4>

					<div>350 Fifth Avenue,</div>
					<div>34th floor. New York,</div>
					<div>NY 10118-3299 USA</div>
				</div>

				

				<div class="col col-md-4 ">					
					
					<h4 class="t4">Contacts</h4>
					<div>Tel: <a href="">333333 33</a></div>
					<div>Email: <a href="mailto:<?php echo bloginfo('admin_email'); ?>" class=""><?php echo bloginfo('admin_email'); ?></a> </div>

					<div>
						<a href="" class="fb--link" target="_blank">
							<svg  class="icon icon-facebook">
							  	<use xlink:href="#icon-facebook"></use>
							</svg>
							Follow Us
						</a>
					</div>
				</div>

				<div class="col col-md-4 footer__inner-right">				
					
					<h4 class="t4">Links</h4>
					<nav class="menu--secondary">
						<a href="<?php echo home_url(); ?>" class="menu__item">Home</a>
						<a href="<?php echo home_url(); ?>/about-us" class="menu__item">About</a>
						<a href="<?php echo home_url(); ?>/work" class="menu__item">Work</a>
						<a href="<?php echo home_url(); ?>/contact" class="menu__item">Contact</a>
					</nav> 
				</div>
			</div>
		</div>
		<div class="footer__copyright">
			<small class="copyright">
				&copy; <?php echo date('Y'); ?> JoBuilder
			</small>
		</div>
	</footer>

</div>

<?php wp_footer(); ?>
	<script>


		document.addEventListener('DOMContentLoaded', (function(){



			let navTrigger = document.querySelector('.nav-trigger'),
				workMore = document.querySelector('.work-more');


			navTrigger.addEventListener('click', (e) => {
				e.preventDefault();

				let eAttr = navTrigger.dataset.target;

				document.getElementById(eAttr).classList.toggle('triggered');
			});

			document.addEventListener("keydown", (e) => {    
			    if(e.keyCode === 27){
			    	document.getElementById('main-header').classList.remove('triggered');				
			    }
		  	});


			$('.owl-carousel').owlCarousel({
			    lazyLoad: true,
			    margin: 10,
			    nav: true,
			    navText: ["&larr;","&rarr;"],
			    responsive : {
				    0 : {
			       		items: 1,
			       		autoplay: true,
			       		autoplayTimeout: 2300
				    },
				    480 : {
				        items: 2,
				        autoplay: true,
			       		autoplayTimeout: 2300
				    },
				    768 : {
				       	items: 3,
				    }
				}
			});


			function filterPath(string) {
			  return string
			    .replace(/^\//, '')
			    .replace(/(index|default).[a-zA-Z]{3,4}$/, '')
			    .replace(/\/$/, '');
			}

			var locationPath = filterPath(location.pathname);
			$('a[href*="#"]').each(function () {
			  var thisPath = filterPath(this.pathname) || locationPath;
			  var hash = this.hash;
			  if ($("#" + hash.replace(/#/, '')).length) {
			    if (locationPath == thisPath && (location.hostname == this.hostname || !this.hostname) && this.hash.replace(/#/, '')) {
			      var $target = $(hash), target = this.hash;
			      if (target) {
			        $(this).click(function (event) {
			          event.preventDefault();
			          $('html, body').animate({scrollTop: $target.offset().top}, 1000, function () {
			            location.hash = target; 
			            $target.focus();
			           
			          });       
			        });
			      }
			    }
			  }
			});
			
				


		
		})() );
	</script>
</body>
</html>
