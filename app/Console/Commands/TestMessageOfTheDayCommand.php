<?php

namespace App\Console\Commands;

use App\Helpers\Inspire;
use Exception;
use Illuminate\Console\Command;

class TestMessageOfTheDayCommand extends Command
{
  protected $signature = "test:motd";
  protected $description = "display message of the day";

  public function handle()
  {
    $startTime = microtime(true); // Get the current time with microseconds

    $messageOfTheDay = Inspire::today();

    $endTime = microtime(true);
    $executionTime = $endTime - $startTime; // Calculate the execution time in seconds

    $this->info($messageOfTheDay);
    $this->info("Execution time: " . round($executionTime, 2) . " seconds");
  }
}
