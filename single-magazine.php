<?php get_header();?>
<?php
if (have_posts()) :
   while (have_posts()) :
      the_post(); ?>
		 <main id="site-main">
			<section id="contents-slider" class="row">
				<?php echo get_post_meta(get_the_ID(), 'author-image', true); ?>
			</section>
			<section id="magazine-adverts" class="row">
				<div class="col-md-12">
					<div id="key-dates-slider">
						<?php //work; ?>
						<?php echo do_shortcode('[metaslider id=543]'); ?>
						<?php //home ?>
						<?php echo do_shortcode('[metaslider id=53]'); ?>
					</div>
					<div id="espressos-section">
						<div class="row">
						<h3 class="col-md-4">Educational<br /> Espressos</h3>
						<p class="col-md-8">“Get slicker with a clicker: roam around and get in amongst your learners — free yourself up with a clicker, you deserve it!”<br/>
						<a href="https://twitter.com/osirisedu">Get updated with @osirisedu</a></p>
						</div>
					</div>
				</div>
			</section>
		 </main>
    <?php endwhile;
endif; ?>
<?php get_footer() ?>