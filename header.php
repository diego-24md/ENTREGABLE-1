<?php
include 'conexion.php'; // Incluir la conexión

// Luego puedes realizar consultas a la base de datos
$query = "SELECT * FROM productos";
$result = mysqli_query($conn, $query);

// Verificar si la consulta fue exitosa
if (!$result) {
    die("Error al obtener productos: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Tienda de Ropa</title>
    
    <!-- Vinculación al archivo CSS -->
    <link rel="stylesheet" href="./CSS/estilos-CP.css">
</head>
<body>
    <!-- Aquí va el código del header (navbar) -->
    <header>
        <h1>Tienda Vesta</h1>
        <a href="logout.php" title="Cerrar sesión"><i class="fas fa-door-open"></i></a>
    </header>

    <div class="productos-container">
        <?php
        while ($producto = mysqli_fetch_assoc($result)) {
            echo "<div class='producto'>";
            echo "<h3>" . $producto['nombre'] . "</h3>";
            echo "<p>Marca: " . $producto['marca'] . "</p>";
            echo "<p>Precio: S/ " . $producto['precio'] . "</p>";
            if (!empty($producto['imagen'])) {
                echo "<img src='img/" . $producto['imagen'] . "' alt='Imagen del producto'>";
            } else {
                echo "<img src='img/sin-imagen.png' alt='Sin imagen'>";
            }
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>

