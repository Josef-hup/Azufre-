<?php
    session_start();
    $url = $_SERVER['REQUEST_URI'];
?>
<nav>
    <ul class="menuNivel1">
        <li class="<?php if($url == '/juegAlmi/' || $url == '/juegAlmi/index.php') echo "activo";?>"><a href="index.php">Portada</a></li>
        <li class="<?php if(str_contains($url, '/juegAlmi/generos.php')) echo "activo";?>">
            <a href="#">Generos</a>
            <ul class="menuNivel2">
                <?php
                    include_once 'bbdd.php';
                    $todasCategorias = get_categorias();
                    $cantidadCategorias = sizeof($todasCategorias);
                    for($i = 0; $i < $cantidadCategorias; $i++)
                    {
                        echo "<li><a href='generos.php?idcategoria=".$todasCategorias[$i]['idCategoria']."'>".$todasCategorias[$i]['nombre']."</a></li>";
                    }
                ?>
            </ul>
        </li>
        <li class="<?php if($url == '/juegAlmi/recomendaciones.php') echo "activo";?>"><a href="recomendaciones.php">Recomendaciones</a></li>
        <li class="<?php if(str_contains($url, '/juegAlmi/login.php') || $url == '/juegAlmi/registro.php'|| $url == '/juegAlmi/gestionJuegos.php') echo "activo";?>">
            <?php
                if(isset($_SESSION['id_usuario']))
                {
                    echo $_SESSION['usuario'];
                    echo "<ul class='menuNivel2'>";
                        echo "<li><a href='gestionJuegos.php'>Gestión juegos</a></li>";
                        echo "<li><a href='cerrarSesion.php'>Cerrar sesión</a></li>";
                    echo "</ul>";
                } else
                {
                    echo "<a href='login.php'><img src='images/usuario.png' class='icono-menu'/>Login</a>";
                    echo "<ul class='menuNivel2'>";
                        echo "<li><a href='registro.php'>Registro</a></li>";
                    echo "</ul>";
                }
            ?>
            
        </li>
    </ul>
</nav>