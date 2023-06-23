<?php
    require_once "./middlewares/AutentificadorJWT.php";
    require_once "./models/Empleado.php";
    require_once "./models/Socio.php";
    class LoginController{
        public function Logearse($request, $response, $args){
            $parametros = $request->getParsedBody();
            $email = $parametros['email'];
            $clave=$parametros['clave'];
            
            $empleado=Empleado::ObtenerEmpleadoPorEmail($email);
            $socio=Socio::ObtenerSocioPorEmail($email);
            $datos=null;
            if( $empleado!=false && password_verify($clave,$empleado->clave) && $empleado->estado=="activo"){
                $datos = array('email' => $email, 'rol' => $empleado->seccion);
            }
            if($socio!=false && password_verify($clave,$socio->clave)){
                $datos = array('email' => $email, 'rol' => "socio");
            }
            if($datos!=null){
                $token = AutentificadorJWT::CrearToken($datos);
                $payload = json_encode(array('jwt' => $token));
            }else{
                $payload = json_encode(array("mensaje" => "no se pudo verificar "));
            }
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>