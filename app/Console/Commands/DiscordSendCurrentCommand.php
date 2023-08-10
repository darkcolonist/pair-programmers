<?php

namespace App\Console\Commands;

use App\Helpers\Discord;
use Exception;
use Illuminate\Console\Command;

class DiscordSendCurrentCommand extends Command
{
  protected $signature = "discord:current";
  protected $description = "send the current pairs to discord webhook";

  public function handle()
  {
    try {
      Discord::current();
      $this->info("sent successfully to ".env('DISCORD_WEBHOOK_URL'));
    } catch (Exception $e) {
      $this->error($e->getMessage());
    }
  }
}
