<?php


class Pizza{
    public $_id;
    public $_sabor;
    public $_precio;
    public $_tipo;
    public $_cantidad;

    public function __construct($sabor,$precio,$tipo,$cantidad,$id="")
    {
        if($id==""){
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
}

?>