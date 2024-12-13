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
class Movie implements JsonSerializable {
    public int $id;
    public string $movie_title;
    public string $genre;
    public string $release_date;
    public int $duration_minutes;
    public float $rating;

    // Getters and Setters
    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getMovieTitle(): string {
        return $this->movie_title;
    }

    public function setMovieTitle(string $movie_title): self {
        $this->movie_title = $movie_title;
        return $this;
    }

    public function getGenre(): string {
        return $this->genre;
    }

    public function setGenre(string $genre): self {
        $this->genre = $genre;
        return $this;
    }

    public function getReleaseDate(): string {
        return $this->release_date;
    }

    public function setReleaseDate(string $release_date): self {
        $this->release_date = $release_date;
        return $this;
    }

    public function getDurationMinutes(): int {
        return $this->duration_minutes;
    }

    public function setDurationMinutes(int $duration_minutes): self {
        $this->duration_minutes = $duration_minutes;
        return $this;
    }

    public function getRating(): float {
        return $this->rating;
    }

    public function setRating(float $rating): self {
        $this->rating = $rating;
        return $this;
    }

    // Implementing jsonSerialize method
    public function jsonSerialize(): mixed {
        return [
            "id" => $this->id,
            "movie_title" => $this->movie_title,
            "genre" => $this->genre,
            "release_date" => $this->release_date,
            "duration_minutes" => $this->duration_minutes,
            "rating" => $this->rating
        ];
    }
}
