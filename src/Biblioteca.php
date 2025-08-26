<?php

require_once 'Libro.php';      
require_once 'Database.php';   

class Biblioteca {
    private $libros = [];
    private $prestamos = [];
    private $database;

    public function __construct() {
        $this->database = new Database();
        $this->libros = $this->database->cargarLibros();
    }

    public function agregarLibro($libro) {
        $this->libros[] = $libro;
        $this->guardar();
    }

    public function editarLibro($id, $titulo, $autorNombre, $categoriaNombre, $isbn) {
        foreach ($this->libros as $libro) {
            if ($libro->getId() == $id) {
                $autor = new Autor($libro->getAutor()->getId(), $autorNombre);
                $categoria = new Categoria($libro->getCategoria()->getId(), $categoriaNombre);
                $libro->setTitulo($titulo);
                $libro->setAutor($autor);
                $libro->setCategoria($categoria);
                $libro->setIsbn($isbn);
                $this->guardar();
                return true;
            }
        }
        return false;
    }

    public function eliminarLibro($id) {
        foreach ($this->libros as $index => $libro) {
            if ($libro->getId() == $id) {
                unset($this->libros[$index]);
                $this->libros = array_values($this->libros);
                $this->guardar();
                return true;
            }
        }
        return false;
    }

    public function buscarLibros($termino, $tipo = 'titulo') {
        $resultados = [];
        foreach ($this->libros as $libro) {
            switch ($tipo) {
                case 'titulo':
                    if (stripos($libro->getTitulo(), $termino) !== false) {
                        $resultados[] = $libro;
                    }
                    break;
                case 'autor':
                    if (stripos($libro->getAutor()->getNombre(), $termino) !== false) {
                        $resultados[] = $libro;
                    }
                    break;
                case 'categoria':
                    if (stripos($libro->getCategoria()->getNombre(), $termino) !== false) {
                        $resultados[] = $libro;
                    }
                    break;
            }
        }
        return $resultados;
    }

    public function prestarLibro($id, $usuario) {
        foreach ($this->libros as $libro) {
            if ($libro->getId() == $id) {
                if ($libro->isDisponible()) {
                    $libro->setDisponible(false);
                    $prestamo = new Prestamo(count($this->prestamos) + 1, $libro, $usuario);
                    $this->prestamos[] = $prestamo;
                    $this->guardar();
                    return "Libro prestado exitosamente.";
                } else {
                    return "El libro no está disponible.";
                }
            }
        }
        return "Libro no encontrado.";
    }

    public function devolverLibro($id) {
        foreach ($this->prestamos as $prestamo) {
            if ($prestamo->getLibro()->getId() == $id && !$prestamo->getFechaDevolucion()) {
                $prestamo->devolver();
                $this->guardar();
                return "Libro devuelto exitosamente.";
            }
        }
        return "Préstamo no encontrado o ya devuelto.";
    }

    public function getLibros() {
        return $this->libros;
    }

    private function guardar() {
        $this->database->guardarLibros($this->libros);
    }
}