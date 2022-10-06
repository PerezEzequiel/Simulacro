<?php

require_once "./Pizza.php";


$pizza = new Pizza(0,$_GET["sabor"],$_GET["precio"],$_GET["tipo"],$_GET["cantidad"]);
if(Pizza::CargarPizza($pizza)){
    echo "Se cargo correctamente";
}


?>