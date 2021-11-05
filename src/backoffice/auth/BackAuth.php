<?php

namespace backoffice\auth;

use backoffice\model\Producteur;
use mf\auth\exception\AuthentificationException;

class BackAuth extends \mf\auth\Authentification
{
    public function loginUser($username, $password){
        $user = Producteur::where('username', '=', $username)->first();

        if(!$user){
            throw new AuthentificationException('Aucun compte');
        } else {
            self::login($username, $user->password, $password, $user->level);
        }
    }
}