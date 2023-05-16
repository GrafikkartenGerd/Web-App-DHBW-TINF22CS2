<?php

    function failWithCode($code){
        http_response_code($code);
        die();
    }

    function getAuthToken(){
        $headers = apache_request_headers();

        if (isset($headers['Authorization'])) {
            return $headers['Authorization'];
        }else{
            failWithCode(401);
        }
    }
?>