<?php
add_action('rest_api_init', function () {
  	register_rest_route( 'tomapi/v1', 'whoami',array(
		'methods'  => 'POST',
        'callback' => function ($request){
        	$refresh_token = $request->get_json_params()['refreshtoken'];

        	if ( !empty($refresh_token) ) {
				$users = get_users( array( 'fields' => 'ID' ) );
				foreach($users as $user_id){
					if ( !empty($user_id) ) {

						$this_user_refresh_token = get_user_meta( $user_id, 'tom_api_refresh_token', true );
						// var_dump($user_id);
						// var_dump($this_user_refresh_token);
						// var_dump($refresh_token);
						if ( $this_user_refresh_token == $refresh_token ) {
							
							$billing_first_name = get_user_meta( $user_id, 'billing_first_name', true );
							$billing_last_name = get_user_meta( $user_id, 'billing_last_name', true );
						 	$billing_address_1 = get_user_meta( $user_id, 'billing_address_1', true ); 
							$billing_address_2 = get_user_meta( $user_id, 'billing_address_2', true );
							$billing_city = get_user_meta( $user_id, 'billing_city', true );
							$billing_postcode = get_user_meta( $user_id, 'billing_postcode', true );

							$shipping_first_name = get_user_meta( $user_id, 'shipping_first_name', true );
							$shipping_last_name = get_user_meta( $user_id, 'shipping_last_name', true );
						 	$shipping_address_1 = get_user_meta( $user_id, 'shipping_address_1', true ); 
							$shipping_address_2 = get_user_meta( $user_id, 'shipping_address_2', true );
							$shipping_city = get_user_meta( $user_id, 'shipping_city', true );
							$shipping_postcode = get_user_meta( $user_id, 'shipping_postcode', true );

							$refresh_token = openssl_random_pseudo_bytes(16);
							$refresh_token = bin2hex($refresh_token);
							// return $refresh_token;
							delete_user_meta( $user_id, 'tom_api_refresh_token' );
							update_user_meta( $user_id, 'tom_api_refresh_token', $refresh_token, true );

							$output = array(
					    		'token' => 'dontusethistoken',
					    		'refresh_token' => $refresh_token,
					    		'addresses' => array(
						    		'billing_first_name' => $billing_first_name,
						    		'billing_last_name' => $billing_last_name,
						    		'billing_address_1' => $billing_address_1,
						    		'billing_address_2' => $billing_address_2,
					    			'billing_city' => $billing_city,
					    			'billing_postcode' => $billing_postcode,
					    			'shipping_first_name' => $shipping_first_name,
						    		'shipping_last_name' => $shipping_last_name,
					    			'shipping_address_1' => $shipping_address_1,
						    		'shipping_address_2' => $shipping_address_2,
					    			'shipping_city' => $shipping_city,
					    			'shipping_postcode' => $shipping_postcode
					    		)
					    	);
							return $output;
						}
						// else return 200;
					}
				}
        	}
        	else{
        		return  100;
        	}
        },
        'args'     => array()
    ));
});
