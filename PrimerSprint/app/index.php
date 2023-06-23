<?php
  // Error Handling
  error_reporting(-1);
  ini_set('display_errors', 1);

  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use Psr\Http\Server\RequestHandlerInterface;
  use Slim\Factory\AppFactory;
  use Slim\Routing\RouteCollectorProxy;
  use Slim\Routing\RouteContext;

  require __DIR__ . '/../vendor/autoload.php';

  require_once './db/AccesoDatos.php';
  require_once './middlewares/Logger.php';

  require_once './middlewares/Logger.php';

  //Controllers
  require_once './controllers/MesaController.php';
  require_once './controllers/ProductoController.php';
  require_once './controllers/EmpleadoController.php';
  require_once './controllers/SocioController.php';
  require_once './controllers/ComandaController.php';
  require_once './controllers/OrdenController.php';
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
    $group->post('/', \MesaController::class . ':CargarUno');
    $group->get('/{id}', \MesaController::class . ':TraerUno');
    $group->get('[/]', \MesaController::class . ':TraerTodos');
    $group->put('/{id}', \MesaController::class . ':ModificarUno');
    $group->delete('/{id}', \MesaController::class . ':BorrarUno');
  });
  $app->group('/productos', function (RouteCollectorProxy $group) {
    $group->post('/', \ProductoController::class . ':CargarUno');
    $group->get('/{id}', \ProductoController::class . ':TraerUno');
    $group->get('[/]', \ProductoController::class . ':TraerTodos');
    $group->put('/{id}', \ProductoController::class . ':ModificarUno');
    $group->delete('/{id}', \ProductoController::class . ':BorrarUno');
  });
  $app->group('/empleados', function (RouteCollectorProxy $group) {
    $group->post('/', \EmpleadoController::class . ':CargarUno');
    $group->get('/{id}', \EmpleadoController::class . ':TraerUno');
    $group->get('[/]', \EmpleadoController::class . ':TraerTodos');
    $group->put('/{id}', \EmpleadoController::class . ':ModificarUno');
    $group->delete('/{id}', \EmpleadoController::class . ':BorrarUno');
  });
  $app->group('/socios', function (RouteCollectorProxy $group) {
    $group->post('/', \SocioController::class . ':CargarUno');
    $group->get('/{id}', \SocioController::class . ':TraerUno');
    $group->get('[/]', \SocioController::class . ':TraerTodos');
    $group->put('/{id}', \SocioController::class . ':ModificarUno');
    $group->delete('/{id}', \SocioController::class . ':BorrarUno');
  });
  $app->group('/comandas', function (RouteCollectorProxy $group) {
    $group->post('/', \ComandaController::class . ':CargarUno');
    $group->get('/{id}', \ComandaController::class . ':TraerUno');
    $group->get('[/]', \ComandaController::class . ':TraerTodos');
    $group->put('/{id}', \ComandaController::class . ':ModificarUno');
    $group->delete('/{id}', \ComandaController::class . ':BorrarUno');
  });
  $app->group('/ordenes', function (RouteCollectorProxy $group) {
    $group->post('/', \OrdenController::class . ':CargarUno');
    $group->get('/{id}', \OrdenController::class . ':TraerUno');
    $group->get('[/]', \OrdenController::class . ':TraerTodos');
    $group->put('/{id}', \OrdenController::class . ':ModificarUno');
    $group->delete('/{id}', \OrdenController::class . ':BorrarUno');
  });


    $app->get('[/]', function (Request $request, Response $response) {    
      $payload = json_encode(array("mensaje" => "Slim Framework 4 PHP"));   
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json');
  });

$app->run();
