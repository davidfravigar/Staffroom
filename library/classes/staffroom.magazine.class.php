<?php
/**
 * Class for the custom post type Magazine
 */
class Staffroom_magazine
{
	/**
	 * constructor, everything is called from this function, including wordpress hooks.
	 * Remember if you want to call a method using a wordpress hook you have to add the $this->
	 * to an array in the hook function call.
	 */
	function __construct()
	{
		add_action( 'after_switch_theme', array($this, 'bones_flush_rewrite_rules' ));

		//create the custom post types
		$this->bones_register_magazine_post_types();

		//remove admin menu items we dont need
		add_action('admin_menu', array($this, 'bones_remove_menu_pages'));

		//register taxonomies
		$this->bones_register_custom_taxonomies();

		//deregister default checkbox metaboxes
		add_action('admin_menu', array($this, 'bones_remove_taxonomy_metaboxes'));

		//add our radiobutton metaboxes
		add_action('add_meta_boxes', array($this, 'bones_add_taxonomy_metaboxes'));

		//add our magazine metaboxes
		add_action('add_meta_boxes', array($this, 'bones_add_magazine_metaboxes'));

		//add our article metaboxes
		add_action('add_meta_boxes', array($this, 'bones_add_article_metaboxes'));

		add_action('save_post', array($this, 'bones_save_metabox_data'));


		//add_action('admin_notices', array($this, 'bones_add_magazine_contents_metabox'));

		//add_action('the_content', array($this, 'bones_display_author_info'));
	}

	/**********************************************************************************
	 * Functions
	 **********************************************************************************
	 * 1. Helper functions
	 * 	1.1 flush rewite rules
	 * 2. Menus
	 * 	2.1 bones_register_magazine_post_types
	 * 	2.2 bones_create_magazine_post_types
	 * 	2.3 bones_remove_menu_pages
	 * 3. Taxonomies
	 * 	3.1 bones_register_custom_taxonomies
	 * 4. Metaboxes
	 * 	4.1 bones_remove_taxonomy_metaboxes
	 * 	4.2 bones_add_taxonomy_metaboxes
	 * 	4.3 bones_add_magazine_metaboxes
	 * 5. Callbacks
	 * 	5.1 bones_add_terms_metabox
	 * 	5.2 bones_add_years_metabox
	 * 	5.3 bones_add_issue_metabox
	 * 	5.4 bones_add_magazine_contents_metabox
	 **********************************************************************************/

	/**********************************************************************************
	 * 1. Helper functions
	 *********************************************************************************/

	/**
	 * 1.1 Flush the rewrite rules, when a new post type is created wordpress needs to flush its
	 * rewrite rules, this is done when you change the permalinks in settings but can be programically
	 * done as well. this function just makes sure that when you've created a post type it will be
	 * displayed correctly on the fronted and no 404 is shown
	 */
	private function bones_flush_rewrite_rules()
	{
		flush_rewrite_rules();
	} //end bones_flush_rewrite

	/**
	 * 1.2 no need to explain, this is styling for the magazines custom metaboxes
	 */
	private function bones_enqeue_scripts()
	{

	}

	/**********************************************************************************
	 * 2. Menus
	 *********************************************************************************/

	/**
	 * 2.1 register the post types so that wordpress can see them
	 * this function plugin into wordpress register_post_type() function.
	 * This function forces a flush of the rewrite rules, if it fails (its temperamental) go to
	 * your settings and save the permalinks which will flush the rewrite rules.
	 */
	public function bones_register_magazine_post_types()
	{
		//lets get the post_type array
		$post_types = $this->bones_create_magazine_post_types();

		//foreach loop to register the post types
		foreach($post_types as $name=>$arr){
			register_post_type($name, $arr);
			//flush the rewrite.
			$this->bones_flush_rewrite_rules();
		}
	} //end bones_register_magazine_post_types

	/**
	 * 2.2 Create the post type Magazine. This function defines the array thsat is past
	 * to the private function register_magazine_post_types.
	 * To add more post types copy and rename the array.
	 * @param  		$post_types 		array
	 * @return   	$post_types 		array
	 */
	private function bones_create_magazine_post_types()
	{
		//create an empty array
		$post_types = array();

		//populate the array
		$post_types['Magazine'] = array( //magazine post type
			'labels' => array(
				'name'					=> __('Magazines', 'bonestheme'),				//The name of the menu item
				'singular_name'			=> __('Magazines', 'bonestheme'),				//The singular name
				'all_items'				=> __('All Magazines', 'bonestheme'), 			//the label for all items
				'add_new'				=> __('Add New', 'bonestheme'), 				//the label to add new
				'add_new_item'			=> __('Add New Magazines', 'bonestheme'), 		//the label for add new item
				'edit'					=> __('Edit', 'bonestheme'),	 				//the label for edit
				'edit_item'				=> __('Edit Magazine', 'bonestheme'), 			//the label for edit items
				'new_items'				=> __('New Magazine', 'bonestheme'), 			//the label for new item
				'view_item'				=> __('View Magazine', 'bonestheme'), 			//the label for view items
				'not_found'				=> __('Not Found in Database', 'bonestheme'), 	//the label for not found
				'not_found_in_trash'	=> __('nothing Found in Trash', 'bonestheme'), 	//the label for the trash
			), //end of labels array
			'description'				=> __('Osiris Staffroom Magazine', 'bonestheme'),//the description
			'public'					=> true,										//is it public viewable
			'public_queryable'			=> true,										//is it public queryable
			'exclude_from_search'		=> false,										//do we need to exclude it for search
			'show_ui'					=> true,										//show in the admin menu
			'query_var'					=> true,										//what to query on
			'menu_postiton'				=> 8,											//the position in the admin menu
			'menu_icon'					=> get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png',			//the icon
			'rewrite'					=> array('slug' => 'magazine'),					//the slug for this post type
			'has_archive'				=> false,										//is its to act like a page set to false
			'capability_type'			=> 'page',										//the kind of post type you want
			'hierarchical'				=>	true,										//if its a page set to true
			'supports'					=> array('title', 'author', 'thumbnail', 'revisions'), //what parts of wordpress does it support in the admin area
		); //end magazine array

		$post_types['article'] = array( //article post type
			'labels' => array(
				'name'					=> __('Articles', 'bonestheme'),				//The name of the menu item
				'singular_name'			=> __('Articles', 'bonestheme'),				//The singular name
				'all_items'				=> __('All Articles', 'bonestheme'), 			//
				'add_new'				=> __('Add New', 'bonestheme'), 				//
				'add_new_item'			=> __('Add New Article', 'bonestheme'), 		//
				'edit'					=> __('Edit', 'bonestheme'),	 				//
				'edit_item'				=> __('Edit Article', 'bonestheme'), 			//
				'new_items'				=> __('New Article', 'bonestheme'), 			//
				'view_item'				=> __('View Article', 'bonestheme'), 			//
				'not_found'				=> __('Not Found in Database', 'bonestheme'), 	//
				'not_found_in_trash'	=> __('nothing Found in Trash', 'bonestheme'), 	//
			), //end of labels array
			'description'				=> __('Osiris Staffroom Magazine Article', 'bonestheme'),//
			'public'					=> true,										//
			'public_queryable'			=> true,										//
			'exclude_from_search'		=> false,										//
			'show_ui'					=> true,										//
			'query_var'					=> true,										//
			'menu_postiton'				=> 5,											//
			'menu_icon'					=> get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png',			//
			'rewrite'					=> array('slug' => 'article'),					//
			'has_archive'				=> true,										//
			'capability_type'			=> 'post',										//
			'hierarchical'				=> false,										//
			'supports'					=> array('title', 'editor', 'author', 'thumbnail', 'revisions', 'page-tags'),
			//'show_in_menu'			=> 'edit.php?post_type=magazine',
		);

		return $post_types;
	} //end bones_create_magazine_post_types

	/**
	 * 2.3 remove the menus you dont want, left the whole menus in so you can see what is what
	 */
	public function bones_remove_menu_pages()
	{
		//remove_menu_page( 'index.php' );                  //Dashboard
  		remove_menu_page( 'edit.php' );                   //Posts
  		//remove_menu_page( 'upload.php' );                 //Media
  		remove_menu_page( 'edit.php?post_type=page' );    //Pages
  		remove_menu_page( 'edit-comments.php' );          //Comments
  		//remove_menu_page( 'themes.php' );                 //Appearance
  		//remove_menu_page( 'plugins.php' );                //Plugins
  		//remove_menu_page( 'users.php' );                  //Users
  		remove_menu_page( 'tools.php' );                  //Tools
  		//remove_menu_page( 'options-general.php' );        //Settings
	}

	/**********************************************************************************
	 3. TAXONOMIES
	**********************************************************************************/

	/**
	 * 3.1 Register the taxonomies that are needed for the staffroom magazine
	 * this function uses a wordpress hook to register the taxonomiy, remember
	 * that you need to state which post type that the taxomony applies to.
	 */
	public function bones_register_custom_taxonomies()
	{
		//register the taxonomies for the magazine
		register_taxonomy('terms',
			array('magazine', 'article'),
			array('hierarchical' => true,
				'labels' => array(
					'name'				=> __('Terms', 'bonestheme'),
					'singular_name'		=> __('Term', 'bonesthmeme'),
					'all_items'	 		=> __('All Terms', 'bonestheme'),
					'edit_item'			=> __('Edit Term', 'bonestheme'),
					'update_item'		=> __('Update Terms', 'bonestheme'),
					'add_new_item'		=> __('Add New', 'bonestheme'),
					'new_item_name'		=> __('New Term', 'bonestheme'),
				), //end of labels array
				'show_admin_column'		=> true,
				'show_ui'				=> true,
				'query_var'				=> true,
				'rewrite'				=> array('slug' => 'term'),
			)
	 	);

		register_taxonomy('years',
			array('magazine', 'article'),
			array('hierarchical' => true,
				'labels' => array(
					'name'				=> __('Years', 'bonestheme'),
					'singular_name'		=> __('Year', 'bonesthmeme'),
					'all_items'	 		=> __('All Years', 'bonestheme'),
					'edit_item'			=> __('Edit Year', 'bonestheme'),
					'update_item'		=> __('Update Years', 'bonestheme'),
					'add_new_item'		=> __('Add New', 'bonestheme'),
					'new_item_name'		=> __('New Year', 'bonestheme'),
				), //end of labels array
				'show_admin_column'		=> true,
				'show_ui'				=> true,
				'query_var'				=> true,
				'rewrite'				=> array('slug' => 'year'),
			)
	 	);

		register_taxonomy('issue_no',
			array('magazine', 'article'),
			array('hierarchical' => true,
				'labels' => array(
					'name'				=> __('Issue Numbers', 'bonestheme'),
					'singular_name'		=> __('Issue Number', 'bonesthmeme'),
					'all_items'	 		=> __('All Issues', 'bonestheme'),
					'edit_item'			=> __('Edit Issue Number', 'bonestheme'),
					'update_item'		=> __('Update Issue Number', 'bonestheme'),
					'add_new_item'		=> __('Add New', 'bonestheme'),
					'new_item_name'		=> __('New Issue Number', 'bonestheme'),
				), //end of labels array
				'show_admin_column'		=> true,
				'show_ui'				=> true,
				'query_var'				=> true,
				'rewrite'				=> array('slug' => 'issue_no'),
			)
	 	);
	} //end bones_register_custom_taxonomies

	/**********************************************************************************
	 4. METABOXES
	**********************************************************************************/

	/**
	 * 4.1 Register the taxonomies that are needed for the staffroom magazine
	 * this function uses a wordpress hook to register the taxonomiy, remember
	 * that you need to state which post type that the taxomony applies to.
	 */
	public function bones_remove_taxonomy_metaboxes()
	{
		//remove from magazine post type
		remove_meta_box('termsdiv', 'magazine', 'side');
		remove_meta_box('yearsdiv', 'magazine', 'side');
		remove_meta_box('issue_nodiv', 'magazine', 'side');

		//remove from article post type
		remove_meta_box('termsdiv', 'article', 'side');
		remove_meta_box('yearsdiv', 'article', 'side');
		remove_meta_box('issue_nodiv', 'article', 'side');
	}//end bones_remove_taxonomy_metaboxes

	/**
	 * 4.2 This function removes the metaboxes for the taxonomies we created, it applies to both
	 * the magazine and article post type, it is used to remove the default checkbox metaboxes
	 * later on in other functions we add metaboxes with radio buttons as we dont want more than one
	 * taxonomy term to be applied to each taxonomy.
	 * it needs to be wrote in a foreach loop but at the current moment they are 6 diffrent functions
	 */
	public function bones_add_taxonomy_metaboxes()
	{
		//add to magaziner post type
		add_meta_box('terms_div', 'Terms', array($this, 'bones_add_terms_metabox'), 'magazine', 'side', 'core');
		add_meta_box('years_div', 'Years', array($this, 'bones_add_years_metabox'), 'magazine', 'side', 'core');
		add_meta_box('issuess_div', 'Issues', array($this, 'bones_add_issue_metabox'), 'magazine', 'side', 'core');

		//add to article post type
		add_meta_box('terms_div', 'Terms', array($this, 'bones_add_terms_metabox'), 'article', 'side', 'core');
		add_meta_box('years_div', 'Years', array($this, 'bones_add_years_metabox'), 'article', 'side', 'core');
		add_meta_box('issues_div', 'Issues', array($this, 'bones_add_issue_metabox'), 'article', 'side', 'core');
	}//end bones_add_taxonomy_metaboxes

	/**
	 * 4.3 Add
	 */
	public function bones_add_magazine_metaboxes()
	{
		add_meta_box('contents_div', 'Magazine Contents', array($this, 'bones_add_magazine_contents_metabox'), 'magazine', 'normal', 'high');
		add_meta_box('slider_div', 'Slider Shortcode', array($this, 'bones_add_magazine_slider_metabox'), 'magazine', 'normal', 'high');
	}//end bones_add_magazine_metaboxes

	/**
	 * 4.4
	 */
	public function bones_add_article_metaboxes()
	{
		add_meta_box('author_info_div', 'Author Information', array($this, 'bones_add_article_author_metabox'), 'article', 'normal', 'high');
		add_meta_box('author_advert_div', 'Article Advert', array($this, 'bones_add_article_advert_metabox'), 'article', 'normal', 'high');
		add_meta_box('further_div', 'Featured Reading', array($this, 'bones_add_further_reading_metabox'), 'article', 'normal', 'high');
	}

	/**********************************************************************************
	 5. CALLBACKS
	**********************************************************************************/

	/**
	 * 5.1 add the new rediobutton metabox for terms
	 */
	public function bones_add_terms_metabox()
	{
		//Get taxonomy and terms
    	$taxonomy = 'terms';

    	//Set up the taxonomy object and get terms
    	$tax = get_taxonomy($taxonomy);
    	$terms = get_terms($taxonomy,array('hide_empty' => 0));

    	//Name of the form
    	$name = 'tax_input[' . $taxonomy . ']';

    	//Get current and popular terms
    	$popular = get_terms( $taxonomy, array( 'orderby' => 'count', 'order' => 'DESC', 'number' => 10, 'hierarchical' => false ) );
    	$postterms = get_the_terms( $post->ID,$taxonomy );
    	$current = ($postterms ? array_pop($postterms) : false);
    	$current = ($current ? $current->term_id : 0);
    	?>

    	<div id="taxonomy-<?php echo $taxonomy; ?>" class="categorydiv">

        <!-- Display tabs-->
        <ul id="<?php echo $taxonomy; ?>-tabs" class="category-tabs">
            <li class="tabs"><a href="#<?php echo $taxonomy; ?>-all" tabindex="3"><?php echo $tax->labels->all_items; ?></a></li>
            <li class="hide-if-no-js"><a href="#<?php echo $taxonomy; ?>-pop" tabindex="3"><?php _e( 'Most Used' ); ?></a></li>
        </ul>

        <!-- Display taxonomy terms -->
        <div id="<?php echo $taxonomy; ?>-all" class="tabs-panel">
            <ul id="<?php echo $taxonomy; ?>checklist" class="list:<?php echo $taxonomy?> categorychecklist form-no-clear">
                <?php   foreach($terms as $term){
                    $id = $taxonomy.'-'.$term->term_id;
                    echo "<li id='$id'><label class='selectit'>";
                    echo "<input type='radio' id='in-$id' name='{$name}'".checked($current,$term->term_id,false)."value='$term->term_id' />$term->name<br />";
                   echo "</label></li>";
                }?>
           </ul>
        </div>

        <!-- Display popular taxonomy terms -->
        <div id="<?php echo $taxonomy; ?>-pop" class="tabs-panel" style="display: none;">
            <ul id="<?php echo $taxonomy; ?>checklist-pop" class="categorychecklist form-no-clear" >
                <?php   foreach($popular as $term){
                    $id = 'popular-'.$taxonomy.'-'.$term->term_id;
                    echo "<li id='$id'><label class='selectit'>";
                    echo "<input type='radio' id='in-$id'".checked($current,$term->term_id,false)."value='$term->term_id' />$term->name<br />";
                    echo "</label></li>";
                }?>
           </ul>
       </div>
    </div>
    <?php
	}

	/**
	 * 5.2 add the new rediobutton metabox for years
	 */
	public function bones_add_years_metabox()
	{
		//Get taxonomy and terms
    	$taxonomy = 'years';

    	//Set up the taxonomy object and get terms
    	$tax = get_taxonomy($taxonomy);
    	$terms = get_terms($taxonomy,array('hide_empty' => 0));

    	//Name of the form
    	$name = 'tax_input[' . $taxonomy . ']';

    	//Get current and popular terms
    	$popular = get_terms( $taxonomy, array( 'orderby' => 'count', 'order' => 'DESC', 'number' => 10, 'hierarchical' => false ) );
    	$postterms = get_the_terms( $post->ID,$taxonomy );
    	$current = ($postterms ? array_pop($postterms) : false);
    	$current = ($current ? $current->term_id : 0);
    	?>

    	<div id="taxonomy-<?php echo $taxonomy; ?>" class="categorydiv">

        <!-- Display tabs-->
        <ul id="<?php echo $taxonomy; ?>-tabs" class="category-tabs">
            <li class="tabs"><a href="#<?php echo $taxonomy; ?>-all" tabindex="3"><?php echo $tax->labels->all_items; ?></a></li>
            <li class="hide-if-no-js"><a href="#<?php echo $taxonomy; ?>-pop" tabindex="3"><?php _e( 'Most Used' ); ?></a></li>
        </ul>

        <!-- Display taxonomy terms -->
        <div id="<?php echo $taxonomy; ?>-all" class="tabs-panel">
            <ul id="<?php echo $taxonomy; ?>checklist" class="list:<?php echo $taxonomy?> categorychecklist form-no-clear">
                <?php   foreach($terms as $term){
                    $id = $taxonomy.'-'.$term->term_id;
                    echo "<li id='$id'><label class='selectit'>";
                    echo "<input type='radio' id='in-$id' name='{$name}'".checked($current,$term->term_id,false)."value='$term->term_id' />$term->name<br />";
                   echo "</label></li>";
                }?>
           </ul>
        </div>

        <!-- Display popular taxonomy terms -->
        <div id="<?php echo $taxonomy; ?>-pop" class="tabs-panel" style="display: none;">
            <ul id="<?php echo $taxonomy; ?>checklist-pop" class="categorychecklist form-no-clear" >
                <?php   foreach($popular as $term){
                    $id = 'popular-'.$taxonomy.'-'.$term->term_id;
                    echo "<li id='$id'><label class='selectit'>";
                    echo "<input type='radio' id='in-$id'".checked($current,$term->term_id,false)."value='$term->term_id' />$term->name<br />";
                    echo "</label></li>";
                }?>
           </ul>
       </div>
    </div>
    <?php
	}

	/**
	 * 5.3 add the new rediobutton metabox for issue numbers
	 */
	public function bones_add_issue_metabox()
	{
		//Get taxonomy and terms
    	$taxonomy = 'issue_no';

    	//Set up the taxonomy object and get terms
    	$tax = get_taxonomy($taxonomy);
    	$terms = get_terms($taxonomy,array('hide_empty' => 0));

    	//Name of the form
    	$name = 'tax_input[' . $taxonomy . ']';

    	//Get current and popular terms
    	$popular = get_terms( $taxonomy, array( 'orderby' => 'count', 'order' => 'DESC', 'number' => 10, 'hierarchical' => false ) );
    	$postterms = get_the_terms( $post->ID,$taxonomy );
    	$current = ($postterms ? array_pop($postterms) : false);
    	$current = ($current ? $current->term_id : 0);
    	?>

    	<div id="taxonomy-<?php echo $taxonomy; ?>" class="categorydiv">

        <!-- Display tabs-->
        <ul id="<?php echo $taxonomy; ?>-tabs" class="category-tabs">
            <li class="tabs"><a href="#<?php echo $taxonomy; ?>-all" tabindex="3"><?php echo $tax->labels->all_items; ?></a></li>
            <li class="hide-if-no-js"><a href="#<?php echo $taxonomy; ?>-pop" tabindex="3"><?php _e( 'Most Used' ); ?></a></li>
        </ul>

        <!-- Display taxonomy terms -->
        <div id="<?php echo $taxonomy; ?>-all" class="tabs-panel">
            <ul id="<?php echo $taxonomy; ?>checklist" class="list:<?php echo $taxonomy?> categorychecklist form-no-clear">
                <?php   foreach($terms as $term){
                    $id = $taxonomy.'-'.$term->term_id;
                    echo "<li id='$id'><label class='selectit'>";
                    echo "<input type='radio' id='in-$id' name='{$name}'".checked($current,$term->term_id,false)."value='$term->term_id' />$term->name<br />";
                   echo "</label></li>";
                }?>
           </ul>
        </div>

        <!-- Display popular taxonomy terms -->
        <div id="<?php echo $taxonomy; ?>-pop" class="tabs-panel" style="display: none;">
            <ul id="<?php echo $taxonomy; ?>checklist-pop" class="categorychecklist form-no-clear" >
                <?php   foreach($popular as $term){
                    $id = 'popular-'.$taxonomy.'-'.$term->term_id;
                    echo "<li id='$id'><label class='selectit'>";
                    echo "<input type='radio' id='in-$id'".checked($current,$term->term_id,false)."value='$term->term_id' />$term->name<br />";
                    echo "</label></li>";
                }?>
           </ul>
       </div>
    </div>
    <?php
	}

	/**
	 * 5.4
	 */
	public function bones_add_magazine_contents_metabox()
	{
		global $my_admin_page;
		$screen = get_current_screen();
		global $post;

		$contents = new Staffroom_magazine_contents;
		$post_type = 'article';
		$args = $contents->get_taxonomy_terms($post_id, $post_type);
		$wp_query = new WP_Query($args);
		?>
		<div class="wrap">
		<?php
		if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post();
			echo '<div class="article-container">';
			echo '<div class="article-header">';
			echo 	'<h3>' . $post->post_title . '</h3>';
			echo '</div>';
			echo '<div class="article-content">';
			echo 	'<a href="/wp-admin/post.php?post=' . $post->ID . '&action=edit">';
			echo 		the_post_thumbnail();
			echo 	'</a>';
			echo 	'<p>Written by: ' . get_post_meta($post->ID, 'author-name', true) . '</p>';
			echo '</div>';
			echo '</div>';
		endwhile; else :
			echo 'No Articles Found! <br>';
			echo '<a href="/wp-admin/post-new.php?post_type=article">Create One!</a>';
		endif;

		wp_reset_postdata();
		?>
		<div class="clear"></div>
		</div>
		<?php
	}

	public function bones_add_magazine_slider_metabox($post)
	{
		?>
		<p>
			<label for="slider-shortcode" class="bones-metabox-label">Slider Shortcode</label>
			<input 	type="text"
					name="slider-shortcode"
					id="slider-shortcode"
					class="bones-metabox-input"
					value="<?php echo get_post_meta($post->ID, 'slider-shortcode', true); ?>"
					placeholder="slider shortcode..." />
		</p>
		<?php
	}

	/**
	 * 5.5
	 */
	public function bones_add_article_author_metabox($post)
	{
		wp_nonce_field(basename(__FILE__), 'bones_nonce-field');
	?>
		<p>
			<label for="author-image" class="bones-metabox-label">Author Image</label>
			<input 	type="text"
					name="author-image"
					id="author-image"
					class="bones-metabox-input"
					value="<?php echo get_post_meta($post->ID, 'author-image', true); ?>"
					placeholder="Author Image..." />

			<label for="author-name" class="bones-metabox-label">Author Name</label>
			<input 	type="text"
					name="author-name"
					id="author-name"
					class="bones-metabox-input"
					value="<?php echo get_post_meta($post->ID, 'author-name', true); ?>"
					placeholder="Author's Name..."/>

			<label for="author-bio" class="bones-metabox-label">Author Biography</label>
			<?php
				$value = get_post_meta($post->ID, 'author-bio', true);
				wp_editor( $value,'author-bio', array ('textarea_rows' => 10));
			?>
		</p>
	<?php
	}

	public function bones_add_article_advert_metabox($post)
	{
	?>
		<p>
			<label for="advert-title" class="bones-metabox-label">Advert Title</label>
			<input class="bones-metabox-input" type="text" name="advert-title" value="<?php echo get_post_meta($post->ID, 'advert-title', true); ?>">
		</p>
		<p>
			<label for="advert-description" class="bones-metabox-label">Advert Description</label>
			<?php
				$value = get_post_meta($post->ID, 'advert-description', true);
				wp_editor( $value,'advert-description', array ('textarea_rows' => 10));
			?>
		</p>
		<p>
			<label for="advert-phone" class="bones-metabox-label">Advert Phone Number</label>
			<input class="bones-metabox-input" type="text" name="advert-phone" value="<?php echo get_post_meta($post->ID, 'advert-phone', true); ?>">
		</p>
		<p>
			<label for="advert-link" class="bones-metabox-label">Advert Link</label>
			<input class="bones-metabox-input"type="text" name="advert-link" value="<?php echo get_post_meta($post->ID, 'advert-link', true); ?>">
		</p>

		<p>
			<label for="secondary-advert-description" class="bones-metabox-label">Secondary Advert Description</label>
			<?php
				$value = get_post_meta($post->ID, 'secondary-advert-description', true);
				wp_editor( $value,'secondary-advert-description', array ('textarea_rows' => 6));
			?>
		</p>
	<?php
	}

	public function bones_add_further_reading_metabox($post)
	{
	?>
		<p>
		<?php
		$value = get_post_meta($post->ID, 'further-reading', true);
		wp_editor( $value,'further-reading', array ('textarea_rows' => 10));
		?>
		</p>
		<?php
	}


	public function bones_save_metabox_data($post_id)
	{

		if($this->bones_user_can_save($post_id, 'bones_nonce-field'))
		{
			if(isset($_POST['author-image']) && 0 < count(strlen(trim($_POST['author-image']))))
			{
				$author_image = stripslashes(strip_tags($_POST['author-image']));
				update_post_meta($post_id, 'author-image', $author_image);

			}

			if(isset($_POST['author-name']) && 0 < count(strlen(trim($_POST['author-name']))))
			{
				$author_name = stripslashes(strip_tags($_POST['author-name']));
				update_post_meta($post_id, 'author-name', $author_name);

			}

			if(isset($_POST['author-bio']) && 0 < count(strlen(trim($_POST['author-name']))))
			{
				$author_bio = stripslashes(strip_tags($_POST['author-bio']));
				update_post_meta($post_id, 'author-bio', $author_bio);
			}

			if(isset($_POST['advert-title']) && 0 < count(strlen(trim($_POST['advert-title']))))
			{
				$advert_title = stripslashes(strip_tags($_POST['advert-title']));
				update_post_meta($post_id, 'advert-title', $advert_title);
			}

			if(isset($_POST['advert-description']) && 0 < count(strlen(trim($_POST['advert-description']))))
			{
				$advert_description = stripslashes(strip_tags($_POST['advert-description']));
				update_post_meta($post_id, 'advert-description', $advert_description);
			}

			if(isset($_POST['advert-phone']) && 0 < count(strlen(trim($_POST['advert-phone']))))
			{
				$advert_phone = stripslashes(strip_tags($_POST['advert-phone']));
				update_post_meta($post_id, 'advert-phone', $advert_phone);
			}

			if(isset($_POST['advert-link']) && 0 < count(strlen(trim($_POST['advert-link']))))
			{
				$advert_link = stripslashes(strip_tags($_POST['advert-link']));
				update_post_meta($post_id, 'advert-link', $advert_link);
			}

			if(isset($_POST['secondary-advert-description']) && 0 < count(strlen(trim($_POST['secondary-advert-description']))))
			{
				$secondary_advert_description = stripslashes(strip_tags($_POST['secondary-advert-description']));
				update_post_meta($post_id, 'secondary-advert-description', $secondary_advert_description);
			}

			if(isset($_POST['further-reading']) && 0 < count(strlen(trim($_POST['further-reading']))))
			{
				$further_reading = stripslashes(strip_tags($_POST['further-reading']));
				update_post_meta($post_id, 'further-reading', $further_reading);
			}

			if(isset($_POST['slider-shortcode']) && 0 < count(strlen(trim($_POST['slider-shortcode']))))
			{
				$slider_shortcode = stripslashes(strip_tags($_POST['slider-shortcode']));
				update_post_meta($post_id, 'slider-shortcode', $slider_shortcode);
			}
		}
	}

	public function bones_user_can_save($post_id, $nonce)
	{

		$is_autosave = wp_is_post_autosave($post_id);
		$is_revision = wp_is_post_revision($post_id);
		$is_valid_nonce = (isset($_POST[$nonce]) && wp_verify_nonce($_POST[$nonce], basename(__FILE__)));

		return !($is_autosave || $is_revision) && $is_valid_nonce;

	}

	public function bones_display_author_info($content)
	{
		if(is_single())
		{
			$html = 'Written by ' . get_post_meta(get_the_ID(), 'author-name', true);
			$content = $html;
		}

		return $content;
	}
} //end staffroom_magazine class


/**
 * Create the class
 */
add_action('init', function(){
	new Staffroom_magazine();
});













