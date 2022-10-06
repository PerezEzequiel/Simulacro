<?php

require_once "./Pizza.php";

class PizzaCarga{


    
    //.Sí el sabor y tipo ya existen , se actualiza el precio y se suma al stock existente.


    private static function buscarCoincidencia($array,$objetoRecibido){
        $seEncuentraEnLista = false;
        foreach($array as $objetosDeLaLista){
            if($objetosDeLaLista->_sabor == $objetoRecibido->_sabor &&  $objetosDeLaLista->_tipo == $objetoRecibido->_tipo){
                $objetosDeLaLista->_precio += $objetoRecibido->_precio;
                $objetosDeLaLista->_cantidad += $objetoRecibido->_cantidad;
                $seEncuentraEnLista = true;
                break;
            }
        }
        return $seEncuentraEnLista;
    }

    public static function LeerPizzas(){
        $lectura = "";       
        $archivo  = fopen("./Pizza.json","r");
        $arrayPizzas = array();
        if($archivo != null){
            $lectura = fread($archivo,filesize("./Pizza.json"));
            if($lectura != ""){
                $jsonDecode = json_decode($lectura,true);
                foreach($jsonDecode as $objeto){
                    $pizza = new Pizza($objeto["_sabor"],$objeto["_precio"],$objeto["_tipo"],$objeto["_cantidad"],$objeto["_id"]);
                    array_push($arrayPizzas,$pizza);
                }
            }
        }
        return $arrayPizzas;
    }

    public static function CargarPizza($objeto){

        $exito = false;
        $arrayPizzas = array();

        if(file_exists("./Pizza.json")){
            $arrayPizzas = PizzaCarga::LeerPizzas();
        }
        if(!PizzaCarga::buscarCoincidencia($arrayPizzas,$objeto)){
            array_push($arrayPizzas,$objeto);
        }
        
        $jsonEncode = json_encode($arrayPizzas,JSON_PRETTY_PRINT);
        
        if($jsonEncode != false){
            $archivo = fopen("./Pizza.json","w");
    
            if($archivo != null && fwrite($archivo,$jsonEncode)>0)
            {
                echo "ENTRE";
                $exito = true;
            }
        }
        
        return $exito;
    }



}

$pizza = new Pizza($_GET["sabor"],$_GET["precio"],$_GET["tipo"],$_GET["cantidad"]);
if(PizzaCarga::CargarPizza($pizza)){
    echo "Se cargo correctamente";
}


?>