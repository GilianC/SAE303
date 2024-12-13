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
    public function getTotalSalesLastSixMonths(): array {
        $requete = $this->cnx->prepare(" 
SELECT 
    DATE_FORMAT(purchase_date, '%Y-%m') AS purchase_month,
    SUM(purchase_price) AS total
FROM 
    Sales
WHERE 
    purchase_date BETWEEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 6 MONTH), '%Y-%m-01') 
                      AND LAST_DAY(CURDATE())
GROUP BY 
    DATE_FORMAT(purchase_date, '%Y-%m')
ORDER BY 
    purchase_month DESC;
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
    public function getTotalSalesGenreSixMonths(): array {
        $requete = $this->cnx->prepare(" 
    WITH LastSixMonths AS (SELECT DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL n MONTH), '%Y-%m') AS month_year
    FROM ( SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5
    ) AS nums
    ) SELECT lsm.month_year AS month, m.genre AS genre, COALESCE(SUM(s.purchase_price), 0) AS total
    FROM LastSixMonths lsm LEFT JOIN Sales s ON DATE_FORMAT(s.purchase_date, '%Y-%m') = lsm.month_year
    LEFT JOIN Movies m ON s.movie_id = m.id GROUP BY lsm.month_year, m.genre
    ORDER BY lsm.month_year DESC, total DESC;
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
     public function getTotalSalesCountry(): array {
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
    //fonction pour visualer l'évolution des ventes d'un film par mois
    public function getSalesbyMovie($id): array {
        $requete = $this->cnx->prepare("
WITH LastSixMonths AS (
    SELECT DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL n MONTH), '%Y-%m') AS month_year
    FROM (SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5) AS nums
)
SELECT 
    lsm.month_year AS month, 
    'Sales' AS type,
    COALESCE(SUM(s.purchase_price), 0.0) AS total, 
    m.movie_title AS movie_title,
    m.id AS movie_id
FROM 
    LastSixMonths lsm
CROSS JOIN 
    (SELECT id, movie_title FROM Movies WHERE id = :id) m
LEFT JOIN 
    Sales s ON DATE_FORMAT(s.purchase_date, '%Y-%m') = lsm.month_year AND s.movie_id = m.id
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
    FROM ( SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5) AS nums
)
SELECT 
    DISTINCT m.id AS movie_id, 
    m.movie_title AS movie_title
FROM 
    LastSixMonths lsm
LEFT JOIN 
    Sales s ON DATE_FORMAT(s.purchase_date, '%Y-%m') = lsm.month_year
LEFT JOIN 
    Movies m ON s.movie_id = m.id
WHERE 
    s.id IS NOT NULL
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