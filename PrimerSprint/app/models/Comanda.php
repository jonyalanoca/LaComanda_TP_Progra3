<?php
    class Comanda{
        public $idComanda;
        public $id_Mesa;
        public $id_Empleado;
        public $nombreCliente;
        public $fotoMesa;
        public $fechaHora;
        public $observacion;
        public function  crearComanda(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO comandas (id_Mesa,id_Empleado,nombreCliente,fotoMesa,fechaHora,observacion) VALUES (:id_Mesa,:id_Empleado,:nombreCliente,:fotoMesa,:fechaHora,:observacion)");
            $consulta->bindValue(':id_Mesa', $this->id_Mesa, PDO::PARAM_INT);
            $consulta->bindValue(':id_Empleado', $this->id_Empleado, PDO::PARAM_INT);
            $consulta->bindValue(':nombreCliente', $this->nombreCliente, PDO::PARAM_STR);
            $consulta->bindValue(':fotoMesa', $this->fotoMesa, PDO::PARAM_STR);
            $consulta->bindValue(':fechaHora', $this->fechaHora, PDO::PARAM_STR);
            $consulta->bindValue(':observacion', $this->observacion, PDO::PARAM_STR);
            $consulta->execute();
            return  $objAccesoDatos->obtenerUltimoId();
        }
        public static function obtenerUno($id){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM comandas WHERE idComanda=:id");
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->execute();
            return $consulta->fetchObject('Comanda');
        }
        public static function obtenerTodos(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM comandas");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_CLASS, 'Comanda');
        }
        public static function modificarComanda($comanda){
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("UPDATE comandas SET id_Mesa=:id_Mesa,id_Empleado=:id_Empleado,nombreCliente=:nombreCliente,fotoMesa=:fotoMesa,fechaHora=:fechaHora,observacion=:observacion WHERE idComanda = :id");
            $consulta->bindValue(':id_Mesa', $comanda->id_Mesa, PDO::PARAM_INT);
            $consulta->bindValue(':id_Empleado', $comanda->id_Empleado, PDO::PARAM_INT);
            $consulta->bindValue(':nombreCliente', $comanda->nombreCliente, PDO::PARAM_STR);
            $consulta->bindValue(':fotoMesa', $comanda->fotoMesa, PDO::PARAM_STR);
            $consulta->bindValue(':fechaHora', $comanda->fechaHora, PDO::PARAM_STR);
            $consulta->bindValue(':observacion', $comanda->observacion, PDO::PARAM_STR);
            $consulta->bindValue(":id",$comanda->idComanda,PDO::PARAM_INT);
            $consulta->execute();
        }
        public static function eliminarComanda($id){
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("DELETE FROM comandas WHERE idComanda=:id");
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->execute();
        }
    }
    

?>