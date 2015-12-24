<?php

abstract class controller
{
    public final function __construct()
    {
        $this->init();
        $_SESSION['errors'] = array();
    }

    abstract public function init();


    public function getSessionError($name)
    {
        return isset($_SESSION['errors'][$name]) ? $_SESSION['errors'][$name] : null;
    }

    public function clearError($name)
    {
        unset($_SESSION['errors'][$name]);
    }

    public function setSessionError($name, $message)
    {
        $_SESSION['errors'][$name] = $message;
    }

    public function redirect($url)
    {
        header("location: " . $url);
    }

    public function redirectTo($controller, $action, $params = null)
    {
        header("location: {$this->generateUrl($controller,$action,$params)}");
    }

    public static function generateUrl($controller, $action, $params = null)
    {
        $paramsString = '';
        if ($params != null) {
            foreach ($params as $key => $value) {
                $paramsString .= "&{$key}=" . urlencode($value);
            }
        }
        return "index.php?c={$controller}&a={$action}" . $paramsString;
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