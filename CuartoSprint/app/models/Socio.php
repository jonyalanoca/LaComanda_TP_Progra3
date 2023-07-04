<?php
    require_once './models/Personal.php';
    class Socio extends Personal{
        public $idSocio;
        public $recaudacion;
        public function  crearPersonal(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO socios (nombre, apellido, edad, dni, email, clave, recaudacion) VALUES (:nombre, :apellido, :edad, :dni, :email, :clave, :recaudacion)");
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
            $consulta->bindValue(':edad', $this->edad, PDO::PARAM_INT);
            $consulta->bindValue(':dni', $this->dni, PDO::PARAM_INT);
            $consulta->bindValue(':email', $this->email, PDO::PARAM_STR);
            $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
            $consulta->bindValue(':recaudacion', $this->recaudacion, PDO::PARAM_STR);

            $consulta->execute();
            return  $objAccesoDatos->obtenerUltimoId();
        }
        public static function obtenerUno($id){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM socios WHERE idSocio=:id");
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->execute();
            return $consulta->fetchObject('Socio');
        }
        public static function obtenerTodos(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM socios");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_CLASS, 'Socio');
        }
        public static function modificarPersonal($personal){
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("UPDATE socios SET nombre=:nombre, apellido=:apellido, edad=:edad, dni=:dni, email=:email, clave=:clave, recaudacion=:recaudacion WHERE idSocio = :id");
    
            $consulta->bindValue(':id', $personal->idSocio, PDO::PARAM_STR);
            $consulta->bindValue(':nombre', $personal->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':apellido', $personal->apellido, PDO::PARAM_STR);
            $consulta->bindValue(':edad', $personal->edad, PDO::PARAM_INT);
            $consulta->bindValue(':dni', $personal->dni, PDO::PARAM_INT);
            $consulta->bindValue(':email', $personal->email, PDO::PARAM_STR);
            $consulta->bindValue(':clave', $personal->clave, PDO::PARAM_STR);
            $consulta->bindValue(':recaudacion', $personal->recaudacion, PDO::PARAM_STR);
            $consulta->execute();
        }
        public static function eliminarPersonal($id){
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("DELETE FROM socios WHERE idSocio=:id");
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->execute();
        }
        public static function ObtenerSocioPorEmail($email){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM socios WHERE email=:email");
            $consulta->bindValue(':email', $email, PDO::PARAM_STR);
            $consulta->execute();
            return $consulta->fetchObject('Socio');
        }
        public static function Cobrar($id,$precio){
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("UPDATE socios SET  recaudacion=recaudacion + :precio WHERE idSocio = :id");
            $consulta->bindValue(":id",$id,PDO::PARAM_INT);
            $consulta->bindValue(':precio', $precio, PDO::PARAM_STR);
            $consulta->execute();
        }
    }
    

?>