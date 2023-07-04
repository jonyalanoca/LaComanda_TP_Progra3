<?php
    class Orden{
        public $idOrden;
        public $id_Comanda;
        public $id_Producto;
        public $tiempoEstimado;
        public $estado;
        public function  crearOrden(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO ordenes (id_Comanda,id_Producto, estado) VALUES (:id_Comanda,:id_Producto, :estado)");
            $consulta->bindValue(':id_Comanda', $this->id_Comanda, PDO::PARAM_INT);
            $consulta->bindValue(':id_Producto', $this->id_Producto, PDO::PARAM_INT);
            $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
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
            $consulta = $objAccesoDato->prepararConsulta("UPDATE ordenes SET id_Comanda=:id_Comanda,id_Producto=:id_Producto, tiempoEstimado=:tiempoEstimado, estado=:estado WHERE idOrden = :id");
            $consulta->bindValue(':id_Comanda', $orden->id_Comanda, PDO::PARAM_INT);
            $consulta->bindValue(':id_Producto', $orden->id_Producto, PDO::PARAM_INT);
            $consulta->bindValue(":id",$orden->idOrden,PDO::PARAM_INT);
            $consulta->bindValue(':tiempoEstimado', $orden->tiempoEstimado, PDO::PARAM_INT);
            $consulta->bindValue(':estado', $orden->estado, PDO::PARAM_STR);
            $consulta->execute();
        }
        public static function modificarOrdenEstado($id, $estado){
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("UPDATE ordenes SET  estado=:estado WHERE idOrden = :id");
            $consulta->bindValue(":id",$id,PDO::PARAM_INT);
            $consulta->bindValue(':estado', $estado, PDO::PARAM_STR);
            $consulta->execute();
        }
        public static function modificarOrdenTiempo($id, $tiempoEstimado){
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("UPDATE ordenes SET  tiempoEstimado=:tiempoEstimado WHERE idOrden = :id");
            $consulta->bindValue(":id",$id,PDO::PARAM_INT);
            $consulta->bindValue(':tiempoEstimado', $tiempoEstimado, PDO::PARAM_STR);
            $consulta->execute();
        }
        
        public static function eliminarOrden($id){
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("DELETE FROM ordenes WHERE idOrden=:id");
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->execute();
        }

        public static function cambiarEstadosPagado($id){
           
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("UPDATE ordenes set estado = 'pagado' WHERE id_Comanda = :id and estado = 'servido'");
            $consulta->bindValue(':id',$id, PDO::PARAM_INT);
            $consulta->execute();
        }
        public static function informe(){
           
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("SELECT ordenes.id_Producto, COUNT(*) AS contador FROM ordenes
            INNER JOIN comandas ON ordenes.id_Comanda = comandas.idComanda
            WHERE comandas.fechaHora >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
            GROUP BY ordenes.id_Producto
            ORDER BY contador DESC
            LIMIT 3");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
        public static function fallidas(){
           
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("SELECT
            ordenes.idOrden,
            ordenes.id_Comanda,
            ordenes.id_Producto,
            ordenes.tiempoEstimado,
            ordenes.estado
            FROM ordenes
            INNER JOIN comandas ON comandas.idComanda = ordenes.id_Comanda
            WHERE comandas.estado = 'pagado' AND ordenes.estado != 'pagado'");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }


    }
    

?>