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
class Sales {
    public int $id;
    public int $customer_id;
    public int $movie_id;
    public string $purchase_date;
    public float $purchase_price;

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
     * Get the value of product_id
     */ 
    public function getProductId(): int {
        return $this->product_id;
    }
    
    /**
     * Set the value of product_id
     *
     * @return self
     */ 
    public function setProductId(int $product_id): self {
        $this->product_id = $product_id;
        return $this;
    }
    
    /**
     * Get the value of sale_date
     */
    public function getPurchaseDate(): string {
        return $this->purchase_date;
    }
    
    public function JsonSerialize(): mixed {
        return [
            "id" => $this->id,
            "customer_id" => $this->customer_id,
            "product_id" => $this->product_id,
            "purchase_date" => $this->purchase_date,
            "sale_price" => $this->sale_price
        ];
    }
    /**
     * Set the value of sale_date
     *
     * @return self
     */
    public function setPurchaseDate(string $purchase_date): self {
        $this->purchase_date = $purchase_date;
        return $this;
    }

    /**
     * Get the value of sale_price
     */
    public function getPurchasePrice(): float {
        return $this->purchase_price;
    }

    /**
     * Set the value of sale_price
     *
     * @return self
     */
    public function setPurchasePrice(float $purchase_price): self {
        $this->purchase_price = $purchase_price;
        return $this;
    }

    /**
     * Define how to convert/serialize a commande to a JSON format
     * This method will be automatically invoked by json_encode when applied to a commande
     */
}