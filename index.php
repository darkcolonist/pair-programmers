<?php
header("content-type: text/plain");
// Function to read file and return an array of names
function readMembers($filename)
{
  // Open the file for reading
  $file = fopen($filename, "r");

  // Initialize an array to store the names
  $names = array();

  // Loop through each line in the file
  while (!feof($file)) {
    $name = fgets($file);
    // Trim any leading/trailing whitespace
    $name = trim($name);

    // Add the name to the array
    if (!empty($name)) {
      $names[] = $name;
    }
  }

  // Close the file
  fclose($file);

  return $names;
}

function println($string = ''){
  echo "{$string}\n";
}

// Function to rotate the array based on $rotate value
function rotateArrayInefficient($array, $rotate)
{
  $count = count($array);

  if ($count === 0 || $rotate === 0) {
    return $array;
  }

  $rotate = $rotate % $count; // In case $rotate is greater than the array size

  for ($i = 0; $i < $rotate; $i++) {
    $element = array_shift($array);
    array_push($array, $element);
  }

  return $array;
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

// Function to display members in a specific order based on $set value
function getMemberPairings($names, $set)
{
  $count = count($names);

  if ($count === 0) {
    println("No members found.");
    return;
  }

  $rotatedNames = rotateArray($names, $set);

  $pairings = [];

  for ($i = 0; $i < $count; $i += 2) {
    $nextIndex = $i + 1;
    $nextName = isset($rotatedNames[$nextIndex]) ? $rotatedNames[$nextIndex] : '';

    $pairings[] = [$rotatedNames[$i], $nextName];
  }

  return $pairings;
}


// Function to display members in a specific order based on $set value
function displayMembersBySet($names, $set)
{
  $count = count($names);

  if ($count === 0) {
    println("No members found.");
    return;
  }

  // if ($set === 1) {
  $rotatedNames = rotateArray($names, $set);

  for ($i = 0; $i < $count; $i += 2) {
    $nextIndex = $i + 1;
    $nextName = isset($rotatedNames[$nextIndex]) ? $rotatedNames[$nextIndex] : '';
    println("{$rotatedNames[$i]} -> $nextName");
  }
  // } elseif ($set === 2) {
  //   for ($i = $count - 1; $i >= 0; $i -= 2) {
  //     $prevIndex = $i - 1;
  //     $prevName = isset($names[$prevIndex]) ? $names[$prevIndex] : '';
  //     println("{$names[$i]} -> $prevName");
  //   }
  // } else {
  //   println("Invalid set value. Please use 1 or 2.");
  // }

}

// Call the function to read members from the file
$members = readMembers("members.txt");

// Set the desired set value (1 or 2)
$set = (integer)$_GET["set"];

// Call the function to display members based on the set value
// displayMembersBySet($members, $set);
$pairs = getMemberPairings($members, $set);
print_r($pairs);
?>