<?php
/**
 * @package  Aje_intermedicao
 */
namespace Inc\Base;

class Activate
{
	public static function activate() {
		flush_rewrite_rules();
		
		$default = array();

		if ( ! get_option( 'ajec_indermediacao' ) ) {
			update_option( 'ajec_indermediacao', $default );
		}

		if ( ! get_option( 'ajec_indermediacao_cpt' ) ) {
			update_option( 'ajec_indermediacao_cpt', $default );
		}

		if ( ! get_option( 'ajec_indermediacao_tax' ) ) {
			update_option( 'ajec_indermediacao_tax', $default );
		}
	}
}