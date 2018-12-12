<?php
namespace casasoft\casawplg;


class styles_and_scripts_front extends Feature {


	public function __construct() {
		wp_enqueue_style( 'casawp-lg-front', PLUGIN_URL . 'assets/css/casawp-lg-front.css', array(), '1', 'screen' );
		wp_enqueue_script( 'casawp-lg-front', PLUGIN_URL . 'assets/js/casawp-lg-front.min.js', array('jquery'), '3');
		wp_enqueue_script( 'moment', PLUGIN_URL . 'assets/js/moment.min.js');
	}

}

add_action( 'wp_enqueue_scripts', array( 'casasoft\casawplg\styles_and_scripts_front', 'init' )  );
