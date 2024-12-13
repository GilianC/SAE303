<?php
require_once("Repository/EntityRepository.php");
require_once("Class/Movie.php");
require_once("Class/Rental.php");

class MovieRepository extends EntityRepository {
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
    public function getTotalRentalMovie(): array {
        $requete = $this->cnx->prepare("
            SELECT m.movie_title, COUNT(r.id) AS rental_count 
            FROM Rentals r 
            JOIN Movies m ON r.movie_id = m.id 
            WHERE r.rental_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) 
            GROUP BY r.movie_id 
            ORDER BY rental_count DESC 
            LIMIT 3
        ");
        $requete->execute();
        $answers = $requete->fetchAll(PDO::FETCH_OBJ);
        return $answers ? $answers : [];
    }
    public function getTotalSalesMovie(): array {
        $requete = $this->cnx->prepare("
            SELECT m.movie_title, COUNT(s.id) AS purchase_count 
            FROM Sales s
            JOIN Movies m ON s.movie_id = m.id 
            WHERE s.purchase_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) 
            GROUP BY s.movie_id 
            ORDER BY purchase_count DESC 
            LIMIT 3
        ");
        $requete->execute();
        $answers = $requete->fetchAll(PDO::FETCH_OBJ);
        return $answers ? $answers : [];
    }
}