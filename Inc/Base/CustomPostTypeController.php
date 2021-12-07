<?php 
/**
 * @package  ajecPlugin
 */
namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\CptCallbacks;
use Inc\Api\Callbacks\AdminCallbacks;

/**
* 
*/
class CustomPostTypeController extends BaseController
{
	public $settings;

	public $callbacks;

	public $cpt_callbacks;

	public $subpages = array();

	public $custom_post_types = array();

	public function register()
	{
		if ( ! $this->activated( 'cpt_manager' ) ) return;

		$this->settings = new SettingsApi();

		$this->callbacks = new AdminCallbacks();

		$this->cpt_callbacks = new CptCallbacks();

		$this->setSubpages();

		$this->setSettings();

		$this->setSections();

		$this->setFields();

		$this->settings->addSubPages( $this->subpages )->register();

		//$this->storeCustomPostTypes();

		if ( ! empty( $this->custom_post_types ) ) {
			add_action( 'init', array( $this, 'registerCustomPostTypes' ) );
		}
	}

	public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'ajec_indermediacao', 
				'page_title' => 'Gestão de Intermediação', 
				'menu_title' => 'Gestão de Intermediação', 
				'capability' => 'manage_options', 
				'menu_slug' => 'ajec_cpt', 
				'callback' => array( $this->callbacks, 'adminCpt' )
			)
		);
	}

	public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'ajec_indermediacao_cpt_settings',
				'option_name' => 'ajec_indermediacao_cpt',
				'callback' => array( $this->cpt_callbacks, 'cptSanitize' )
			)
		);

		$this->settings->setSettings( $args );
	}

	public function setSections()
	{
		$args = array(
			array(
				'id' => 'ajec_indermediacaocpt_index',
				'title' => 'Gestão de Intermediação Nego',
				'callback' => array( $this->cpt_callbacks, 'cptSectionManager' ),
				'page' => 'ajec_indermediacao_cpt'
			)
		);

		$this->settings->setSections( $args );
	}

	public function setFields()
	{
		$args = array(
			array(
				'id' => 'post_type',
				'title' => 'Sender ID',
				'callback' => array( $this->cpt_callbacks, 'textField' ),
				'page' => 'ajec_cpt',
				'section' => 'ajec_cpt_index',
				'args' => array(
					'option_name' => 'ajec_indermediacao_cpt',
					'label_for' => 'post_type',
					'placeholder' => 'eg. product',
					'array' => 'post_type'
				)
			),
			array(
				'id' => 'singular_name',
				'title' => 'Singular Name',
				'callback' => array( $this->cpt_callbacks, 'textField' ),
				'page' => 'ajec_cpt',
				'section' => 'ajec_cpt_index',
				'args' => array(
					'option_name' => 'ajec_indermediacao_cpt',
					'label_for' => 'singular_name',
					'placeholder' => 'eg. Product',
					'array' => 'post_type'
				)
			)
		);

		$this->settings->setFields( $args );
	}
}