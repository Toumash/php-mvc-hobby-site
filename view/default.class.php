<?php

class defaultView extends View
{

    public function index($value){
        $this->set('simpleValue',$value);
        $this->render('default');
    }
}