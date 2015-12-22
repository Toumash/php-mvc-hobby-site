<?php


class Dispatcher
{
    public function Dispatch($controller, $action)
    {
        $path = ROOT . 'controller\\' . $controller . '.class.php';
        $name = $controller . 'Controller';
        $ob = null;
        try {
            if (!is_file($path)) {
                throw new Exception('Can not open controller ' . $name . ' in: ' . $path);
            }
            require_once $path;
            /** @var Controller $ob */
            $ob = new $name();

            if(is_callable(array($ob,$action))) {
                $ob->$action();
            }else{
                $ob->index();
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