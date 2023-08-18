<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
      $router->get('discord/message', function () {
        return response(Discord::getCurrentMessage(), 200, [
          "content-type" => "text/plain"
        ]);
      });

      $router->get('pairs/simulation[/{count}]', function ($count = 5) {
        // $router->get('pairs/simulation/{?count}', function () {
        return response(Pairs::simulations($count), 200, [
          "content-type" => "text/plain"
        ]);
      });

      $router->get('app/env', function () use ($router) {
        return response(app()->environment(), 200, [
          "content-type" => "text/plain"
        ]);
      });

      $router->get('log', function () use ($router) {
        app('log')->channel('debug')->info('test');
        return response(config('app.env'), 200, [
          "content-type" => "text/plain"
        ]);
      });

      $router->get('randomint', function () use ($router) {
        $arr = [];

        $arr[] = Random::int(5,21,20230816);
        $arr[] = Random::int(5,21,20230817);
        $arr[] = Random::int(5,20,1);
        $arr[] = Random::int(5,20,2);
        $arr[] = Random::int(5,20,1);

        return response()->json($arr);
      });

      $router->get('mask', function () use ($router) {
        $disp = [];
        $disp[] = Discord::webhookURL(true);
        $disp[] = Git::commitHashShort();
        return response()->json($disp);
      });

    });

    $router->get('/legacy', function () use ($router) {
      return response(Pairs::currentAsciiTable(), 200, [
        "content-type" => "text/plain"
      ]);
    });

    $router->get('/legacy/slim', function () use ($router) {
      return response(Pairs::currentAsciiTableSlim(), 200, [
        "content-type" => "text/plain"
      ]);
    });

    $router->get('/version', function () use ($router) {
      return response(Git::commitHash(), 200, [
        "content-type" => "text/plain"
      ]);
    });

    $router->get('/pairs', function () use ($router) {
      return response()->json([
        "current" => Pairs::currentWithMeta(),
        // "yesterday" => Pairs::custom(-1),
        // "tomorrow" => Pairs::custom(1),
        "yesterday" => [],
        "tomorrow" => [],
      ]);
    });

    // Catch all route for SPA
    $router->get('[{path:.*}]', function ($path = null) use ($router) {
      return view('react', [
        "expose" => [
          "APP_NAME" => env("APP_NAME"), "APP_BUILD" => Git::commitHashShort()
        ]
      ]);
    });
  }
);
