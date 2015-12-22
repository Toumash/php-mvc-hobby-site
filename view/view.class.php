<?php

abstract class View
{
    private $data = array();

    public static function load($name, $path = '\view/')
    {
        $path = ROOT . $path . $name . '.class.php';
        $name = $name . 'View';
        try {
            if (is_file($path)) {
                require $path;
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

    public function render($name, $path = '\templates/')
    {
        $path = ROOT . $path . $name . '.html.php';
        try {
            if (is_file($path)) {
                require $path;
            } else {
                throw new Exception('Can not open template ' . $name . ' in: ' . $path);
            }
        } catch (Exception $e) {
            echo $e->getMessage() . '<br />
                File: ' . $e->getFile() . '<br />
                Code line: ' . $e->getLine() . '<br />
                Trace: ' . $e->getTraceAsString();
            exit;
        }
    }

    public function set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function get($name)
    {
        return $this->data[$name];
    }
}