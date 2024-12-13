<?php
require_once "Controller.php";
require_once "Repository/SalesRepository.php";

// This class inherits the jsonResponse method and the $cnx property from the parent class Controller
// Only the process????Request methods need to be (re)defined.

class SalesController extends Controller {

    private SalesRepository $repository;

    public function __construct() {
        $this->repository = new SalesRepository();
    }

    protected function processGetRequest(HttpRequest $request) {
        $param = $request->getParam("param");
        $id = $request->getParam("id");
        // $rental = $request->getId("rental");
        if ($param == "totalsales") {
            return $this->repository->getTotalSalesPrice();
        }
        else if ($param == "salessixmonth") {
            return $this->repository->getTotalSalesLastSixMonths();
        }
        else if ($param == "salesgenremonth") {
            return $this->repository->getTotalSalesGenreSixMonths();
        }
        else if ($param == "salespercountry") {
            return $this->repository->getTotalSalesCountry();
        }
        else if ( $param == "salesmoviestat") {
            return $this->repository->getAllMovieByStat();
        }
        else if ($id ) {
            return $this->repository->getSalesbyMovie($id);
        }

        return null;
    }

}
?>
