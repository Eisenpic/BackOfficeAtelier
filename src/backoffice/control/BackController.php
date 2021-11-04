<?php

namespace backoffice\control;

use backoffice\auth\BackAuth;
use backoffice\model\Producteur;
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
            Router::executeRoute('tableau_de_bord');
        } catch (AuthentificationException $e){
            Router::executeRoute('accueil');
            echo "aled";
        }
    }

    public function viewTDB(){
        $prod = Producteur::where('username','=',$_SESSION['user_login'])->first();
        $view = new BackView($prod);
        $view->render('tdb');
    }
}