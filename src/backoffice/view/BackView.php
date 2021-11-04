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
        $html = $this->renderHeader();
        switch ($selector){
            case 'accueil':
                $html .= $this->renderLogin();
                break;
        }
        return $html;
    }

    protected function renderHeader(){
        return "
            <header>
                <div>
                    <h1>LeHangar.local 🥕</h1>
                </div>
                <nav>
                    <a href=''>Accueil</a>
                    <a href=''>Producteurs</a>
                    <a href=''>Panier</a>
                </nav>
            </header>
        ";
    }

    private function renderLogin() {
        return "<div>
                    <h2>Connexion</h2>
                    <div>
                        <form action='../connexion/' method='post'>
                                Username : <input type='text' name='username' required>
                                Mot de passe : <input type='password' name='mdp' required>                  
                            <button type='submit'>Valider</button>
                        </form>
                    </div>
                </div>";
    }
}