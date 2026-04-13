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
            include_once 'menu.php';
        ?>
    </header>
    

    <main>
        <h2>Recomendaciones</h2>
        <a class="botonGestion" href="insertJuego.php">Insertar juego</a>

        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Argumento</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Comprar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    include_once 'bbdd.php';
                    $juegos = get_all_juegos_y_categoria();
                    $cantidadJuegos = sizeof($juegos);
                    $precioTotal = 0;

                    for($i = 0; $i < $cantidadJuegos; $i++)
                    {
                        echo "<tr>";
                            echo "<td>".$juegos[$i]['titulo']."</td>";
                            echo "<td>".$juegos[$i]['descripcion']."</td>";
                            if(!empty($juegos[$i]['imagen'])){
                                echo "<td><img src='".$juegos[$i]['imagen']."' class='imagenTabla'/></td>";
                            } else {
                                echo "<td></td>";
                            }
                            echo "<td>".$juegos[$i]['precio']."</td>";
                            echo "<td>";
                                $idJuego = intval($juegos[$i]['idJuego']);
                                echo "<a class='botonCompra' href='modificar.php?idjuego=".$idJuego."'>";
                                echo "<img src='images/carro.png' class='iconoCompra' alt='Ir a modificar'/>";
                                echo "<img src='images/trash.png' class='iconoCompra'/>";
                                echo "</a>";
                            echo "</td>";
                        echo "</tr>";

                        $precioTotal += floatval($juegos[$i]['precio']);
                    }
                ?>

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">Total de juegos en la tabla: <?php echo sizeof($juegos);?></td>
                    <td>Total precio: <?php echo $precioTotal; ?>€</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="6"><p><strong>Nota:</strong> los precios son aproximados.</p></td>
                </tr>
            </tfoot>
        </table>
    </main> 
    
    
    <footer>
        <a href="#">Sobre nosotros</a>
        <a href="#">Condiciones legales</a>
        <a href="#">Contacto</a>
    </footer>
</body>
</html>