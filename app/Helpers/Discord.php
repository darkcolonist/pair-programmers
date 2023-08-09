<?php
namespace App\Helpers;

class Discord{
  static function verifyEndpoint(): array
  {
    $headers = $_SERVER;
    $payload = file_get_contents('php://input');
    $publicKey = env('DISCORD_PUBIC_KEY','YOUR_PUBLIC_KEY');

    if (
        !isset($headers['HTTP_X_SIGNATURE_ED25519'])
        || !isset($headers['HTTP_X_SIGNATURE_TIMESTAMP'])
    )
        return ['code' => 401, 'payload' => null];

    $signature = $headers['HTTP_X_SIGNATURE_ED25519'];
    $timestamp = $headers['HTTP_X_SIGNATURE_TIMESTAMP'];

    if (!trim($signature, '0..9A..Fa..f') == '')
        return ['code' => 401, 'payload' => null];

    $message = $timestamp . $payload;
    $binarySignature = sodium_hex2bin($signature);
    $binaryKey = sodium_hex2bin($publicKey);

    if (!sodium_crypto_sign_verify_detached($binarySignature, $message, $binaryKey))
        return ['code' => 401, 'payload' => null];

    $payload = json_decode($payload, true);
    switch ($payload['type']) {
        case 1:
            return ['code' => 200, 'payload' => ['type' => 1]];
        case 2:
            return ['code' => 200, 'payload' => ['type' => 2]];
        default:
            return ['code' => 400, 'payload' => null];
    }
  }
}
