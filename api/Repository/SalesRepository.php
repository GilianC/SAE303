<?php

require_once("Repository/EntityRepository.php");
require_once("Class/Sales.php");

/**
 *  Classe SalesRepository
 * 
 *  Cette classe représente le "stock" de Sales.
 *  Toutes les opérations sur les Sales doivent se faire via cette classe 
 *  qui tient "synchro" la bdd en conséquence.
 * 
 *  La classe hérite de EntityRepository ce qui oblige à définir les méthodes  (find, findAll ... )
 *  Mais il est tout à fait possible d'ajouter des méthodes supplémentaires si
 *  c'est utile !
 *  
 */
class SalesRepository extends EntityRepository {

    public function __construct(){
        parent::__construct();
    }

    public function findAll(): array {
        $requete = $this->cnx->prepare("SELECT * FROM Sales"); 
        $requete->execute();
        $answers = $requete->fetchAll(PDO::FETCH_OBJ);
        $res = [];
        if ($answers == false) return [];
        foreach($answers as $obj){
            $sale = new Sale($obj->id);
            $sale->setCustomerId($obj->customer_id);
            $sale->setProductId($obj->product_id);
            $sale->setPurchaseDate($obj->purchase_date);
            $sale->setPurchasePrice($obj->purchase_price);
            array_push($res, $sale);
        }
        return $res;
    }

    public function getTotalSalesPrice(): float {
        $requete = $this->cnx->prepare("SELECT purchase_price FROM Sales WHERE purchase_date > :date");
        $cdate = date('Y-m-01');
        $requete->bindParam(':date', $cdate, PDO::PARAM_STR);
        $requete->execute();
        $prices = $requete->fetchAll(PDO::FETCH_COLUMN, 0);
        $total = array_sum($prices);
        return $total ? $total : 0.0;
    }
}
