<?php

    function conectarBBDD()
    {
        // Configuración: ajusta estos datos si tu servidor MySQL usa otros credenciales
        $host = 'localhost';
        $user = 'root';
        $pass = '';
        $db = 'Sport';

        $mysqli = @new mysqli($host, $user, $pass, $db);
        if($mysqli->connect_errno)
        {
            // Mensaje más descriptivo
            $mensaje = "Fallo en la conexión: ({$mysqli->connect_errno}) {$mysqli->connect_error}";
            echo $mensaje;
            error_log("[bbdd.php] " . $mensaje);
            return false;
        }

        // Usar modo estricto puede ayudar a detectar errores durante el desarrollo
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        return $mysqli;
    }

    function get_categorias()
    {
        $mysqli = conectarBBDD();
        if(!$mysqli) return array();

        $codigoSentencia = "SELECT * FROM categoria";
        $sentencia = $mysqli->prepare($codigoSentencia);
        if(!$sentencia)
        {
            echo "Fallo en la preparacion de la sentencia: {$mysqli->error}";
        }

        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion de la sentencia: {$mysqli->error}";
        }

        $id = -1;
        $nombre = "";

        $vincular = $sentencia->bind_result($id, $nombre);
        if(!$vincular)
        {
            echo "Fallo al asociar variables: {$mysqli->error}";
        }

        $categorias = array();
        
        while($sentencia->fetch())
        {
            $categoria = array(
                'idCategoria' => $id,
                'nombre' => $nombre
            );
            $categorias[] = $categoria;
        }

        $mysqli->close();
        return $categorias;
    }

    function get_juegos_categoria($id_cat)
    {
        $mysqli = conectarBBDD();

        if(!$mysqli) return array();

        // En la BD la tabla 'juego' almacena la categoría como texto en la columna 'categoria'.
        // Hacemos JOIN con categoria por nombre para obtener el idCategoria
        $codigoSentencia = "SELECT juego.id_juego, juego.nombre AS titulo, juego.description AS descripcion, juego.precio, categoria.idCategoria
                    FROM juego
                    INNER JOIN categoria ON juego.categoria = categoria.nombre
                    WHERE categoria.idCategoria = ?";
        $sentencia = $mysqli->prepare($codigoSentencia);
        if(!$sentencia)
        {
            echo "Fallo en la preparacion de la sentencia: {$mysqli->error}";
        }
        $asignar = $sentencia->bind_param("i", $id_cat);
        if(!$asignar)
        {
           echo "Fallo al asignar parámetros: {$mysqli->error}"; 
        }

        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion de la sentencia: {$mysqli->error}";
        }

        $id_juego = -1;
        $titulo = "";
        $descripcion = "";
        $precio = "";
        $id_categoria = -1;

        $vincular = $sentencia->bind_result($id_juego, $titulo, $descripcion, $precio, $id_categoria);
        if(!$vincular)
        {
            echo "Fallo al asociar variables: {$mysqli->error}";
        }

        $juegos = array();
        
        while($sentencia->fetch())
        {
            $juego = array(
                'idJuego' => $id_juego,
                'titulo' => $titulo,
                'descripcion' => $descripcion,
                'precio' => $precio,
                'imagen' => '', // en la BD actual no existe columna imagen
                'enlace' => '', // en la BD actual no existe columna enlace
                'idCategoria' => $id_categoria
            );
            $juegos[] = $juego;
        }

        $mysqli->close();
        return $juegos;
    }

    function get_juego_by_id($idjuego)
    {
        $mysqli = conectarBBDD();

        if(!$mysqli) return array();

        // Obtener juego y el id de categoria (si existe) usando el nombre de categoría almacenada en Juego.categoria
        $codigoSentencia = "SELECT juego.id_juego, juego.nombre AS titulo, juego.description AS descripcion, juego.precio, juego.categoria, categoria.idCategoria
                    FROM juego
                    LEFT JOIN categoria ON juego.categoria = categoria.nombre
                    WHERE juego.id_juego = ?";
        $sentencia = $mysqli->prepare($codigoSentencia);
        if(!$sentencia)
        {
            echo "Fallo en la preparacion de la sentencia: {$mysqli->error}";
        }

        $asignar = $sentencia->bind_param("i", $idjuego);
          if(!$asignar)
          {
              echo "Fallo al asignar parámetros: {$mysqli->error}"; 
          }

        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion de la sentencia: {$mysqli->error}";
        }

        $id_juego = -1;
        $titulo = "";
        $descripcion = "";
        $precio = "";
        $categoriaNombre = "";
        $id_categoria = null;

        $vincular = $sentencia->bind_result($id_juego, $titulo, $descripcion, $precio, $categoriaNombre, $id_categoria);
        if(!$vincular)
        {
            echo "Fallo al asociar variables: {$mysqli->error}";
        }

        $juego = array();
        
        if($sentencia->fetch())
        {
            $juego = array(
                'idJuego' => $id_juego,
                'titulo' => $titulo,
                'descripcion' => $descripcion,
                'precio' => $precio,
                'imagen' => '',
                'enlace' => '',
                'idCategoria' => $id_categoria
            );
        }

        $mysqli->close();
        return $juego;

    }

    function get_categoria_by_id($idcategoria)
    {
        $mysqli = conectarBBDD();

        $codigoSentencia = "SELECT * FROM categoria WHERE idCategoria = ?";
        $sentencia = $mysqli->prepare($codigoSentencia);
        if(!$sentencia)
        {
            echo "Fallo en la preparacion de la sentencia: {$mysqli->error}";
        }

        $asignar = $sentencia->bind_param("i", $idcategoria);
        if(!$asignar)
        {
           echo "Fallo al asignar parámetros: {$mysqli->error}"; 
        }

        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion de la sentencia: {$mysqli->error}";
        }

        $id_categoria = -1;
        $nombre = "";

        $vincular = $sentencia->bind_result($id_categoria, $nombre);
        if(!$vincular)
        {
            echo "Fallo al asociar variables: {$mysqli->error}";
        }

        $categoria = array();
        
        if($sentencia->fetch())
        {
            $categoria = array(
                'idCategoria' => $id_categoria,
                'nombre' => $nombre
            );
        }

        $mysqli->close();
        return $categoria;

    }

    function get_juegos_y_categoria($id_cat)
    {
        $mysqli = conectarBBDD();
        if(!$mysqli) return array();

        // Adaptar a la estructura real: Juego.categoria contiene el nombre de la categoría
        $codigoSentencia = "SELECT juego.id_juego, juego.nombre AS titulo, juego.description AS descripcion, juego.precio, '' AS imagen, '' AS enlace, categoria.nombre
                    FROM juego
                    INNER JOIN categoria ON juego.categoria = categoria.nombre
                            WHERE categoria.idCategoria = ?";
        $sentencia = $mysqli->prepare($codigoSentencia);
        if(!$sentencia)
        {
            echo "Fallo en la preparacion de la sentencia: {$mysqli->error}";
        }

        $asignar = $sentencia->bind_param("i", $id_cat);
        if(!$asignar)
        {
           echo "Fallo al asignar parámetros: {$mysqli->error}"; 
        }

        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion de la sentencia: {$mysqli->error}";
        }

        $id_juego = -1;
        $titulo = "";
        $descripcion = "";
        $precio = "";
        $imagen = "";
        $enlace = "";
        $nombre_cat = "";

        $vincular = $sentencia->bind_result($id_juego, $titulo, $descripcion, $precio, $imagen, $enlace, $nombre_cat);
        if(!$vincular)
        {
            echo "Fallo al asociar variables: {$mysqli->error}";
        }

        $juegos = array();

        while($sentencia->fetch())
        {
            $juego = array(
                'idJuego' => $id_juego,
                'titulo' => $titulo,
                'descripcion' => $descripcion,
                'precio' => $precio,
                'imagen' => $imagen,
                'enlace' => $enlace,
                'nombre_categoria' => $nombre_cat
            );
            $juegos[] = $juego;
        }

        $mysqli->close();
        return $juegos;
    }

    function get_all_juegos_y_categoria()
    {
        $mysqli = conectarBBDD();
        if(!$mysqli) return array();

        $codigoSentencia = "SELECT juego.id_juego, juego.nombre AS titulo, juego.description AS descripcion, juego.precio, '' AS imagen, '' AS enlace, categoria.nombre
                    FROM juego
                    INNER JOIN categoria ON juego.categoria = categoria.nombre";
        $sentencia = $mysqli->prepare($codigoSentencia);
        if(!$sentencia)
        {
            echo "Fallo en la preparacion de la sentencia: {$mysqli->error}";
        }

        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion de la sentencia: {$mysqli->error}";
        }

        $id_juego = -1;
        $titulo = "";
        $descripcion = "";
        $precio = -1;
        $imagen = "";
        $enlace = "";
        $nombre_cat = "";

        $vincular = $sentencia->bind_result($id_juego, $titulo, $descripcion, $precio, $imagen, $enlace, $nombre_cat);
        if(!$vincular)
        {
            echo "Fallo al asociar variables: {$mysqli->error}";
        }

        $juegos = array();

        while($sentencia->fetch())
        {
            $juego = array(
                'idJuego' => $id_juego,
                'titulo' => $titulo,
                'descripcion' => $descripcion,
                'precio' => $precio,
                'imagen' => $imagen,
                'enlace' => $enlace,
                'nombre_categoria' => $nombre_cat
            );
            $juegos[] = $juego;
        }

        $mysqli->close();
        return $juegos;
    }

    function login($user, $password)
    {
        $mysqli = conectarBBDD();
        if(!$mysqli) return array();

        $codigoSentencia = "SELECT id_usuario, usuario FROM Usuario WHERE usuario= ? AND password= ? ";

        $sentencia = $mysqli->prepare($codigoSentencia);
        if(!$sentencia)
        {
            echo "Fallo en la preparacion de la sentencia: {$mysqli->error}";
        }

        $asignar = $sentencia->bind_param("ss", $user, $password);
        if(!$asignar)
        {
           echo "Fallo al asignar parámetros: {$mysqli->error}"; 
        }

        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion de la sentencia: {$mysqli->error}";
        }

        $id_usuario = -1;
        $usuario = "";

        $vincular = $sentencia->bind_result($id_usuario, $usuario);
        if(!$vincular)
        {
            echo "Fallo al asociar variables: {$mysqli->error}";
        }

        $usu = array();
        if($sentencia->fetch())
        {
            $usu = array(
                'id_usuario' => $id_usuario,
                'usuario' => $usuario
            );
        }

        $mysqli->close();
        return $usu;
    }

    function insertarUsuario($nombre, $user, $password)
    {
        $mysqli = conectarBBDD();
        if(!$mysqli) return false;

        $codigoSentencia = "INSERT INTO Usuario(nombre, usuario, password) VALUES (?, ?, ?)";

        $sentencia = $mysqli->prepare($codigoSentencia);
        if(!$sentencia)
        {
            echo "Fallo en la preparacion de la sentencia: {$mysqli->error}";
        }

        $asignar = $sentencia->bind_param("sss", $nombre, $user, $password);
        if(!$asignar)
        {
           echo "Fallo al asignar parámetros: {$mysqli->error}"; 
        }

        $resultado = $sentencia->execute();
        if(!$resultado)
        {
            echo "Fallo en la ejecucion de la sentencia: {$mysqli->error}";
        }

        $mysqli->close();

        return $resultado;
    }

    function insertarJuego($titulo, $description, $precio, $idCategoria)
    {
        $mysqli = conectarBBDD();
        if(!$mysqli) return false;

        // Obtener el nombre de la categoría a partir del id
        $categoria = get_categoria_by_id(intval($idCategoria));
        $categoriaNombre = $categoria['nombre'] ?? null;
        if(!$categoriaNombre) {
            echo "Fallo: categoría no encontrada.";
            return false;
        }

        $sql = "INSERT INTO juego (nombre, categoria, description, precio) VALUES (?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        if(!$stmt) {
            echo "Fallo en la preparacion de la sentencia: {$mysqli->error}";
            return false;
        }

        $precioFloat = floatval($precio);
        $bind = $stmt->bind_param('sssd', $titulo, $categoriaNombre, $description, $precioFloat);
        if(!$bind) {
            echo "Fallo al asignar parámetros: {$mysqli->error}";
            return false;
        }

        $exec = $stmt->execute();
        if(!$exec) {
            echo "Fallo en la ejecucion de la sentencia: {$stmt->error}";
            return false;
        }

        $stmt->close();
        $mysqli->close();
        return true;
    }

    function eliminarJuego($idJuego)
    {
        $mysqli = conectarBBDD();
        if(!$mysqli) return false;

        $id = intval($idJuego);
        if($id <= 0) return false;

        $sql = "DELETE FROM juego WHERE id_juego = ?";
        $stmt = $mysqli->prepare($sql);
        if(!$stmt) {
            echo "Fallo en la preparacion de la sentencia: {$mysqli->error}";
            return false;
        }

        $bind = $stmt->bind_param('i', $id);
        if(!$bind) {
            echo "Fallo al asignar parámetros: {$mysqli->error}";
            return false;
        }

        $exec = $stmt->execute();
        if(!$exec) {
            echo "Fallo en la ejecucion de la sentencia: {$stmt->error}";
            return false;
        }

        $stmt->close();
        $mysqli->close();
        return true;
    }
?>