<?php

require_once("Repository/EntityRepository.php");
require_once("Class/Rental.php");

/**
 *  Classe CommandeRepository
 * 
 *  Cette classe représente le "stock" de Commande.
 *  Toutes les opérations sur les Commande doivent se faire via cette classe 
 *  qui tient "synchro" la bdd en conséquence.
 * 
 *  La classe hérite de EntityRepository ce qui oblige à définir les méthodes  (find, findAll ... )
 *  Mais il est tout à fait possible d'ajouter des méthodes supplémentaires si
 *  c'est utile !
 *  
 */
class RentalRepository extends EntityRepository {

    public function __construct(){

        parent::__construct();
    }

    public function findAll(): array {
        $requete = $this->cnx->prepare("SELECT * FROM Rentals"); 
        $requete->execute();
        $answers = $requete->fetchAll(PDO::FETCH_OBJ);
        $res = [];
        if ($answers == false) return [];
        foreach($answers as $obj){

            $co = new Rental($obj->id);
            $co->setCustomerId($obj->customer_id);
            $co->setMovieId($obj->movie_id);
            $co->setRentalDate($obj->rental_date);
            $co->setRentalPrice($obj->rental_price);
            array_push($res, $co);
        }
        // var_dump($res);
        return $res;
    }
    public function getTotalRentalPrice(): float {
        $requete = $this->cnx->prepare("SELECT rental_price FROM Rentals Where rental_date > :date");
        $cdate = date('Y-m-01');
        $requete-> bindParam(':date', $cdate, PDO :: PARAM_STR);
        $requete->execute();
        $result = $requete->fetch(PDO::FETCH_OBJ); 
        $prices = $requete->fetchAll(PDO::FETCH_COLUMN, 0);
        $total = array_sum($prices);
        $result = (object) ['total' => $total];
        return $result ? $result->total : 0.0;
    }

    
}
