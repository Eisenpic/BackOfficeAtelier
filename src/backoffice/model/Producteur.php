<?php

namespace lehangar\model;


use Illuminate\Database\Eloquent\Model;

class Producteur extends Model {
    protected $table = 'producteur';
    protected $primaryKey = 'id';
    public $timestamps = false;
}