<?php

class menuView extends View
{
    public function index()
    {
        $items = ['Wstęp' => ['page', 'index', ['page' => 'intro']],
            'Podstawy C#' => ['page', 'index', ['page' => 'tut']],
            'Galeria' => ['photo', 'index'],
            'Kontakt' => ['page', 'index', ['page' => 'contact']]];
        /** @var userModel $users */
        $users = Model::load('user');
        if (!$users->isLoggedIn()) {
            $items['Logowanie'] = ['authorization', 'login_form'];
        } else {
            $items['Profil'] = ['user', 'profile'];
        }
        $menuItems = [];
        foreach ($items as $item => $value) {
            $menuItems[] = ['name' => $item, 'url' => $this->generateUrl($value[0], $value[1], isset($value[2]) ? $value[2] : null)];
        }
        $this->set('menu-items', $menuItems);
        $this->render('menu', true);
    }
}