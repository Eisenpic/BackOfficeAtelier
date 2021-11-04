<?php

namespace backoffice\control;

use backoffice\auth\BackAuth;
use backoffice\view\BackView;
use mf\auth\exception\AuthentificationException;
use mf\control\AbstractController;
use mf\router\Router;

class BackController extends AbstractController
{
    public function construct() {
        parent::__construct();
    }

    public function viewAccueil(){
        $view = new BackView("");
        $view->render('accueil');
    }

    public function checkLogin(){
        $username = $_POST['username'];
        $mdp = $_POST['mdp'];

        try {
            $backauth = new BackAuth();
            $backauth->loginUser($username, $mdp);
        } catch (AuthentificationException $e){
            Router::executeRoute('accueil');
        }
    }
}