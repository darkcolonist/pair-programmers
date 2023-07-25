<?php
header("content-type: text/plain");
// Function to read file and return an array of lines
function fileToArray($filename)
{
  // Read the entire file into an array, with each element representing a line
  $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

  return $lines;
}

function println($string = ''){
  echo "{$string}\n";
}

// Function to rotate the array based on $rotate value
function rotateArray($array, $rotate)
{
  $count = count($array);

  if ($count === 0 || $rotate === 0) {
    return $array;
  }

  $rotate = $rotate % $count; // In case $rotate is greater than the array size

  $slice1 = array_slice($array, $rotate);
  $slice2 = array_slice($array, 0, $rotate);

  return array_merge($slice1, $slice2);
}

// Function to display members in a specific order based on $rotations value
function getMemberPairings($names, $rotations)
{
  $count = count($names);

  if ($count === 0) {
    println("No members found.");
    return;
  }

  $rotatedNames = rotateArray($names, $rotations);

  $pairings = [];

  for ($i = 0; $i < $count; $i += 2) {
    $nextIndex = $i + 1;
    $nextName = isset($rotatedNames[$nextIndex]) ? $rotatedNames[$nextIndex] : '';

    $pairings[] = [$rotatedNames[$i], $nextName];
  }

  return $pairings;
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

function useCase1(){
  for ($i=0; $i < 5; $i++) {
    // Call the function to read members from the file
    $members = fileToArray("members.txt");
    $currents = fileToArray("current.txt");
    $rotations = (int)$currents[0];

    $pairs = getMemberPairings($members, $i);
    // Call the function to generate the ASCII table as a string
    $asciiTable = generateAsciiTable($pairs);
    echo $asciiTable;
    println('');
    println('');
  }
}

// Call the function to read members from the file
$members = fileToArray("members.txt");
$currents = fileToArray("current.txt");
$rotations = (integer)$currents[0];

// $pairs = getMemberPairings($members, $rotations);
// // Call the function to generate the ASCII table as a string
// $asciiTable = generateAsciiTable($pairs);
// echo $asciiTable;

useCase1();
?>