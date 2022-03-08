<?php

namespace App\Entity;
use App\Entity\Categorie;

class FiltreData
{
    /**
     * @var string
     */
    //public puisque je vais par faire des getters et setters
    public $q='';
    /**
     * @var
     */
    public $categories=[];
   /**
    * @var null|integer
    */
   public $max;
    /**
     * @var null|integer
     */
    public $min;

    /**
     * @var boolean
     */
    public $promo=false;



}