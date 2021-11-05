<?php

namespace backoffice\view;

use backoffice\model\Commande;
use backoffice\model\Contenu;
use backoffice\model\Producteur;
use backoffice\model\Produit;
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
            case 'admin':
                $html = $this->renderHeaderAdmin();
                $html .= $this->renderStat();
                break;
            case 'liste':
                $html = $this->renderHeaderAdmin();
                $html .= $this->renderList();
                break;
        }
        $html .= $this->renderFooter();
        return $html;
    }

    private function renderHeaderAdmin(){
        $r = new Router();
        return "
            <header>
                <div>
                    <h1>LeHangar.local 🥕</h1>
                </div>
                <nav>
                    <a href=".$r->urlFor('admin_panel')."><p>Tableau de bord</p></a>
                    <a href=". $r->urlFor('liste') ."><p>Liste</p></a>
                    <a href=". $r->urlFor('logout') .">Déconnexion</a>
                </nav>
            </header>
        ";
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
                    <a href=". $r->urlFor('logout'). ">Deconnexion</a>
                </nav>
            </header>
        ";
    }

    private function renderLogin() {
        return "
            <section id='bg'>
                <div>
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
                </div>
            </section>";
    }

    private function renderTDB(){
        $compteur = 0;
        $total = 0;
        foreach ($this->data->products as $product){
            $compteur++;
            $total += $product->tarif_unitaire;
        }
        $html = "
            <section id=bg>
                <div>
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
        $html .="</div>
</section>";
        return $html;
    }

    private function renderStat(){
        $nbClient = Commande::distinct()->get(['tel_client'])->count();
        $allcommande = Commande::get();
        $ca = 0;
        foreach ($allcommande as $com){
            $ca += $com->montant;
        }
        $html = "<section id='bg'>
                <div>
                    <h2>Tableau de bord :</h2>
                    <section>
                    <div>
                        <p>Nombre de client : $nbClient</p>
                        <p>Nombre de commandes : ". $allcommande->count() ."</p>
                    </div>
                    <div>
                        <p>Chiffre d'affaire global :</p>
                        <div>
                            <p>$ca</p>
                        </div>
                    </div>
                    <div>
                        <p>CA par producteur</p>";
        $ca = 0;
        // Parcour du tableau de Producteur
        foreach (Producteur::get() as $prod){
            if($prod->nom != 'admin') {
                $nameprod = $prod->nom;
                $html .= "<p> $nameprod </p>";
                // Parcours de tableau de contenue qui décris les articles acheté
                foreach (Contenu::get() as $commande) {
                    $numprod = $commande->prod_id;
                    // Récupération des produits par id de producteur
                    $produit = Produit::where('id', '=', $numprod)->first();
                    // On compare le numéro du producteur avec le numéro que le produit connait ( son producteur )
                    if ($produit->prod_id == $prod->id) {
                        $ca += $produit->tarif_unitaire * $commande->quantite;
                    }
                }
                // Ajout du $ca et reset pour le prochain producteur
                $html .= "<p> $ca </p>";
                $ca = 0;
            }
        }

        $html .= "</div>
                </div>";
        return $html;
    }

    private function renderList(){
        $html = '<section id="bg">
                   <div>
                    <h1>Liste des commandes : </h1>
                    <div>';
        foreach($this->data as $commande) {
            $html .= "<p>Nom du client : $commande->nom_client</p>
                      <p>Montant : $commande->montant</p>
                      <p>Etat : ";
            $etat = ($commande->etat == 1) ? "Récuperé" : "Commandé";
            $html .= "$etat </p>";
        }
        $html .= "</div>
                 </div>
                 </section>";
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