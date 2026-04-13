<?php
include_once 'bbdd.php';

// Probar get_categorias
echo "Categorias:\n";
$cats = get_categorias();
var_dump($cats);

echo "\nTodos juegos con categoria:\n";
$juegos = get_all_juegos_y_categoria();
var_dump(array_slice($juegos,0,5));

echo "\nJuegos de la primera categoria (si existe):\n";
if(count($cats) > 0){
    $id = $cats[0]['idCategoria'];
    $jg = get_juegos_y_categoria($id);
    var_dump($jg);
}

echo "\nJuego por id 1:\n";
$j = get_juego_by_id(1);
var_dump($j);
?>