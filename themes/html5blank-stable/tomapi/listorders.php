<?php
add_action('rest_api_init', function () {
  	register_rest_route( 'tomapi/v1', 'listorders',array(
		'methods'  => 'GET',
        'callback' => function ($request){
        	$base_url = site_url();
			$parameters = '&';
			
			foreach ($_REQUEST as $key => $value) {
				if ( $key != 'woocs_order_emails_is_sending' ) {
					$parameters .= $key . '=' . $value . '&';
				}
			}

			$response = wp_remote_post( $base_url . '/wp-json/wc/v3/orders?'.$parameters, array(
			    'method'      => 'GET',
			    'headers'     => array(
			    	'Content-Type'	=>'application/json',
			    	'Authorization'	=>'Basic '.base64_encode( TOM_WOO_CK . ':' . TOM_WOO_CS ),
			    	'charset'		=>'utf-8',
			    ),
			    'data_format' => 'body',
			    'cookies'     => array()
			    )
			);
			 
			if ( is_wp_error( $response ) ) {
			    $error_message = $response->get_error_message();
			    return "Something went wrong: $error_message";
			} else {

			    print_r( $response['body'] );
			    return 1;
			}
        },
        'args'     => array()
    ));
});