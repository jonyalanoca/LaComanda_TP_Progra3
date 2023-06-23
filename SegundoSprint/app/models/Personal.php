<?php
    abstract class Personal{
        public $nombre;
        public $apellido;
        public $edad;
        public $dni;
        public $email;
        public $clave;

        abstract public function  crearPersonal();
        abstract public static function obtenerUno($id);
        abstract public static function obtenerTodos();
        abstract public static function modificarPersonal($personal);
        abstract public static function eliminarPersonal($id);
    }
?>