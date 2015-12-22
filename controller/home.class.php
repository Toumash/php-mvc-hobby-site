<?php

class homeController extends Controller
{

    public function index()
    {
        /** @var defaultModel $model */
        $model = Model::load('default');
        $x = $model->getSimpleValue();

        /** @var defaultView $view */
        $view = View::load('default');
        $view->index($x);
    }
}