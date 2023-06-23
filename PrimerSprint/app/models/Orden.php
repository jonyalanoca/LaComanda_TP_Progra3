<?php
    class Orden{
        public $idOrden;
        public $id_Comanda;
        public $id_Producto;
        public function  crearOrden(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO ordenes (id_Comanda,id_Producto) VALUES (:id_Comanda,:id_Producto)");
            $consulta->bindValue(':id_Comanda', $this->id_Comanda, PDO::PARAM_INT);
            $consulta->bindValue(':id_Producto', $this->id_Producto, PDO::PARAM_INT);
            $consulta->execute();
            return  $objAccesoDatos->obtenerUltimoId();
        }
        public static function obtenerUno($id){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM ordenes WHERE idOrden=:id");
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->execute();
            return $consulta->fetchObject('Orden');
        }
        public static function obtenerTodos(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM ordenes");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_CLASS, 'Orden');
        }
        public static function modificarOrden($orden){
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("UPDATE ordenes SET id_Comanda=:id_Comanda,id_Producto=:id_Producto WHERE idOrden = :id");
            $consulta->bindValue(':id_Comanda', $orden->id_Comanda, PDO::PARAM_INT);
            $consulta->bindValue(':id_Producto', $orden->id_Producto, PDO::PARAM_INT);
            $consulta->bindValue(":id",$orden->idOrden,PDO::PARAM_INT);
            $consulta->execute();
        }
        public static function eliminarOrden($id){
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("DELETE FROM ordenes WHERE idOrden=:id");
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->execute();
        }
    }
    

?>