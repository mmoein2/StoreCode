<?php
namespace App\Utility;
class FireBase
{
    private $key;
    public function __construct()
    {
        $this->key = env('FIREBASE_SECRET_KEY');
    }

    public function send($play_id,$message)
    {
        $path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
                'to' => $play_id,
                'priority' => 10,
                'data' => array('message' =>$message)
            );
            $headers = array(
                'Authorization:key='.$this->key,
                'Content-Type:application/json'
            );
     $ch = curl_init();
    // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // Execute post
        $result = curl_exec($ch);
          // Close connection
         curl_close($ch);
        return $result;
        }


}
    ?>