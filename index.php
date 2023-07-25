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

function println($string = ''){
  echo "{$string}\n";
}

function generateAsciiTable($data)
{
    $table = '';
    // Calculate the maximum length of each column
    $maxColumnLengths = array_map('max', ...array_map(function ($row) {
        return array_map('strlen', $row);
    }, $data));

    // Generate the table header
    $table .= "+-" . implode("-+-", array_map(function ($length) {
        return str_repeat("-", $length);
    }, $maxColumnLengths)) . "-+\n";

    // Generate the table rows
    foreach ($data as $row) {
        $table .= "| " . implode(" | ", array_map(function ($value, $length) {
            return str_pad($value, $length, " ", STR_PAD_RIGHT);
        }, $row, $maxColumnLengths)) . " |\n";
        $table .= "+-" . implode("-+-", array_map(function ($length) {
            return str_repeat("-", $length);
        }, $maxColumnLengths)) . "-+\n";
    }

    return $table;
}

// Call the function to read members from the file
$members = fileToArray("members.txt");
$currents = fileToArray("current.txt");
$rotations = (integer)$currents[0];
$pairs = createPairs($members);
$currentPair = $pairs[$rotations % count($pairs)];
header("content-type: text/plain");
println("pair up #" . $rotations);
println("date: " . date('r'));

echo generateAsciiTable($currentPair);
?>