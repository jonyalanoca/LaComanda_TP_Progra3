<?php
   use Psr\Http\Message\ServerRequestInterface as Request;
   use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
   use Slim\Psr7\Response as  ResponseMW;

   require_once './models/Empleado.php';
   require_once './models/Mesa.php';
   require_once './models/Producto.php';
   require_once './models/Comanda.php';
   

   class Verificadora{
      private $patronNombres="/^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/";
      private $patronEdad='/^(1[8-9]|[2-9][0-9]|100)$/';
      private $patronEmail='/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
      private $patronDni='/^\d{8}$/';
      private $patronTexto= '/^[A-Za-z\s]+$/';
      private $patronNumeros='/^[0-9]+$/';
      private $patronFecha='/^\d{4}-\d{2}-\d{2}$/';
      private $patronFechaHora = '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/';
      private $patronAlfaNumerico='/^[A-Za-z0-9\s]+$/';

      private $mesaEstados=['disponible','esperando pedido', 'comiendo','pagando','cerrada'];
      private $empleadoSeccion=["mozo","bartender","cocinero","repostero"];
      private $empleadoEstado=["activo","inactivo","suspendido"];
      private $productoSeccion=["cerveceria","vinoteca","cocina","candybar"];
      private $ordenEstados=["pendiente","en praparacion","listo para servir","servido"];

      public function VerificarParamEmpleado(Request $request, RequestHandler $handler):ResponseMW{

         $parameters = $request->getParsedBody();
         if(
            isset($parameters["nombre"]) && preg_match($this->patronNombres,$parameters["nombre"]) &&
            isset($parameters["apellido"]) && preg_match($this->patronNombres,$parameters["apellido"]) &&
            isset($parameters["edad"]) && preg_match($this->patronEdad,$parameters["edad"]) &&
            isset($parameters["dni"]) && preg_match($this->patronDni,$parameters["dni"]) &&
            isset($parameters["email"]) && preg_match($this->patronEmail,$parameters["email"]) &&
            isset($parameters["clave"]) && preg_match($this->patronAlfaNumerico,$parameters["clave"]) &&
            isset($parameters["seccion"]) && in_array($parameters["seccion"],$this->empleadoSeccion) &&
            isset($parameters["sueldo"]) && preg_match($this->patronNumeros,$parameters["sueldo"]) &&
            isset($parameters["fechaIngreso"]) && preg_match($this->patronFecha,$parameters["fechaIngreso"]) &&
            isset($parameters["fechaEgreso"]) && preg_match($this->patronFecha,$parameters["fechaEgreso"]) &&
            (
               ($request->getMethod()=="PUT" && isset($parameters["estado"]) && in_array($parameters["estado"],$this->empleadoEstado)) ||
               ($request->getMethod()=="POST" && !isset($parameters["estado"]))
            )){
               return $handler->handle($request);
            }
         $response = new ResponseMW();
         $payload=json_encode(array("mensaje"=>"Faltan parametros o no cumplen el formato correcto"));
         $response->getBody()->write($payload);
         $response=$response->withStatus(404);
         return $response->withHeader('Content-Type', 'application/json');
      }
      public function VerificarParamSocio(Request $request, RequestHandler $handler):ResponseMW{
      
         $parameters = $request->getParsedBody();
         if(
            isset($parameters["nombre"]) && preg_match($this->patronNombres,$parameters["nombre"]) &&
            isset($parameters["apellido"]) && preg_match($this->patronNombres,$parameters["apellido"]) &&
            isset($parameters["edad"]) && preg_match($this->patronEdad,$parameters["edad"]) &&
            isset($parameters["dni"]) && preg_match($this->patronDni,$parameters["dni"]) &&
            isset($parameters["email"]) && preg_match($this->patronEmail,$parameters["email"]) &&
            isset($parameters["clave"]) && preg_match($this->patronAlfaNumerico,$parameters["clave"]) &&
            isset($parameters["recaudacion"]) && preg_match($this->patronNumeros,$parameters["recaudacion"])
         ){
            //Cumple con la existencia y el formato correcto de parametros
            return $handler->handle($request);
         }else{   
            $response = new ResponseMW();
            $payload=json_encode(array("mensaje"=>"Faltan parametros o no cumplen el formato correcto"));
            $response->getBody()->write($payload);
            $response=$response->withStatus(403);
            return $response->withHeader('Content-Type', 'application/json');
         }
      }
      public function VerificarParamProducto(Request $request, RequestHandler $handler):ResponseMW{
      
         $parameters = $request->getParsedBody();
         if(
            isset($parameters["nombre"]) && preg_match($this->patronNombres,$parameters["nombre"]) &&
            isset($parameters["precio"]) && preg_match($this->patronNumeros,$parameters["precio"]) &&
            isset($parameters["stock"]) && preg_match($this->patronNumeros,$parameters["stock"]) &&
            isset($parameters["seccion"]) && in_array($parameters["seccion"],$this->productoSeccion) &&
            isset($parameters["tiempoPreparacion"]) && preg_match($this->patronNumeros,$parameters["tiempoPreparacion"]) &&
            isset($parameters["descripcion"]) && preg_match($this->patronAlfaNumerico,$parameters["descripcion"])
         ){
            //Cumple con la existencia y el formato correcto de parametros
            return $handler->handle($request);
         }else{   
            $response = new ResponseMW();
            $payload=json_encode(array("mensaje"=>"Faltan parametros o no cumplen el formato correcto"));
            $response->getBody()->write($payload);
            $response=$response->withStatus(403);
            return $response->withHeader('Content-Type', 'application/json');
         }
      }
      public function VerificarParamMesa(Request $request, RequestHandler $handler):ResponseMW{
         
         $parameters = $request->getParsedBody();
         if(
            ($request->getMethod()=="PUT"&& isset($parameters["estado"]) && in_array($parameters["estado"],$this->mesaEstados))||
            ($request->getMethod()=="POST"&& !isset($parameters["estado"]))
         ){
            //Cumple con la existencia y el formato correcto de parametros
            return $handler->handle($request);
         }else{   
            $response = new ResponseMW();
            $payload=json_encode(array("mensaje"=>"Faltan parametros o no cumplen el formato correcto"));
            $response->getBody()->write($payload);
            $response=$response->withStatus(403);
            return $response->withHeader('Content-Type', 'application/json');
         }
      }
      public function VerificarParamComanda(Request $request, RequestHandler $handler):ResponseMW{     

         $parameters = $request->getParsedBody();
         if(
            isset($parameters["id_Mesa"]) && in_array($parameters["id_Mesa"],Mesa::ObtenerIds()) &&
            isset($parameters["id_Empleado"]) && in_array($parameters["id_Empleado"],Empleado::ObtenerIds()) &&
            isset($parameters["nombreCliente"]) && preg_match($this->patronNombres,$parameters["nombreCliente"]) &&
            isset($parameters["fechaHora"]) && preg_match($this->patronFechaHora,$parameters["fechaHora"]) &&
            isset($parameters["observacion"]) && preg_match($this->patronTexto,$parameters["observacion"])
         ){
            //Cumple con la existencia y el formato correcto de parametros
            return $handler->handle($request);
         }else{   
            $response = new ResponseMW();
            $payload=json_encode(array("mensaje"=>"Faltan parametros o no cumplen el formato correcto o los ids no existen"));
            $response->getBody()->write($payload);
            $response=$response->withStatus(403);
            return $response->withHeader('Content-Type', 'application/json');
         }
      }
      public function VerificarParamOrden(Request $request, RequestHandler $handler):ResponseMW{
         
         $parameters = $request->getParsedBody();
         if(
            isset($parameters["id_Comanda"]) && in_array($parameters["id_Comanda"],Comanda::ObtenerIds()) &&
            isset($parameters["id_Producto"]) && in_array($parameters["id_Producto"],Producto::ObtenerIds()) &&
            isset($parameters["tiempoEstimado"]) && preg_match($this->patronNumeros,$parameters["tiempoEstimado"]) &&
            ($request->getMethod()=="PUT"&& isset($parameters["estado"]) && in_array($parameters["estado"],$this->ordenEstados))||
            ($request->getMethod()=="POST"&& !isset($parameters["estado"]))
         ){
            //Cumple con la existencia y el formato correcto de parametros
            return $handler->handle($request);
         }else{   
            $response = new ResponseMW();
            $payload=json_encode(array("mensaje"=>"Faltan parametros o no cumplen el formato correcto o los ids no existen"));
            $response->getBody()->write($payload);
            $response=$response->withStatus(403);
            return $response->withHeader('Content-Type', 'application/json');
         }
      }
   }
?>