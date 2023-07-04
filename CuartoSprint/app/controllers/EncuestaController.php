<?php
    require_once './models/Encuesta.php';
    require_once './models/Mesa.php';


    class EncuestaController extends Encuesta
    {
        public function CargarUno($request, $response, $args)
        {
            $parametros = $request->getParsedBody();
            $id_Mesa=$parametros['id_Mesa'];
            $id_Comanda=$parametros['id_Comanda'];
            $puntajeServicio = $parametros['puntajeServicio'];
            $comentario=$parametros['comentario'];

            Mesa::cambiarEstado($id_Mesa,"disponible");
            
            $nuevo=new Encuesta();
            $nuevo->id_Mesa=$id_Mesa;
            $nuevo->id_Comanda=$id_Comanda;
            $nuevo->puntajeServicio=$puntajeServicio;
            $nuevo->comentario=$comentario;
            $nuevo->crearEncuesta();

            $payload = json_encode(array("mensaje" => "Se creo la encuenta con exito."));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
        public function MejorEncuesta($request, $response, $args)
        {
            $respuesta=Encuesta::obtenerLaMejor();
            $payload = json_encode(array("La mejor comentario" => $respuesta));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

    }
?>