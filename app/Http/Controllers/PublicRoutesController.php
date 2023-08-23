<?php

namespace App\Http\Controllers;

use App\Helpers\Git;
use App\Helpers\Pairs;
use Illuminate\Http\Request;

class PublicRoutesController extends DynamicRouteController
{
  function _default(){
    return view('react', [
      "expose" => [
        "APP_NAME" => env("APP_NAME"), "APP_BUILD" => Git::commitHashShort()
      ]
    ]);
  }

  function legacy(){
    return response(Pairs::currentAsciiTable(), 200, [
      "content-type" => "text/plain"
    ]);
  }

  function legacySlim(){
    return response(Pairs::currentAsciiTableSlim(), 200, [
      "content-type" => "text/plain"
    ]);
  }

  function version(){
    return response(Git::commitHash(), 200, [
      "content-type" => "text/plain"
    ]);
  }

  function pairs(){
    return response()->json([
      "current" => Pairs::currentWithMeta(),
      // "yesterday" => Pairs::custom(-1),
      // "tomorrow" => Pairs::custom(1),
      "yesterday" => [],
      "tomorrow" => [],
    ]);
  }
}
