<?php
    class Producto{
        public $idProducto;
        public $nombre;
        public $precio;
        public $stock;
        public $seccion;
        public $tiempoPreparacion;
        public $descripcion;

        public function  crearProducto(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO productos (nombre,precio,stock,seccion,tiempoPreparacion,descripcion) VALUES (:nombre, :precio, :stock, :seccion, :tiempoPreparacion, :descripcion)");
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
            $consulta->bindValue(':stock', $this->stock, PDO::PARAM_INT);
            $consulta->bindValue(':seccion', $this->seccion, PDO::PARAM_STR);
            $consulta->bindValue(':tiempoPreparacion', $this->tiempoPreparacion, PDO::PARAM_INT);
            $consulta->bindValue(':descripcion', $this->descripcion, PDO::PARAM_STR);
            $consulta->execute();
            return  $objAccesoDatos->obtenerUltimoId();
        }
        public static function obtenerUno($id){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM productos WHERE idProducto=:id");
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->execute();
            return $consulta->fetchObject('Producto');
        }
        public static function obtenerTodos(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM productos");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_CLASS, 'Producto');
        }
        Public static function modificarProducto($producto){
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("UPDATE productos SET nombre=:nombre, precio=:precio, stock=:stock, seccion=:seccion, tiempoPreparacion=:tiempoPreparacion, descripcion=:descripcion WHERE idProducto = :id");
            $consulta->bindValue(":id",$producto->idProducto,PDO::PARAM_INT);
            $consulta->bindValue(':nombre', $producto->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $producto->precio, PDO::PARAM_STR);
            $consulta->bindValue(':stock', $producto->stock, PDO::PARAM_INT);
            $consulta->bindValue(':seccion', $producto->seccion, PDO::PARAM_STR);
            $consulta->bindValue(':tiempoPreparacion', $producto->tiempoPreparacion, PDO::PARAM_INT);
            $consulta->bindValue(':descripcion', $producto->descripcion, PDO::PARAM_STR);
            $consulta->execute();
        }
        public  static function eliminarProducto($id){
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("DELETE FROM productos WHERE idProducto=:id");
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->execute();
        }
        public static function ObtenerIds(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idProducto FROM productos");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_COLUMN, 0);
        }
    }
    

?>