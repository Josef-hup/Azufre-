<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuegAlmi</title>
    <meta name="description" content="Página de una tienda de videojuegos" />
    <meta name="keywords" content="tienda,videojuegos,bilbao" />

    <link rel="stylesheet" href="css/styleFlex.css" />
    <link rel="stylesheet" href="css/detalles.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tagesschrift&display=swap" rel="stylesheet">
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

    <?php
        include_once 'bbdd.php';

        $id_cat = $_GET['idcategoria'];
        
        //$juegos = get_juegos_categoria($id_cat);
        $juegos = get_juegos_y_categoria($id_cat);
        $cantidadJuegos = sizeof($juegos);

        //$categoria = get_categoria_by_id($id_cat);
        echo "<h2>".$juegos[0]['nombre_categoria']."</h2>";

        for($i = 0; $i < $cantidadJuegos; $i++)
        {
            echo "<h3>".$juegos[$i]['titulo']."</h3>";
            if(!empty($juegos[$i]['imagen'])){
                echo "<img src='".$juegos[$i]['imagen']."' />";
            }
        }
    ?>

    </main>

    <footer>
        <a href="#">Sobre nosotros</a>
        <a href="#">Condiciones legales</a>
        <a href="#">Contacto</a>
    </footer>
</body>
</html>