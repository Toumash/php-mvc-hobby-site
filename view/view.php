<?php

abstract class View
{
    private $data = array();

    public static function load($name, $path = '/view/')
    {
        $path = ROOT . $path . $name . 'view.php';
        $name = $name . 'View';
        try {
            if (is_file($path)) {
                require_once $path;
                $ob = new $name();
            } else {
                throw new Exception('Can not open view ' . $name . ' in: ' . $path);
            }
        } catch (Exception $e) {
            echo $e->getMessage() . '<br />
                File: ' . $e->getFile() . '<br />
                Code line: ' . $e->getLine() . '<br />
                Trace: ' . $e->getTraceAsString();
            exit;
        }
        return $ob;
    }

    public function render($name, $output = true, $path = '/templates/', $extension = '.php')
    {
        $path = ROOT . $path . $name . $extension;
        try {
            if (is_file($path)) {
                if (!$output) {
                    ob_start();
                }
                require $path;
                if (!$output) {
                    // returns buffered output
                    return ob_get_clean();
                }
            } else {
                throw new Exception('Can not open template ' . $name . ' in: ' . $path);
            }
            return null;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br />
                File: ' . $e->getFile() . '<br />
                Code line: ' . $e->getLine() . '<br />
                Trace: ' . $e->getTraceAsString();
            exit;
        }
    }

    function generateUrl($controller, $action, $params = null)
    {
        return controller::generateUrl($controller, $action, $params);
    }

    protected function set($name, $value)
    {
        $this->data[$name] = $value;
    }

    protected function get($name)
    {
        return $this->data[$name];
    }
}