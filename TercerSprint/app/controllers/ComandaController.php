<?php
    require_once './models/Comanda.php';
    require_once './interfaces/IApiUsable.php';
    require_once './models/Imagen.php';

    class ComandaController extends Comanda implements IApiUsable
    {
        public function CargarUno($request, $response, $args)
        {
            $parametros = $request->getParsedBody();
            $id_Mesa=$parametros['id_Mesa'];
            $id_Empleado=$parametros['id_Empleado'];
            $nombreCliente = $parametros['nombreCliente'];
            $fotoMesa=$parametros['fotoMesa'];
            $fechaHora=$parametros['fechaHora'];
            $observacion=$parametros['observacion'];

            $nombreMesa=$nombreCliente.".jpg";
            $fotoBinaria=base64_decode($parametros["fotoMesa"]);
            $ruta=Imagen::Guardar($nombreMesa, $fotoBinaria);
            if(file_exists($ruta)){
                $nuevo = new Comanda();
                $nuevo->id_Mesa=$id_Mesa;
                $nuevo->id_Empleado=$id_Empleado;
                $nuevo->nombreCliente=$nombreCliente;
                $nuevo->fotoMesa=$ruta;
                $nuevo->fechaHora=$fechaHora;
                $nuevo->observacion=$observacion;
                $nuevo->crearComanda();
                $payload = json_encode(array("mensaje" => "Comanda creada con exito"));
            }else{
                $payload = json_encode(array("mensaje" => "La imagen no se pudo guardar. No se aplicaron cambios."));
            }
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    
        public function TraerUno($request, $response, $args)
        {
            $id = $args['id'];
            $mesa = Comanda::obtenerUno($id);
            $payload = json_encode($mesa);
    
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
        public function TraerTodos($request, $response, $args)
        {
            $lista = Comanda::obtenerTodos();
            $payload = json_encode(array("ListaComanda" => $lista));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
        
        public function ModificarUno($request, $response, $args)
        {
            $id = $args['id'];
            $parametros = $request->getParsedBody();
            $id_Mesa=$parametros['id_Mesa'];
            $id_Empleado=$parametros['id_Empleado'];
            $nombreCliente = $parametros['nombreCliente'];
            $fotoMesa=$parametros['fotoMesa'];
            $fechaHora=$parametros['fechaHora'];
            $observacion=$parametros['observacion'];

            $nombreMesa=$nombreCliente.".jpg";
            $fotoBinaria=base64_decode($parametros["fotoMesa"]);
            $ruta=Imagen::Guardar($nombreMesa, $fotoBinaria);
            if(file_exists($ruta)){
                $nuevo = new Comanda();
                $nuevo->id_Mesa=$id_Mesa;
                $nuevo->id_Empleado=$id_Empleado;
                $nuevo->nombreCliente=$nombreCliente;
                $nuevo->fotoMesa=$ruta;
                $nuevo->fechaHora=$fechaHora;
                $nuevo->observacion=$observacion;
                Comanda::modificarComanda($nuevo);
                $payload = json_encode(array("mensaje" => "Comanda modificada con exito"));
            }else{
                $payload = json_encode(array("mensaje" => "La imagen no se pudo guardar. No se aplicaron cambios."));
            }
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function BorrarUno($request, $response, $args)
        {
            $id = $args['id'];
            Comanda::eliminarComanda($id);

            $payload = json_encode(array("mensaje" => "Comanda borrada con exito"));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>