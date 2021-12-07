<?php 
/**
 * @package  Aje_intermedicao
 */
namespace Inc\Base;

use Inc\Base\BaseController;

/**
* 
*/
class Enqueue extends BaseController
{
	public function register() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
	}
	
	function enqueue() {
		// enqueue all our scripts
		//wp_enqueue_script( 'media-upload' );
		//wp_enqueue_media();
		wp_enqueue_style( 'mypluginstyle', $this->plugin_url . 'assets/mystyle.css' );
		wp_enqueue_script( 'mypluginscript', $this->plugin_url . 'assets/myscript.js' );
		wp_enqueue_script( 'bootstrap_min', $this->plugin_url . 'assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js' );
		

		add_action('wp_enqueue_scripts' , 'vault_files');
	
		function vault_files(){

		  wp_enqueue_style('vault_main_style', get_stylesheet_uri()); 
		  
		}
	}
}