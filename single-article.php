<?php get_header();?>
<?php
if (have_posts()) :
   while (have_posts()) :
      the_post(); ?>
     <main id="site-main">
		<section id="article-header" class="row page-bottom">
			<div class="col-md-12">
				<?php the_post_thumbnail('bones-article-image', array('class' => "img-responsive")); ?>
			</div>
		</section>
		<section id="article-content" class="row">
			<div class="col-xs-12 col-md-7">
				<?php the_content(); ?>
				<div class="share-social">
				<ul>
					<li>Share this article on</li>
					<li>
					<a href="https://twitter.com/share" class="twitter-share-button">
						<span class="fa-stack fa-lg">
	  					<i class="fa fa-circle fa-stack-2x"></i>
						<i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
						</span>
						</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
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
						<?php
						$prev_post = get_previous_post();
						if (!empty( $prev_post )): ?>
						  <a class="btn social-btn" href="<?php echo get_permalink( $prev_post->ID ); ?>"><i class="fa fa-chevron-left"></i> Previous Article</a>
						<?php endif; ?>
					</li>
					<li>
						<!--<button type="submit" class="social-btn">
							Next Article <i class="fa fa-chevron-right"></i></button> -->
							<?php
							$next_post = get_next_post();
							if (!empty( $next_post )): ?>
							  <a class="btn social-btn" href="<?php echo get_permalink( $next_post->ID ); ?>">Next Article <i class="fa fa-chevron-right"></i></button></a>
							<?php endif; ?>
					</li>
				</ul>
				</div>
			</div>
			<div class="col-md-4 col-md-offset-1" id="social-share">
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
						<?php
						$prev_post = get_previous_post();
						if (!empty( $prev_post )): ?>
						  <a class="btn social-btn" href="<?php echo get_permalink( $prev_post->ID ); ?>"><i class="fa fa-chevron-left"></i> Previous Article</a>
						<?php endif; ?>
					</li>
					<li>
						<!--<button type="submit" class="social-btn">
							Next Article <i class="fa fa-chevron-right"></i></button> -->
							<?php
							$next_post = get_next_post();
							if (!empty( $next_post )): ?>
							  <a class="btn social-btn" href="<?php echo get_permalink( $next_post->ID ); ?>">Next Article <i class="fa fa-chevron-right"></i></button></a>
							<?php endif; ?>
					</li>
				</ul>

				<div id="article-author">
					<div class="panel-body">
						<div class="author-image">
						<?php if(get_post_meta(get_the_ID(), 'author-name', true)) : ?>
							<p>Written by <br><?php echo get_post_meta(get_the_ID(), 'author-name', true); ?></span></p>
							<img class="img-responsive" src="<?php echo get_post_meta(get_the_ID(), 'author-image', true); ?>" />
						</div>
						<div class="author-bio">
							<p><?php echo get_post_meta(get_the_ID(), 'author-bio', true); ?></p>
						</div>
						<div class="author-link">
							<a href="<?php echo get_post_meta(get_the_ID(), 'author-link', true); ?> ">Click for more</a>
						</div>
					</div>
				</div>

				<div id="article-advert">
					<div class="panel-body">
						<h3 class="advert-title"><?php echo get_post_meta(get_the_ID(), 'advert-title', true); ?></h3>

			    		<p><?php echo get_post_meta(get_the_ID(), 'advert-description', true); ?></p>

						<p class="advert-info">Call to book now</p>
			    		<h3 class="advert-phone"><?php echo get_post_meta(get_the_ID(), 'advert-phone', true); ?></h3>

			    		<p class="advert-info">Click here to</p>
			    		<h3 class="advert-link"><a href="<?php echo get_post_meta(get_the_ID(), 'advert-phone', true); ?>">Book online</a></h3>
					</div>
				</div>
				<div class="bottom-content">
				<div id="further-reading">
					<div class="panel-body">
						<div id="further-reading">
							<h4><span><img src="<?php echo get_template_directory_uri(); ?>/library/images/icons/FurtherReading.png"></span> Further Reading</h4>
							<?php echo get_post_meta(get_the_ID(), 'further-reading', true); ?>
						</div>
					</div>
				</div>

				<div id="secondary-advert">
					<div class="panel-body">
						<h3 class="advert-title"><?php echo get_post_meta(get_the_ID(), 'advert-title', true); ?></h3>
						<p><?php echo get_post_meta(get_the_ID(), 'secondary-advert-description', true); ?></p>

						<p class="advert-info">Call to book now</p>
		    			<h3 class="advert-phone"><?php echo get_post_meta(get_the_ID(), 'advert-phone', true); ?></h3>

		    			<p class="advert-info">Click here to</p>
		    			<h3 class="advert-link"><a href="<?php echo get_post_meta(get_the_ID(), 'advert-phone', true); ?>">Book online</a></h3>
					</div>
				</div>
			</div>
			</div>
		</section>
	</main>
	        <?php endif; ?>
	  <?php endwhile;
	endif; ?>
	<?php get_footer() ?>