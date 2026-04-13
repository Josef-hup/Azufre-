<?php
session_start();
// Solo usuarios autenticados (y administradores) deberían poder eliminar
if(!isset($_SESSION['id_usuario'])){
    header('Location: login.php');
    exit;
}

include_once 'bbdd.php';

$id = intval($_GET['idjuego'] ?? 0);
if($id <= 0){
    header('Location: gestionJuegos.php');
    exit;
}
// Realizar la eliminación
$ok = eliminarJuego($id);

// Redirigir de vuelta con indicador opcional
if($ok){
    header('Location: gestionJuegos.php?msg=deleted');
} else {
    header('Location: gestionJuegos.php?msg=error');
}
exit;

?>