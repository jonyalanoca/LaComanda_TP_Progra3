<?php
    require_once "./middlewares/AutentificadorJWT.php";

    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
    use Slim\Psr7\Response as  ResponseMW;
    
    class AutentificadoraLogin{

        public function VerificarLogeo(Request $request, RequestHandler $handler):ResponseMW{
            $header = $request->getHeaderLine('Authorization');
            if(!empty($header)){
                return $handler->handle($request);
            }
            $response = new ResponseMW();
            $payload=json_encode(array("mensaje"=>"Porfavor logese antes de continuar"));
            $response->getBody()->write($payload);
            $response=$response->withStatus(404);
            return $response->withHeader('Content-Type', 'application/json');
        }
        
        public function VerificarSocio(Request $request, RequestHandler $handler):ResponseMW{
            $header = $request->getHeaderLine('Authorization');
            $token = trim(explode("Bearer", $header)[1]);
            $datos=AutentificadorJWT::ObtenerData($token);
            if($datos->rol=="socio"){
                return $handler->handle($request);
            } 
            $response = new ResponseMW();
            $payload=json_encode(array("mensaje"=>"No se tiene tiene autorización. Solo socios"));
           $response->getBody()->write($payload);
           $response=$response->withStatus(404);
           return $response->withHeader('Content-Type', 'application/json');
        }
        public function VerificarSocioOMozo(Request $request, RequestHandler $handler):ResponseMW{
            $header = $request->getHeaderLine('Authorization');
            $token = trim(explode("Bearer", $header)[1]);
            $datos=AutentificadorJWT::ObtenerData($token);
            if($datos->rol=="socio" || $datos->rol=="mozo"){
                return $handler->handle($request);
            } 
            $response = new ResponseMW();
            $payload=json_encode(array("mensaje"=>"No se tiene tiene autorizacion. Solo socios o mozo"));
           $response->getBody()->write($payload);
           $response=$response->withStatus(404);
           return $response->withHeader('Content-Type', 'application/json');
        }
        public function VerificarSocioORepostero(Request $request, RequestHandler $handler):ResponseMW{
            $header = $request->getHeaderLine('Authorization');
            $token = trim(explode("Bearer", $header)[1]);
            $datos=AutentificadorJWT::ObtenerData($token);
            if($datos->rol=="socio" || $datos->rol=="repostero"){
                return $handler->handle($request);
            } 
            $response = new ResponseMW();
            $payload=json_encode(array("mensaje"=>"No se tiene tiene autorizacion. Solo socios o repostero"));
           $response->getBody()->write($payload);
           $response=$response->withStatus(404);
           return $response->withHeader('Content-Type', 'application/json');
        }
        public function VerificarSocioOBarman(Request $request, RequestHandler $handler):ResponseMW{
            $header = $request->getHeaderLine('Authorization');
            $token = trim(explode("Bearer", $header)[1]);
            $datos=AutentificadorJWT::ObtenerData($token);
            if($datos->rol=="socio" || $datos->rol=="bartender"){
                return $handler->handle($request);
            } 
            $response = new ResponseMW();
            $payload=json_encode(array("mensaje"=>"No se tiene tiene autorizacion. Solo socios o bartender"));
           $response->getBody()->write($payload);
           $response=$response->withStatus(404);
           return $response->withHeader('Content-Type', 'application/json');
        }
        public function VerificarSocioOCocinero(Request $request, RequestHandler $handler):ResponseMW{
            $header = $request->getHeaderLine('Authorization');
            $token = trim(explode("Bearer", $header)[1]);
            $datos=AutentificadorJWT::ObtenerData($token);
            if($datos->rol=="socio" || $datos->rol=="cocinero"){
                return $handler->handle($request);
            } 
            $response = new ResponseMW();
            $payload=json_encode(array("mensaje"=>"No se tiene tiene autorizacion. Solo socios o cocinero"));
           $response->getBody()->write($payload);
           $response=$response->withStatus(404);
           return $response->withHeader('Content-Type', 'application/json');
        }

        public function VerifAutorizacionModificarOrden(Request $request, RequestHandler $handler):ResponseMW{
            $header = $request->getHeaderLine('Authorization');
            $parameters = $request->getParsedBody();
            
            $id = $args['id'];
            $token = trim(explode("Bearer", $header)[1]);
            $datos=AutentificadorJWT::ObtenerData($token);
            if($datos->rol=="socio" || $datos->rol=="mozo"){
                return $handler->handle($request);
            } 
            $response = new ResponseMW();
            $payload=json_encode(array("mensaje"=>"No se tiene tiene autorización. Solo socios o mozo"));
           $response->getBody()->write($payload);
           $response=$response->withStatus(404);
           return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>