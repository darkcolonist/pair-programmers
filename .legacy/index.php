<?php
function createPairs($members){
  $n = count($members);
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

function fileToArray($filename)
{
  if (!file_exists($filename)) {
    throw new Exception("The file '$filename' does not exist.");
  }

  $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

  return $lines;
}

function fileStat($filename)
{
  if (!file_exists($filename)) {
    throw new Exception("The file '$filename' does not exist.");
  }

  $stat = stat($filename);

  $neededStat = [];

  $neededStat["atime"] = date("r", $stat["atime"]);
  $neededStat["mtime"] = date("r", $stat["mtime"]);
  $neededStat["ctime"] = date("r", $stat["ctime"]);

  return $neededStat;
}

function println($string = ''){
  echo "{$string}\n";
}

// https://stackoverflow.com/a/6557863/27698
function fisherYatesShuffle($items, $seed)
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

function shuffleAll($items){
  $seedToday = date("Ymd", strtotime("now"));

  if(isset($_GET['random_shuffle']))
    $seedToday = rand();

  $shuffled = fisherYatesShuffle($items, $seedToday);

  foreach ($shuffled as $key => $anItem) {
    $shuffled[$key] = fisherYatesShuffle($anItem, intval("{$seedToday}{$key}"));
  }

  return $shuffled;
}

// credits to chatGPT
function generateAsciiTable($data)
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

$members = fileToArray("members.txt");
$currents = fileToArray("current.txt");
$rotations = (integer)$currents[0];

// below is where the engine starts
$pairs = createPairs($members);
$currentPair = $pairs[$rotations % count($pairs)];

header("content-type: text/plain");
println("pair up #" . $rotations);
println("generated: " . fileStat("current.txt")["mtime"]);
$shuffledRowPairs = shuffleAll($currentPair);
echo generateAsciiTable($shuffledRowPairs);
// println(generateAsciiTable($currentPair)); // if you don't want shuffling
?>