<?php

class Jusibe_WC_SMS_Admin{

	public function __construct(){

		add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_tab'  ), 100 );

		add_action( 'woocommerce_settings_tabs_jusibe_sms', array( $this, 'jusibe_sms_settings_tab' ) );

		add_action( 'woocommerce_update_options_jusibe_sms', array( $this, 'update_jusibe_sms_settings' ) );

		add_action( 'add_meta_boxes', array( $this, 'add_send_sms_meta_box' ) );

		add_action( 'wp_ajax_wc_jusibe_sms_send_order_sms', array( $this, 'send_order_sms' ) );
	}

	public function add_settings_tab( $settings_tabs ) {

		$jusibe_settings_tab = array();

		foreach ( $settings_tabs as $tab_id => $tab_title ) {

			$jusibe_settings_tab[ $tab_id ] = $tab_title;

			if ( 'email' == $tab_id ) {
				$jusibe_settings_tab[ 'jusibe_sms' ] = 'Jusibe SMS';
			}
		}

		return $jusibe_settings_tab;
	}

	public function jusibe_sms_settings_tab() {
	    woocommerce_admin_fields( $this->get_jusibe_sms_settings() );

		ob_start(); ?>
			jQuery( document ).ready( function(){
				if ( $('#wc_jusibe_order_pending').is(':checked') == true ) {
					$( "#wc_jusibe_pending_sms" ).closest( "tr" ).show();
				}
				else{
					$( "#wc_jusibe_pending_sms" ).closest( "tr" ).hide();
				}
				if ( $('#wc_jusibe_order_on-hold').is(':checked') == true ) {
					$( "#wc_jusibe_on-hold_sms" ).closest( "tr" ).show();
				}
				else{
					$( "#wc_jusibe_on-hold_sms" ).closest( "tr" ).hide();
				}
				if ( $('#wc_jusibe_order_processing').is(':checked') == true ) {
					$( "#wc_jusibe_processing_sms" ).closest( "tr" ).show();
				}
				else{
					$( "#wc_jusibe_processing_sms" ).closest( "tr" ).hide();
				}
				if ( $('#wc_jusibe_order_completed').is(':checked') == true ) {
					$( "#wc_jusibe_completed_sms" ).closest( "tr" ).show();
				}
				else{
					$( "#wc_jusibe_completed_sms" ).closest( "tr" ).hide();
				}
				if ( $('#wc_jusibe_order_cancelled').is(':checked') == true ) {
					$( "#wc_jusibe_cancelled_sms" ).closest( "tr" ).show();
				}
				else{
					$( "#wc_jusibe_cancelled_sms" ).closest( "tr" ).hide();
				}
				if ( $('#wc_jusibe_order_refunded').is(':checked') == true ) {
					$( "#wc_jusibe_refunded_sms" ).closest( "tr" ).show();
				}
				else{
					$( "#wc_jusibe_refunded_sms" ).closest( "tr" ).hide();
				}
				if ( $('#wc_jusibe_order_failed').is(':checked') == true ) {
					$( "#wc_jusibe_failed_sms" ).closest( "tr" ).show();
				}
				else{
					$( "#wc_jusibe_failed_sms" ).closest( "tr" ).hide();
				}

				$( '#wc_jusibe_order_pending' ).change(function(){
					if( $(this).prop("checked") ) {
						$( "#wc_jusibe_pending_sms" ).closest( "tr" ).show();
					} else {
						$( "#wc_jusibe_pending_sms" ).closest( "tr" ).hide();
					}
				});
				$( '#wc_jusibe_order_on-hold' ).change(function(){
					if( $(this).prop("checked") ) {
						$( "#wc_jusibe_on-hold_sms" ).closest( "tr" ).show();
					} else {
						$( "#wc_jusibe_on-hold_sms" ).closest( "tr" ).hide();
					}
				});
				$( '#wc_jusibe_order_processing' ).change(function(){
					if( $(this).prop("checked") ) {
						$( "#wc_jusibe_processing_sms" ).closest( "tr" ).show();
					} else {
						$( "#wc_jusibe_processing_sms" ).closest( "tr" ).hide();
					}
				});
				$( '#wc_jusibe_order_completed' ).change(function(){
					if( $(this).prop("checked") ) {
						$( "#wc_jusibe_completed_sms" ).closest( "tr" ).show();
					} else {
						$( "#wc_jusibe_completed_sms" ).closest( "tr" ).hide();
					}
				});
				$( '#wc_jusibe_order_cancelled' ).change(function(){
					if( $(this).prop("checked") ) {
						$( "#wc_jusibe_cancelled_sms" ).closest( "tr" ).show();
					} else {
						$( "#wc_jusibe_cancelled_sms" ).closest( "tr" ).hide();
					}
				});
				$( '#wc_jusibe_order_processing' ).change(function(){
					if( $(this).prop("checked") ) {
						$( "#wc_jusibe_processing_sms" ).closest( "tr" ).show();
					} else {
						$( "#wc_jusibe_processing_sms" ).closest( "tr" ).hide();
					}
				});
				$( '#wc_jusibe_order_refunded' ).change(function(){
					if( $(this).prop("checked") ) {
						$( "#wc_jusibe_refunded_sms" ).closest( "tr" ).show();
					} else {
						$( "#wc_jusibe_refunded_sms" ).closest( "tr" ).hide();
					}
				});
				$( '#wc_jusibe_order_failed' ).change(function(){
					if( $(this).prop("checked") ) {
						$( "#wc_jusibe_failed_sms" ).closest( "tr" ).show();
					} else {
						$( "#wc_jusibe_failed_sms" ).closest( "tr" ).hide();
					}
				});
			});

		<?php
		wc_enqueue_js( ob_get_clean() );
	}

	public function get_jusibe_sms_settings() {

	    $settings = array(
	        array(
	            'title'    	=> 'Jusibe.com API Credentials',
	            'type'     	=> 'title',
	            'desc' 		=> 'This section lets you enter your Jusibe API credentials. To get your API credentials login to your account <a href="https://jusibe.com/cp" target="_blank">here</a> and click on the settings tab. If you don\'t an account visit <a href="https://jusibe.com"  target="_blank">Jusibe.com</a> to register and purchase SMS credits. '
	        ),
	        array(
	            'title' 	=> 'API Key',
	            'desc' 		=> 'Enter your Jusibe API key',
	            'type' 		=> 'text',
	            'id'   		=> 'wc_jusibe_api_key',
				'css'   	=> 'width:40%',
	        ),
	        array(
	            'title' 	=> 'API Token',
	            'desc' 		=> 'Enter your Jusibe API token',
	            'type' 		=> 'text',
	            'id'   		=> 'wc_jusibe_api_token',
				'css'   	=> 'width:40%',
	        ),
	        array(
	            'title' 	=> 'Sender ID',
	            'desc' 		=> 'Enter the sender ID for the SMS. Maximum of eleven (11) characters. Mobile numbers not allowed',
	            'type' 		=> 'text',
	            'id'   		=> 'wc_jusibe_sender_id',
	        ),

			array( 'type' => 'sectionend' ),

	        array(
	            'title'    	=> 'Admin SMS Notifications',
	            'type'     	=> 'title',
	            'desc' 		=> 'This section lets you enable SMS notifications to admin for new orders & customise the SMS message that is sent to the admin when an order is placed. Use the tags below to customize the message:
	            	<code>%shop_name%</code>: Shop Name
	            	<code>%order_id%</code>: The Order Number
	            	<code>%order_amount%</code>: The Order Amount
	            	<code>%store_currency%</code>: The default currency of the store
	            	<code>%order_status%</code>: The Order Status'
	        ),
			array(
				'id'       => 'wc_jusibe_enable_admin_sms',
				'name'     => 'Enable Admin New Order SMS Notifcations',
				'desc_tip' => 'Enable Admin New Order SMS notifications',
				'default'  => 'no',
				'type'     => 'checkbox'
			),
	        array(
	            'title' 	=> 'Admin Mobile Number',
	            'desc' 		=> 'Enter the mobile number where new order SMS will be sent to, in the format 080XXXXXXXX. Seperate multiple numbers by commas',
	            'type' 		=> 'text',
	            'id'   		=> 'wc_jusibe_admin_mobile',
	        ),

			array(
				'id'       => 'wc_jusibe_admin_sms',
				'name'     => 'Admin SMS Message',
				'desc_tip' => 'This is the SMS message that is sent to the admin when an order is placed',
				'css'      => 'min-width:500px;min-height:80px;',
				'default'  => 'You have a new order #%order_id% on %shop_name% for %store_currency%%order_amount%',
				'type'     => 'textarea'
			),

			array( 'type' => 'sectionend' ),

	        array(
	            'title'    	=> 'Customer SMS Notifications',
	            'type'     	=> 'title',
	            'desc' 		=> 'This section lets you select the order status changes that will send a SMS notification to customers'
	        ),

			array(
				'name'          => 'Send SMS Notifications for these order statuses:',
				'id'            => 'wc_jusibe_order_pending',
				'desc'          => 'Pending',
				'default'       => 'no',
				'type'          => 'checkbox',
				'checkboxgroup' => 'start'
			),

			array(
				'id'            => 'wc_jusibe_order_on-hold',
				'desc'          => 'On-Hold',
				'default'       => 'no',
				'type'          => 'checkbox',
				'checkboxgroup' => ''
			),

			array(
				'id'            => 'wc_jusibe_order_processing',
				'desc'          => 'Processing',
				'default'       => 'no',
				'type'          => 'checkbox',
				'checkboxgroup' => ''
			),

			array(
				'id'            => 'wc_jusibe_order_completed',
				'desc'          => 'Completed',
				'default'       => 'no',
				'type'          => 'checkbox',
				'checkboxgroup' => ''
			),

			array(
				'id'            => 'wc_jusibe_order_cancelled',
				'desc'          => 'Cancelled',
				'default'       => 'no',
				'type'          => 'checkbox',
				'checkboxgroup' => ''
			),

			array(
				'id'            => 'wc_jusibe_order_refunded',
				'desc'          => 'Refunded',
				'std'           => 'yes',
				'default'       => 'no',
				'type'          => 'checkbox',
				'checkboxgroup' => ''
			),

			array(
				'id'            => 'wc_jusibe_order_failed',
				'desc'          => 'Failed',
				'default'       => 'no',
				'type'          => 'checkbox',
				'checkboxgroup' => 'end'
			),

			array( 'type' => 'sectionend' ),

	        array(
	            'title'    	=> 'Customise SMS Messages',
	            'type'     	=> 'title',
	            'desc' 		=> 'This section lets you customise the SMS message that is sent to customers when their order status changes. Use the tags below to customize the SMS message:
	            	<code>%first_name%</code>: Customer\'s First Name
	            	<code>%last_name%</code>: Customer\'s Last Name
	            	<code>%shop_name%</code>: Shop Name
	            	<code>%order_id%</code>: The Order Number
	            	<code>%order_amount%</code>: The Order Amount
	            	<code>%store_currency%</code>: The default currency of the store
	            	<code>%order_status%</code>: The Order Status'
	        ),

			array(
				'id'       		=> 'wc_jusibe_default_sms',
				'name'     		=> 'Default Customer SMS Message',
				'desc_tip' 		=> 'This is the default SMS message that is sent when an order status changes.',
				'css'      		=> 'min-width:500px;min-height:80px;',
				'default'  		=> 'Hi %first_name% Thanks for placing an order on %shop_name. Your order #%order_id% on %shop_name% is now %order_status%.',
				'type'     		=> 'textarea',
			),

			array(
				'id'       	=> 'wc_jusibe_pending_sms',
				'name'     	=> 'Pending SMS Message',
				'desc_tip' 	=> 'Enter a custom SMS message to be sent for pending orders or leave blank to use the default message above.',
				'css'      	=> 'min-width:500px;min-height:80px;',
				'type'     	=> 'textarea',
			),

			array(
				'id'       	=> 'wc_jusibe_on-hold_sms',
				'name'     	=> 'On-Hold SMS Message',
				'desc_tip' 	=> 'Enter a custom SMS message to be sent for on-hold orders or leave blank to use the default message above.',
				'css'      	=> 'min-width:500px;min-height:80px;',
				'type'     	=> 'textarea',
			),

			array(
				'id'       	=> 'wc_jusibe_processing_sms',
				'name'     	=> 'Processing SMS Message',
				'desc_tip' 	=> 'Enter a custom SMS message to be sent for processing orders or leave blank to use the default message above.',
				'css'      	=> 'min-width:500px;min-height:80px;',
				'type'     	=> 'textarea',
			),

			array(
				'id'       	=> 'wc_jusibe_completed_sms',
				'name'     	=> 'Completed SMS Message',
				'desc_tip' 	=> 'Enter a custom SMS message to be sent for completed orders or leave blank to use the default message above.',
				'css'      	=> 'min-width:500px;min-height:80px;',
				'type'     	=> 'textarea',
			),

			array(
				'id'       	=> 'wc_jusibe_cancelled_sms',
				'name'     	=> 'Cancelled SMS Message',
				'desc_tip' 	=> 'Enter a custom SMS message to be sent for cancelled orders or leave blank to use the default message above.',
				'css'      	=> 'min-width:500px;min-height:80px;',
				'type'     	=> 'textarea',
			),

			array(
				'id'       	=> 'wc_jusibe_refunded_sms',
				'name'     	=> 'Refunded SMS Message',
				'desc_tip' 	=> 'Enter a custom SMS message to be sent for refunded orders or leave blank to use the default message above.',
				'css'      	=> 'min-width:500px;min-height:80px;',
				'type'     	=> 'textarea',
			),

			array(
				'id'       	=> 'wc_jusibe_failed_sms',
				'name'     	=> 'Failed SMS Message',
				'desc_tip' 	=> 'Enter a custom SMS message to be sent for failed orders or leave blank to use the default message above.',
				'css'      	=> 'min-width:500px;min-height:80px;',
				'type'     	=> 'textarea',
			),

			array( 'type' => 'sectionend' ),

	    );

	    return apply_filters( 'jusibe_api_details_settings', $settings );
	}

	public function update_jusibe_sms_settings() {
	    woocommerce_update_options( $this->get_jusibe_sms_settings() );
	}

	public function add_send_sms_meta_box(){

		add_meta_box(
			'wc_jusibe_send_sms_meta_box',
			'Send SMS Message Jusibe',
		 	array( $this, 'display_send_sms_meta_box' ),
			'shop_order',
			'side',
			'default'
		);
	}

	public function display_send_sms_meta_box(){

		global $theorder;
	?>
    	<p><textarea type="text" name="wc_jusibe_sms_order_message" id="wc_jusibe_sms_order_message" class="input-text" style="width: 100%;" rows="4" value="<?php echo esc_attr( $default_message ); ?>"></textarea></p>
    	<p><a class="button tips" id="wc_jusibe_sms_order_send_message" data-tip="Send an SMS to the billing phone number for this order.">Send SMS</a>
        <span id="wc_jusibe_sms_order_message_char_count" style="color: green; float: right; font-size: 16px;">0</span></p>

		<?php ob_start(); ?>
			// character count
			$('#wc_jusibe_sms_order_message').on('change keyup input', function() {

				$('#wc_jusibe_sms_order_message_char_count').text( $(this).val().length );

				if( $(this).val().length > 160 ) {
					$('#wc_jusibe_sms_order_message_char_count').css('color','red');
				}
			});

			// AJAX message send
			$( "a#wc_jusibe_sms_order_send_message" ).click( function( e ) {

				var $section = $( "div#wc_jusibe_send_sms_meta_box" ),
					$message = $( "textarea#wc_jusibe_sms_order_message" );

				if ( $section.is( ".processing" ) ) return false;

				$section.addClass( "processing" ).block( { message: null, overlayCSS: { background: "#fff url( '<?php echo esc_url( WC()->plugin_url() . '/assets/images/ajax-loader@2x.gif' ); ?>' ) no-repeat center", backgroundSize: "16px 16px", opacity: 0.6 } } );

				var data = {
					action:    "wc_jusibe_sms_send_order_sms",
					security:  "<?php echo wp_create_nonce( 'wc_jusibe_sms_send_order_sms' ); ?>",
					order_id:  "<?php echo esc_js( $theorder->id ); ?>",
					message:   $message.val()
				};

				$.ajax( {
						type:     "POST",
						url:      ajaxurl,
						data:     data,
						success:  function( response ) {

						$section.removeClass( "processing" ).unblock();

						if ( response ) {

							$section.block( { message: response, timeout: 900 } );
							$message.val( '' );
						}
					},
					dataType: "html"
				} );
				return false;
			});
		<?php

		wc_enqueue_js( ob_get_clean() );
	}

	public function send_order_sms() {

		if( ! is_admin() || ! current_user_can( 'edit_posts' ) ) {
			wp_die( 'You do not have sufficient permissions to access this page.' );
		}

		if( ! wp_verify_nonce( $_POST['security'], 'wc_jusibe_sms_send_order_sms' ) ) {
			wp_die( 'You have taken too long, please go back and try again.' );
		}

		$message = sanitize_text_field( $_POST[ 'message' ] );

		$order_id = ( is_numeric( $_POST['order_id'] ) ) ? absint( $_POST['order_id'] ) : null;

		if ( ! $order_id ) {
			return;
		}

		$order = wc_get_order( $order_id );

		$phone = $order->billing_phone;

		require_once JUSIBE_WC_SMS_DIR . '/includes/class-jusibe-sms.php';

		$jusibe_wc_sms = new Jusibe_WC_SMS();

		$jusibe_wc_sms->send_sms( $phone, $message, true, $order_id );

		exit( 'Message Sent' );
	}

}
new Jusibe_WC_SMS_Admin;

