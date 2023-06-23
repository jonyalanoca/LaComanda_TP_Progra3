<?php
    require_once './models/Orden.php';
    require_once './interfaces/IApiUsable.php';
    require_once './models/Producto.php';

    class OrdenController extends Orden implements IApiUsable
    {
        public function CargarUno($request, $response, $args)
        {
            $parametros = $request->getParsedBody();
            $id_Comanda=$parametros['id_Comanda'];
            $id_Producto=$parametros['id_Producto'];
            $tiempoEstimado=$parametros["tiempoEstimado"];

            $nuevo = new Orden();
            $nuevo->id_Comanda=$id_Comanda;
            $nuevo->id_Producto=$id_Producto;
            $nuevo->tiempoEstimado=$tiempoEstimado;
            $nuevo->estado="pendiente";

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
            $tiempoEstimado=$parametros["tiempoEstimado"];
            $estado=$parametros["estado"];
            
            $nuevo = new Orden();
            $nuevo->idOrden=$id;
            $nuevo->id_Comanda=$id_Comanda;
            $nuevo->id_Producto=$id_Producto;
            $nuevo->tiempoEstimado=$tiempoEstimado;
            $nuevo->estado=$estado;

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

            $payload = json_encode(array("mensaje" => "Orden borrada con exito"));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
        public function PrepararOrden($request, $response, $args){
            $id = $args['id'];
            //obtenermos la ruta completa luego la seccion
            $ruta = $request->getUri()->getPath();
            $segments = explode('/', $ruta);
            $seccion= $segments[4];

            $orden=Orden::obtenerUno($id);
            $producto=Producto::obtenerUno($orden->id_Producto);
            if($producto->seccion==$seccion){
                Orden::modificarOrdenEstado($id,"en preparacion");
                $payload = json_encode(array("mensaje" => "Orden puesto en preparacion con exito"));
            }else{
                $payload = json_encode(array("mensaje" => "Esta orden pertenece a la seccion ".$producto->seccion.". No se aplicaron cambios"));
            }
            
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
        public function ListoOrden($request, $response, $args){
            $id = $args['id'];
            
            $ruta = $request->getUri()->getPath();
            $segments = explode('/', $ruta);
            $seccion= $segments[4];

            $orden=Orden::obtenerUno($id);
            $producto=Producto::obtenerUno($orden->id_Producto);
            if($producto->seccion==$seccion){
                Orden::modificarOrdenEstado($id,"listo para servir");
                $payload = json_encode(array("mensaje" => "Orden terminada con exito"));
            }else{
                $payload = json_encode(array("mensaje" => "Esta orden pertenece a la seccion ".$producto->seccion.". No se aplicaron cambios"));
            }
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
        public function ServirOrden($request, $response, $args){
            $id = $args['id'];
            Orden::modificarOrdenEstado($id,"servido");
            $payload = json_encode(array("mensaje" => "Orden servida con exito"));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>