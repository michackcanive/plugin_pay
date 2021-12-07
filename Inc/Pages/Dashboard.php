<?php 
/**
 * @package  ajec-intermediacao
 */
namespace Inc\Pages;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\ManagerCallbacks;

class Dashboard extends BaseController
{
	public $settings;

	public $callbacks;

	public $callbacks_mngr;

	public $pages = array();

	public function register()
	{
		$this->settings = new SettingsApi();

		$this->callbacks = new AdminCallbacks();

		$this->callbacks_mngr = new ManagerCallbacks();

		$this->setPages();
		$this->setSettings();
		$this->setSections();
		$this->setFields();

		

		$this->settings->addPages( $this->pages )->withSubPage( 'Configuração' )->register();
	}

	public function setPages() 
	{
		$this->pages = array(
			array(
				'page_title' => 'Pajec', 
				'menu_title' => 'Pajec', 
				'capability' => 'manage_options', 
				'menu_slug' => 'ajec_indermediacao', 
				'callback' => array( $this->callbacks, 'adminDashboard' ), 
				'icon_url' => 'dashicons-store', 
				'position' => 110
			)
		);
	}

	public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'ajec_indermediacao_settings',
				'option_name' => 'ajec_indermediacao',
				'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
			)
		);

		$this->settings->setSettings( $args );
	}

	public function setSections()
	{
		$args = array(
			array(
				'id' => 'ajec_admin_index',
				'title' => 'Gerenciador de configurações',
				'callback' => array( $this->callbacks_mngr, 'adminSectionManager' ),
				'page' => 'ajec_indermediacao'
			),
			array(
			  'id'=>'ajec_indermediacao_admin_index_inputs',
			  'title'=>' ',
			  'callback'=>array($this->callbacks_mngr,'adminSectionManager_inputs'),
			  'page'=>'ajec_indermediacao_inputs'
			)
		);

		$this->settings->setSections( $args );
	}

	public function setFields()
	{
		$args = array();

		foreach ( $this->managers as $key => $value ) {
			$args[] = array(
				'id' => $key,
				'title' => $value,
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'ajec_indermediacao',
				'section' => 'ajec_admin_index',
				'args' => array(
					'option_name' => 'ajec_indermediacao',
					'label_for' => $key,
					'class' => 'ui-toggle'
				)
			);
		}

		$this->settings->setFields( $args );
	}
	public function set_fields_inputs(){

		$args=array();
		
		foreach ($this->managers_inputs as $key=> $value){
			$args[]=array(
			  'id'=>$key,
			'title'=>'',
			'callback'=>array($this->callbacks_mngr,'inputs'),
			'page'=>'nego_sms_inputs',
			'section'=>'nego_sms_admin_index_inputs',
			'agrs'=>array(
			  'label_for'=>'thoken_nego_sms',
			  'class'=>'ui-toggle'
			)
		  );
		}
	  
		$this->definicaoApi->set_fields_inputs($args);
	  }
}