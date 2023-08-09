<?php
namespace App\Helpers;

class File{
  static function fileToArray($filename)
  {
    if (!file_exists($filename)) {
      throw new \Exception("The file '$filename' does not exist.");
    }

    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    return $lines;
  }

  static function fileStat($filename)
  {
    if (!file_exists($filename)) {
      throw new \Exception("The file '$filename' does not exist.");
    }

    $stat = stat($filename);

    $neededStat = [];

    $neededStat["atime"] = $stat["atime"];
    $neededStat["mtime"] = $stat["mtime"];
    $neededStat["ctime"] = $stat["ctime"];

    return $neededStat;
  }
}
