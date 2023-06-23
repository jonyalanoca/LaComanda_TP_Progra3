<?php
    require_once './models/Producto.php';
    require_once './interfaces/IApiUsable.php';
    require_once './models/Backup.php';

    class ProductoController extends Producto implements IApiUsable
    {
        public function CargarUno($request, $response, $args)
        {
            $parametros = $request->getParsedBody();
            $nombre = $parametros['nombre'];
            $precio = $parametros['precio'];
            $stock = $parametros['stock'];
            $seccion = $parametros['seccion'];
            $tiempoPreparacion = $parametros['tiempoPreparacion'];
            $descripcion = $parametros['descripcion'];

            $nuevo = new Producto();
            $nuevo->nombre=$nombre;
            $nuevo->precio=$precio;
            $nuevo->stock=$stock;
            $nuevo->seccion=$seccion;
            $nuevo->tiempoPreparacion=$tiempoPreparacion;
            $nuevo->descripcion=$descripcion;
            $nuevo->crearProducto();
    
            $payload = json_encode(array("mensaje" => "Producto creado con exito"));
    
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    
        public function TraerUno($request, $response, $args)
        {
            $id = $args['id'];
            $mesa = Producto::obtenerUno($id);
            $payload = json_encode($mesa);
    
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
        public function TraerTodos($request, $response, $args)
        {
            $lista = Producto::obtenerTodos();
            $payload = json_encode(array("ListaProductos" => $lista));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
        
        public function ModificarUno($request, $response, $args)
        {
            $id = $args['id'];
            $parametros = $request->getParsedBody();
            $nombre = $parametros['nombre'];
            $precio = $parametros['precio'];
            $stock = $parametros['stock'];
            $seccion = $parametros['seccion'];
            $tiempoPreparacion = $parametros['tiempoPreparacion'];
            $descripcion = $parametros['descripcion'];
            
            $nuevo = new Producto();
            $nuevo->idProducto=$id;
            $nuevo->nombre=$nombre;
            $nuevo->precio=$precio;
            $nuevo->stock=$stock;
            $nuevo->seccion=$seccion;
            $nuevo->tiempoPreparacion=$tiempoPreparacion;
            $nuevo->descripcion=$descripcion;
            Producto::modificarProducto($nuevo);

            $payload = json_encode(array("mensaje" => "Producto modificado con exito"));

            $response->getBody()->write($payload);
            return $response
            ->withHeader('Content-Type', 'application/json');
        }

        public function BorrarUno($request, $response, $args)
        {
            $id = $args['id'];
            Producto::eliminarProducto($id);

            $payload = json_encode(array("mensaje" => "Producto borrado con exito"));

            $response->getBody()->write($payload);
            return $response
            ->withHeader('Content-Type', 'application/json');
        }
        public function GuardarDatosEnCsv($request, $response, $args){
            $parametros = $request->getParsedBody();
            $productos=Producto::obtenerTodos();
            Csv::GuardarCsv($parametros["nombreArchivo"],$productos);
            $payload = json_encode(array("mensaje" => "Los productos se guardaron en un archivo csv con exito"));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
        public function CargarDatosDesdeCsv($request, $response, $args){
            $parametros = $request->getParsedBody();

            $arrayDatos=Csv::LeerCsv($parametros["nombreArchivo"]);
            if($arrayDatos!=null){
                Producto::eliminarProductos();
                foreach($arrayDatos as $datos){
                    $nuevoProducto=new Producto();
                    $nuevoProducto->idProducto=$datos[0];
                    $nuevoProducto->nombre=$datos[1];
                    $nuevoProducto->precio=$datos[2];
                    $nuevoProducto->stock=$datos[3];
                    $nuevoProducto->seccion=$datos[4];
                    $nuevoProducto->tiempoPreparacion=$datos[5];
                    $nuevoProducto->descripcion=$datos[6];
                    $nuevoProducto->crearProductoConId();
                }
                $payload = json_encode(array("mensaje" => "Se cargaron los productos desde csv"));
            }else{
                $payload = json_encode(array("mensaje" => "EL archivo no existe. Verififcar la existencia de productos.csv"));
            }
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>