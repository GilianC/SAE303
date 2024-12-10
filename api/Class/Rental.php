<?php
/**
 *  Class Commande
 * 
 *  Représente une commande avec les propriétés id, customer_id, movie_id, rental_date, rental_price
 * 
 *  Implémente l'interface JsonSerializable 
 *  qui oblige à définir une méthode jsonSerialize. Cette méthode permet de dire comment les objets
 *  de la classe Commande doivent être convertis en JSON. Voir la méthode pour plus de détails.
 */

// Rental.php
class Rental {
    public int $id;
    public int $customer_id;
    public int $movie_id;
    public string $rental_date;
    public float $rental_price;

    // Other methods...
    public function getId(): int {
        return $this->id;
    }
    /**
     * Get the value of customer_id
     */ 
    public function getCustomerId(): int {
        return $this->customer_id;
    }

    /**
     * Set the value of customer_id
     *
     * @return self
     */ 
    public function setCustomerId(int $customer_id): self {
        $this->customer_id = $customer_id;
        return $this;
    }

    /**
     * Get the value of movie_id
     */ 
    public function getMovieId(): int {
        return $this->movie_id;
    }
    
    /**
     * Set the value of movie_id
     *
     * @return self
     */ 
    public function setMovieId(int $movie_id): self {
        $this->movie_id = $movie_id;
        return $this;
    }
    
    /**
     * Get the value of rental_date
     */
    public function getRentalDate(): string {
        return $this->rental_date;
    }
    
    public function JsonSerialize(): mixed {
        return [
            "id" => $this->id,
            "customer_id" => $this->customer_id,
            "movie_id" => $this->movie_id,
            "rental_date" => $this->rental_date,
            "rental_price" => $this->rental_price
        ];
    }
    /**
     * Set the value of rental_date
     *
     * @return self
     */
    public function setRentalDate(string $rental_date): self {
        $this->rental_date = $rental_date;
        return $this;
    }

    /**
     * Get the value of rental_price
     */
    public function getRentalPrice(): float {
        return $this->rental_price;
    }

    /**
     * Set the value of rental_price
     *
     * @return self
     */
    public function setRentalPrice(float $rental_price): self {
        $this->rental_price = $rental_price;
        return $this;
    }

    /**
     * Define how to convert/serialize a commande to a JSON format
     * This method will be automatically invoked by json_encode when applied to a commande
     */
}