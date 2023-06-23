<?php
    require_once './models/Socio.php';
    require_once './interfaces/IApiUsable.php';

    class SocioController extends Socio implements IApiUsable
    {
        public function CargarUno($request, $response, $args)
        {
            $parametros = $request->getParsedBody();
            $nombre = $parametros['nombre'];
            $apellido=$parametros['apellido'];
            $edad=$parametros['edad'];
            $dni = $parametros['dni'];
            $email=$parametros['email'];
            $clave=$parametros['clave'];
            $recaudacion=$parametros['recaudacion'];

            $nuevo = new Socio();
            $nuevo->nombre=$nombre;
            $nuevo->apellido=$apellido;
            $nuevo->edad=$edad;
            $nuevo->dni=$dni;
            $nuevo->email=$email;
            $nuevo->clave=$clave;
            $nuevo->recaudacion=$recaudacion;
            
            $nuevo->crearPersonal();
    
            $payload = json_encode(array("mensaje" => "Socio creado con exito"));
    
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    
        public function TraerUno($request, $response, $args)
        {
            $id = $args['id'];
            $mesa = Socio::obtenerUno($id);
            $payload = json_encode($mesa);
    
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
        public function TraerTodos($request, $response, $args)
        {
            $lista = Socio::obtenerTodos();
            $payload = json_encode(array("ListaSocios" => $lista));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
        
        public function ModificarUno($request, $response, $args)
        {
            $id = $args['id'];
            $parametros = $request->getParsedBody();
            $nombre = $parametros['nombre'];
            $apellido=$parametros['apellido'];
            $edad=$parametros['edad'];
            $dni = $parametros['dni'];
            $email=$parametros['email'];
            $clave=$parametros['clave'];
            $recaudacion=$parametros['recaudacion'];
              

            $nuevo = new Socio();
            $nuevo->idSocio=$id;
            $nuevo->nombre=$nombre;
            $nuevo->apellido=$apellido;
            $nuevo->edad=$edad;
            $nuevo->dni=$dni;
            $nuevo->email=$email;
            $nuevo->clave=$clave;
            $nuevo->recaudacion=$recaudacion;
            Socio::modificarPersonal($nuevo);

            $payload = json_encode(array("mensaje" => "Socio modificado con exito"));

            $response->getBody()->write($payload);
            return $response
            ->withHeader('Content-Type', 'application/json');
        }

        public function BorrarUno($request, $response, $args)
        {
            $id = $args['id'];
            Socio::eliminarPersonal($id);

            $payload = json_encode(array("mensaje" => "Socio borrado con exito"));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>