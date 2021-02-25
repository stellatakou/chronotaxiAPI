<?php

namespace App\Helpers;

class Helper
{
    public static function getDistance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('miles', 'feet', 'yards', 'kilometers', 'meters');
    }

    public static function sendNotificationIOS()
    {
        $url = "https://fcm.googleapis.com/fcm/send";
        $registrationIds = array($_GET['id']);
        $serverKey = env("GCM_KEY");
        $title = "Push Notification";
        $body = "This is body.";
        $notification = array('title' => $title, 'text' => $body, 'sound' => 'default', 'badge' => '1');

        $arrayToSend = array('registration_ids' => $registrationIds, 'notification' => $notification, 'priority' => 'high');
        $json = json_encode($arrayToSend);
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=' . $serverKey;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //Send the request
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }

        curl_close($ch);
        return $result;
    }

    public static function sendNotification()
    {
        define('SERVER_KEY', env("GCM_TOKEN"));
        $registrationIds = array($_GET['id']);
        // prep the bundle
        $msg = array(
            'message'     => 'here is a message. message',
            'title'        => 'This is a title. title',
            'subtitle'    => 'This is a subtitle. subtitle',
            'vibrate'    => 1,
            'sound'        => 1,
            'largeIcon'    => 'large_icon',
            'smallIcon'    => 'small_icon'
        );

        $fields = array(
            'to ' => $registrationIds, //for single user  (OR)
            //'registration_ids' => $registrationIds, //  for  multiple users
            'data'    => $msg
        );

        $headers = array(
            'Authorization: key=' . SERVER_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

    public static function getStatusColor($code){
        if($code == "ENC") return "success";
        if($code == "PEN") return "default";
        if($code == "REF") return "danger";
        if($code == "TER") return "primary";
    }

    public static function getRankcolor($rank){
        if($rank == 1) return "primary";
        if($rank == 2) return "success";
        if($rank == 3) return "default";
        if($rank == 3) return "warning";
        if($rank == 4) return "danger";
    }
}
