<?php

require_once("Repository/EntityRepository.php");
require_once("Class/Commande.php");

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
class CommandeRepository extends EntityRepository {

    public function __construct(){
        // appel au constructeur de la classe mère (va ouvrir la connexion à la bdd)
        parent::__construct();
    }

    public function find($id): ?Rental {
        $requete = $this->cnx->prepare("SELECT * FROM `Rental` WHERE id_commande = :value"); // prepare la requête SQL
        $requete->bindParam(':value', $id_rental); // fait le lien entre le "tag" :value et la valeur de $id
        $requete->execute(); // execute la requête
        $answer = $requete->fetch(PDO::FETCH_OBJ);
        
        if ($answer == false) return null; // may be false if the sql request failed (wrong $id value for example)
        foreach($answer as $obj){

            $co = new Rental($answer->id);
            $co->setCustomerId($answer->customer_id);
            $co->setMovieId($answer->movie_id);
            $co->setRentalDate($answer->rental_date);
            $co->setRentalPrice($answer->rental_price);
        }
        // Add other properties as needed

        return $co;
    }

    
}
