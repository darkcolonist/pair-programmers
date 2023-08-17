<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;

class TestLogCommand extends Command
{
  protected $signature = "test:log {message}";
  protected $description = "write to debug log file";

  public function handle()
  {
    app('log')->channel('debug')->info(get_class($this) . ": " . $this->argument("message"));
    $this->info("logged to debug.log: ".$this->argument("message"));
  }
}
