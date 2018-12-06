<?php
namespace casasoft\casawplg;

class post_types extends Feature {

	public function __construct() {
		$this->add_action( 'init', 'set_posttypes', 10 );


		/**
		 * Add the scheduling if it doesnt already exist
		 */
		$this->add_action('wp', 'setup_casawplg_inquiry_schedule');
		
		/**
		 * Add the function that takes care of removing all rows with post_type=complex_inquiry that are older than 6 Months
		 */
		$this->add_action('clg_posttype_daily_pruning', 'remove_old_posts');		

		if (is_admin()) {
			$this->add_filter( 'dashboard_glance_items', 'glance_items', 10, 1 );
		}
	}

	public function setup_casawplg_inquiry_schedule() {
	  if (!wp_next_scheduled('clg_posttype_daily_pruning') ) {
	    wp_schedule_event( time(), 'daily', 'clg_posttype_daily_pruning');
	  }
	}
	public function remove_old_posts() {
	  global $wpdb;
	  $wpdb->query($wpdb->prepare("DELETE FROM `{$wpdb->prefix}posts` WHERE post_type=%s AND post_date < DATE_SUB(NOW(), INTERVAL 182 DAY);",
	  	'complex_inquiry'
	  ));
	}

	public function set_posttypes() {


		$labels = array(
			'name'               => _x( 'Inquiries', 'post type general name', 'casawplg' ),
			'singular_name'      => _x( 'Inquiry', 'post type singular name', 'casawplg' ),
			'menu_name'          => _x( 'Inquiries', 'admin menu', 'casawplg' ),
			'name_admin_bar'     => _x( 'Inquiry', 'add new on admin bar', 'casawplg' ),
			'add_new'            => _x( 'Add New', 'inquiry', 'casawplg' ),
			'add_new_item'       => __( 'Add New Inquiry', 'casawplg' ),
			'new_item'           => __( 'New Inquiry', 'casawplg' ),
			'edit_item'          => __( 'Edit Inquiry', 'casawplg' ),
			'view_item'          => __( 'View Inquiry', 'casawplg' ),
			'all_items'          => __( 'All Inquiries', 'casawplg' ),
			'search_items'       => __( 'Search Inquiries', 'casawplg' ),
			'parent_item_colon'  => __( 'Parent Inquiries:', 'casawplg' ),
			'not_found'          => __( 'No inquiries found.', 'casawplg' ),
			'not_found_in_trash' => __( 'No inquiries found in Trash.', 'casawplg' )
		);

		$args = array(
			'labels'             => $labels,
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'clg-inquiry' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title')
		);

		register_post_type( 'casawplg_inquiry', $args );


		if (is_admin() && function_exists('pti_set_post_type_icon')) {
			pti_set_post_type_icon( 'complex_inquiry', 'inbox' );
		}

	}

} // End Class


// Subscribe to the drop-in to the initialization event
add_action( 'casawplg_init', array( 'casasoft\casawplg\post_types', 'init' ), 10 );



