<?php

namespace backoffice\control;

use backoffice\view\BackView;
use mf\control\AbstractController;

class BackController extends AbstractController
{
    public function construct() {
        parent::__construct();
    }

    public function viewAccueil(){
        $view = new BackView("");
        $view->render('accueil');
    }
}