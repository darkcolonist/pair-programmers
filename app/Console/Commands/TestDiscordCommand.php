<?php

namespace App\Console\Commands;

use App\Helpers\Discord;
use Exception;
use Illuminate\Console\Command;

class TestDiscordCommand extends Command
{
  protected $signature = "test:discord";
  protected $description = "send a test message to discord";

  public function handle()
  {
    $this->info(Discord::test());
  }
}
