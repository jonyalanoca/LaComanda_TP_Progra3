<?php
    class Imagen{
        public static function Guardar($nombreArchivo,$binario){
            $nombreCarpeta="./downloads/fotoMesa";
            if(!file_exists($nombreCarpeta)){
                mkdir($nombreCarpeta, 0777, true);
            }
            $pathCompleto=$nombreCarpeta."/".$nombreArchivo;

            file_put_contents($pathCompleto, $binario);
            return $pathCompleto;
        }
    }
?>