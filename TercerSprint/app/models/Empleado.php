<?php
    require_once './models/Personal.php';
    class Empleado extends Personal{
        public $idEmpleado;
        public $seccion;
        public $sueldo;
        public $fechaIngreso;
        public $fechaEgreso;
        public $estado;
        public function  crearPersonal(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO empleados (nombre, apellido, edad, dni, email, clave, seccion, sueldo, fechaIngreso, fechaEgreso, estado) VALUES (:nombre, :apellido, :edad, :dni, :email, :clave, :seccion, :sueldo, :fechaIngreso, :fechaEgreso, :estado)");
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
            $consulta->bindValue(':edad', $this->edad, PDO::PARAM_INT);
            $consulta->bindValue(':dni', $this->dni, PDO::PARAM_INT);
            $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
            $consulta->bindValue(':seccion', $this->seccion, PDO::PARAM_STR);
            $consulta->bindValue(':sueldo', $this->sueldo, PDO::PARAM_INT);
            $consulta->bindValue(':email', $this->email, PDO::PARAM_STR);
            $consulta->bindValue(':fechaIngreso', $this->fechaIngreso, PDO::PARAM_STR);
            $consulta->bindValue(':fechaEgreso', $this->fechaEgreso, PDO::PARAM_STR);
            $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
            $consulta->execute();
            return  $objAccesoDatos->obtenerUltimoId();
        }
        public static function obtenerUno($id){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM empleados WHERE idEmpleado=:id");
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->execute();
            return $consulta->fetchObject('Empleado');
        }
        public static function obtenerTodos(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM empleados");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_CLASS, 'Empleado');
        }
        public static function modificarPersonal($personal){
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("UPDATE empleados SET nombre=:nombre, apellido=:apellido, edad=:edad, dni=:dni, email=:email, clave=:clave, seccion=:seccion, sueldo=:sueldo, fechaIngreso=:fechaIngreso, fechaEgreso=:fechaEgreso, estado=:estado WHERE idEmpleado = :id");
            $consulta->bindValue(':nombre', $personal->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':apellido', $personal->apellido, PDO::PARAM_STR);
            $consulta->bindValue(':edad', $personal->edad, PDO::PARAM_INT);
            $consulta->bindValue(':dni', $personal->dni, PDO::PARAM_INT);
            $consulta->bindValue(':clave', $personal->clave, PDO::PARAM_STR);
            $consulta->bindValue(':seccion', $personal->seccion, PDO::PARAM_STR);
            $consulta->bindValue(':sueldo', $personal->sueldo, PDO::PARAM_INT);
            $consulta->bindValue(':email', $personal->email, PDO::PARAM_STR);
            $consulta->bindValue(':fechaIngreso', $personal->fechaIngreso, PDO::PARAM_STR);
            $consulta->bindValue(':fechaEgreso', $personal->fechaEgreso, PDO::PARAM_STR);
            $consulta->bindValue(':estado', $personal->estado, PDO::PARAM_STR);
            $consulta->bindValue(":id",$personal->idEmpleado,PDO::PARAM_INT);
            $consulta->execute();
        }
        public static function eliminarPersonal($id){
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("DELETE FROM empleados WHERE idEmpleado=:id");
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->execute();
        }
        public static function ObtenerIds(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idEmpleado FROM empleados");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_COLUMN, 0);
        }
        public static function ObtenerEmpleadoPorEmail($email){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM empleados WHERE email=:email");
            $consulta->bindValue(':email', $email, PDO::PARAM_STR);
            $consulta->execute();
            return $consulta->fetchObject('Empleado');
        }
    }
    

?>