<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class Discord{
  static function getCurrentMessage(){
    $currentAsciiTable = Pairs::currentAsciiTableSlim();

    return "Good Day Programmers!\n\n".
      "Here are today's pairs:\n\n".
      "```{$currentAsciiTable}```\n".
      "Let the coding begin and may the odds be ever in your favor!\n".
      "see ".env('APP_URL')." for more"
      ;
  }

  static function current()
  {
    $webhookUrl = env('DISCORD_WEBHOOK_URL', 'YOUR_WEBHOOK_URL_HERE');

    $data = [
      'content' => self::getCurrentMessage()
    ];

    $response = Http::withoutVerifying()
      ->post($webhookUrl, $data);

    return $response;
  }
}
