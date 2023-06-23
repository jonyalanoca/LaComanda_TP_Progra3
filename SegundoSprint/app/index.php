<?php
  // Error Handling
  error_reporting(-1);
  ini_set('display_errors', 1);

  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
  use Psr\Http\Server\RequestHandlerInterface;
  use Slim\Factory\AppFactory;
  use Slim\Routing\RouteCollectorProxy;
  use Slim\Routing\RouteContext;

  require __DIR__ . '/../vendor/autoload.php';

  require_once './db/AccesoDatos.php';

  //Controllers
  require_once './controllers/MesaController.php';
  require_once './controllers/ProductoController.php';
  require_once './controllers/EmpleadoController.php';
  require_once './controllers/SocioController.php';
  require_once './controllers/ComandaController.php';
  require_once './controllers/OrdenController.php';
  require_once './controllers/LoginController.php';

  //MiddleWares
  require_once './middlewares/Autentificadora.php';
  require_once './middlewares/AutentificadoraLogin.php';

  // Load ENV
  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
  $dotenv->safeLoad();

  // Instantiate App
  $app = AppFactory::create();
  $app->setBasePath('/LaComanda/app');

  // Add error middleware
  $app->addErrorMiddleware(true, true, true);

  // Add parse body
  $app->addBodyParsingMiddleware();

  // Routes
  $app->group('/mesas', function (RouteCollectorProxy $group) {
    $group->post('/', \MesaController::class . ':CargarUno')->add(\Verificadora::class . ':VerificarParamMesa');
    $group->get('/{id}', \MesaController::class . ':TraerUno');
    $group->get('[/]', \MesaController::class . ':TraerTodos');
    $group->put('/{id}', \MesaController::class . ':ModificarUno')->add(\Verificadora::class . ':VerificarParamMesa');
    $group->delete('/{id}', \MesaController::class . ':BorrarUno');
  })->add(\AutentificadoraLogin::class . ':VerificarSocioOMozo')
    ->add(\AutentificadoraLogin::class . ':VerificarLogeo');

  $app->group('/productos', function (RouteCollectorProxy $group) {
    $group->post('/', \ProductoController::class . ':CargarUno')->add(\Verificadora::class . ':VerificarParamProducto');
    $group->get('/{id}', \ProductoController::class . ':TraerUno');
    $group->get('[/]', \ProductoController::class . ':TraerTodos');
    $group->put('/{id}', \ProductoController::class . ':ModificarUno')->add(\Verificadora::class . ':VerificarParamProducto');
    $group->delete('/{id}', \ProductoController::class . ':BorrarUno');
  })->add(\AutentificadoraLogin::class . ':VerificarSocio')
    ->add(\AutentificadoraLogin::class . ':VerificarLogeo');

  $app->group('/empleados', function (RouteCollectorProxy $group) {
    $group->post('/', \EmpleadoController::class . ':CargarUno')->add(\Verificadora::class . ':VerificarParamEmpleado');
    $group->get('/{id}', \EmpleadoController::class . ':TraerUno');
    $group->get('[/]', \EmpleadoController::class . ':TraerTodos');
    $group->put('/{id}', \EmpleadoController::class . ':ModificarUno')->add(\Verificadora::class . ':VerificarParamEmpleado');
    $group->delete('/{id}', \EmpleadoController::class . ':BorrarUno');
  })->add(\AutentificadoraLogin::class . ':VerificarSocio')
    ->add(\AutentificadoraLogin::class . ':VerificarLogeo');
  
  $app->group('/socios', function (RouteCollectorProxy $group) {
    $group->post('/', \SocioController::class . ':CargarUno')->add(\Verificadora::class . ':VerificarParamSocio');
    $group->get('/{id}', \SocioController::class . ':TraerUno');
    $group->get('[/]', \SocioController::class . ':TraerTodos');
    $group->put('/{id}', \SocioController::class . ':ModificarUno')->add(\Verificadora::class . ':VerificarParamSocio');
    $group->delete('/{id}', \SocioController::class . ':BorrarUno');
  })->add(\AutentificadoraLogin::class . ':VerificarSocio')
    ->add(\AutentificadoraLogin::class . ':VerificarLogeo');
    
  $app->group('/comandas', function (RouteCollectorProxy $group) {
    $group->post('/', \ComandaController::class . ':CargarUno')->add(\Verificadora::class . ':VerificarParamComanda');
    $group->get('/{id}', \ComandaController::class . ':TraerUno');
    $group->get('[/]', \ComandaController::class . ':TraerTodos');
    $group->put('/{id}', \ComandaController::class . ':ModificarUno')->add(\Verificadora::class . ':VerificarParamComanda');
    $group->delete('/{id}', \ComandaController::class . ':BorrarUno');
  })->add(\AutentificadoraLogin::class . ':VerificarLogeo');

  $app->group('/ordenes', function (RouteCollectorProxy $group) {
    $group->post('/', \OrdenController::class . ':CargarUno')->add(\AutentificadoraLogin::class . ':VerificarSocioOMozo')->add(\Verificadora::class . ':VerificarParamOrden');
    $group->get('/{id}', \OrdenController::class . ':TraerUno')->add(\AutentificadoraLogin::class . ':VerificarSocioOMozo');
    $group->get('[/]', \OrdenController::class . ':TraerTodos')->add(\AutentificadoraLogin::class . ':VerificarSocioOMozo');
    $group->put('/{id}', \OrdenController::class . ':ModificarUno')->add(\AutentificadoraLogin::class . ':VerificarSocioOMozo')->add(\Verificadora::class . ':VerificarParamOrden');
    $group->delete('/{id}', \OrdenController::class . ':BorrarUno')->add(\AutentificadoraLogin::class . ':VerificarSocioOMozo');

    $group->put('/cocina/preparar/{id}', \OrdenController::class . ':PrepararOrden')->add(\AutentificadoraLogin::class . ':VerificarSocioOCocinero');
    $group->put('/cocina/terminar/{id}', \OrdenController::class . ':ListoOrden')->add(\AutentificadoraLogin::class . ':VerificarSocioOCocinero');

    $group->put('/cerveceria/preparar/{id}', \OrdenController::class . ':PrepararOrden')->add(\AutentificadoraLogin::class . ':VerificarSocioOBarman');
    $group->put('/cerveceria/terminar/{id}', \OrdenController::class . ':ListoOrden')->add(\AutentificadoraLogin::class . ':VerificarSocioOBarman');

    $group->put('/vinoteca/preparar/{id}', \OrdenController::class . ':PrepararOrden')->add(\AutentificadoraLogin::class . ':VerificarSocioOBarman');
    $group->put('/vinoteca/terminar/{id}', \OrdenController::class . ':ListoOrden')->add(\AutentificadoraLogin::class . ':VerificarSocioOBarman');

    $group->put('/candybar/preparar/{id}', \OrdenController::class . ':PrepararOrden')->add(\AutentificadoraLogin::class . ':VerificarSocioORepostero');
    $group->put('/candybar/terminar/{id}', \OrdenController::class . ':ListoOrden')->add(\AutentificadoraLogin::class . ':VerificarSocioORepostero');

    $group->put('/servir/{id}', \OrdenController::class . ':ServirOrden')->add(\AutentificadoraLogin::class . ':VerificarSocioOMozo');
})->add(\AutentificadoraLogin::class . ':VerificarLogeo');


  $app->post('/login',\LoginController::class . ':Logearse');

    $app->get('[/]', function (Request $request, Response $response) {    
      $payload = json_encode(array("mensaje" => "HERO PAGE - LA COMANDA"));   
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json');
  });

$app->run();
