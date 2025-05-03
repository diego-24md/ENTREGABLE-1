<?php
session_start();

// Verificar sesión
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include 'conexion.php';

// Categorías definidas
$categorias = [
    'Polos',
    'Camisetas',
    'Pantalones',
    'Shorts',
    'Chaquetas',
    'Sudaderas',
    'Ropa Deportiva'
];

// Obtener filtros desde GET
$categoria_filtro = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$precio_filtro = isset($_GET['precio']) ? $_GET['precio'] : '';
$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';

// Construir consulta dinámica
$query_productos = "SELECT * FROM productos";
$where = [];

// Filtro por categoría
if ($categoria_filtro) {
    $where[] = "categoria_id = $categoria_filtro";
}

// Filtro por precio
if ($precio_filtro) {
    switch ($precio_filtro) {
        case 1:
            $where[] = "precio BETWEEN 0 AND 50";
            break;
        case 2:
            $where[] = "precio BETWEEN 51 AND 100";
            break;
        case 3:
            $where[] = "precio BETWEEN 101 AND 150";
            break;
        case 4:
            $where[] = "precio BETWEEN 151 AND 200";
            break;
        case 5:
            $where[] = "precio > 200";
            break;
    }
}

// Filtro por búsqueda
if (!empty($busqueda)) {
    $busqueda = mysqli_real_escape_string($conn, $busqueda);
    $where[] = "(nombre LIKE '%$busqueda%' OR marca LIKE '%$busqueda%')";
}

// Combinar condiciones
if (count($where) > 0) {
    $query_productos .= " WHERE " . implode(" AND ", $where);
}

$result_productos = mysqli_query($conn, $query_productos);

require 'header.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="./CSS/productos.css">
</head>

<body>

    <h1>Catálogo de Productos</h1>

    <div class="filtros-container">
        <!-- Formulario único con filtros y búsqueda -->
        <form action="productos.php" method="GET">

            <div>
                <label for="categoria">Categoría:</label>
                <select name="categoria" id="categoria">
                    <option value="">Todas</option>
                    <?php foreach ($categorias as $index => $categoria) { ?>
                        <option value="<?php echo $index + 1; ?>" <?php echo ($categoria_filtro == $index + 1) ? 'selected' : ''; ?>>
                            <?php echo $categoria; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div>
                <label for="precio">Precio:</label>
                <select name="precio" id="precio">
                    <option value="">Todos</option>
                    <option value="1" <?php echo ($precio_filtro == 1) ? 'selected' : ''; ?>>S/ 0 - S/ 50</option>
                    <option value="2" <?php echo ($precio_filtro == 2) ? 'selected' : ''; ?>>S/ 51 - S/ 100</option>
                    <option value="3" <?php echo ($precio_filtro == 3) ? 'selected' : ''; ?>>S/ 101 - S/ 150</option>
                    <option value="4" <?php echo ($precio_filtro == 4) ? 'selected' : ''; ?>>S/ 151 - S/ 200</option>
                    <option value="5" <?php echo ($precio_filtro == 5) ? 'selected' : ''; ?>>S/ 200+</option>
                </select>
            </div>

            <div>
                <input type="text" name="busqueda" placeholder="Buscar producto..." value="<?php echo htmlspecialchars($busqueda); ?>">
            </div>

            <button type="submit">Aplicar Filtros</button>
            <a href="productos.php" class="limpiar-filtros">Limpiar</a>

        </form>
    </div>

    <div class="productos-container">
        <?php if (mysqli_num_rows($result_productos) > 0) { ?>
            <?php while ($producto = mysqli_fetch_assoc($result_productos)) { ?>
                <div class="producto">
                    <h3><?php echo $producto['nombre']; ?></h3>
                    <p>Marca: <?php echo $producto['marca']; ?></p>
                    <p>Precio: S/ <?php echo $producto['precio']; ?></p>
                    <?php if (!empty($producto['imagen'])) { ?>
                        <img src="img/<?php echo $producto['imagen']; ?>" alt="Imagen del producto">
                    <?php } else { ?>
                        <img src="img/sin-imagen.png" alt="Sin imagen">
                    <?php } ?>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p class="sin-resultados">No se encontraron productos con los filtros aplicados.</p>
        <?php } ?>
    </div>

    <!-- Cards fijas -->
    <div class="productos-container">

        <div class="card">
            <img src="images/polo.jpg" alt="Polo">
            <h3>Polo</h3>
            <p>Polo de algodón suave y fresco para el verano.</p>
        </div>

        <div class="card">
            <img src="images/pantalon.jpg" alt="Pantalón">
            <h3>Pantalón</h3>
            <p>Pantalón jean clásico azul oscuro, corte recto.</p>
        </div>

        <div class="card">
            <img src="images/short.jpg" alt="Short">
            <h3>Short</h3>
            <p>Short casual para uso diario, varios colores.</p>
        </div>

        <div class="card">
            <img src="images/gorra.jpg" alt="Gorra">
            <h3>Gorra</h3>
            <p>Gorra deportiva ajustable, disponible en varios colores.</p>
        </div>

        <div class="card">
            <img src="images/camisa.jpg" alt="Camisa">
            <h3>Camisa</h3>
            <p>Camisa manga corta de algodón, ideal para oficina.</p>
        </div>

        <div class="card">
            <img src="images/casaca.jpg" alt="Casaca">
            <h3>Casaca</h3>
            <p>Casaca impermeable para media estación y lluvia ligera.</p>
        </div>

        <div class="card">
            <img src="images/sudadera.jpg" alt="Sudadera">
            <h3>Sudadera</h3>
            <p>Sudadera con capucha de algodón y bolsillo canguro.</p>
        </div>

    </div>

</body>

</html>

<?php
require 'footer.php';
?>
