<?php

require_once 'Libro.php';
require_once 'Autor.php';
require_once 'Categoria.php';

class Database {
    private $archivo = __DIR__ . '/../data/libros.json';

    public function guardarLibros($libros) {
        $data = array_map(function($libro) {
            return $libro->toArray();
        }, $libros);
        file_put_contents($this->archivo, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function cargarLibros() {
        if (!file_exists($this->archivo)) {
            return [];
        }
        $json = file_get_contents($this->archivo);
        $data = json_decode($json, true);
        return $this->convertirAObjetos($data);
    }

    private function convertirAObjetos($data) {
        $libros = [];
        $autores = [];
        $categorias = [];

        foreach ($data as $item) {
            $id = $item['id'];
            $titulo = $item['titulo'];
            $isbn = $item['isbn'];
            $disponible = $item['disponible'];

            $autorNombre = $item['autor'];
            $categoriaNombre = $item['categoria'];

            if (!isset($autores[$autorNombre])) {
                $autores[$autorNombre] = new Autor(uniqid(), $autorNombre);
            }
            if (!isset($categorias[$categoriaNombre])) {
                $categorias[$categoriaNombre] = new Categoria(uniqid(), $categoriaNombre);
            }

            $libro = new Libro($id, $titulo, $autores[$autorNombre], $categorias[$categoriaNombre], $isbn, $disponible);
            $libros[] = $libro;
        }
        return $libros;
    }
}