<?php

require_once "Pizza.php";

$sabor = isset($_POST["sabor"]) ? $_POST["sabor"] : null;
$tipo = $_POST["tipo"] ? $_POST["tipo"] : null;

$objAux = new Pizza(0,$sabor,0,$tipo,0);

var_dump($objAux);


$array = Pizza::LeerPizzas();

if(Pizza::buscarCoincidencia($array,$objAux))











?>