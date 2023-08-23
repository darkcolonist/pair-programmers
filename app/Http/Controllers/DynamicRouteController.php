<?php

namespace App\Http\Controllers;

use App\Helpers\Str;

abstract class DynamicRouteController extends Controller
{
  function index($path = ''){
    $formattedPath = Str::convertUrlSegmentToCamelCase($path);

    if (is_callable([$this, $formattedPath])) {
      return $this->{$formattedPath}();
    } else if (is_callable([$this, '_default'])){
      return $this->_default();
    }

    return response($path . ' not found',
      404,
      ["content-type" => "text/plain"]);
  }
}
