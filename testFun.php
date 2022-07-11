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
const API_PARAGRAPH = 'results';

/**
 * 排序方式
 * bySale = 有貨優先, 
 * byRanking = 精準度, 
 * byPriceDc = 價格由高到底, 
 * byPriceAc = 價格由低到高
 * newProd = 新商品
 */
const SORT_TYPE = [
    'bySale' => 'sale/dc',
    'byRanking' => 'rnk/dc',
    'byPriceDC' => 'prc/dc',
    'byPriceAC' => 'prc/ac',
    'newProd' => 'new/dc'
];

/**
 * 查詢來源
 * all = 全部, 
 * by24h = 查24h商店, 
 * by24hBooks = 查24h書店, 
 * byVendor = 廠商出貨
 * byTour = pchome旅遊
 * mercari = 日本mercari //TODO 這是另一個API要改寫
 */
const SOURCE_TYPE = [
    'all' => 'all/',
    'by24h' => '24h/',
    'by24hBooks' => '24b/',
    'byVendor' => 'vdr/',
    'byTour' => 'tour/',
    // 'mercari' => 'mercari/'
];

$result = findPchomeEC($argv);

echo '查詢[' . $argv[1] . ']的結果共: ' . $result['count'] . '筆' . PHP_EOL;

foreach ($result['prod'] as $row) {

    if (count($row['couponActid']) > 0) {
        $couponId = PHP_EOL . '　　　這個有優惠券:' . json_encode($row['couponActid']);
    } else {
        $couponId = '';
    }

    echo "https://24h.pchome.com.tw/prod/{$row['Id']}   商品名稱:{$row['name']},價格:{$row['price']}(原價{$row['originPrice']}){$couponId}" . PHP_EOL;
}


function findPchomeEC($argv = [])
{
    $key = $argv[1];
    $type = $argv[2];
    $sort = $argv[3];

    $searchKey = '?q=' . $key . '&';
    $sourceType = SOURCE_TYPE[$type];
    $sortType = SORT_TYPE[$sort];

    $apiUrl = API_DOMAIN . API_FUNCTION . API_VERSION . $sourceType . API_PARAGRAPH . $searchKey . $sortType;

    $result = grabIt($apiUrl, 'GET');

    $result = json_decode($result, true);

    $formatResult = [
        'prod' => $result['prods'],
        'count' => count($result['prods'])
    ];

    return $formatResult;
}

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
            CURLOPT_CUSTOMREQUEST => $request
        ]
    );

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}
