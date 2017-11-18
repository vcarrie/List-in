<?php

namespace App\Repositories\ApiCdiscount;


class ApiCdiscountSearchByKeywordRepository
{
    public function searchWithKeyword($keyword)
    {
        $template = file_get_contents("app/Repositories/ApiCdiscount/templateSearchByKeyword.txt");
        $delimiter = explode("$1", $template);

        $file = $delimiter[0] . $keyword . $delimiter[1];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, "https://api.cdiscount.com/OpenApi/json/Search");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $file);
        $json = curl_exec($ch);
        curl_close($ch);

        return json_decode($json, true);
    }
}
