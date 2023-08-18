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
    if(!env('DISCORD_SEND_CURRENT')){
      $this->info('DISCORD_SEND_CURRENT is false');
      return false;
    }

    try {
      $result = Discord::current();
      if ($result)
        $this->info('message sent successfully to ' . Discord::webhookURL(true));
      else
        $this->info('unable to send message to ' . Discord::webhookURL(true));
    } catch (Exception $e) {
      $this->error($e->getMessage());
    }
  }
}
