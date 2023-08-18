<?php
namespace App\Helpers;

class DateSkipper{
  static function dates(){
    $skipDatesString = env('SKIP_DATES', ''); // Fetch the SKIP_DATES string from .env
    if (empty($skipDatesString)) {
      $skipDatesArray = []; // Return an empty array
    } else {
      $skipDatesArray = array_map('trim', explode(',', $skipDatesString)); // Split and trim
    }
    return $skipDatesArray;
  }

  static function matchToday()
  {
    $today = date('Y-m-d');
    $skipDatesArray = self::dates(); // Get the skip dates array

    return in_array($today, $skipDatesArray);
  }
}
