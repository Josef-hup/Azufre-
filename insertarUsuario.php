<?php
    $nombre = $_POST['name'];
    $user = $_POST['user'];
    $password = $_POST['password'];
    include_once 'bbdd.php';

    $result = insertarUsuario($nombre, $user, $password);
    
    header("location: login.php");
?>