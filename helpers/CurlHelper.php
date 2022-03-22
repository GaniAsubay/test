<?php
namespace app\helpers;
use app\models\Supplier;

/**
 * Created by PhpStorm.
 * User: gani
 * Date: 3/22/22
 * Time: 10:15 PM
 */
class CurlHelper
{
    /**
     * отправка запроса
     * демо верся )
     * @param $url
     * @param $type
     * @return int
     */
    public static function sendCurl($url, $type)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

        if ((int)$type === Supplier::REQUEST_TYPE_POST) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, []);
        }

      /*$result = curl_exec($ch);
        curl_close ($ch);*/
        return rand(0,1);
    }
}