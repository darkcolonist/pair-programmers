<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Str;
use App\Helpers\Str;

class Discord{
  static function getCurrentMessage(){
    $currentAsciiTable = Pairs::currentAsciiTableSlim();

    return "Good Day Programmers!\n\n".
      "Here are today's pairs:\n\n".
      "```{$currentAsciiTable}```\n".
      "Message of the day:\n" .
      "\"".Inspire::today(). "\"\n\n".
      "See ".env('APP_URL')." for more. Happy Coding!"
      ;
  }

  static function webhookURL($mask = false){
    $webhookURL = env('DISCORD_WEBHOOK_URL', 'YOUR_WEBHOOK_URL_HERE');

    if($mask)
      $webhookURL = Str::truncateWithMiddleEllipsis($webhookURL, 20, 20, "···");

    return $webhookURL;
  }

  static function sendPost($url, $data){
    if($url == null)
      // return "DISCORD_WEBHOOK_URL is empty";
      return false;

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

  static function customMessage($message){
    $data = [
      'content' => $message
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
