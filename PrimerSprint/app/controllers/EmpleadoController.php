<?php
    require_once './models/Empleado.php';
    require_once './interfaces/IApiUsable.php';

    class EmpleadoController extends Empleado implements IApiUsable
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
            $seccion=$parametros['seccion'];
            $sueldo=$parametros['sueldo'];
            $fechaIngreso=$parametros['fechaIngreso'];
            $fechaEgreso=$parametros['fechaEgreso'];
            

            $nuevo = new Empleado();
            $nuevo->nombre=$nombre;
            $nuevo->apellido=$apellido;
            $nuevo->edad=$edad;
            $nuevo->dni=$dni;
            $nuevo->email=$email;
            $nuevo->clave=$clave;
            $nuevo->sueldo=$sueldo;
            $nuevo->seccion=$seccion;
            $nuevo->fechaIngreso=$fechaIngreso;
            $nuevo->fechaEgreso=$fechaEgreso;
            $nuevo->crearPersonal();
    
            $payload = json_encode(array("mensaje" => "Empleado creado con exito"));
    
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    
        public function TraerUno($request, $response, $args)
        {
            $id = $args['id'];
            $mesa = Empleado::obtenerUno($id);
            $payload = json_encode($mesa);
    
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
        public function TraerTodos($request, $response, $args)
        {
            $lista = Empleado::obtenerTodos();
            $payload = json_encode(array("ListaEmpleado" => $lista));

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
            $seccion=$parametros['seccion'];
            $sueldo=$parametros['sueldo'];
            $fechaIngreso=$parametros['fechaIngreso'];
            $fechaEgreso=$parametros['fechaEgreso'];
            

            $nuevo = new Empleado();
            $nuevo->idEmpleado=$id;
            $nuevo->nombre=$nombre;
            $nuevo->apellido=$apellido;
            $nuevo->edad=$edad;
            $nuevo->dni=$dni;
            $nuevo->email=$email;
            $nuevo->clave=$clave;
            $nuevo->sueldo=$sueldo;
            $nuevo->seccion=$seccion;
            $nuevo->fechaIngreso=$fechaIngreso;
            $nuevo->fechaEgreso=$fechaEgreso;
            Empleado::modificarPersonal($nuevo);

            $payload = json_encode(array("mensaje" => "Empleado modificado con exito"));

            $response->getBody()->write($payload);
            return $response
            ->withHeader('Content-Type', 'application/json');
        }

        public function BorrarUno($request, $response, $args)
        {
            $id = $args['id'];
            Empleado::eliminarPersonal($id);

            $payload = json_encode(array("mensaje" => "Empleado borrado con exito"));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>