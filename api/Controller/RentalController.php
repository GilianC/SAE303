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

    protected function processGetRequest(HttpRequest $request) {
        $param = $request->getParam("param");
        $id = $request->getParam("id");
        // $rental = $request->getId("rental");
        if ($param == "totalrental") {
            return $this->repository->getTotalRentalPrice();
        }
        else if ($param == "rentalsixmonth") {
            return $this->repository->getTotalRentalLastSixMonths();
        }
        else if ($param == "rentalgenremonth") {
            return $this->repository->getTotalRentalGenreSixMonths();
        }
        else if ($param == "rentalpercountry") {
            return $this->repository->getTotalRentalCountry();
        }
        else if ($param == "rentalmoviestat") {
            return $this->repository->getAllMovieByStat();
        }
        else if ($id ) {
            return $this->repository->getRentalbyMovie($id);
        }

        return null;
    }

}


?>
