<?php

require_once '../src/Autor.php';
require_once '../src/Categoria.php';
require_once '../src/Libro.php';
require_once '../src/Prestamo.php';
require_once '../src/Database.php';
require_once '../src/Biblioteca.php';

$biblioteca = new Biblioteca();
$libros = $biblioteca->getLibros();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca POO</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Sistema de Gestión de Biblioteca</h1>
        <nav>
            <a href="agregar_libro.php">Agregar Libro</a>
            <a href="buscar_libro.php">Buscar Libro</a>
            <a href="prestar_libro.php">Prestar Libro</a>
            <a href="devolver_libro.php">Devolver Libro</a>
        </nav>
        <h2>Libros Disponibles</h2>
        <?php if (empty($libros)): ?>
            <p>No hay libros registrados.</p>
        <?php else: ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Categoría</th>
                    <th>ISBN</th>
                    <th>Estado</th>
                </tr>
                <?php foreach ($libros as $libro): ?>
                <tr>
                    <td><?= $libro->getId() ?></td>
                    <td><?= $libro->getTitulo() ?></td>
                    <td><?= $libro->getAutor()->getNombre() ?></td>
                    <td><?= $libro->getCategoria()->getNombre() ?></td>
                    <td><?= $libro->getIsbn() ?></td>
                    <td><?= $libro->isDisponible() ? 'Disponible' : 'Prestado' ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>