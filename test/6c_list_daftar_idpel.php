<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$order[0]['dir'] = 'asc';
$search['value'] = '';

$detail = '{
  "action" : "list",
  "noid" : "8188468291",
  "product" : "lorem ipsum",
  "product_detail" : "lorem ipsum dolor"
}';

$param = array(
	'detail' => json_decode($detail),
	'draw' => '1',
	'start' => '0',
	'length' => '10',
	'order' => $order,
	'search' => $search,
	'noid' => $_SESSION['noid'],
	'username' => USERNAME,
	'token' => $_SESSION['token'],
	'appid' => APPID
);

echo $json_request = json_encode($param);
echo '

';
echo $url_request = BASE_URL . 'RPAGINGPOS/act/REPORT/mob_daftar_idpel/MOBILE';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;
