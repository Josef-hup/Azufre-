<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuegAlmi</title>
    <meta name="description" content="Página de una tienda de videojuegos" />
    <meta name="keywords" content="tienda,videojuegos,bilbao" />

    <link rel="stylesheet" href="css/styleFlex.css" />
    <link rel="stylesheet" href="css/recomendaciones.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tagesschrift&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/inserjuego.css" />
</head>
<body>
    <header>
        <div id="primeraFilaEncabezado">
            <a href="index.html"><img src="images/joystick.png" id="logo" alt="Logo de un mando"/></a>
            <h1>JuegAlmi</h1>
            <img src="images/raton.png" id="logo2" alt="Icono con un ratón de pc"/>
        </div>
        <p>Tu tienda de cercanía</p>

        <?php
            include_once 'menu.php';
        ?>
    </header>

    <main>
        <h2>Insertar juego</h2>

        <form action="insertJuego.php" method="post" enctype="multipart/form-data">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required />

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required></textarea>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" step="0.01" required />

            <label for="categoria">Categoría:</label>
            <select id="categoria" name="categoria" required>
                <?php
                    include_once 'bbdd.php';
                    $categorias = get_categorias();
                    foreach($categorias as $categoria) {
                        echo "<option value='" . $categoria['idCategoria'] . "'>" . $categoria['nombre'] . "</option>";
                    }
                ?>
            </select>

            <input type="submit" value="Insertar juego" />
            <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Usar los nombres de campo correctos del formulario
                    $titulo = trim($_POST['titulo'] ?? '');
                    $descripcion = trim($_POST['descripcion'] ?? '');
                    $precio = floatval($_POST['precio'] ?? 0);
                    $categoria = intval($_POST['categoria'] ?? 0);

                    if(function_exists('insertarJuego')) {
                        $resultado = insertarJuego($titulo, $descripcion, $precio, $categoria);
                    } elseif(function_exists('insert_juego')) {
                        $resultado = insert_juego($titulo, $descripcion, $precio, $categoria);
                    } else {
                        $resultado = false;
                        echo "<p class='error'>Función de inserción no encontrada. Añádela en `bbdd.php` (ej: insertarJuego).</p>";
                    }
                    if ($resultado) {
                        echo "<p>Juego insertado correctamente.</p>";
                    } else {
                        echo "<p>Error al insertar el juego.</p>";
                    }
                }
            ?>
            </form>
    </main> 
    
    
    <footer>
        <a href="#">Sobre nosotros</a>
        <a href="#">Condiciones legales</a>
        <a href="#">Contacto</a>
    </footer>
</body>
</html>