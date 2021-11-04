<?php

namespace backoffice\model;


use Illuminate\Database\Eloquent\Model;

class Producteur extends Model {
    protected $table = 'producteur';
    protected $primaryKey = 'id';
    public $timestamps = false;


    public function products(){
        return $this->hasMany(Produit::class, 'prod_id');
    }

    public function howMuchOf($product){
        $compteur = 0;
        $prod = $product->id;
        $commande = Contenu::where('prod_id','=',$prod)->get();
        var_dump($commande);
        foreach ($commande as $com){
            $compteur += $com->quantite;
        }
        return $compteur;
    }
}