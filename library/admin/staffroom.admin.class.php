<?php
/**
 *
 */
class Staffroom_theme_options
{
	/**
	 * constructor
	 */
	function __construct()
	{
		//enqeue the scripts
		add_action('admin_enqueue_scripts', array($this, 'bones_admin_enqeue_scripts'));

		//add the theme options page
		add_action('admin_menu', array($this, 'bones_add_options_page'));

		add_action('admin_init', array($this, 'bones_add_settings_fields'));
	}

	/**********************************************************************************
	 * Functions
	 **********************************************************************************
	 * 1. Helper functions
	 * 	1.1 bones_admin_enqeue_scripts
	 * 2. Menus
	 * 	2.1 bones_add_options_page
	 * 	2.2 bones_add_theme_submenu_pages
	 * 3. Sections settings and fields
	 * 4. Callbacks
	 **********************************************************************************/

	/**********************************************************************************
	 * 1. Helper functions
	 *********************************************************************************/
	/**
	 * 1.1
	 */
	public function bones_admin_enqeue_scripts()
	{
		//font awesome
		wp_register_style('bones-font-awsome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css');
		//admin styles
		wp_register_style('bones-admin-styles', get_template_directory_uri() . 'library/css/admin.css');

		wp_enqueue_style('bones-font-awsome');
		wp_enqueue_style('bones-admin-styles');

	}

	/**********************************************************************************
	 * 2. Menus
	 *********************************************************************************/
	public function bones_add_options_page()
	{
		add_menu_page(
			'Staffroom Options',	 											//page title
			'Staffroom Options',												//menu title
			'manage_options',													//capability
			'staffroom-theme-options',											//menu slug
			array($this, 'bones_display_theme_options_display'), 				//the callback
			get_template_directory_uri() . '/library/images/theme-icon.png',	//the icon
			59 																	//menu postion
	 	);
	}//end bones_add_options_page

	/**
	 * [bones_add_theme_submenu_pages description]
	 * @return [type] [description]
	 */
	public function bones_add_theme_submenu_pages()
	{

	}//end bones_add_theme_submenu_pages

	/**********************************************************************************
	 * 3. Sections settings and fields
	 *********************************************************************************/
	/**
	 * [bones_add_settings_fields description]
	 * @return [type] [description]
	 */
	public function bones_add_settings_fields()
	{
		//header settings
		add_settings_section(
			'options_section', 										//the id
			'Header Options',										//the title
			array($this, 'bones_theme_header_description_display',	//the callback
			'staffroom-theme-options'								//the page to display it
		);

		//footer settings
		add_settings_section(
			'footer_section',
			'Footer Options',
			array($this, 'bones_footer_options_display'),
			'staffroom-theme-options'
	 	);

	 	add_settings_field(
	 		'footer_section',
	 		'Theme Footer Message',
	 		array($this, 'bones_footer_message_display'),
	 		'staffroom-theme-options',
	 		'footer_section'
	  	);

	  	register_setting(
	  		'footer_section',
	  		'footer_options'
	  	);


	}

	/**********************************************************************************
	 * 4. Callbacks
	 *********************************************************************************/
	public function bones_display_theme_options_display()
	{
	?>
		<div class="wrap">
			<h2><i class="fa fa-rebel"></i> Staffroom Theme Options</h2>
			<form method="post" action="options.php">
				<?php
					settings_fields('footer_section');

					do_settings_sections('staffroom-theme-options');

					submit_button();
				?>
			</form>
		</div><!-- .wrap -->
	<?php
	}//end bones_display_theme_options_page

	/**
	 *
	 */
	public function bones_footer_options_display()
	{
		echo 'These options are designed to help you control whats displayed in your footer';
	} //end bones_footer_options_display

	/**
	 *
	 */
	public function bones_footer_message_display()
	{
		$options = (array)get_option('footer_options');
		$message = $options['message'];

		echo '<input type="text" name="footer_options[message]" id="footer_options_message" value="' . $message . '" />';
	} //end bones_footer_message_display

	/**
	 *
	 */
	public function bones_theme_header_description_display()
	{

	}
}//end Staffroom_theme_options class

/**
 * Create the class
 */
add_action('init', function(){
	new Staffroom_theme_options();
});











