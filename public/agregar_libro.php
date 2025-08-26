<?php
require_once '../src/Biblioteca.php';

$biblioteca = new Biblioteca();
$mensaje = '';

if ($_POST) {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $categoria = $_POST['categoria'];
    $isbn = $_POST['isbn'];

    // Validación básica
    if ($id && $titulo && $autor && $categoria && $isbn) {
        $nuevoAutor = new Autor(uniqid(), $autor);
        $nuevaCategoria = new Categoria(uniqid(), $categoria);
        $libro = new Libro($id, $titulo, $nuevoAutor, $nuevaCategoria, $isbn);

        // Evitar duplicados por ID
        $existe = false;
        foreach ($biblioteca->getLibros() as $l) {
            if ($l->getId() == $id) {
                $existe = true;
                break;
            }
        }

        if (!$existe) {
            $biblioteca->agregarLibro($libro);
            $mensaje = "Libro agregado exitosamente.";
        } else {
            $mensaje = " Ya existe un libro con ese ID.";
        }
    } else {
        $mensaje = " Todos los campos son obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Libro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>➕ Agregar Nuevo Libro</h1>
        <?php if ($mensaje): ?>
            <p class="mensaje"><?= $mensaje ?></p>
        <?php endif; ?>
        <form method="POST">
            <label>ID del Libro:</label>
            <input type="number" name="id" required><br>

            <label>Título:</label>
            <input type="text" name="titulo" required><br>

            <label>Autor:</label>
            <input type="text" name="autor" required><br>

            <label>Categoría:</label>
            <input type="text" name="categoria" required><br>

            <label>ISBN:</label>
            <input type="text" name="isbn" required><br>

            <button type="submit">Agregar Libro</button>
        </form>
        <a href="index.php">Volver al inicio</a>
    </div>
</body>
</html>