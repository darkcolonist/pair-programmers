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

// Catch all route for SPA
$router->get('[{path:.*}]', function ($path = null) use ($router) {
  return view('react');
});
