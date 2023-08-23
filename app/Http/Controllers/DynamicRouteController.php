<?php

namespace App\Http\Controllers;

use App\Helpers\Str;

abstract class DynamicRouteController extends Controller
{
  function index($path)
  {
    $formattedPath = Str::convertUrlSegmentToCamelCase($path);

    if (is_callable([$this, $formattedPath])) {
      return $this->{$formattedPath}();
    }

    return response()->json($path . ' not found');
  }
}
