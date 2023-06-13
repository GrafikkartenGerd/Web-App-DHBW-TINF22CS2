<?php

    function failWithCode($code){
        http_response_code($code);
        die();
    }

    function getAuthToken(){
       $headers = apache_request_headers();

        if (isset($headers['Authorization'])) {
            $authorizationHeader = $headers['Authorization'];
            $token = null;

                // Check if the header starts with 'Bearer'
                if (preg_match('/Bearer\s+(.*)$/i', $authorizationHeader, $matches)) {
                    $token = $matches[1];
                }

                return $token;
            }

            failWithCode(401);
    }
?>