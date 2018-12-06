<?php
namespace casasoft\casawplg;


class styles_and_scripts extends Feature {


	public function __construct() {
		wp_enqueue_style( 'casawp-lg-admin', PLUGIN_URL . 'assets/css/casawp-lg-admin.css', array(), '1', 'screen' );
	}

}

add_action( 'load-post.php', array( 'casasoft\casawplg\styles_and_scripts', 'init' )  );
add_action( 'load-post-new.php', array( 'casasoft\casawplg\styles_and_scripts', 'init' )  );

