<?php

abstract class View
{
    public function render($name, $path = 'templates/')
    {
        $path = $path . $name . '.html.php';
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
        $this->$name = $value;
    }

    public function get($name)
    {
        return $this->$name;
    }
}