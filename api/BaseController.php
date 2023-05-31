<?php
class BaseController
{
    public function fail($code)
    {
        http_response_code($code);
        exit();
        return null;
    }
}