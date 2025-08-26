<?php

class Libro {
    private $id;
    private $titulo;
    private $autor; 
    private $categoria; 
    private $isbn;
    private $disponible;

    public function __construct($id, $titulo, $autor, $categoria, $isbn, $disponible = true) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->categoria = $categoria;
        $this->isbn = $isbn;
        $this->disponible = $disponible;
    }

   
    public function getId() { return $this->id; }
    public function getTitulo() { return $this->titulo; }
    public function getAutor() { return $this->autor; }
    public function getCategoria() { return $this->categoria; }
    public function getIsbn() { return $this->isbn; }
    public function isDisponible() { return $this->disponible; }

    
    public function setTitulo($titulo) { $this->titulo = $titulo; }
    public function setAutor($autor) { $this->autor = $autor; }
    public function setCategoria($categoria) { $this->categoria = $categoria; }
    public function setIsbn($isbn) { $this->isbn = $isbn; }
    public function setDisponible($disponible) { $this->disponible = $disponible; }

    
    public function toArray() {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'autor' => $this->autor->getNombre(),
            'categoria' => $this->categoria->getNombre(),
            'isbn' => $this->isbn,
            'disponible' => $this->disponible
        ];
    }
}