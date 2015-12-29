<?php

abstract class Model
{
    public static function load($name, $path = '/model/')
    {
        $path = ROOT . $path . $name . 'model.php';
        $name = $name . 'Model';
        try {
            if (is_file($path)) {
                require $path;
                return new $name();

            } else {
                throw new Exception('Can not open model ' . $name . ' in: ' . $path);
            }
        } catch (Exception $e) {
            echo $e->getMessage() . '<br />
                File: ' . $e->getFile() . '<br />
                Code line: ' . $e->getLine() . '<br />
                Trace: ' . $e->getTraceAsString();
            exit;
        }
    }
}