<?php
namespace App\Helpers;

use DateTime;

class DateSkipper{
  static function datesHumanReadable()
  {
    $skipDatesString = env('SKIP_DATES', ''); // Fetch the SKIP_DATES string from .env
    if (empty($skipDatesString)) {
      $skipDatesArray = []; // Return an empty array
    } else {
      $skipDatesArray = array_map(function ($date) {
        $date = trim($date); // Trim whitespace
        $timestamp = strtotime($date); // Convert the date to a timestamp

        $endDate = new DateTime($date);
        $now = new DateTime();

        $interval = $now->diff($endDate);
        $daysDifference = $interval->days;

        if($now > $endDate)
          $daysDifference = $daysDifference * -1;

        return [
          date('l Y-m-d [e]', $timestamp),
          $daysDifference
        ];
      }, explode(',', $skipDatesString));
    }
    return $skipDatesArray;
  }

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
