<?php


class Pizza{
    public $_id;
    public $_sabor;
    public $_precio;
    public $_tipo;
    public $_cantidad;

    public function __construct($id=0,$sabor="",$precio=0,$tipo="",$cantidad=0)
    {
        if($id==0){
            $this->_id = Pizza::generarId();
        }else{
            $this->_id = $id;
        }
        $this->_sabor = $sabor;
        $this->_precio = $precio;
        $this->_tipo = $tipo;
        $this->_cantidad = $cantidad;
    }

    public static function generarId()
    {
        
        $idEnArchivo = -1;
        if(file_exists("./idAutoIncremental") && file_get_contents("./idAutoIncremental"))
        {
            $archivo = fopen("./idAutoIncremental","r");

            if($archivo != null){
                $idEnArchivo = fgets($archivo);
                $idEnArchivo = $idEnArchivo + 1;
                fclose($archivo);
                $archivo = fopen("./idAutoIncremental","w");
                fwrite($archivo,$idEnArchivo);
                fclose($archivo);
            }
        }
        else
        {
            $idEnArchivo = 1;
            $archivo = fopen("./idAutoIncremental","w");
            fwrite($archivo,$idEnArchivo);
        }
        
        return $idEnArchivo;
    }

    public function MostrarPizza(){
        return "$this->_id,$this->_sabor,$this->_precio,$this->_tipo,$this->_cantidad";
    }

    
    public static function buscarCoincidencia($array,$objetoRecibido){
    $posicionCoincidencia = -1;

        for($i=0;$i<count($array);$i++){
            if($array[$i]->_sabor == $$array[$i]->_sabor &&  $$array[$i]->_tipo == $$array[$i]->_tipo){
                $posicionCoincidencia = $i;
                break;
            }
        }
        return $posicionCoincidencia;
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
                    $pizza = new Pizza($objeto["_id"],$objeto["_sabor"],$objeto["_precio"],$objeto["_tipo"],$objeto["_cantidad"]);
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
            $arrayPizzas = Pizza::LeerPizzas();
        }
        if(!Pizza::buscarCoincidencia($arrayPizzas,$objeto)){
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

?>