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

  static function commitHashShort($padLength = 4){
    $commitHash = '145ff7e5c0d2717ee6a47a72d39811dbdfba9e70';
    $shortenedHash = substr($commitHash, 0, $padLength) . '...' . substr($commitHash, -$padLength);

    return $shortenedHash;
  }
}
