<?php
/*
 *	Plugin Name: 	CASAWP Lead Generator
 *	Description:    Plugin for estimating the value of a property.
 *	Author:         Casasoft AG
 *	Author URI:     http://casasoft.ch
 *	Version: 		0.0.1
 *	Text Domain: 	casawplg
 *	Domain Path: 	languages/
 */

namespace casasoft\casawplg;
require_once( 'features/silence.php' );


define( 'casasoft\casawplg\VERSION', '0.0.1' );
define( 'casasoft\casawplg\PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'casasoft\casawplg\PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/*
 * The following includes add features to the plugin
 */
require_once( 'features/feature.php' );
require_once( 'features/template.php' );
require_once( 'features/options.php' );
require_once( 'features/class-loader.php' );
require_once( 'features/kit.php' );
/**
 * The central plugin class and bootstrap for the application.
 *
 * While this class is primarily boilerplate code and can be used without alteration,
 * there are a few things you need to edit to get the most out of this kit:
 *  * Add any initialization code that must run *during* the plugins_loaded action in the constructor.
 *  * Edit the return value of the defaults function so that the array contains all your default plugin values.
 *  * Add any plugin activation code to the activate_plugin method.
 *  * Add any plugin deactivation code to the deactivate_plugin method.
 *      - If you don't have any activation code, be sure to comment-out register_deactivation_hook
 */
class CasawpLg extends Kit {

	private static $__instance;

	public static function init() {

		if ( !self::$__instance ) {
			$plugin_dir = basename( dirname( __FILE__ ) );
			load_plugin_textdomain( 'casawplg', FALSE, $plugin_dir . '/languages/' );
			self::$__instance = new CasawpLg();
			parent::initialize();
		}
		return self::$__instance;
	}

	/**
	 * Constructor: Main entry point for your plugin. Runs during the plugins_loaded action.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Plugin activation hook
	 *
	 * Add any activation code you need to do here, like building tables and such.
	 * You won't need to worry about your options so long as you updated them using the defaults method.
	 *
	 * @static
	 * @hook register_activation_hook
	 */
	public static function activate_plugin() {
		//generate standard inquiry-reasons

		/*$terms = get_terms( 'inquiry_reason', array() );
		print_r($terms);
		die();*/

	}

	/**
	 * Plugin deactivation hook
	 *
	 * Need to clean up your plugin when it's deactivated?  Do that here.
	 * Remember, this isn't when your plugin is uninstalled, just deactivated
	 * ( so it happens when the plugin is updated too ).
	 *
	 * @static
	 * @hook register_deactivation_hook
	 */
	public static function deactivate_plugin() {

	}

	public static function clg_acf_settings_path( $path ) {
	    $path = plugin_dir_path( __FILE__ ) . '/assets/acf/';
	    return $path;
	}
	public static function clg_acf_settings_dir( $dir ) {
	    $dir = plugin_dir_url( __FILE__ ) . '/assets/acf/';
	    return $dir;
	}

} // End Class


// included ACF
// 1. customize ACF path
if( ! class_exists('acf') ) {
	add_filter('acf/settings/path', array( 'casasoft\casawplg\CasawpLg', 'clg_acf_settings_path'));

	// 2. customize ACF dir
	add_filter('acf/settings/dir', array( 'casasoft\casawplg\CasawpLg', 'clg_acf_settings_dir'));

	// 3. Hide ACF field group menu item
	//add_filter('acf/settings/show_admin', '__return_false');

	// 4. Include ACF
	include_once(plugin_dir_path( __FILE__ ) . '/assets/acf/acf.php' );
}



//...and away we go!
add_action( 'plugins_loaded', array( 'casasoft\casawplg\CasawpLg', 'init' ) );
register_activation_hook( __FILE__, array( 'casasoft\casawplg\CasawpLg', 'activate_plugin' ) );
register_deactivation_hook( __FILE__, array( 'casasoft\casawplg\CasawpLg', 'deactivate_plugin' ) );