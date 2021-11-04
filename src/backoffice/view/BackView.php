<?php

namespace backoffice\view;

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
        }
        return $html;
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
        return "
            <header>
                <div>
                    <h1>LeHangar.local 🥕</h1>
                </div>
                <nav>
                    <p>Deconnexion</p>
                </nav>
            </header>
        ";
    }

    private function renderLogin() {
        return "<div>
                    <h2>Connexion</h2>
                    <div>
                        <form action='../check_login/' method='post'>
                                Username : <input type='text' name='username' required>
                                Mot de passe : <input type='password' name='mdp'>                  
                            <button type='submit'>Valider</button>
                        </form>
                    </div>
                </div>";
    }

    public function renderTDB(){
        foreach ($this->data->products as $product){
            echo $product->nom;
        }
        return "<div>
                    <div>
                        <p>Nombre total d'article : </p>
                        <p>Prix total : </p>                    
                    </div>
                    <section>
                                               
                    </section>



    
                </div>";
    }
}