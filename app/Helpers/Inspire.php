<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class Inspire{
  private static function defaultMessage(){
    return 'Let the coding begin and may the odds be ever in your favor!';
  }

  static function today()
  {
    if (env('QUOTE_SOURCE_URL')) {
      try {
        $response = Http::withoutVerifying()
          ->timeout(3) // Set a timeout of 3 seconds
          ->get(env('QUOTE_SOURCE_URL'));

        if ($response->successful()) {
          return $response->body();
        } else {
          return self::defaultMessage();
        }
      } catch (\Illuminate\Http\Client\RequestException $e) {
        // Handle request exceptions here
        return self::defaultMessage();
      } catch (\Illuminate\Http\Client\ConnectionException $e) {
        // Handle connection exceptions here
        return self::defaultMessage();
      } catch (\Exception $e) {
        // Handle other exceptions here
        return self::defaultMessage();
      }
    } else {
      return self::defaultMessage();
    }
  }
}
