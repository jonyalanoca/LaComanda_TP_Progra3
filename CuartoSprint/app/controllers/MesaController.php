<?php
    require_once './models/Mesa.php';
    require_once './interfaces/IApiUsable.php';
    
    

    class MesaController extends Mesa implements IApiUsable
    {
        public function CargarUno($request, $response, $args)
        {
            $parametros = $request->getParsedBody();
            $nuevo = new Mesa();
            $nuevo->estado="disponible";
            $nuevo->crearMesa();
    
            $payload = json_encode(array("mensaje" => "Mesa creada con exito"));
    
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    
        public function TraerUno($request, $response, $args)
        {

            $id = $args['id'];
            $mesa = Mesa::obtenerUno($id);
            $payload = json_encode($mesa);
    
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
        public function TraerTodos($request, $response, $args)
        {
            $lista = Mesa::obtenerTodos();
            $payload = json_encode(array("ListaMesas" => $lista));

            $response->getBody()->write($payload);

            return $response->withHeader('Content-Type', 'application/json');
        }
        
        public function ModificarUno($request, $response, $args)
        {
            $id = $args['id'];
            $parametros = $request->getParsedBody();
            $mesa= new Mesa();
            $mesa->idMesa=$id;
            $mesa->estado=$parametros["estado"];
            Mesa::modificarMesa($mesa);

            $payload = json_encode(array("mensaje" => "Mesa modificada con exito"));

            $response->getBody()->write($payload);
            return $response
            ->withHeader('Content-Type', 'application/json');
        }

        public function BorrarUno($request, $response, $args)
        {
            $id = $args['id'];
            Mesa::eliminarMesa($id);

            $payload = json_encode(array("mensaje" => "Mesa borrada con exito"));

            $response->getBody()->write($payload);
            return $response
            ->withHeader('Content-Type', 'application/json');
        }
    }
?>