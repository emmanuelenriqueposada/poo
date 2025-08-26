<?php
require_once '../src/Autor.php';
require_once '../src/Categoria.php';
require_once '../src/Libro.php';
require_once '../src/Prestamo.php';
require_once '../src/Database.php';
require_once '../src/Biblioteca.php';

$biblioteca = new Biblioteca();
$resultados = [];
$termino = '';
$tipo = 'titulo';

if (isset($_GET['termino']) && !empty($_GET['termino'])) {
    $termino = trim($_GET['termino']);
    $tipo = $_GET['tipo'] ?? 'titulo';
    $resultados = $biblioteca->buscarLibros($termino, $tipo);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Libro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>🔍 Buscar Libro</h1>

        <form method="GET">
            <label for="tipo">Buscar por:</label>
            <select name="tipo" id="tipo">
                <option value="titulo" <?= $tipo === 'titulo' ? 'selected' : '' ?>>Título</option>
                <option value="autor" <?= $tipo === 'autor' ? 'selected' : '' ?>>Autor</option>
                <option value="categoria" <?= $tipo === 'categoria' ? 'selected' : '' ?>>Categoría</option>
            </select><br><br>

            <label for="termino">Término de búsqueda:</label>
            <input type="text" name="termino" id="termino" value="<?= htmlspecialchars($termino) ?>" required><br><br>

            <button type="submit">Buscar 🔍</button>
        </form>

        <?php if ($termino && empty($resultados)): ?>
            <p>No se encontraron libros que coincidan con "<?= htmlspecialchars($termino) ?>"</p>
        <?php elseif (!empty($resultados)): ?>
            <h2>Resultados (<?= count($resultados) ?>)</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Categoría</th>
                    <th>ISBN</th>
                    <th>Estado</th>
                </tr>
                <?php foreach ($resultados as $libro): ?>
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

        <br>
        <a href="index.php">Volver al inicio</a>
    </div>
</body>
</html>