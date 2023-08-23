<?php

namespace App\Http\Controllers;

use App\Helpers\DateSkipper;
use App\Helpers\Discord;
use App\Helpers\Git;
use App\Helpers\Pairs;
use App\Helpers\Random;

class TestController extends DynamicRouteController
{
  function mask(){
    $disp = [];
    $disp[] = Discord::webhookURL(true);
    $disp[] = Git::commitHashShort();
    return response()->json($disp);
  }

  function discordMessage(){
    return response(Discord::getCurrentMessage(), 200, [
      "content-type" => "text/plain"
    ]);
  }

  function pairsSimulation() {
    return response(Pairs::simulations(request()->query('count', 5)), 200, [
      "content-type" => "text/plain"
    ]);
  }

  function appEnv(){
    return response(app()->environment(), 200, [
      "content-type" => "text/plain"
    ]);
  }

  function log(){
    app('log')->channel('debug')->info('test');
    return response(config('app.env'), 200, [
      "content-type" => "text/plain"
    ]);
  }

  function randomInt(){
    $arr = [];

    $arr[] = Random::int(5, 21, 20230816);
    $arr[] = Random::int(5, 21, 20230817);
    $arr[] = Random::int(5, 20, 1);
    $arr[] = Random::int(5, 20, 2);
    $arr[] = Random::int(5, 20, 1);

    return response()->json($arr);
  }

  function skipDates(){
    $disp = DateSkipper::dates();
    return response()->json($disp);
  }

  function skipDatesToday(){
    $disp = DateSkipper::dates();
    $disp = [DateSkipper::matchToday()];
    $disp[] = date('r');
    return response()->json($disp);
  }
}
