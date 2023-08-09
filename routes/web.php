<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Helpers\Discord;
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
    "current" => Pairs::currentWithMeta(),
    "yesterday" => Pairs::custom(-1),
    "tomorrow" => Pairs::custom(1),
  ]);
});

$router->group(['prefix' => 'api'], function () use ($router) {
  $router->post('discord/interactions', function () {
    // return response(Pairs::currentAsciiTable(), 200, [
    //   "content-type" => "text/plain"
    // ]);
    $result = Discord::verifyEndpoint();

    return response(
      $result['payload'],
      $result['code'],
      [
        'content-type' => 'application/json'
      ]
    );
  });
});

// Catch all route for SPA
$router->get('[{path:.*}]', function ($path = null) use ($router) {
  return view('react', [
    "expose" => [
      "APP_NAME" => env("APP_NAME")
    ]
  ]);
});
