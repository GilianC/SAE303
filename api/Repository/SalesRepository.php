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

    public function getTotalSalesPrice() {
        $requete = $this->cnx->prepare("  SELECT SUM(purchase_price) as total FROM Sales WHERE MONTH(purchase_date) = MONTH(CURDATE()) AND YEAR(purchase_date) = YEAR(CURDATE());");
        $requete->execute();
        $result = $requete->fetch(PDO::FETCH_OBJ); 
        return $result ? $result : 0.0;
    }
}
