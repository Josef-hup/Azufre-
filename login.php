<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuegAlmi</title>
    <meta name="description" content="Página de una tienda de videojuegos" />
    <meta name="keywords" content="tienda,videojuegos,bilbao" />

    <link rel="stylesheet" href="css/styleFlex.css" />
    <link rel="stylesheet" href="css/login.css" />
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
        <h2>Login</h2>
        <?php
            if(isset($_GET['loginIncorrecto']))
            {
                echo "<p>El usuario o la contraseña no son correctos</p>";
            }
        ?>
        <form id="formulario" action="iniciarSesion.php" method="post">
            <div class="parFormulario">
                <label for="user">Usuario:</label>
                <input type="text" id="user" name="user" placeholder="Escriba su usuario"/>
            </div>
            <div class="parFormulario">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" placeholder="Escriba su contraseña"/>
            </div>
            <input type="submit" id="enviar" value="Enviar"/>
        </form>
    </main> 
    
    
    <footer>
        <a href="#">Sobre nosotros</a>
        <a href="#">Condiciones legales</a>
        <a href="#">Contacto</a>
    </footer>
</body>
</html>