<?php

namespace backoffice\view;

use mf\router\Router;
use mf\utils\HttpRequest;

class BackView extends \mf\view\AbstractView
{
    public function __construct($data)
    {
        parent::__construct($data);
    }

    protected function renderBody($selector)
    {
        $html = '';
        switch ($selector){
            case 'accueil':
                $html = $this->renderHeader();
                $html .= $this->renderLogin();
                break;
            case 'tdb':
                $html = $this->renderHeaderProd();
                $html .= $this->renderTDB();
                break;
            case 'adminpanel':
                $hmtl = $this->renderHeaderAdmin();
                break;
        }
        $html .= $this->renderFooter();
        return $html;
    }

    private function renderHeaderAdmin(){
        return 'wip';
    }

    private function renderHeader(){
        return "
            <header>
                <div>
                    <h1>LeHangar.local 🥕</h1>
                </div>
            </header>
        ";
    }

    private function renderHeaderProd(){
        $r = new Router();
        return "
            <header>
                <div>
                    <h1>LeHangar.local 🥕</h1>
                </div>
                <nav>
                    <a href=". $r->urlFor('accueil', []). ">Deconnexion</a>
                </nav>
            </header>
        ";
    }

    private function renderLogin() {
        return "<div>
                    <h2>Connexion</h2>
                    <div>
                        <form action='../check_login/' method='post'>
                                <div>
                                Username : <input type='text' name='username' required></br>
                                Mot de passe : <input type='password' name='mdp'></br>
                                </div>       
                                <div>    
                                <button type='submit'>Valider</button>
                                </div> 
                            
                        </form>
                    </div>
                </div>";
    }

    public function renderTDB(){
        $compteur = 0;
        $total = 0;
        foreach ($this->data->products as $product){
            $compteur++;
            $total += $product->tarif_unitaire;
        }
        $html = "<div>
                    <div>
                        <p><b>Nombre total d'article :</b> $compteur</p>
                        <p><b>Prix total : </b> $total €</p>                    
                    </div>";
        foreach($this->data->products as $product){
            $html .= "<section>
                         <p>$product->nom</p>
                         <p><b>Quantitée : </b>". $this->data->howMuchOf($product)."</p>
                       </section>";
        }
        $html .="</div>";
        return $html;
    }

    protected function renderFooter()
    {
        $http_req = new HttpRequest();
        return "
            <footer>
                <div>
                    <img src='$http_req->root/html/img/wave.svg'>
                </div>        
            </footer>
        ";
    }
}