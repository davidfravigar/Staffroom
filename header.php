<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<?php // force Internet Explorer to use the latest rendering engine available ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<title><?php wp_title(''); ?></title>

		<?php // mobile meta (hooray!) ?>
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) ?>
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-touch.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<?php // or, set /favicon.ico for IE10 win ?>
		<meta name="msapplication-TileColor" content="#f01d4f">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php // wordpress head functions ?>
		<?php wp_head(); ?>
		<?php // end of wordpress head ?>

		<?php // drop Google Analytics Here ?>
		<?php // end analytics ?>

	</head>
	<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
	<div class="container">
	<header id="site-header" class="row">
			<div id="site-branding" class="col-xs-12 col-md-6">
				<a href="<?php echo site_url(); ?>">
					<img  class="img-responsive" src="<?php echo get_template_directory_uri() . '/library/images/staffroom-logo.png'; ?>" alt="">
				</a>
				<?php
					if(is_front_page())
					{
						$contents = new Staffroom_magazine_contents;
					 	$magazine_slug = $contents->the_latest_magazine();
					 	$args = array(
					 		'name'			=> $magazine_slug,
					 		'post_type'		=> 'magazine',
					 		'post_status'	=> 'publish',
					 		'numberposts'	=> 1
						);
						$post = get_posts($args);
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
					}
					else
					{
				 		$post_id = $post->ID;
						$contents = new Staffroom_magazine_contents;
						$contents->the_magazine_title($post_id);
					}
				?>
			</div>
			<div id="site-navigation" class="col-xs-12 col-md-4 col-md-offset-2">
				<div class="row">
					<div class="col-md-12">
					<ul id="social-navigation" class="pull-right nav nav-pills">
		            	<li class="social-icon twitter">
							<a target="_blank" href="https://www.twitter.com/osirisedu">
								<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/library/images/icons/twitter.png">
							</a>
						</li>
						<li class="social-icon pinterest">
							<a target="_blank" href="https://uk.pinterest.com/osirisedu/">
								<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/library/images/icons/pinterest.png">
							</a>
						</li>
						<li class="social-icon facebook">
							<a target="_blank" href="https://www.facebook.com/osiriseducational">
								<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/library/images/icons/facebook.png">
							</a>
						</li>
						<li class="social-icon googleplus">
							<a target="_blank" href="https://plus.google.com/105526175386535909223/posts">
								<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/library/images/icons/googleplus.png">
							</a>
						</li>
						<li class="social-icon youtube">
							<a target="_blank" href="https://www.youtube.com/osiriseducational">
								<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/library/images/icons/youtube.png">
							</a>
						</li>
					</ul>
					</div>
				</div>
				<div id="site-search" class="col-md-12">
					<div class="form-group">
						<?php
							$contents = new Staffroom_magazine_contents;
							$post_type = '';
							$post_id = '';
							if(is_front_page())
							{
							 	$magazine_slug = $contents->the_latest_magazine();
							 	$args = array(
							 		'name'			=> $magazine_slug,
							 		'post_type'		=> 'magazine',
							 		'post_status'	=> 'publish',
							 		'numberposts'	=> 1
								);

								$post = get_posts($args);

								$post_id = $post[0]->ID;
								$post_type = get_post_type($post[0]->ID);
							}
							elseif(is_single())
							{
								$post_id = get_the_ID();
								$post_type =  get_post_type($post);
							}
							else
							{
								echo '<option value="">';
								echo 'No Articles Found!';
								echo '</option>';
							}
						?>
						<select name="term-articles" id="term-select"  onchange='document.location.href=this.options[this.selectedIndex].value;' class="form-control">
						<option value="">
						<?php echo esc_attr( __( 'Select: This Term' ) ); ?></option>
						<?php $contents->get_magazine_articles($post_id); ?>
						</select>
					</div>
					<div class="form-group">
						<?php
							$args = array(
								'sort_order' => 'ASC',
								'sort_column' => 'post_title',
								'hierarchical' => 1,
								'exclude' => '',
								'include' => '',
								'meta_key' => '',
								'meta_value' => '',
								'authors' => '',
								'child_of' => 0,
								'parent' => -1,
								'exclude_tree' => '',
								'number' => '',
								'offset' => 0,
								'post_type' => 'magazine',
								'post_status' => 'publish'
							);
						?>
						<select name="page-dropdown" id="issue-select"
						onchange='document.location.href=this.options[this.selectedIndex].value;'
						class="form-control">
						<option value="">
							<?php echo esc_attr( __( 'Select: Past Issues' ) ); ?></option>
							 <?php
							  $pages = get_pages($args);
							  foreach ( $pages as $page ) {
							  	$option = '<option value="' . get_page_link( $page->ID ) . '">';
								$option .= $page->post_title;
								$option .= '</option>';
								echo $option;
							  }
							 ?>
						</select>
					</div>
				</div>
			</div>
	</header>