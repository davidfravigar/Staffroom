<?php

get_header(); ?>
<main id="site-main">
	<?php
		$contents = new Staffroom_magazine_contents;
	 	$magazine_slug = $contents->the_latest_magazine();
	 	$args = array(
	 		'name'			=> $magazine_slug,
	 		'post_type'		=> 'magazine',
	 		'post_status'	=> 'publish',
	 		'numberposts'	=> 1
		);

		$post = get_posts($args);
	?>
	<section class="magazine-title">
		<?php
		if($post)
		{
			//get the title
			$title = $post[0]->post_title;
			//spilt the title on the |
			$pieces = explode("|", $title);
			//create the new title
			$new_title = '<h3>' . $pieces[0] . ' | <span>' . $pieces[1] . '<span></h3>';
			echo $new_title;
		}
		?>
	</section>
	<section class="contents-slider">

	</section>
	<section class="container">
			<div class="key-dates-slider">
				<?php
					if($post)
					{
						echo do_shortcode('[metaslider id=543]');
					}
				?>
			</div>

			<div class="espressos-section">
				<h3>Educational<br /> Espressos</h3>
				<p>“Get slicker with a clicker: roam around and get in amongst your learners — free yourself up with a clicker, you deserve it!”<br/>
				<a href="">Get updated with @osirisedu</a></p>
			</div>
		</section>
</main>
<?php get_footer(); ?>