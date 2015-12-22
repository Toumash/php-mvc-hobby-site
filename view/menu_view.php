<?php
class menuView extends View{
    public function index(){
        $menuItems = array(
            'Wstęp' => '?c=page&page=intro',
            'Podstawy C#' => '?c=page&page=tut',
            'Galeria' => '?c=photo',
            'Kontakt' => '?c=page&page=contact'
        );
        $this->set('menu-items', $menuItems);
        $this->render('menu',true);
    }
}