<?php

namespace backoffice\control;

use backoffice\auth\BackAuth;
use backoffice\model\Commande;
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
        $view->addStyleSheet('/html/css/login.css');
        $view->render('accueil');
    }

    public function checkLogin(){
        $username = $_POST['username'];
        $mdp = $_POST['mdp'];

        try {
            $backauth = new BackAuth();
            $backauth->loginUser($username, $mdp);
            $user = Producteur::where('username','=', $username)->first();
            if($user->level == 100){
                Router::executeRoute('tableau_de_bord');
            } else if($user->level == 999){
                Router::executeRoute('admin_panel');
            }
        } catch (AuthentificationException $e){
            Router::executeRoute('accueil');
            echo "aled";
        }
    }

    public function viewTDB(){
        $prod = Producteur::where('username','=',$_SESSION['user_login'])->first();
        $view = new BackView($prod);
        $view->addStyleSheet('/html/css/homeprod.css');
        $view->render('tdb');
    }

    public function viewAdminPanel(){
        $view = new BackView('');//Pour le moment
        $view->addStyleSheet('/html/css/adminpanel.css');
        $view->render('admin');
    }

    public function viewList(){
        $allcommande = Commande::get();
        $view = new BackView($allcommande);
        $view->addStyleSheet('/html/css/adminlist.css');
        $view->render('liste');
    }

    public function logout(){
        $back = new BackAuth();
        $back->logout();
        Router::executeRoute('accueil');
    }

    public function validcommande() {
        $id_com = $_GET['id'];
        $commande = Commande::where('id','=',$id_com)->first();
        $commande->etat = 1;
        $commande->save();
        Router::executeRoute('liste');
    }

    public function viewCommande(){
        if(isset($_GET['id'])) {
            $commande = Commande::where('id', '=', $_GET['id'])->first();
            $view = new BackView($commande);
            $view->addStyleSheet('/html/css/resumecommand.css');
            $view->render('commande');
        }
    }
}