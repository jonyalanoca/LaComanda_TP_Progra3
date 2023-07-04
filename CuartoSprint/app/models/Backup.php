<?php
    class Csv{
        public static function GuardarCsv($nombreArchivo,$objetos){
            // $objAccesoDatos = AccesoDatos::obtenerInstancia(); 

            $nombreCarpeta="./downloads/csv";
            if(!file_exists($nombreCarpeta)){
                mkdir($nombreCarpeta, 0777, true);
            }
            $pathCompleto=$nombreCarpeta."/".$nombreArchivo;

            $archivo = fopen($pathCompleto, 'w');
            fputcsv($archivo, array_keys(get_object_vars($objetos[0])));

            foreach ($objetos as $objeto) {
                fputcsv($archivo, array_values(get_object_vars($objeto)));
            }
            fclose($archivo);
        }
        public static function LeerCsv($nombreArchivo){
            // $objAccesoDatos = AccesoDatos::obtenerInstancia();

            $nombreCarpeta="./downloads/csv";
            $pathCompleto=$nombreCarpeta."/".$nombreArchivo;

            $auxArray=array();
            if(file_exists($pathCompleto)){
                $archivo = fopen($pathCompleto, 'r');
                $aux=fgetcsv($archivo);
                while(is_array($lineaCsv=fgetcsv($archivo))){
                    array_push($auxArray,$lineaCsv);
                }
                fclose($archivo);
                return $auxArray;
            }
            return null;
        }

    }
    
?>