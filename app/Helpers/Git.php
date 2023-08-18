<?php
namespace App\Helpers;

use App\Helpers\Str;

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
    return Str::truncateWithMiddleEllipsis(self::commitHash(), $padLength, $padLength);
  }
}
