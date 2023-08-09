<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Helpers\Pairs;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/legacy', function () use ($router) {
  return response(Pairs::currentAsciiTable(), 200, [
    "content-type" => "text/plain"
  ]);
});

$router->get('/pairs', function () use ($router) {
  if(env("APP_ENV") === "local" && env("APP_DEBUG") === true)
    sleep(2);

  return response()->json([
    "current" => Pairs::currentWithMeta()
  ]);
});

// Catch all route for SPA
$router->get('[{path:.*}]', function ($path = null) use ($router) {
  return view('react', [
    "expose" => [
      "APP_NAME" => env("APP_NAME")
    ]
  ]);
});
