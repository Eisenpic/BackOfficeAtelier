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
}