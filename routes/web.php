<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Helpers\DateSkipper;
use App\Helpers\Discord;
use App\Helpers\Git;
use App\Helpers\Pairs;
use App\Helpers\Random;

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

$router->group(["middleware" => ['all']],
  function () use ($router) {
    $router->group(['prefix' => 'test', "middleware" => ['test']], function () use ($router) {
      // $router->get('pairs/simulation[/{count}]', function ($count = 5) {
      //   // $router->get('pairs/simulation/{?count}', function () {
      //   return response(Pairs::simulations($count), 200, [
      //     "content-type" => "text/plain"
      //   ]);
      // });

      $router->get('[{path:.*}]', 'TestController@index');
    });

    $router->get('[{path:.*}]', 'PublicRoutesController@index');
  }
);
