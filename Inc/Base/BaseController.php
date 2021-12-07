<?php 
/**
 * @package  Aje_intermedicao
 */
namespace Inc\Base;

class BaseController
{
	public $plugin_path;

	public $plugin_url;

	public $plugin;

	public $managers = array();
	public $managers_inputs=array();

	public function __construct() {
		$this->plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) );
		$this->plugin_url = plugin_dir_url( dirname( __FILE__, 2 ) );
		$this->plugin = plugin_basename( dirname( __FILE__, 3 ) ) . '/ajec-intermediacao.php';

		$this->managers = array(
			'cpt_manager' => 'Activar alerta de Sms',
			'taxonomy_manager' => 'Conta Nego (Carteira)',
		);

		$this->managers_inputs=array(
			'phone_ajec_pay'=>'Seu Número da Conta Nego'
		  );
	}

	public function activated( string $key )
	{
		$option = get_option( 'ajec_indermediacao' );

		return isset( $option[ $key ] ) ? $option[ $key ] : false;
	}

}