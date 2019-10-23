<?php

namespace App\Custom;

class Khalti
{
  public static function verify($amount, $token)
  {
    $args = http_build_query([
      'token'  => $token,
      'amount' => $amount,
    ]);

    $url = "https://khalti.com/api/payment/verify/";

    # Make the call using API.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $headers = ["Authorization: Key " . config('services.khalti.test_secret_key')];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Response
    $response    = curl_exec($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return json_decode($response, true);
  }

  public static function transaction($idx)
  {
    $url = "https://khalti.com/api/transaction/{$idx}/";

    return self::curl_get($url);
  }

  public static function transactions()
  {
    $url = "https://khalti.com/api/transaction/";

    return self::curl_get($url);
  }

  private static function curl_get($url)
  {
    # Make the call using API.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $headers = ["Authorization: Key " . config('services.khalti.test_secret_key')];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Response
    $response    = curl_exec($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return json_decode($response, true);
  }
}