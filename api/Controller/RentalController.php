<?php
require_once "Controller.php";
require_once "Repository/RentalRepository.php";

// This class inherits the jsonResponse method and the $cnx property from the parent class Controller
// Only the process????Request methods need to be (re)defined.

class RentalController extends Controller {

    private RentalRepository $repository;

    public function __construct() {
        $this->repository = new RentalRepository();
    }

    protected function processGetRequest(HttpRequest $request): ?string {
        if ($request->getMethod() == 'GET' ) {
            $totalPrice = $this->repository->getTotalRentalPrice();
            return json_encode(['totalrental' => $totalPrice]);
        }
        if ($request->getMethod() == 'GET') {
            $rentalData = $this->repository->findAll();
            return json_encode($rentalData);
        }
        return null;
    }
    // protected function processGetRequest(HttpRequest $request) {
    //     $json = $request->getJson();
    //     $obj = json_decode($json);
    //     $r = new Rental(0); 
    //     $r->setCustomerId($obj->customer_id);
    //     $r->setMovieId($obj->movie_id);
    //     $r->setRentalDate($obj->rental_date);
    //     $r->setRentalPrice($obj->rental_price);
    //     $ok = $this->repository->save($r); 
    //     return $ok ? $r : false;
    // }
    protected function processPostRequest(HttpRequest $request) {
        $json = $request->getJson();
        $obj = json_decode($json);
        $r = new Rental(0);
        $r->setCustomerId($obj->customer_id);
        $r->setMovieId($obj->movie_id);
        $r->setRentalDate($obj->rental_date);
        $r->setRentalPrice($obj->rental_price);
        $ok = $this->repository->save($r); 
        return $ok ? $r : false;
    }
}


?>
