<?php

namespace App\Console\Commands;

use App\Helpers\Discord;
use Exception;
use Illuminate\Console\Command;

class DiscordSendCustomMessageCommand extends Command
{
  protected $signature = "discord:message {message}";
  protected $description = "send a custom message to discord webhook";

  public function handle()
  {
    try {
      Discord::customMessage($this->argument("message"));
      $this->info("sent successfully to ".env('DISCORD_WEBHOOK_URL'));
    } catch (Exception $e) {
      $this->error($e->getMessage());
    }
  }
}
