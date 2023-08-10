<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class Discord{
  static function current()
  {
    $webhookUrl = env('DISCORD_WEBHOOK_URL', 'YOUR_WEBHOOK_URL_HERE');
    $currentAsciiTable = Pairs::currentAsciiTableSlim();
    $data = [
      'content' => "Good Day Programmers! Here are today's pairs:\n```{$currentAsciiTable}```\nLet the coding begin and may the odds be ever in your favor!",
    ];

    $response = Http::withoutVerifying()
      ->post($webhookUrl, $data);

    return $response;
  }
}
