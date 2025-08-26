<?php

require_once '../src/Autor.php';
require_once '../src/Categoria.php';
require_once '../src/Libro.php';
require_once '../src/Prestamo.php';
require_once '../src/Database.php';
require_once '../src/Biblioteca.php';

$biblioteca = new Biblioteca();
$mensaje = '';

if ($_POST) {
    $id = (int)($_POST['id'] ?? 0);
    $usuario = trim($_POST['usuario'] ?? '');

    if ($id > 0 && !empty($usuario)) {
        $mensaje = $biblioteca->prestarLibro($id, $usuario);
    } else {
        $mensaje = "❌ Por favor, completa todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prestar Libro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Solicitar Préstamo de Libro</h1>

        <?php if ($mensaje): ?>
            <p class="mensaje" style="padding: 10px; margin: 10px 0; background: <?= strpos($mensaje, 'exitosamente') ? '#d4edda' : '#f8d7da' ?>;
            color: <?= strpos($mensaje, 'exitosamente') ? '#155724' : '#721c24' ?>;
            border: 1px solid <?= strpos($mensaje, 'exitosamente') ? '#c3e6cb' : '#f5c6cb' ?>;
            border-radius: 4px;"><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="id">ID del Libro:</label>
            <input type="number" name="id" id="id" min="1" required><br><br>

            <label for="usuario">Tu Nombre:</label>
            <input type="text" name="usuario" id="usuario" required><br><br>

            <button type="submit">Solicitar Préstamo</button>
        </form>

        <h2>Libros Disponibles</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Estado</th>
            </tr>
            <?php foreach ($biblioteca->getLibros() as $libro): ?>
                <tr>
                    <td><?= $libro->getId() ?></td>
                    <td><?= $libro->getTitulo() ?></td>
                    <td><?= $libro->getAutor()->getNombre() ?></td>
                    <td><?= $libro->isDisponible() ? 'Disponible' : 'Prestado' ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <br>
        <a href="index.php">Volver al inicio</a>
    </div>
</body>
</html>