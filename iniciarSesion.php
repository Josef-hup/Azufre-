<?php
    session_start();

    include_once 'bbdd.php';
    $usu = login($_POST['user'], $_POST['password']);
    $login_correcto = isset($usu['id_usuario']);
    if($login_correcto)
    {
        //Sesión iniciada
        $_SESSION['id_usuario'] = $usu['id_usuario'];
        $_SESSION['usuario'] = $usu['usuario'];

        header("location: index.php");
    } else
    {
        //Usuario incorrecto
        header("location: login.php?loginIncorrecto=1");
    }
?>
