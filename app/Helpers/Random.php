<?php
namespace App\Helpers;

class Random{
  static function int($min, $max, $seed = null) : int {
    if($seed !== null)
      mt_srand($seed);

    $randint = mt_rand($min, $max);

    mt_srand(); // reset
    return $randint;
  }

  // https://stackoverflow.com/a/6557863/27698
  static function fisherYatesShuffle($items, $seed): array{
    @mt_srand($seed);
    for ($i = count($items) - 1; $i > 0; $i--) {
      $j = @mt_rand(0, $i);
      $tmp = $items[$i];
      $items[$i] = $items[$j];
      $items[$j] = $tmp;
    }

    return $items;
  }

  static function shuffleAll($items): array{
    $seedToday = date("Ymd", strtotime("now"));

    if(isset($_GET['random_shuffle']))
    $seedToday = rand();

    $shuffled = self::fisherYatesShuffle($items, $seedToday);

    foreach ($shuffled as $key => $anItem) {
      $shuffled[$key] = self::fisherYatesShuffle($anItem, intval("{$seedToday}{$key}"));
    }

    return $shuffled;
  }
}
