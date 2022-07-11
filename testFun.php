<?php

/**
 * 20220711 ALlen init
 * 以pchome 24h 爬蟲為例子
 */

/**
 * pchome 24h url
 */
const API_DOMAIN = 'https://ecshweb.pchome.com.tw/';

/**
 * pchome 24h func
 */
const API_FUNCTION = 'search/';

/**
 * pchome 24h 版本號
 */
const API_VERSION = 'v3.3/';

/**
 * pchome 24h 其他參數
 */
const API_PARAGRAPH = 'all/results';


$apiUrl = API_DOMAIN . API_FUNCTION . API_VERSION . API_PARAGRAPH;

$apiParam = '?q=' . $argv[1];

$apiUrl .= $apiParam;

$result = grabIt($apiUrl, 'GETR');

echo $result;

/**
 * cURL function
 */
function grabIt($apiUrl, $request)
{
    $curl = curl_init();

    curl_setopt_array(
        $curl,
        [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $request,
            CURLOPT_HTTPHEADER => [
                'Cookie: U=c7c9be50ba855fb7c2566f0266a1d7d5ba792931'
            ],
        ]
    );

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}
