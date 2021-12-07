<?php
 /**
 * @package  Aje_intermedicao
 */
/*
Plugin Name: Ajec Intermediação
Plugin URI: https://ajec.ao
Description: Ajec Intermediação, tem como objectivo de Ajudar em fazer compras e Trocas de Encomendas .
Version: 1.0.0
Author:"Ajec" soft
* WC requires at least: 2.2
* WC tested up to: 2.3
Author URI: https://nego.ao
License: GPLv2 or later
Text Domain: ajec-intermediacao
*/


// Se este arquivo for chamado diretamente, aborte!!!
defined( 'ABSPATH' ) or die( 'Não foi possivel inicializar o seu Plugin' );
//woocommerce_settings_checkout  

// Exigir uma vez que o Autoload do Composer
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

/**
 * O código executado durante a ativação do plugin
 */

function activate_ajec_intermediacao() {
    // Test to see if WooCommerce is active (including network activated).
$plugin_path = trailingslashit( WP_PLUGIN_DIR ) . 'woocommerce/woocommerce.php';

if (
    in_array( $plugin_path, wp_get_active_and_valid_plugins() )
    || in_array( $plugin_path, wp_get_active_network_plugins() )
) {
    Inc\Base\Activate::activate();
}
return;
}
register_activation_hook( __FILE__, 'activate_ajec-intermediacao' );

add_action( 'woocommerce_order_details_after_customer_details', 'butao' );

function butao() {

    //$pegar_id=get_the_ID()??'';
    global $wpdb; // Get the global $wpdb

    $wc_order_product_lookup = $wpdb->prefix . 'wc_order_stats';

   /**
 * Remove product data tabs
 */
    $id_produto=get_the_ID()??0;
    add_action( 'wp_login', 'login_cookie' );

    global $wpdb;
     $user = wp_get_current_user(); 
    //Get current user 
    $id_user = $user->ID; 

        //ORDER BY post_id DESC LIMIT 1
        // pegar id do usurio 
    $url_prod = "SELECT status,customer_id,total_sales,num_items_sold ,order_id FROM  $wc_order_product_lookup WHERE customer_id=$id_user  ORDER BY order_id DESC LIMIT 1" ;
    //$url_prod = "SELECT status,customer_id,total_sales,num_items_sold  FROM  $wc_order_product_lookup  WHERE order_id =117" ;

    if(is_user_logged_in()){
        $teste=$_SESSION['ativect']??'';
        if($teste!='yes'){
            return;}
             }else{
        return;
    }

    $result_sql_prod = $wpdb->get_results($url_prod);

    $id_user=$result_sql_prod[0]->customer_id??'';
    $total_sales_a_pagar=$result_sql_prod[0]->total_sales??'';
    $num_items_sold=$result_sql_prod[0]->num_items_sold??'' ;
    $num_items_sold=  $num_items_sold;
    $order_id=$result_sql_prod[0]->order_id??'' ;

    if(!session_id()){
        session_start();
      };
     $user_id_prc=get_current_user_id();// pega o id do usurio logado

   $quantidade_de_tenttativas= $_SESSION['ajec_pay_quatidade_de_sms_confirma_conta'];
   $numero_nego=$_SESSION['ajec_pay_numero_conta']??'';
   $thoken_nego_sms= $_SESSION['ajec_pay_token_conta']??'';
  

    $url="http://api.negoof.ao/api/intermediacao_p?token=$thoken_nego_sms";
        $estruturajson=' {
            "numero_nego": "'.$numero_nego.'",
            "preco" : "'.$total_sales_a_pagar.'",
            "id_produto":"'.$order_id.'",
            "ttivas_sms":"'.$quantidade_de_tenttativas.'",
            "id_usurio_prc":"'.$user_id_prc.'"
       }';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, true);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $estruturajson);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    // Resposta da Api a ser requisitada
    $response = curl_exec($ch);
    curl_close($ch);// fechando
    $infor = json_decode($response);

    if(is_user_logged_in()){
        
        echo "
        <button  class='btn rounded-pill btn-white text-primary border-0 m-1' onclick='callConversor();'  title='Vizualise o conversor de saldo.'>Pagamento Ajec</button>
        <div id='' >
        ".$response."
        </div>
        <input type='hidden' 'd='ttevas' value='$quantidade_de_tenttativas' >
    ";
}
    }

    add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {

     $tabs['description'] ='';      	// Remove the description tab
    $tabs['reviews'] ; 			// Remove the reviews tab
     $tabs['additional_information'];  	// Remove the additional information tab

    return $tabs;
}

/**
 * O código executado durante a desativação do plugin
 */
function deactivate_ajec_intermediacao() {
	Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_ajec-intermediacao' );

 function load_gateway($load_gateways) {
    include_once( 'class-wc-gateway-terawallet.php' );
    $load_gateways[] = 'WC_Gateway_TeraWallet';
    return $load_gateways;
}


/**
 * Inicializa todas as classes principais do plugin
 */

if ( class_exists( 'Inc\\Init' ) ) {
    $plugin_path = trailingslashit( WP_PLUGIN_DIR ) . 'woocommerce/woocommerce.php';
if (
    in_array( $plugin_path, wp_get_active_and_valid_plugins() )
    || in_array( $plugin_path, wp_get_active_network_plugins() )
) {
    Inc\Init::registerServices();
    }
}

function teste(){
    echo'estehhhhhh';
}


/*function shot(){
   // woocommerce_account_dashboard
        echo"ola mundohhhh";
        
}*/

 add_filter( 'woocommerce_account_menu_items', 'add_my_menu_items', 99, 1 );

function add_my_menu_items( $items ) {
    $is_rendred_from_myaccount = wc_post_content_has_shortcode( 'ajec_pay' ) ? false : is_account_page();
$my_items = array(
 //'endpoint'  => 'label',
'ajec_pay' => __( 'Ajec Pay', 'my_plugin' ),
);

$my_items = array_slice( $items, 0, 1, true ) + $my_items + array_slice( $items, 1, count( $items ), true );
return $my_items;

}

//in_admin_footer

//1- nome da funcao , 2-nome do short code

final class Ajec_Payment_Gateway {

            /**
     * The single instance of the class.
     *
     * @var WooWallet
     * @since 1.0.0
     */

    protected static $_instance = null;

    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

   public   function __construct() {
        add_action('woocommerce_payment_gateways', array($this, 'load_gateway'));
        add_action('init', array($this, 'load_plugin_textdomain'));
    }

    /**
     * Text Domain loader
     */

    public  function load_plugin_textdomain() {
        $locale = is_admin() && function_exists( 'get_user_locale' ) ? get_user_locale() : get_locale();
        $locale = apply_filters( 'plugin_locale', $locale, 'ajec-intermediacao' );

        unload_textdomain( 'ajec-intermediacao' );
        load_textdomain( 'ajec-intermediacao', WP_LANG_DIR . '/ajec-intermediacao/ajec-intermediacao-' . $locale . '.mo' );
        load_plugin_textdomain( 'ajec-intermediacao', false, plugin_basename(dirname(__FILE__) ) . '/languages' );
    }

    public  function load_gateway($load_gateways) {
        session_start();
        include_once( 'class-carrega-tipo.php' );
        $load_gateways[] = 'WC_carrega_paga_ajec';
        return $load_gateways;
    }
}
Ajec_Payment_Gateway::instance();