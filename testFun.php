<?php

/**
 * 20220711 ALlen init
 * 以pchome 24h 爬蟲為例子
 */

$param = $argv[1];

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://ecshweb.pchome.com.tw/search/v3.3/all/results?q=' . $param . '&page=1&sort=rnk/dc',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Cookie: U=c7c9be50ba855fb7c2566f0266a1d7d5ba792931'
    ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
