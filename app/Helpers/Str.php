<?php
namespace App\Helpers;

class Str extends \Illuminate\Support\Str{
  static function truncateWithMiddleEllipsis($text,
    $leftChars = 5,
    $rightChars = 5,
    $ellipsis = "···"){
    $totalChars = $leftChars + $rightChars;

    if (mb_strlen($text) <= $totalChars) {
      return $text;
    }

    $left = mb_substr($text, 0, $leftChars);
    $right = mb_substr($text, -$rightChars);

    return $left . $ellipsis . $right;
  }

  static function convertUrlSegmentToCamelCase($urlSegment)
  {
    $segments = explode('/', $urlSegment);

    foreach ($segments as $index => $segment) {
      if ($index === 0) {
        $segments[$index] = $segment;
      } else {
        $segments[$index] = ucfirst($segment);
      }
    }

    return implode('', $segments);
  }
}
