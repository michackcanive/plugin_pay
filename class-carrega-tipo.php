<?php 
        use Inc\Base\Client;

    if (class_exists('WC_Payment_Gateway')) {
        
    
        class WC_carrega_paga_ajec extends WC_Payment_Gateway {

            public function __construct() {
                $this->setup_properties();
                $this->supports = array(
                    'products',
                    'refunds'
                );
                // Load the settings
                $this->init_form_fields();
                $this->init_settings();
                $this->analizar_se_tem_nova();
                // Get settings
                $this->title = $this->get_option('title');
                $this->description = $this->get_option('description');
                $this->instructions = $this->get_option('instructions');
               
                $this->site_url = $this->get_option('site_url');
                $this->consumer_key = $this->get_option('consumer_key');
                $this->consumer_secret = $this->get_option('consumer_secret');
                $this->is_connected = $this->get_option('is_site_connected');

    
                add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
                add_filter('woocommerce_settings_api_sanitized_fields_' . $this->id, array($this, 'woocommerce_settings_api_sanitized_fields'));
            }


            public function analizar_se_tem_nova(){

                if(!session_id()){
                    session_start();
                  }

                $this->title = $this->get_option('title');
                $this->description = $this->get_option('description');
                $this->instructions = $this->get_option('instructions');

                $this->site_url = $this->get_option('site_url');
                $this->consumer_key = $this->get_option('consumer_key');
                $this->consumer_secret = $this->get_option('consumer_secret');
                $this->is_connected = $this->get_option('is_site_connected');
                $this->_quatidade_de_sms_confirma = $this->get_option('tentativa');
                $this->activado_pluigin = $this->get_option('enabled');//enabled


                $_SESSION['ajec_pay_numero_conta']=$this->instructions;
                $_SESSION['ajec_pay_token_conta']= $this->consumer_key;
                $_SESSION['ajec_pay_description_conta']= $this->description;
                $_SESSION['ajec_pay_site_url_conta']=$this->site_url;
                $_SESSION['ajec_pay_title_conta']=$this->title ;
                $_SESSION['ajec_pay_quatidade_de_sms_confirma_conta']=$this->_quatidade_de_sms_confirma;
                $_SESSION['ativect']= $this->activado_pluigin;
            }

            public function woocommerce_settings_api_sanitized_fields($settings) {
                try {
                    $woocommerce = new Client($settings['site_url'], $settings['consumer_key'], $settings['consumer_secret'], ['version' => 'wc/v3']);
                    $response = $woocommerce->get('terawallet');
                    if ($response->is_connected) {
                        $settings['is_site_connected'] = true;
                    } else {
                        $settings['is_site_connected'] = false;
                    }
                } catch (Exception $e) {
                    $settings['is_site_connected'] = false;
                }
                return $settings;
            }

              /**
         * Setup general properties for the gateway.
         */
        protected function setup_properties() {
            $this->id = 'ajec_intermediacao';
            $this->method_title = __('Ajec Inte-Pay', 'ajec-intermediacao');
            $this->method_description = __('Faça seus clientes pagarem com carteira.', 'ajec-intermediacao');
            $this->has_fields = false;
        }
        
        /**
         * Initialise Gateway Settings Form Fields.
         */
        public function init_form_fields() {

            $this->form_fields = array(
                'enabled' => array(
                    'title' => __('Habilitar/desabilitar', 'ajec-intermediacao'),
                    'label' => __('Habilitar pagamentos de carteira', 'ajec-intermediacao'),
                    'type' => 'checkbox',
                    'description' => '',
                    'default' => 'no',
                ),
                'title' => array(
                    'title' => __('Nome Da Loja', 'ajec-intermediacao'),
                    'type' => 'text',
                    'description' => __('Isso controla o título que o usuário vê durante o checkout.', 'ajec-intermediacao'),
                    'default' => __('Nego Carteira', 'ajec-intermediacao'),
                    'desc_tip' => true,
                ),
                'description' => array(
                    'title' => __('Descrição', 'ajec-intermediacao'),
                    'type' => 'textarea',
                    'description' => __('Descrição da forma de pagamento que o cliente verá em sua finalização da compra.', 'ajec-intermediacao'),
                    'default' => __('Este é um serviço de pagamento da nego. Você precisa de uma conta nego para fazer pagamento. Clica no link para criar uma: https://nego.com/', 'ajec-intermediacao'),
                    'desc_tip' => true,
                ),
                'instructions' => array(
                    'title' => __('Número Da Conta Nego', 'ajec-intermediacao'),
                    'type' => 'text',
                    'description' => __('Seu Número da Conta Nego.', 'ajec-intermediacao'),
                    'default' => __('seu Número da sua conta Nego .', 'ajec-intermediacao'),
                    'desc_tip' => true,
                ),
                'site_url' => array(
                    'title' => __('Site URL', 'ajec-intermediacao'),
                    'type' => 'text',
                    'description' => __('Visita o nosso Site Nego.', 'ajec-intermediacao'),
                    'default' => 'https://ajec-plugin.com/',
                    'desc_tip' => true,
                ),
                'consumer_key' => array(
                    'title' => __('Token', 'ajec-intermediacao'),
                    'type' => 'text',
                    'description' => __('Seu token de Activação.', 'ajec-intermediacao'),
                    'default' => 'Seu token de Actvação',
                    'desc_tip' => true,
                ),
                'tentativa' => array(
                    'title' => __('Números de Vezes de Receber o codígo de Confirmação', 'ajec-intermediacao'),
                    'type' => 'text',
                    'description' => __('Numeros de vezes para seu clientes receber o codigo', 'ajec-intermediacao'),
                    'default' => '2',
                    'desc_tip' => true,
                ),
    
            );
        }
        
        public function admin_options() {
            parent::admin_options();
            if ($this->is_connected) {
                echo '<span class="status-enabled tips" data-tip="' . __('Seu site agora está conectado', 'bwevip-directo') . '"></span>';
            } else {
                echo '<span class="status-disabled tips" data-tip="' . __('Seu site não está conectado', 'bwevip-directo') . '"></span>';
            }
        }


        public function is_available() {
            if (!$this->site_url || !$this->consumer_key || !$this->consumer_secret) {
                return false;
            }
            return parent::is_available();
        }

        public function payment_fields() {
            $this->form();
        }

        public function form() {
            $fields = array();
            $default_fields = array(
                'account-username' => '<p class="form-row form-row-first">
				<label for="' . esc_attr($this->id) . '-username">' . esc_html__('Username or email address', 'bwevipay-carteira') . '&nbsp;<span class="required">*</span></label>
				<input id="' . esc_attr($this->id) . '-username" class="input-text" type="text" autocomplete="off" name="' . esc_attr($this->id) . '-username" />
			</p>',
                'account-password' => '<p class="form-row form-row-last">
				<label for="' . esc_attr($this->id) . '-password">' . esc_html__('Password', 'bwevipay-carteira') . '&nbsp;<span class="required">*</span></label>
				<input id="' . esc_attr($this->id) . '-password" class="input-text" type="password" autocomplete="off" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" name="' . esc_attr($this->id) . '-password" />
			</p>',
            );
            $fields = wp_parse_args($fields, apply_filters('woocommerce_terawallet_form_fields', $default_fields, $this->id));
            ?>

            <fieldset id="<?php echo esc_attr($this->id); ?>-terawallet-form" class='wc-terawallet-form wc-payment-form'>
                <?php do_action('woocommerce_terawallet_form_start', $this->id); ?>
                <?php
                foreach ($fields as $field) {
                    echo $field; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
                }
                ?>
                <?php do_action('woocommerce_terawallet_form_end', $this->id); ?>
                <div class="clear"></div>
            </fieldset>
            <?php
    }

            /**
         * Process wallet payment
         * @param int $order_id
         * @return array
         */
        public function process_payment($order_id) {
            $order = wc_get_order($order_id);

            $woocommerce = new Client($this->site_url, $this->consumer_key, $this->consumer_secret, ['version' => 'wc/v3']);


            $data = array(
                'username' => $_POST["{$this->id}-username"],
                'password' => $_POST["{$this->id}-password"],
                'order_id' => $order_id,
                'site_url' => site_url(),
                'billing' => array(
                    'first_name' => $order->get_billing_first_name('edit'),
                    'last_name' => $order->get_billing_last_name('edit'),
                    'address_1' => $order->get_billing_address_1('edit'),
                    'address_2' => $order->get_billing_address_2('edit'),
                    'city' => $order->get_billing_city('edit'),
                    'state' => $order->get_billing_state('edit'),
                    'postcode' => $order->get_billing_postcode('edit'),
                    'country' => $order->get_billing_country('edit'),
                    'email' => $order->get_billing_email('edit'),
                    'phone' => $order->get_billing_phone('edit')
                ),
                "line_items" => [],
                'shipping_total' => $order->get_shipping_total('edit'),
                'total_tax' => $order->get_tax_totals('edit'),
                'subtotal' => $order->get_subtotal(),
                'total' => $order->get_total('edit'),
                'currency' => $order->get_currency('edit')
            );

            foreach ($order->get_items() as $item_id => $item) {
                $product_id = $item->get_product_id();
                $product = wc_get_product($product_id);
                $qty = $item->get_quantity();
                $data['line_items'][] = array(
                    "product_id" => $product_id,
                    'title' => $product->get_title(),
                    'url' => get_permalink($product_id),
                    "quantity" => $qty,
                    'price' => $order->get_item_subtotal( $item, false, true ) / $qty
                );
            }

           $response = $woocommerce->post('terawallet/orders', $data);

            if ('error' == $response->type) {
                wc_add_notice($response->message, 'error');
                return;
            }

            // Reduce stock levels
            wc_reduce_stock_levels($order_id);

            // Remove cart
            WC()->cart->empty_cart();

            if ('success' == $response->type && isset($response->transaction_id)) {
                $order->payment_complete($response->transaction_id);
            }

            // Return thankyou redirect
            return array(
                'result' => 'success',
                'redirect' => $this->get_return_url($order),
            );
        }

        
        /**
         * Process a refund if supported.
         *
         * @param  int    $order_id Order ID.
         * @param  float  $amount Refund amount.
         * @param  string $reason Refund reason.
         * @return bool|WP_Error
         */
        public function process_refund($order_id, $amount = null, $reason = '') {
            $order = wc_get_order($order_id);
//            $transaction_id = woo_wallet()->wallet->credit($order->get_customer_id(), $amount, __('Wallet refund #', 'bwevipay-carteira') . $order->get_order_number());
//            if (!$transaction_id) {
//                throw new Exception(__('Refund not credited to customer', 'bwevipay-carteira'));
//            }
//            do_action('woo_wallet_order_refunded', $order, $amount, $transaction_id);
            return true;
        }

        }
    }