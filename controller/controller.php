<?php

abstract class Controller
{
    public function redirect($url)
    {
        header("location: " . $url);
    }

    public function redirectTo($controller, $action, $params = null)
    {
        $paramsString = '';
        if ($params != null) {
            foreach ($params as $key => $value) {
                $paramsString .= "&{$key}=" . urlencode($value);
            }
        }
        header("location: index.php?c={$controller}&a={$action}" . $paramsString);
    }

    /**
     * @param $code integer
     */
    public function responseCode($code)
    {
        http_response_code($code);
    }

    public abstract function index();
}