<?php

namespace App\Http\Controllers;

use App\Custom\Khalti;
use Illuminate\Http\Request;

class KhaltiController extends Controller
{
  public function verify(Request $request)
  {
    $response = Khalti::verify($request->input('amount'), $request->input('token'));

    return response()->json(['response' => $response]);
  }

  public function transaction($idx = 'jXdqYnXkzPkhcLwDDw36ch')
  {
//    $transaction = Khalti::transaction($idx);

    $url = "https://khalti.com/api/transaction/{$idx}/";

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

    return response()->json(['transaction' => json_decode($response)]);
  }

  public function transactions()
  {
    // $transactions = Khalti::transactions();

    $url = "https://khalti.com/api/transaction/";

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

    return response()->json(['transactions' => $response]);
  }
}
