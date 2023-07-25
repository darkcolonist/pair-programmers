<?php
// Check if running from CLI
if (php_sapi_name() !== 'cli') {
    echo "This script can only be executed via CLI.";
    exit(1);
}

$file = __DIR__ . '/current.txt';

try {
  if (!file_exists($file)) {
    // Create the file if it doesn't exist
    file_put_contents($file, '0');
  }

  // Read the current value from the file
  $currentValue = intval(file_get_contents($file));

  // Increment the value by 1
  $newValue = $currentValue + 1;

  // Write the updated value back to the file
  if (!is_writable($file)) {
    throw new Exception("The file '$file' is not writable.");
  }

  file_put_contents($file, strval($newValue));

  echo "Current value: $currentValue\n";
  echo "Updated value: $newValue\n";
} catch (Exception $e) {
  echo "Error: " . $e->getMessage() . "\n";
}