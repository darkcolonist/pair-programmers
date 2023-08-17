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
      $result = Discord::customMessage($this->argument("message"));
      if($result)
        $this->info('message sent successfully to '.env('DISCORD_WEBHOOK_URL'));
      else
        $this->info('unable to send message to ' . env('DISCORD_WEBHOOK_URL'));
    } catch (Exception $e) {
      $this->error($e->getMessage());
    }
  }
}
