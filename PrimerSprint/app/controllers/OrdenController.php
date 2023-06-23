<?php
    require_once './models/Orden.php';
    require_once './interfaces/IApiUsable.php';

    class OrdenController extends Orden implements IApiUsable
    {
        public function CargarUno($request, $response, $args)
        {
            $parametros = $request->getParsedBody();
            $id_Comanda=$parametros['id_Comanda'];
            $id_Producto=$parametros['id_Producto'];

            $nuevo = new Orden();
            $nuevo->id_Comanda=$id_Comanda;
            $nuevo->id_Producto=$id_Producto;

            $nuevo->crearOrden();
    
            $payload = json_encode(array("mensaje" => "Orden creada con exito"));
    
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    
        public function TraerUno($request, $response, $args)
        {
            $id = $args['id'];
            $mesa = Orden::obtenerUno($id);
            $payload = json_encode($mesa);
    
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
        public function TraerTodos($request, $response, $args)
        {
            $lista = Orden::obtenerTodos();
            $payload = json_encode(array("ListaOrden" => $lista));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
        
        public function ModificarUno($request, $response, $args)
        {
            $id = $args['id'];
            $parametros = $request->getParsedBody();
            $id_Comanda=$parametros['id_Comanda'];
            $id_Producto=$parametros['id_Producto'];

            $nuevo = new Orden();
            $nuevo->idOrden=$id;
            $nuevo->id_Comanda=$id_Comanda;
            $nuevo->id_Producto=$id_Producto;

            Orden::modificarOrden($nuevo);

            $payload = json_encode(array("mensaje" => "Orden modificada con exito"));

            $response->getBody()->write($payload);
            return $response
            ->withHeader('Content-Type', 'application/json');
        }

        public function BorrarUno($request, $response, $args)
        {
            $id = $args['id'];
            Orden::eliminarOrden($id);

            $payload = json_encode(array("mensaje" => "ORden borrada con exito"));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>