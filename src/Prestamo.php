<?php

class Prestamo {
    private $id;
    private $libro;
    private $usuario;
    private $fechaPrestamo;
    private $fechaDevolucion;

    public function __construct($id, $libro, $usuario) {
        $this->id = $id;
        $this->libro = $libro;
        $this->usuario = $usuario;
        $this->fechaPrestamo = date('Y-m-d');
        $this->fechaDevolucion = null;
    }

    public function devolver() {
        if (!$this->fechaDevolucion) {
            $this->fechaDevolucion = date('Y-m-d');
            $this->libro->setDisponible(true);
            return true;
        }
        return false;
    }

    public function getLibro() { return $this->libro; }
    public function getUsuario() { return $this->usuario; }
    public function getFechaPrestamo() { return $this->fechaPrestamo; }
    public function getFechaDevolucion() { return $this->fechaDevolucion; }
}