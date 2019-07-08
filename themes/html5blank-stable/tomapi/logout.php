<?php
add_action('rest_api_init', function () {
    register_rest_route('tomapi/v1', 'logout', array(
        'methods' => 'POST',
        'callback' => function ($request) {
            // $refresh_token = $request->get_headers()['refreshtoken'];
            $refresh_token = $request->get_json_params()['refreshtoken'];

            $users = get_users(array('fields' => 'ID'));
            foreach ($users as $user_id) {
                if (!empty($user_id)) {
                    $this_user_refresh_token = get_user_meta($user_id, 'tom_api_refresh_token', true);
                    if (!empty($this_user_refresh_token)) {
                        if ($this_user_refresh_token == $refresh_token) {
                            delete_user_meta($user_id, 'tom_api_refresh_token');
                            return 1;
                        } else {
                            return 0;
                        }

                    }
                }
            }
        },
        'args' => array(),
    ));
});
