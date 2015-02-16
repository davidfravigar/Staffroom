<?php
$contents = new Staffroom_magazine_contents;
get_header(); ?>
<?php /* The loop */ ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<main id="site-main">
		<section class="magazine-title">
			<?php
				//get the title
				$title = $post->post_title;
				//spilt the title on the |
				$pieces = explode("|", $title);
				//create the new title
				$new_title = '<h3>' . $pieces[0] . ' | <span>' . $pieces[1] . '<span></h3>';
				echo $new_title;
			?>
		</section>
		<section class="contents-slider">

		</section>
		<section class="container">
			<div class="key-dates-slider">
			<?php //work; ?>
			<?php echo do_shortcode('[metaslider id=543]'); ?>
			<?php //home ?>
			<?php echo do_shortcode('[metaslider id=53]'); ?>
			</div>
			<div class="espressos-section">
				<h3>Educational<br /> Espressos</h3>
				<p>“Get slicker with a clicker: roam around and get in amongst your learners — free yourself up with a clicker, you deserve it!”<br/>
				<a href="">Get updated with @osirisedu</a></p>
			</div>
		</section>
		<?php endwhile; ?>
	</main>
<?php get_footer(); ?>