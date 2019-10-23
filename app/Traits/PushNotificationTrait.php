<?php

namespace app\Traits;

trait PushNotificationTrait
{
  // keys of message must be 'title' and 'message'
  public $pushNotificationMessage = [];
  public $deviceTokens = [];
  // authorization key is unique per application.
  public $authorizationKey;
  // public $authorizationKeyAndroid = 'AAAAXQZYu0o:APA91bFIU0eswtG95fbiha9iPs92N2CUYQ-PQb0PCQp20sAoJw-H4antVIcMveIdn8j2cJfIeyWlBgE2KQ3Zqqw0uTXugrLFhhssM4jIEMMj65Auntmq-j2_4ZcM_t8kzZxU-sFLM4S7';
  // public $authorizationKeyIos = 'AAAANhlG5Qo:APA91bHOekKe0XPmqRC61xczqIvSO5-UXPr5SzJIwgbVtcMzmVKkDAZC_sD91_ylLtBgP-7k68XWnBoxZNeEnWfN3mO8kemfn4zDF8v4AhfBDURhRsmarpDJfsR9yYUNgX3yF4g0c7Nt';

  public function send_push_notification_android()
  {
    $url     = 'https://fcm.googleapis.com/fcm/send';
    $fields  = [
        'registration_ids' => $this->deviceTokens,
        'data'             => $this->pushNotificationMessage,
    ];
    $headers = [
        "Authorization:key = {$this->authorizationKey}",
        "Content-Type: application/json",
    ];
    $ch      = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $response = curl_exec($ch);
    if ($response === FALSE) {
      die('Curl failed: ' . curl_error($ch));
    }
    curl_close($ch);

    return $response;
  }

  public function send_push_notification_ios()
  {
    /*foreach ($this->deviceTokenIos as $deviceToken) {
      //  push_token
      $ch = curl_init("https://fcm.googleapis.com/fcm/send");
      //The device token.
      $token = $deviceToken;
      //Title of the Notification.
      $title = $this->message['title'];
      //Body of the Notification.
      $body = $this->message['message'];
      //Creating the notification array.
      $notification = ['title' => $title, 'text' => $body, 'sound' => 'default'];
      $arrayToSend  = ['to' => $token, 'notification' => $notification, 'priority' => 'high'];
      //Generating JSON encoded string form the above array.
      $json = json_encode($arrayToSend);
      //Setup headers:
      $headers   = [];
      $headers[] = "Content-Type: application/json";
      $headers[] = "Authorization: key= {$this->authorizationKeyIos}"; // key here
      //Setup curl, add headers and post parameters.
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      //Send the request
      $response = curl_exec($ch);
      //Close request
      curl_close($ch);
    }*/

    //  push_token
    $ch = curl_init("https://fcm.googleapis.com/fcm/send");
    //The device token.
    $token = $this->deviceTokens;
    //Title of the Notification.
    $title = $this->pushNotificationMessage['title'];
    //Body of the Notification.
    $body = $this->pushNotificationMessage['message'];
    //Creating the notification array.
    $notification = ['title' => $title, 'text' => $body, 'sound' => 'default'];
    $arrayToSend  = ['to' => $token, 'notification' => $notification, 'priority' => 'high'];
    //Generating JSON encoded string form the above array.
    $json = json_encode($arrayToSend);
    //Setup headers:
    $headers   = [];
    $headers[] = "Content-Type: application/json";
    $headers[] = "Authorization: key= {$this->authorizationKey}"; // key here
    //Setup curl, add headers and post parameters.
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //Send the request
    $response = curl_exec($ch);
    //Close request
    curl_close($ch);

    return $response;
  }
}
