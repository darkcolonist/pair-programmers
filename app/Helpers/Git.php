<?php
namespace App\Helpers;

class Git{
  static function commitHash()
  {
    $gitDirectory = base_path('.git');
    $headFile = $gitDirectory . '/HEAD';
    $headContents = file_get_contents($headFile);
    $commitHash;
    if (preg_match('/ref: (.+)/', $headContents, $matches)) {
      $commitRef = trim($matches[1]);
      $commitHashFile = $gitDirectory . '/' . $commitRef;
      $commitHash = trim(file_get_contents($commitHashFile));
    } else {
      $commitHash = 'Unable to determine latest commit hash.';
    }

    return $commitHash;
  }
}
