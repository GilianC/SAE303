<?php
require_once "Controller.php";
require_once "Repository/CommandeRepository.php";

// This class inherits the jsonResponse method and the $cnx property from the parent class Controller
// Only the process????Request methods need to be (re)defined.

class CommandeController extends Controller {

    private CommandeRepository $rental;

    public function __construct(){
        $this->rental = new CommandeRepository();
    }

    protected function processGetRequest(HttpRequest $request) {
        $id = $request->getId("id");
        if ($id){
            // URI is .../commandes/{id}
            $co = $this->rental->find($id);
            return $co == null ? false : $co;
        }
    }

    protected function processPostRequest(HttpRequest $request) {
        $json = $request->getJson();
        $obj = json_decode($json);
        $co = new Rental(0); // 0 is a symbolic and temporary value since the product does not have a real id yet.
        $co->setCustomerId($obj->customer_id);
        $co->setMovieId($answer->movie_id);
        $co->setRentalDate($answer->rental_date);
        $co->setRentalPrice($answer->rental_price);

        $ok = $this->rental->save($co); 
        return $ok ? $co : false;
    }
}
?>
