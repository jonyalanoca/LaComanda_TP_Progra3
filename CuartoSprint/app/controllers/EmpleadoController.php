<?php
    require_once './models/Empleado.php';
    require_once './interfaces/IApiUsable.php';
    require_once "./models/Socio.php";

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
            $estado="activo";

            $empleado=Empleado::ObtenerEmpleadoPorEmail($email);
            $socio=Socio::ObtenerSocioPorEmail($email);

            if($empleado==false && $socio==false){
                $nuevo = new Empleado();
                $nuevo->nombre=$nombre;
                $nuevo->apellido=$apellido;
                $nuevo->edad=$edad;
                $nuevo->dni=$dni;
                $nuevo->email=$email;
                $nuevo->clave= password_hash($clave,PASSWORD_DEFAULT);
                $nuevo->sueldo=$sueldo;
                $nuevo->seccion=$seccion;
                $nuevo->fechaIngreso=$fechaIngreso;
                $nuevo->fechaEgreso=$fechaEgreso;
                $nuevo->estado=$estado;
                $nuevo->crearPersonal();
                $payload = json_encode(array("mensaje" => "Empleado creado con exito"));
            }else{
                $payload = json_encode(array("mensaje" => "Ya hay un usuario registrado con ese email. No se aplicarion cambios."));
            }
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
            $estado=$parametros['estado'];

            $empleado=Empleado::ObtenerEmpleadoPorEmail($email);
            $socio=Socio::ObtenerSocioPorEmail($email);

            if($empleado==false && $socio==false){
                $nuevo = new Empleado();
                $nuevo->idEmpleado=$id;
                $nuevo->nombre=$nombre;
                $nuevo->apellido=$apellido;
                $nuevo->edad=$edad;
                $nuevo->dni=$dni;
                $nuevo->email=$email;
                $nuevo->clave=password_hash($clave,PASSWORD_DEFAULT);
                $nuevo->sueldo=$sueldo;
                $nuevo->seccion=$seccion;
                $nuevo->fechaIngreso=$fechaIngreso;
                $nuevo->fechaEgreso=$fechaEgreso;
                $nuevo->estado=$estado;
                Empleado::modificarPersonal($nuevo);
                $payload = json_encode(array("mensaje" => "Empleado modificado con exito"));
            }else{
                $payload = json_encode(array("mensaje" => "Ya hay un usuario registrado con ese email. No se aplicarion cambios."));
            }
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
        public function ModificarEstado($request, $response, $args)
        {
            $id = $args['id'];
            $parametros = $request->getParsedBody();
            $estado = $parametros['estado'];
            Empleado::cambiarEstado($id,$estado);

            $payload = json_encode(array("mensaje" => "Se cambio el estado del empleado con exito"));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>