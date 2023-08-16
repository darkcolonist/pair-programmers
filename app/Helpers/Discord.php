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

  static function webhookURL() : string {
    return env('DISCORD_WEBHOOK_URL', 'YOUR_WEBHOOK_URL_HERE');
  }

  static function sendPost($url, $data) : \Illuminate\Http\Client\Response {
    return Http::withoutVerifying()
      ->post($url, $data);
  }

  static function current()
  {
    $data = [
      'content' => self::getCurrentMessage()
    ];

    $response = self::sendPost(self::webhookURL(), $data);

    return $response;
  }

  static function test(){
    $data = [
      'content' => uniqid() . " hello from " . config('app.name')
    ];

    $response = self::sendPost(self::webhookURL(), $data);

    return $response;
  }
}
