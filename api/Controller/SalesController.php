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

    protected function processGetRequest(HttpRequest $request): ?string {
        if ($request->getMethod() == 'GET' ) {
            $totalSales = $this->repository->getTotalSalesPrice();
            return json_encode(['totalsales' => $totalSales]);
        }
        if ($request->getMethod() == 'GET') {
            $rentalSales = $this->repository->findAll();
            return json_encode($rentalSales);
        }
        return null;
    }


    protected function processPostRequest(HttpRequest $request) {
        $json = $request->getJson();
        $obj = json_decode($json);
        $s = new Sale(0);
        $s->setCustomerId($obj->customer_id);
        $s->setProductId($obj->product_id);
        $s->setPurchaseDate($obj->purchase_date);
        $s->setPurchasePrice($obj->purchase_price);
        $ok = $this->repository->save($s); 
        return $ok ? $s : false;
    }
}
?>
