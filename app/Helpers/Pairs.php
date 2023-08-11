<?php
namespace App\Helpers;

class Pairs{
  static function createPairs($members){
    $n = count($members);

    if($n % 2 != 0){
      $members[] = "-";
      $n++;
    }

    $rounds = array();
    for ($r = 0; $r < $n - 1; $r++) {
      for ($i = 0; $i < $n / 2; $i++) {
        $rounds[$r][] = [$members[$i], $members[$n - 1 - $i]];
      }
      // Perform round-robin shift, keeping first player in its spot:
        $members[] = array_splice($members, 1, 1)[0];
    }
    // shift once more to put array in its original sequence:
    $members[] = array_splice($members, 1, 1)[0];
    return $rounds;
  }

  static function println($string = ''){
    echo "{$string}\n";
  }

  // https://stackoverflow.com/a/6557863/27698
  static function fisherYatesShuffle($items, $seed)
  {
    @mt_srand($seed);
    for ($i = count($items) - 1; $i > 0; $i--) {
      $j = @mt_rand(0, $i);
      $tmp = $items[$i];
      $items[$i] = $items[$j];
      $items[$j] = $tmp;
    }

    return $items;
  }

  static function shuffleAll($items){
    $seedToday = date("Ymd", strtotime("now"));

    if(isset($_GET['random_shuffle']))
    $seedToday = rand();

    $shuffled = self::fisherYatesShuffle($items, $seedToday);

    foreach ($shuffled as $key => $anItem) {
      $shuffled[$key] = self::fisherYatesShuffle($anItem, intval("{$seedToday}{$key}"));
    }

    return $shuffled;
  }

  // credits to chatGPT
  static function generateAsciiTable($data)
  {
    $table = '';
    // Calculate the maximum length of each column
    $maxColumnLengths = array_map('max', ...array_map(function ($row) {
      return array_map('strlen', $row);
    }, $data));

    // Generate the table header
    $table .= "+-" . implode("-+-", array_map(function ($length) {
      return str_repeat("-", $length + 4);
    }, $maxColumnLengths)) . "-+\n";

    // Generate the table rows
    foreach ($data as $row) {
      $table .= "|  " . implode("  |  ", array_map(function ($length) {
        return str_repeat(" ", $length + 2);
      }, $maxColumnLengths)) . "  |\n";
      $table .= "|  " . implode("  |  ", array_map(function ($value, $length) {
        return str_pad($value, $length + 2, " ", STR_PAD_BOTH);
      }, $row, $maxColumnLengths)) . "  |\n";
      $table .= "|  " . implode("  |  ", array_map(function ($length) {
        return str_repeat(" ", $length + 2);
      }, $maxColumnLengths)) . "  |\n";
      $table .= "+-" . implode("-+-", array_map(function ($length) {
        return str_repeat("-", $length + 4);
      }, $maxColumnLengths)) . "-+\n";
    }

    return rtrim($table, "\n");
  }

  static function current($mode = "normal"){
    $members = File::fileToArray(storage_path('app/members.txt'));

    if($mode == "reduced"){
      $members = self::reduceMembersToFirstNameOnly($members);
    }

    $currents = File::fileToArray(storage_path('app/current.txt'));
    $rotations = (integer)$currents[0];

    // below is where the engine starts
    $pairs = self::createPairs($members);
    $currentPair = $pairs[$rotations % count($pairs)];
    $shuffledRowPairs = self::shuffleAll($currentPair);

    return $shuffledRowPairs;
  }

  static function custom($incrementToCurrent, $mode = "normal", $overrideCurrent = null, $shuffleMembersSeed = null){
    $members = File::fileToArray(storage_path('app/members.txt'));
    $rotations = $overrideCurrent;

    if($rotations === null){
      $currents = File::fileToArray(storage_path('app/current.txt'));
      $rotations = (int)$currents[0];
    }

    if($shuffleMembersSeed !== null)
      $members = self::fisherYatesShuffle($members, $shuffleMembersSeed);

    if ($mode == "reduced") {
      $members = self::reduceMembersToFirstNameOnly($members);
    }

    $rotations += $incrementToCurrent;
    if($rotations < 0)
      $rotations = 0;

    $pairs = self::createPairs($members);
    $currentPair = $pairs[$rotations % count($pairs)];

    if($shuffleMembersSeed === null){
      return $currentPair;
    }else{
      $shuffledRowPairs = self::shuffleAll($currentPair);

      return $shuffledRowPairs;
    }
  }

  static function currentAsciiTable(){
    $currents = File::fileToArray(storage_path('app/current.txt'));
    $rotations = (int)$currents[0];
    $shuffledRowPairs = self::current();
    $disp = "pair up #" . $rotations . "\n";
    $disp .= "generated: " . date("r",File::fileStat(storage_path('app/current.txt'))["mtime"]) . "\n";
    $disp .= self::generateAsciiTable($shuffledRowPairs) . "\n";
    return $disp;
  }

  private static function reduceMembersToFirstNameOnly($members){
    $reduced = [];
    foreach ($members as $key => $value) {
      $fields = explode(',', $value);
      $reduced[$key] = $fields[0];
    }
    return $reduced;
  }

  static function currentAsciiTableSlim()
  {
    $currents = File::fileToArray(storage_path('app/current.txt'));
    $rotations = (int)$currents[0];
    $shuffledRowPairs = self::current("reduced");
    $disp = "pair up #" . $rotations . "\n";
    $disp .= "generated: " . date("D, d M Y g:ia O", File::fileStat(storage_path('app/current.txt'))["mtime"]) . "\n";
    $disp .= self::generateAsciiTable($shuffledRowPairs) . "\n";
    return $disp;
  }

  static function currentWithMeta() : array {
    $currents = File::fileToArray(storage_path('app/current.txt'));
    $rotations = (int)$currents[0];

    return [
      "pairs" => self::current(),
      "generated" => gmdate(DATE_ATOM,File::fileStat(storage_path('app/current.txt'))["mtime"]),
      "rotations" => $rotations,
    ];
  }

  private static function shortenNameForSimulation($name){
    return substr(strtoupper(str_replace(' ', '', $name)), 0, 3);
  }

  private static function getSeason($membersCount, $current){
    return floor($current/ ($membersCount-1));
  }

  static function simulations($count = 1) : array {
    $members = File::fileToArray(storage_path('app/members.txt'));
    $pairs = [];
    for ($i=0; $i < $count; $i++) {
      $season = self::getSeason(count($members), $i);

      $pair = self::custom($i, "reduced", 0, $season == 0 ? null : $season);

      $newPair = [];
      $newPair[] = "rotation $i";
      // $newPair[] = "modulo ". $i % (count($members) - 1);
      $newPair[] = "season $season";
      foreach ($pair as $pairValue) {
        $left = self::shortenNameForSimulation($pairValue[0]);
        $right = self::shortenNameForSimulation($pairValue[1]);
        // $left = $pairValue[0];
        // $right = $pairValue[1];
        $newPair[] = "$left-$right";
      }

      $pairs[] = $newPair;
    }

    return [
      "pairs" => $pairs
    ];
  }
}
