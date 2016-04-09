<?php

class Jusibe_WC_SMS{

	private $api_url;

	public function __construct(){

		$this->api_url = 'https://jusibe.com/smsapi/send_sms/';

		$this->add_order_status_hooks();

	}

	private function add_order_status_hooks() {

		foreach( array( 'pending', 'failed', 'on-hold', 'processing', 'completed', 'refunded', 'cancelled' ) as $status ) {

			add_action( 'woocommerce_order_status_' . $status, array( $this, 'send_customer_notification' ) );
		}

		foreach( array( 'pending_to_on-hold', 'pending_to_processing', 'pending_to_completed', 'failed_to_on-hold', 'failed_to_processing', 'failed_to_completed' ) as $status ) {

			add_action( 'woocommerce_order_status_' . $status, array( $this, 'send_admin_new_order_notification' ) );
		}
	}

	public function send_customer_notification( $order_id ) {

		$this->send_automated_customer_notification( $order_id );
	}

	public function send_admin_new_order_notification( $order_id ) {

		$this->send_admin_notification( $order_id );
	}

	public function send_admin_notification( $order_id ) {

		if ( 'yes' == get_option( 'wc_jusibe_enable_admin_sms' ) ) {

			$message = get_option( 'wc_jusibe_admin_sms', '' );

			$message = $this->replace_message_variables( $message, $order_id );

			$recipients = explode( ',', trim( get_option( 'wc_jusibe_admin_mobile' ) ) );

			if ( ! empty( $recipients ) ) {

				foreach ( $recipients as $recipient ) {

					$this->send_sms( $recipient, $message );

				}
			}

		}
	}

	public function send_automated_customer_notification( $order_id ) {

		$order = wc_get_order( $order_id );

		$order_status = $order->get_status();

		if ( 'yes' == get_option( 'wc_jusibe_order_' . $order_status ) ) {

			$message = get_option( 'wc_jusibe_' . $order_status . '_sms', '' );

			if ( empty( $message ) ) {
				$message = get_option( 'wc_jusibe_default_sms' );
			}

			$message = $this->replace_message_variables( $message, $order_id );

			$phone = $order->billing_phone;

			$this->send_sms( $phone, $message, true, $order_id );
		}
	}

	public function send_sms( $to, $message, $customer_notification = false, $order_id = '' ){

		$api_key 	= get_option( 'wc_jusibe_api_key', true );
		$api_token 	= get_option( 'wc_jusibe_api_token', true );

		if( empty ( $api_key ) || empty( $api_token ) ){
			return;
		}

		$sender_id 	= get_option( 'wc_jusibe_sender_id', true );

		$status  	= 'Sent';

		$message    = sanitize_text_field( $message );

		$body = array(
			'to'		=> $to,
			'from'		=> $sender_id,
			'message'	=> $message
		);

		$headers = array(
			'Authorization' => 'Basic ' . base64_encode( $api_key . ':' . $api_token )
		);

		$args = array(
			'body' 		=> $body,
			'headers'	=> $headers,
			'timeout'	=> 60
		);

		$response = wp_remote_post( $this->api_url, $args );

		if( ! is_wp_error( $response ) && 200 == wp_remote_retrieve_response_code( $response ) ) {
			$error = false;

			$sent_timestamp = time();

			if ( $customer_notification && ! empty( $order_id ) ) {
				$order = wc_get_order( $order_id );
				$order->add_order_note( $this->format_order_note( $to, $sent_timestamp, $message, $status, $error ) );
			}
		}
		else{
			$error = true;
		}

		return json_decode( wp_remote_retrieve_body( $response ) );

	}

	public function replace_message_variables( $message, $order_id ) {

		$order = wc_get_order( $order_id );

		$replacements = array(
			'%first_name%'    	=> $order->billing_first_name,
			'%last_name%'    	=> $order->billing_last_name,
			'%shop_name%'    	=> get_bloginfo( 'name' ),
			'%order_id%'     	=> $order->get_order_number(),
			'%order_amount%' 	=> $order->get_total(),
			'%order_status%' 	=> ucfirst( $order->get_status() ),
			'%store_currency%'	=> get_woocommerce_currency(),
		);

		return str_replace( array_keys( $replacements ), $replacements, $message );
	}

	private function format_order_note( $to, $sent_timestamp, $message, $status, $error ) {

		try {

			$datetime = new DateTime( "@{$sent_timestamp}", new DateTimeZone( 'UTC' ) );

			$datetime->setTimezone( new DateTimeZone( wc_timezone_string() ) );

			$formatted_datetime = date_i18n( wc_date_format() . ' ' . wc_time_format(), $sent_timestamp + $datetime->getOffset() );

		} catch ( Exception $e ) {

			$formatted_datetime = 'N/A';
		}

		ob_start();
		?>
	  	<p><strong>SMS Notification</strong></p>
		<p><strong>To: </strong><?php echo esc_html( $to ); ?></p>
		<p><strong>Date Sent: </strong><?php echo esc_html( $formatted_datetime ); ?></p>
		<p><strong>Message: </strong><?php echo esc_html( $message ); ?></p>
		<p><strong>Status: <span style="<?php echo ( $error ) ? 'color: red;' : 'color: green;'; ?>"><?php echo esc_html( $status ); ?></span></strong></p>
		<?php

		return ob_get_clean();
	}
}
new Jusibe_WC_SMS;