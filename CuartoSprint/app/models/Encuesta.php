<?php
class Encuesta
{
    public $idEncuesta;
    public $id_Mesa;
    public $id_Comanda;
    public $puntajeServicio;
    public $comentario;

    public function crearEncuesta()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO encuestas (id_Mesa, id_Comanda, puntajeServicio, comentario)
        VALUES (:id_Mesa, :id_Comanda, :puntajeServicio, :comentario)");
        $consulta->bindValue(':id_Mesa', $this->id_Mesa, PDO::PARAM_INT);
        $consulta->bindValue(':id_Comanda', $this->id_Comanda, PDO::PARAM_INT);
        $consulta->bindValue(':puntajeServicio', $this->puntajeServicio, PDO::PARAM_INT);
        $consulta->bindValue(':comentario', $this->comentario, PDO::PARAM_STR);
        $consulta->execute();
    
        return $objAccesoDatos->obtenerUltimoId();
    }
    public static function obtenerLaMejor()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT comentario from encuestas ORDER BY puntajeServicio DESC LIMIT 1");
        $consulta->execute();
    
        return  $consulta->fetchColumn();
    }
}