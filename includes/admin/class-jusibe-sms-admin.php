<?php

/**
 * Class Jusibe_WC_SMS_Admin
 */
class Jusibe_WC_SMS_Admin {

	/**
	 * Jusibe_WC_SMS_Admin constructor.
	 */
	public function __construct() {

		add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_tab' ), 100 );

		add_action( 'woocommerce_settings_tabs_jusibe_sms', array( $this, 'jusibe_sms_settings_tab' ) );

		add_action( 'woocommerce_update_options_jusibe_sms', array( $this, 'update_jusibe_sms_settings' ) );

		add_action( 'woocommerce_admin_field_wc_jusibe_sms_link', array( $this, 'add_link_field' ) );

		add_action( 'add_meta_boxes', array( $this, 'add_send_sms_meta_box' ) );

		add_action( 'wp_ajax_wc_jusibe_sms_send_test_sms', array( $this, 'send_test_sms' ) );

		add_action( 'wp_ajax_wc_jusibe_sms_send_order_sms', array( $this, 'send_order_sms' ) );

		add_action( 'admin_bar_menu', array( $this, 'show_jusibe_sms_credits' ), 100 );

		add_filter( 'plugin_action_links_' . JUSIBE_WC_SMS_BASENAME, array( $this, 'plugin_action_links' ) );
	}

	/**
	 * Add Jusibe settings tab.
	 *
	 * @param array $settings_tabs.
	 *
	 * @return array
	 */
	public function add_settings_tab( $settings_tabs ) {

		$jusibe_settings_tab = array();

		foreach ( $settings_tabs as $tab_id => $tab_title ) {

			$jusibe_settings_tab[ $tab_id ] = $tab_title;

			if ( 'email' === $tab_id ) {
				$jusibe_settings_tab['jusibe_sms'] = 'Jusibe SMS';
			}
		}

		return $jusibe_settings_tab;
	}

	/**
	 * Jusibe settings tab custom script.
	 */
	public function jusibe_sms_settings_tab() {
		woocommerce_admin_fields( $this->get_jusibe_sms_settings() );

		ob_start(); ?>
			jQuery( document ).ready( function(){
				if ( $('#wc_jusibe_enable_admin_sms').is(':checked') == true ) {
					$( "#wc_jusibe_admin_sms" ).closest( "tr" ).show();
					$( "#wc_jusibe_admin_mobile" ).closest( "tr" ).show();
				}
				else{
					$( "#wc_jusibe_admin_sms" ).closest( "tr" ).hide();
					$( "#wc_jusibe_admin_mobile" ).closest( "tr" ).hide();
				}
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

				$( '#wc_jusibe_enable_admin_sms' ).change(function(){
					if( $(this).prop("checked") ) {
						$( "#wc_jusibe_admin_sms" ).closest( "tr" ).show();
						$( "#wc_jusibe_admin_mobile" ).closest( "tr" ).show();;
					} else {
						$( "#wc_jusibe_admin_sms" ).closest( "tr" ).hide();
						$( "#wc_jusibe_admin_mobile" ).closest( "tr" ).hide();
					}
				});
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

				// handle SMS test send
				$('a.<?php echo 'wc_send_sms_test_sms_button'; ?>').on('click', function () {

					var number  = $('input#<?php echo 'wc_jusibe_sms_test_mobile_number'; ?>');
					var message = $('textarea#<?php echo 'wc_jusibe_sms_test_message'; ?>');

					// make sure values are not empty
					if ( ( !number.val() ) || ( !number.val() ) ) {
						alert("Please make sure you have entered a mobile phone number and test message.");
						return false;
					}

					// block UI
					number.closest('table').addClass( "processing" ).block( { message: null, overlayCSS: { background: "#fff", backgroundSize: "16px 16px", opacity: 0.6 } } );

					var data = {
						action			: 'wc_jusibe_sms_send_test_sms',
						mobile_number	: number.val(),
						message			: message.val(),
						security		: '<?php echo wp_create_nonce( 'wc_jusibe_sms_send_test_sms' ); ?>',

					};

					$.ajax(	{
						type:     "POST",
						url:      ajaxurl,
						data:     data,
						success:  function( response ) {

							if ( response ) {

								// unblock UI
								number.closest('table').unblock();

								// clear posted values
								number.val('');
								message.val('');

								// Display Success or Failure message from response
								alert(response);

							}
						},
						dataType: "html"
					} );

					return false;

				});

			});

		<?php
		wc_enqueue_js( ob_get_clean() );
	}

	/**
	 * Jusibe WooCommerce settings.
	 *
	 * @return mixed|void
	 */
	public function get_jusibe_sms_settings() {

		$settings = array(
			array(
				'title' => 'Jusibe.com API Credentials',
				'type'  => 'title',
				'desc'  => 'This section lets you enter your Jusibe API credentials. To get your API credentials login to your account <a href="https://dashboard.jusibe.com" target="_blank">here</a> and click on the settings menu. If you don\'t an account visit <a href="https://jusibe.com"  target="_blank">Jusibe.com</a> to register and purchase SMS credits. ',
			),
			array(
				'title' => 'Public Key',
				'desc'  => 'Enter your Jusibe Public key',
				'type'  => 'text',
				'id'    => 'wc_jusibe_api_key',
				'css'   => 'width:40%',
			),
			array(
				'title' => 'Access Token',
				'desc'  => 'Enter your Jusibe Access token',
				'type'  => 'text',
				'id'    => 'wc_jusibe_api_token',
				'css'   => 'width:40%',
			),
			array(
				'title' => 'Sender ID',
				'desc'  => 'Enter the sender ID for the SMS. Maximum of eleven (11) characters. Mobile numbers not allowed',
				'type'  => 'text',
				'id'    => 'wc_jusibe_sender_id',
			),

			array( 'type' => 'sectionend' ),

			array(
				'title' => 'Admin SMS Notifications',
				'type'  => 'title',
				'desc'  => 'This section lets you enable SMS notifications to admin for new orders & customise the SMS message that is sent to the admin when an order is placed.<br>Use the tags below to customize the message:
	            	<code>%first_name%</code>: Customer\'s First Name
	            	<code>%last_name%</code>: Customer\'s Last Name
	            	<code>%phone_number%</code>: Customer\'s Phone Number
	            	<code>%shop_name%</code>: Shop Name (' . get_bloginfo( 'name' ) . ')
	            	<code>%shop_url%</code>: Shop URL (' . get_home_url() . ')
	            	<code>%order_id%</code>: The Order Number
	            	<code>%order_amount%</code>: The Order Amount
	            	<code>%order_notes%</code>: Order notes provided by the customer
	            	<code>%products%</code>: Products in the order. (Shoe)
	            	<code>%products_with_quantity%</code>: Products in the order with the quantity ordered. (Shoe (Qty: 10))
	            	<code>%payment_method%</code>: Payment method used to pay for the order
	            	<code>%store_currency%</code>: The default currency of the store
	            	<code>%order_status%</code>: The Order Status',
			),
			array(
				'id'       => 'wc_jusibe_enable_admin_sms',
				'name'     => 'Enable Admin New Order SMS Notifications',
				'desc_tip' => 'Enable Admin New Order SMS notifications',
				'default'  => 'no',
				'type'     => 'checkbox',
			),
			array(
				'title' => 'Admin Mobile Number',
				'desc'  => '<br>Enter the mobile number where new order SMS will be sent to, in the format 080XXXXXXXX. Seperate multiple numbers by commas',
				'type'  => 'text',
				'id'    => 'wc_jusibe_admin_mobile',
				'css'   => 'width:40%',
			),

			array(
				'id'       => 'wc_jusibe_admin_sms',
				'name'     => 'Admin SMS Message',
				'desc_tip' => 'This is the SMS message that is sent to the admin when an order is placed',
				'css'      => 'min-width:500px;min-height:80px;',
				'default'  => 'You have a new order #%order_id% on %shop_name% for %store_currency%%order_amount%',
				'type'     => 'textarea',
			),

			array( 'type' => 'sectionend' ),

			array(
				'title' => 'Customer SMS Notifications',
				'type'  => 'title',
				'desc'  => 'This section lets you select the order status changes that will send a SMS notification to customers',
			),

			array(
				'name'          => 'Send SMS Notifications for these order statuses:',
				'id'            => 'wc_jusibe_order_pending',
				'desc'          => 'Pending',
				'default'       => 'no',
				'type'          => 'checkbox',
				'checkboxgroup' => 'start',
			),

			array(
				'id'            => 'wc_jusibe_order_on-hold',
				'desc'          => 'On-Hold',
				'default'       => 'no',
				'type'          => 'checkbox',
				'checkboxgroup' => '',
			),

			array(
				'id'            => 'wc_jusibe_order_processing',
				'desc'          => 'Processing',
				'default'       => 'no',
				'type'          => 'checkbox',
				'checkboxgroup' => '',
			),

			array(
				'id'            => 'wc_jusibe_order_completed',
				'desc'          => 'Completed',
				'default'       => 'no',
				'type'          => 'checkbox',
				'checkboxgroup' => '',
			),

			array(
				'id'            => 'wc_jusibe_order_cancelled',
				'desc'          => 'Cancelled',
				'default'       => 'no',
				'type'          => 'checkbox',
				'checkboxgroup' => '',
			),

			array(
				'id'            => 'wc_jusibe_order_refunded',
				'desc'          => 'Refunded',
				'std'           => 'yes',
				'default'       => 'no',
				'type'          => 'checkbox',
				'checkboxgroup' => '',
			),

			array(
				'id'            => 'wc_jusibe_order_failed',
				'desc'          => 'Failed',
				'default'       => 'no',
				'type'          => 'checkbox',
				'checkboxgroup' => 'end',
			),

			array( 'type' => 'sectionend' ),

			array(
				'title' => 'Customise SMS Messages',
				'type'  => 'title',
				'desc'  => 'This section lets you customise the SMS message that is sent to customers when their order status changes.<br>Use the tags below to customize the SMS message:
	            	<code>%first_name%</code>: Customer\'s First Name
	            	<code>%last_name%</code>: Customer\'s Last Name
	            	<code>%phone_number%</code>: Customer\'s Phone Number
	            	<code>%shop_name%</code>: Shop Name (' . get_bloginfo( 'name' ) . ')
	            	<code>%shop_url%</code>: Shop URL (' . get_home_url() . ')
	            	<code>%order_id%</code>: The Order Number
	            	<code>%order_amount%</code>: The Order Amount
	            	<code>%order_notes%</code>: Order notes provided by the customer
	            	<code>%products%</code>: Products in the order. (Shoe)
	            	<code>%products_with_quantity%</code>: Products in the order with the quantity ordered. (Shoe (Qty: 10))
	            	<code>%payment_method%</code>: Payment method used to pay for the order
	            	<code>%store_currency%</code>: The default currency of the store
	            	<code>%order_status%</code>: The Order Status',
			),

			array(
				'id'       => 'wc_jusibe_default_sms',
				'name'     => 'Default Customer SMS Message',
				'desc_tip' => 'This is the default SMS message that is sent when an order status changes.',
				'css'      => 'min-width:500px;min-height:80px;',
				'default'  => 'Hi %first_name% Thanks for placing an order on %shop_name%. Your order #%order_id% on %shop_name% is now %order_status%.',
				'type'     => 'textarea',
			),

			array(
				'id'       => 'wc_jusibe_pending_sms',
				'name'     => 'Pending SMS Message',
				'desc_tip' => 'Enter a custom SMS message to be sent when an order status is changed to pending or leave blank to use the default message above.',
				'css'      => 'min-width:500px;min-height:80px;',
				'type'     => 'textarea',
			),

			array(
				'id'       => 'wc_jusibe_on-hold_sms',
				'name'     => 'On-Hold SMS Message',
				'desc_tip' => 'Enter a custom SMS message to be sent when an order status is changed to on-hold or leave blank to use the default message above.',
				'css'      => 'min-width:500px;min-height:80px;',
				'type'     => 'textarea',
			),

			array(
				'id'       => 'wc_jusibe_processing_sms',
				'name'     => 'Processing SMS Message',
				'desc_tip' => 'Enter a custom SMS message to be sent when an order status is changed to processing or leave blank to use the default message above.',
				'css'      => 'min-width:500px;min-height:80px;',
				'type'     => 'textarea',
			),

			array(
				'id'       => 'wc_jusibe_completed_sms',
				'name'     => 'Completed SMS Message',
				'desc_tip' => 'Enter a custom SMS message to be sent for completed orders or leave blank to use the default message above.',
				'css'      => 'min-width:500px;min-height:80px;',
				'type'     => 'textarea',
			),

			array(
				'id'       => 'wc_jusibe_cancelled_sms',
				'name'     => 'Cancelled SMS Message',
				'desc_tip' => 'Enter a custom SMS message to be sent when an order status is changed to cancelled or leave blank to use the default message above.',
				'css'      => 'min-width:500px;min-height:80px;',
				'type'     => 'textarea',
			),

			array(
				'id'       => 'wc_jusibe_refunded_sms',
				'name'     => 'Refunded SMS Message',
				'desc_tip' => 'Enter a custom SMS message to be sent when an order status is changed to refunded or leave blank to use the default message above.',
				'css'      => 'min-width:500px;min-height:80px;',
				'type'     => 'textarea',
			),

			array(
				'id'       => 'wc_jusibe_failed_sms',
				'name'     => 'Failed SMS Message',
				'desc_tip' => 'Enter a custom SMS message to be sent when an order status is changed to failed or leave blank to use the default message above.',
				'css'      => 'min-width:500px;min-height:80px;',
				'type'     => 'textarea',
			),

			array( 'type' => 'sectionend' ),

			array(
				'name' => 'Send Test SMS',
				'type' => 'title',
				'desc' => 'The Sender ID that will be used is the Sender ID that was set above.',
			),

			array(
				'id'       => 'wc_jusibe_sms_test_mobile_number',
				'name'     => 'Mobile Number',
				'desc_tip' => 'Enter the mobile number you are test SMS will be sent to',
				'type'     => 'text',
			),

			array(
				'id'       => 'wc_jusibe_sms_test_message',
				'name'     => 'Message',
				'desc_tip' => 'Enter the test message to be sent.',
				'type'     => 'textarea',
				'css'      => 'min-width: 500px;',
			),

			array(
				'name'   => 'Send SMS',
				'href'   => '#',
				'class'  => 'wc_send_sms_test_sms_button button',
				'length' => 160,
				'type'   => 'wc_jusibe_sms_link',
			),

			array( 'type' => 'sectionend' ),

		);

		return apply_filters( 'jusibe_api_details_settings', $settings );
	}

	/**
	 * Add link field.
	 *
	 * @param $field
	 */
	public function add_link_field( $field ) {

		if ( isset( $field['name'] ) && isset( $field['class'] ) && isset( $field['href'] ) ) :

			?>
			<tr valign="top">
				<th scope="row" class="titledesc"></th>
				<td class="forminp">
					<a href="<?php echo esc_url( $field['href'] ); ?>" class="<?php echo esc_attr( $field['class'] ); ?>"><?php echo wp_filter_kses( $field['name'] ); ?></a>
				</td>
			</tr>
			<?php

		endif;
	}

	/**
	 * Save Jusibe settings.
	 */
	public function update_jusibe_sms_settings() {
		woocommerce_update_options( $this->get_jusibe_sms_settings() );
	}

	/**
	 * Add send message metabox.
	 */
	public function add_send_sms_meta_box() {

		add_meta_box(
			'wc_jusibe_send_sms_meta_box',
			'Jusibe: Send SMS To Customer',
			array( $this, 'display_send_sms_meta_box' ),
			'shop_order',
			'side',
			'default'
		);
	}

	/**
	 * Display send message metabox.
	 *
	 * @param WP_Post $post WP_Post.
	 */
	public function display_send_sms_meta_box( $post ) {

		global $post;
		?>
		<p><textarea type="text" name="wc_jusibe_sms_order_message" id="wc_jusibe_sms_order_message" class="input-text" style="width: 100%;" rows="4"></textarea></p>
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

				$section.addClass( "processing" ).block( { message: null, overlayCSS: { background: "#fff", backgroundSize: "16px 16px", opacity: 0.6 } } );

				var data = {
					action:    "wc_jusibe_sms_send_order_sms",
					security:  "<?php echo wp_create_nonce( 'wc_jusibe_sms_send_order_sms' ); ?>",
					order_id:  "<?php echo esc_js( $post->ID ); ?>",
					message:   $message.val()
				};

				$.ajax(	{
					type:     "POST",
					url:      ajaxurl,
					data:     data,
					success:  function( response ) {

						$section.removeClass( "processing" ).unblock();

						if ( response ) {
							$section.block( { message: response, timeout: 2000 } );
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

	/**
	 * Send test message
	 */
	public function send_test_sms() {

		if ( ! is_admin() || ! current_user_can( 'edit_posts' ) ) {
			wp_die( 'You do not have sufficient permissions to access this page.' );
		}

		if ( ! wp_verify_nonce( $_POST['security'], 'wc_jusibe_sms_send_test_sms' ) ) {
			wp_die( 'You have taken too long, please go back and try again.' );
		}

		$message = sanitize_textarea_field( $_POST['message'] );
		$phone   = sanitize_text_field( $_POST['mobile_number'] );

		$jusibe_wc_sms = new Jusibe_WC_SMS();

		$send_sms = $jusibe_wc_sms->send_sms( $phone, $message );

		if ( isset( $send_sms->status ) && ( 'Sent' === $send_sms->status ) ) {
			exit( 'Message Sent' );
		} else {
			exit( 'Message Not Sent ' );
		}
	}

	/**
	 * Send message from the order details page.
	 */
	public function send_order_sms() {

		if ( ! is_admin() || ! current_user_can( 'edit_posts' ) ) {
			wp_die( 'You do not have sufficient permissions to access this page.' );
		}

		if ( ! wp_verify_nonce( $_POST['security'], 'wc_jusibe_sms_send_order_sms' ) ) {
			wp_die( 'You have taken too long, please go back and try again.' );
		}

		$message = sanitize_textarea_field( $_POST['message'] );

		$order_id = ( is_numeric( $_POST['order_id'] ) ) ? absint( $_POST['order_id'] ) : null;

		if ( ! $order_id ) {
			return;
		}

		$order = wc_get_order( $order_id );

		$phone = method_exists( $order, 'get_billing_phone' ) ? $order->get_billing_phone() : $order->billing_phone;

		$jusibe_wc_sms = new Jusibe_WC_SMS();

		$message = $jusibe_wc_sms->replace_message_variables( $message, $order_id );

		$send_sms = $jusibe_wc_sms->send_sms( $phone, $message, true, $order_id );

		if ( isset( $send_sms->status ) && ( 'Sent' === $send_sms->status ) ) {
			exit( 'Message Sent' );
		} else {
			exit( 'Message Not Sent ' );
		}
	}

	/**
	 * Display Jusibe credits balance in the admin bar.
	 *
	 * @param $wp_admin_bar
	 */
	public function show_jusibe_sms_credits( $wp_admin_bar ) {

		if ( ! is_admin_bar_showing() || ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}

		if ( false === ( $my_query = get_transient( 'jusibe_available_sms_credits' ) ) ) {

			$api_key   = get_option( 'wc_jusibe_api_key', true );
			$api_token = get_option( 'wc_jusibe_api_token', true );

			if ( empty( $api_key ) || empty( $api_token ) ) {
				return;
			}

			$headers = array(
				'Authorization' => 'Basic ' . base64_encode( $api_key . ':' . $api_token ),
			);

			$args = array(
				'headers' => $headers,
				'timeout' => 60,
			);

			$url = 'https://jusibe.com/smsapi/get_credits/';

			$response = wp_remote_get( $url, $args );

			if ( ! is_wp_error( $response ) && 200 === (int) wp_remote_retrieve_response_code( $response ) ) {
				$body = json_decode( wp_remote_retrieve_body( $response ) );
				set_transient( 'jusibe_available_sms_credits', $body->sms_credits, 12 * HOUR_IN_SECONDS );
			}
		}

		$sms_credits = get_transient( 'jusibe_available_sms_credits' );

		if ( $sms_credits ) {

			$message = 'You have ' . $sms_credits . ' SMS credits left';

			$menu_args = array(
				'id'    => 'wc_jusibe_sms_admin_bar_menu',
				'title' => 'Jusibe SMS Credits: ' . $sms_credits,
				'href'  => false,
			);

			$sms_usage_item_args = array(
				'id'     => 'wc_jusibe_sms_sms_usage_item',
				'title'  => $message,
				'href'   => false,
				'parent' => 'wc_jusibe_sms_admin_bar_menu',
			);

			$add_funds_item_args = array(
				'id'     => 'wc_jusibe_sms_add_funds_item',
				'title'  => 'Buy SMS Credits for Your Jusibe Account',
				'href'   => 'https://dashboard.jusibe.com/buy-credit',
				'meta'   => array( 'target' => '_blank' ),
				'parent' => 'wc_jusibe_sms_admin_bar_menu',
			);

			$wp_admin_bar->add_menu( $menu_args );
			$wp_admin_bar->add_menu( $sms_usage_item_args );
			$wp_admin_bar->add_menu( $add_funds_item_args );
		}
	}

	/**
	 * Plugin action links.
	 *
	 * @param array $links Action links.
	 *
	 * @return array
	 */
	public function plugin_action_links( $links ) {
		$settings_link = array(
			'settings' => '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=jusibe_sms' ) . '" title="View Jusibe Settings">Settings</a>',
		);
		return array_merge( $links, $settings_link );
	}

}
new Jusibe_WC_SMS_Admin();

