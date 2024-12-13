<?php
require_once "Controller.php";
require_once "Repository/MovieRepository.php";

// This class inherits the jsonResponse method and the $cnx property from the parent class Controller
// Only the process????Request methods need to be (re)defined.

class MovieController extends Controller {

    private MovieRepository $repository;

    public function __construct() {
        $this->repository = new MovieRepository();
    }

    protected function processGetRequest(HttpRequest $request) {
        $param = $request->getParam("param");

        if ($param == 'rentalmovie' ) {
            return $this->repository->getTotalRentalMovie();
        }
        if ($param == 'salesmovie' ) {
            return $this->repository->getTotalSalesMovie();
        }
        // if ($request->getMethod() == 'GET') {
        //     $rentalSales = $this->repository->findAll();
        //     return json_encode($rentalSales);
        // }
        return null;
    }


    // protected function processPostRequest(HttpRequest $request) {
    //     $json = $request->getJson();
    //     $obj = json_decode($json);
    //     $s = new Movie;
    //     $s->setCustomerId($obj->customer_id);
    //     $s->setProductId($obj->product_id);
    //     $s->setPurchaseDate($obj->purchase_date);
    //     $s->setPurchasePrice($obj->purchase_price);
    //     $ok = $this->repository->save($s); 
    //     return $ok ? $s : false;
    // }
}
?>
