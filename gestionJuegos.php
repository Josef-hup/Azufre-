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
            session_start();
            if(!isset($_SESSION['id_usuario']))
            {
                header("location: index.php");
            }
            include_once 'menu.php';
        ?>
    </header>
    

    <main>
        <h2>Gestión juegos</h2>
        <?php
            if(isset($_GET['msg']) && $_GET['msg'] === 'deleted') {
                echo "<p class='success'>Juego eliminado correctamente.</p>";
            } elseif(isset($_GET['msg']) && $_GET['msg'] === 'error') {
                echo "<p class='error'>Error al eliminar el juego.</p>";
            }
        ?>

        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Argumento</th>
                    <th>Categoría</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>

                <?php
                    include_once 'bbdd.php';
                    $juegos = get_all_juegos_y_categoria();
                    $cantidadJuegos = sizeof($juegos);

                    for($i = 0; $i < $cantidadJuegos; $i++)
                    {
                        echo "<tr>";
                            echo "<td>".$juegos[$i]['titulo']."</td>";
                            echo "<td>".$juegos[$i]['descripcion']."</td>";
                            echo "<td>".$juegos[$i]['nombre_categoria']."</td>";
                            echo "<td>";
                                echo "<img src='images/edit.png' class='iconoCompra'/>";
                            echo "</td>";
                            echo "<td>";
                                $idJuego = intval(
                                    isset($juegos[$i]['idJuego']) ? $juegos[$i]['idJuego'] : 0
                                );
                                echo "<a href='eliminarJuego.php?idjuego=".$idJuego."' onclick='return confirm(\'¿Eliminar este juego?\');'>";
                                echo "<img src='images/trash.png' class='iconoCompra' alt='Eliminar'/>";
                                echo "</a>";
                            echo "</td>";
                        echo "</tr>";
                    }
                ?>
                
                
            </tbody>
            
        </table>
    </main> 
    
    
    <footer>
        <a href="#">Sobre nosotros</a>
        <a href="#">Condiciones legales</a>
        <a href="#">Contacto</a>
    </footer>
</body>
</html>