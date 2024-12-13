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
        $requete = $this->cnx->prepare("SELECT * FROM Movies"); 
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
        // $requete = $this->cnx->prepare("SELECT Sum(rental_price) as total FROM Rentals Where rental_date > :date");
        $requete = $this->cnx->prepare("  SELECT SUM(rental_price) as total FROM Rentals WHERE MONTH(rental_date) = MONTH(CURDATE()) AND YEAR(rental_date) = YEAR(CURDATE());");
        $requete->execute();
        $result = $requete->fetch(PDO::FETCH_OBJ); 


        return $result ? $result->total : 0.0;
    }
    public function getTotalRentalLastSixMonths(): array {
        $requete = $this->cnx->prepare(" 
    WITH LastSixMonths AS ( SELECT DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL n MONTH), '%Y-%m') AS month_year 
    FROM ( SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 ) AS nums ) 
    SELECT lsm.month_year AS month, COALESCE(SUM(r.rental_price), 0) AS total 
    FROM LastSixMonths lsm LEFT JOIN Rentals r ON DATE_FORMAT(r.rental_date, '%Y-%m') = lsm.month_year GROUP BY lsm.month_year ORDER BY lsm.month_year DESC;
    ");
        $requete->execute();
        $results = $requete->fetchAll(PDO::FETCH_OBJ); 
        $res = [];
        if ($results == false) return [];
        foreach($results as $obj){
            $res[] = $obj;
        }
        return $res;
    }
    public function getTotalRentalGenreSixMonths(): array {
        $requete = $this->cnx->prepare(" 
   WITH LastSixMonths AS (SELECT DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL n MONTH), '%Y-%m') AS month_year
    FROM (SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5
    ) AS nums) SELECT 
    lsm.month_year AS month, m.genre AS genre, COALESCE(SUM(r.rental_price), 0) AS total
    FROM LastSixMonths lsm LEFT JOIN 
    Rentals r ON DATE_FORMAT(r.rental_date, '%Y-%m') = lsm.month_year LEFT JOIN 
    Movies m ON r.movie_id = m.id GROUP BY lsm.month_year, m.genre ORDER BY 
    lsm.month_year DESC, total DESC;
    ");
        $requete->execute();
        $results = $requete->fetchAll(PDO::FETCH_OBJ); 
        $res = [];
        if ($results == false) return [];
        foreach($results as $obj){
            $res[] = $obj;
        }
        return $res;
    }
    public function getTotalRentalCountry(): array {
        $requete = $this->cnx->prepare(" 
SELECT 
    c.country AS country,
    'Sales' AS type,
    COALESCE(SUM(s.purchase_price), 0) AS total
FROM 
    Customers c
LEFT JOIN 
    Sales s ON c.id = s.customer_id
GROUP BY 
    c.country
    
Union ALL
SELECT 
    c.country AS country,
    'Rentals' AS type,
    COALESCE(SUM(r.rental_price), 0) AS total
FROM 
    Customers c
LEFT JOIN 
    Rentals r ON c.id = r.customer_id
GROUP BY 
    c.country
ORDER BY 
    country, type;
    ");
        $requete->execute();
        $results = $requete->fetchAll(PDO::FETCH_OBJ); 
        $res = [];
        if ($results == false) return [];
        foreach($results as $obj){
            $res[] = $obj;
        }
        return $res;
    }

    
public function getRentalbyMovie($id): array {
    $requete = $this->cnx->prepare("
WITH LastSixMonths AS (
    SELECT DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL n MONTH), '%Y-%m') AS month_year
    FROM (SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5) AS nums
)
SELECT 
    lsm.month_year AS month, 
    'Rentals' AS type,
    COALESCE(SUM(r.rental_price), 0.0) AS total, 
    m.movie_title AS movie_title,
    m.id AS movie_id
FROM 
    LastSixMonths lsm
CROSS JOIN 
    (SELECT id, movie_title FROM Movies WHERE id = :id) m
LEFT JOIN 
    Rentals r ON DATE_FORMAT(r.rental_date, '%Y-%m') = lsm.month_year AND r.movie_id = m.id
GROUP BY 
    lsm.month_year, m.movie_title, m.id
ORDER BY 
    lsm.month_year DESC;
");
$requete->bindParam(':id', $id, PDO::PARAM_INT);
$requete->execute();
    $results = $requete->fetchAll(PDO::FETCH_OBJ); 
    $res = [];
    if ($results == false) return [];
    foreach($results as $obj){
        $res[] = $obj;
    }
    return $res; 
}
public function getAllMovieByStat(): array {
    $requete = $this->cnx->prepare(" 
WITH LastSixMonths AS (
    SELECT DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL n MONTH), '%Y-%m') AS month_year
    FROM (SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5) AS nums
)
SELECT 
    DISTINCT m.id AS movie_id, 
    m.movie_title AS movie_title
FROM 
    LastSixMonths lsm
LEFT JOIN 
    Rentals r ON DATE_FORMAT(r.rental_date, '%Y-%m') = lsm.month_year
LEFT JOIN 
    Movies m ON r.movie_id = m.id
WHERE 
    r.id IS NOT NULL
ORDER BY 
    m.id;


");
    $requete->execute();
    $results = $requete->fetchAll(PDO::FETCH_OBJ); 
    $res = [];
    if ($results == false) return [];
    foreach($results as $obj){
        $res[] = $obj;
    }
    return $res;
}
}