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

// Function to display members in a specific order based on $set value
function displayMembersBySet($names, $set)
{
  $count = count($names);

  if ($count === 0) {
    println("No members found.");
    return;
  }

  if ($set === 1) {
    for ($i = 0; $i < $count; $i += 2) {
      $nextIndex = $i + 1;
      $nextName = isset($names[$nextIndex]) ? $names[$nextIndex] : '';
      println("{$names[$i]} -> $nextName");
    }
  } elseif ($set === 2) {
    for ($i = $count - 1; $i >= 0; $i -= 2) {
      $prevIndex = $i - 1;
      $prevName = isset($names[$prevIndex]) ? $names[$prevIndex] : '';
      println("{$names[$i]} -> $prevName");
    }
  } else {
    println("Invalid set value. Please use 1 or 2.");
  }

}

// Path to the members.txt file
$filename = "members.txt";

// Call the function to read members from the file
$members = readMembers($filename);

// Set the desired set value (1 or 2)
$set = (integer)$_GET["set"];

// Call the function to display members based on the set value
displayMembersBySet($members, $set);
?>