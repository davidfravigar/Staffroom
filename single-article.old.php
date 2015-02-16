<?php

get_header(); ?>


<?php
if (have_posts()) :
   while (have_posts()) :
      the_post(); ?>
  	<main id="site-main">
  	<section class="magazine-title">
		<?php
			//now go get the tax for the page
			$post_id = $post->ID;
			$contents = new Staffroom_magazine_contents;
			$contents->the_magazine_title($post_id)
		?>
  	</section>
	<section class="article-header">
		<?php the_post_thumbnail('bones-article-image'); ?>
	</section>
	<section class="article-content">
         <?php the_content(); ?>
         <div class="social-share">
			<ul>
				<li>Share this article on</li>
				<li><span class="fa-stack fa-lg">
  					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
					</span>
				</li>
				<li><span class="fa-stack fa-lg">
  					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
					</span>
				</li>
				<li><span class="fa-stack fa-lg">
  					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-google-plus fa-stack-1x fa-inverse"></i>
					</span>
				</li>
			</ul>
			<ul>
				<li>
					<button type="submit" class="social-btn">
						<i class="fa fa-chevron-left"></i> Previous Article</button>
				</li>
				<li>
					<button type="submit" class="social-btn">
						Next Article <i class="fa fa-chevron-right"></i></button>
				</li>
			</ul>
    	</div>
    	<div class="page-bottom">
	    	<div class="further-reading">
	    		<h3><span><img src="<?php echo get_template_directory_uri(); ?>/library/images/icons/FurtherReading.png"></span> Further Reading</h3>
				<?php echo get_post_meta(get_the_ID(), 'further-reading', true); ?>
	    	</div>
	    	<div class="secondary-article article-advert">
				<h3 class="advert-title"><?php echo get_post_meta(get_the_ID(), 'advert-title', true); ?></h3>
				<p><?php echo get_post_meta(get_the_ID(), 'secondary-advert-description', true); ?></p>

				<p class="advert-info">Call to book now</p>
    			<h3 class="advert-phone"><?php echo get_post_meta(get_the_ID(), 'advert-phone', true); ?></h3>

    			<p class="advert-info">Click here to</p>
    			<h3 class="advert-link"><a href="<?php echo get_post_meta(get_the_ID(), 'advert-phone', true); ?>">Book online</a></h3>
	    	</div>
    	</div>
    </section>
    <aside class="article-side">
    	<div class="social-share">
			<ul>
				<li>Share this article on</li>
				<li><span class="fa-stack fa-lg">
  					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
					</span>
				</li>
				<li><span class="fa-stack fa-lg">
  					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
					</span>
				</li>
				<li><span class="fa-stack fa-lg">
  					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-google-plus fa-stack-1x fa-inverse"></i>
					</span>
				</li>
			</ul>
			<ul>
				<li>
					<button type="submit" class="social-btn">
						<i class="fa fa-chevron-left"></i> Previous Article</button>
				</li>
				<li>
					<button type="submit" class="social-btn">
						Next Article <i class="fa fa-chevron-right"></i></button>
				</li>
			</ul>
    	</div>
    	<div class="author-info">
    		<div class="author-image">
			<?php if(get_post_meta(get_the_ID(), 'author-name', true)) : ?>
				<p>Written by <br><?php echo get_post_meta(get_the_ID(), 'author-name', true); ?></span></p>
				<img src="<?php echo get_post_meta(get_the_ID(), 'author-image', true); ?>" />
			</div>
			<div class="author-bio">
				<p><?php echo get_post_meta(get_the_ID(), 'author-bio', true); ?></p>
			</div>
    	</div>

    	<div class="article-advert">
    		<h3 class="advert-title"><?php echo get_post_meta(get_the_ID(), 'advert-title', true); ?></h3>

    		<p><?php echo get_post_meta(get_the_ID(), 'advert-description', true); ?></p>

			<p class="advert-info">Call to book now</p>
    		<h3 class="advert-phone"><?php echo get_post_meta(get_the_ID(), 'advert-phone', true); ?></h3>

    		<p class="advert-info">Click here to</p>
    		<h3 class="advert-link"><a href="<?php echo get_post_meta(get_the_ID(), 'advert-phone', true); ?>">Book online</a></h3>
    	</div>
    <?php endif; ?>
	</aside>
  <?php endwhile;
endif; ?>
</main>
</div>
<?php get_footer(); ?>