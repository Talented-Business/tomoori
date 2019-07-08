<?php
add_action('rest_api_init', function () {
	if(isset($_GET['route'])){
        register_rest_route( 'tomapi/wc', 'index',array(
            'methods'  => 'GET',
            'callback' => function ($request){
                $base_url = site_url();//"https://tomoori.sa/dev";//
                $parameters = array();
                foreach ($_REQUEST as $key => $value) {
                    if ( $key != 'woocs_order_emails_is_sending' && $key !="route" ) {
                        $parameters[] = $key . '=' . $value;
                    }
                }
                $consumer_key = TOM_WOO_CK;
                $consumer_secret = TOM_WOO_CS;
                $oauth_access_token_secret = "";
                $oauth = array( 'oauth_consumer_key' => $consumer_key,
                                'oauth_nonce' => time(),
                                'oauth_signature_method' => 'HMAC-SHA1',
                                'oauth_timestamp' => time(),
                                'oauth_version' => '1.0');
                $url = $base_url . '/wp-json/wc/v3/'.$_GET['route'];
                if(!empty($parameters))$url .= '?'.implode($parameters,'&');
                $base_info = buildBaseString($url, 'GET', $oauth);
                $composite_key = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);
                $oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
                $oauth['oauth_signature'] = $oauth_signature;
                $response = wp_remote_post( $url, array(
                    'method'      => 'GET',
                    'headers'     => array(
                        'Content-Type'	=>'application/json',
                        'Authorization'	=>'Basic '.base64_encode( TOM_WOO_CK . ':' . TOM_WOO_CS ),
                        //'Authorization'	=>buildAuthorizationHeader($oauth),
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
    }
});
function buildBaseString($baseURI, $method, $params){
    $r = array();
    ksort($params);
    foreach($params as $key=>$value){
        $r[] = "$key=" . rawurlencode($value);
    }

    return $method."&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
}

function buildAuthorizationHeader($oauth){
    $r = 'OAuth ';
    $values = array();
    foreach($oauth as $key=>$value)
        $values[] = "$key=\"" . rawurlencode($value) . "\"";

    $r .= implode(', ', $values);
    return $r;
}