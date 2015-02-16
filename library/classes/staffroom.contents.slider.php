<?php
/**
 * Class for displaying the contents of the magazine in a slider
 */
class Staffroom_magazine_contents
{
	/**
	 * constructor. adds the actions to call class methods using the wordpress hooks
	 */
	function __construct()
	{
		//add the action to call the function
		add_action('the_latest_magazine', array($this, 'the_lastest_magazine'));
		add_action('the_magazine_title', array($this, 'the_magazine_title'));

		add_action('the_magazine_articles', array($this, 'get_magazine_articles'));
	}//end constructor

	/**
	 * get the latest magazine for display on the front page
	 * @return 	array 		an array with the current pages information in it
	 */
	public function the_latest_magazine()
	{
		$latest_magazine;

		$pages = $this->get_all_magazines();
		//var_dump($pages);
		$magazines = $this->sort_magazines_by_year($pages);


		foreach($magazines as $magazine)
		{
			for($i = 0; $i < count($magazines); $i++)
			{
				$issue_no = (string)count($magazines);
				if(strpos($magazine['post_title'], 'issue-' . $issue_no) != false)
				{

					$latest_magazine =  $magazine['post_title'];
				}
				//check title
				break;
			}
		}

		return $latest_magazine;
	}//end the_latest_magazine

	/**
	 * [get_all_magazines description]
	 * @return [type] [description]
	 */
	private function get_all_magazines()
	{
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

		$pages = get_pages($args);
		return $pages;
	}//end get_all_magazines

	/**
	 * [sort_magazines_by_year description]
	 * @param  [type] $pages [description]
	 * @param  [type] $year  [description]
	 * @return [type]        [description]
	 */
	private function sort_magazines_by_year($pages)
	{
		//some vars
		$current_year = date('Y');
		//the issues
		$magazines = array();

		foreach($pages as $page)
		{
			if(strpos($page->post_title, $current_year) != false)
			{
				$magazine = array(
					'post_id'		=> $page->ID,
					'post_title'	=> $page->post_name
				);

				$magazines[] = $magazine;
			}
		}

		return $magazines;
	}//end sort_magazines_by_year

	/**********************************************************************************************************************/

	/**
	 * [the_contents_list description]
	 * @param  [type] $post_id [description]
	 * @return [type]          [description]
	 */
	public function the_contents_list($post_id)
	{
		$post_type = 'article';
		$args = $this->get_taxonomy_terms($post_id, $post_type);
		$wp_query = new WP_Query($args);


	}//end the_contents_list

	/**
	 * [get_magazine_articles description]
	 * @param  [type] $post_id [description]
	 * @return [type]          [description]
	 */
	public function get_magazine_articles($post_id)
	{
		//1. get the magazine id
		$post_type = 'article';
		$args = $this->get_taxonomy_terms($post_id, $post_type);

		$wp_query = new WP_Query($args);
		//var_dump($wp_query);
		//
		if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post();
			echo '<option value="' . get_page_link( $page->ID ) . '">';
			echo the_title();
			$title = the_title();
			echo '</option>';
		endwhile; else :
			echo '<option value="">';
			echo 'No Article Found!';
			echo '</option>';
		endif;

		wp_reset_postdata();
	}

	/**
	 *
	 */
	public function the_magazine_title($post_id)
	{
		$post_type = 'magazine';
		$terms = $this->get_taxonomy_terms($post_id, $post_type);
		$wp_query = new WP_Query( $terms );
		if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post();
			//echo the_title();
			$title = get_the_title($page->ID);
			$pieces = explode("|", $title);
				//create the new title
				$new_title = '<h3>' . $pieces[0] . ' | <span>' . $pieces[1] . '<span></h3>';
				echo $new_title;
		endwhile; else :

		endif;
		wp_reset_postdata();
	}

	public function get_taxonomy_terms($post_id, $post_type)
	{
		$term = 0;
		$year = 0;
		$issue = 0;
		$html = '';
		$taxonomies = array('terms', 'years', 'issue_no');

		foreach($taxonomies as $taxonomy)
		{
			$tax_terms = get_the_terms($post_id, $taxonomy);

			foreach($tax_terms as $tax_term)
			{
				switch ($taxonomy) {
					case 'terms':
						$term = $tax_term->term_id;
						break;
					case 'years':
						$year = $tax_term->term_id;
						break;
					case 'issue_no':
						$issue = $tax_term->term_id;
						break;
					default:
						# code...
						break;
				}
			}
		} //end foreach

		$args = array(
			'post_type' => $post_type,
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'terms',
					'field'    => 'id',
					'terms'    => array($term),
				),
				array(
					'taxonomy' => 'years',
					'field'    => 'id',
					'terms'    => array($year),
					'operator' => 'IN',
				),
				array(
					'taxonomy' => 'issue_no',
					'field'    => 'id',
					'terms'    => array($issue),
					'operator' => 'IN',
				),
			),
		); //end $args
		return $args;
	}

}//end class