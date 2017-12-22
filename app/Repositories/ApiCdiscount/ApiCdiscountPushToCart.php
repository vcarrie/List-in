<?php
/**
 * Created by PhpStorm.
 * User: valentin
 * Date: 24/11/17
 * Time: 16:47
 */

namespace App\Repositories\ApiCdiscount;


class ApiCdiscountPushToCart
{

    public function createCart($id, $quantity)
    {
        $template = file_get_contents("app/Repositories/ApiCdiscount/templateCreateCart.txt");
        $delimiter = explode("$1", $template);

        $file = $delimiter[0] . $id . $delimiter[1] . $quantity . $delimiter[2];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, "https://api.cdiscount.com/OpenApi/json/PushToCart");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $file);
        $json = curl_exec($ch);
        curl_close($ch);

        return json_decode($json);
    }

    public function pushToCart($id, $quantity, $idCart)
    {
        $template = file_get_contents("app/Repositories/ApiCdiscount/templatePushToCart.txt");
        $delimiter = explode("$1", $template);

        $file = $delimiter[0] . $idCart. $delimiter[1] . $id . $delimiter[2] . $quantity . $delimiter[3];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, "https://api.cdiscount.com/OpenApi/json/PushToCart");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $file);
        $json = curl_exec($ch);
        curl_close($ch);

        return json_decode($json);
    }
}