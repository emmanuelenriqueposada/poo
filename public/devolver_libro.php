<?php
// Incluir todas las clases
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

    if ($id > 0) {
        $mensaje = $biblioteca->devolverLibro($id);
    } else {
        $mensaje = "Ingresa un ID válido.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Devolver Libro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Devolver Libro</h1>

        <?php if ($mensaje): ?>
            <p class="mensaje" style="padding: 10px; margin: 10px 0; background: <?= strpos($mensaje, 'exitosamente') ? '#d4edda' : '#f8d7da' ?>;
            color: <?= strpos($mensaje, 'exitosamente') ? '#155724' : '#721c24' ?>;
            border: 1px solid <?= strpos($mensaje, 'exitosamente') ? '#c3e6cb' : '#f5c6cb' ?>;
            border-radius: 4px;"><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="id">ID del Libro a devolver:</label>
            <input type="number" name="id" id="id" min="1" required><br><br>
            <button type="submit">Devolver Libro</button>
        </form>

        <h2>Libros Actualmente Prestados</h2>
        <?php
        $prestados = array_filter($biblioteca->getLibros(), fn($libro) => !$libro->isDisponible());
        ?>
        <?php if (empty($prestados)): ?>
            <p>No hay libros prestados actualmente.</p>
        <?php else: ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                </tr>
                <?php foreach ($prestados as $libro): ?>
                <tr>
                    <td><?= $libro->getId() ?></td>
                    <td><?= $libro->getTitulo() ?></td>
                    <td><?= $libro->getAutor()->getNombre() ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>

        <br>
        <a href="index.php">Volver al inicio</a>
    </div>
</body>
</html>