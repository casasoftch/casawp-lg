<?php
namespace casasoft\casawplg;


class inquiry_archive_cols extends Feature {

	public function __construct() {
		add_filter( 'manage_edit-complex_inquiry_columns', array( $this, 'editColumns' )) ;
		add_action( 'manage_complex_inquiry_posts_custom_column', array( $this, 'manageColumns' ));
	}

	public function editColumns($columns){
		$columns = array(
			'cb' 		=> '<input type="checkbox" />',
			'title' 	=> __( 'From', 'casawplg' ),
			'address' 	=> __( 'Address', 'casawplg' ),
			'email' 	=> __( 'Email', 'casawplg' ),
			'phone' 	=> __( 'Telephone', 'casawplg' ),
			'date' => __( 'Date')
		);

		return $columns;
	}

	public function manageColumns( $column ) {
		global $post;


		switch( $column ) {
			case 'address' :
				echo get_clg($post->ID, 'address_html');
				break;
			case 'email' :
				echo get_clg($post->ID, 'email');
				break;
			case 'phone' :
				echo get_clg($post->ID, 'phone');
				break;
			default :
				break;
		}
	}
}
add_action( 'casawplg_init', array( 'casasoft\casawplg\inquiry_archive_cols', 'init' ));