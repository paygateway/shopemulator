<?php

require_once( '../config/config.php' );
require '../vendor/autoload.php';

$config = getConfig();

$data = $_POST;

$data['signature'] = "{$data['opertype']}:";
if ( $data['opertype'] != 'check' && $data['opertype'] != 'unblock' ) {
	$data['signature'] .= "{$data['amount']}:";
	$data['amount' . $data['opertype']] = $data['amount'];
	unset($data['amount']);

}
$data['signature'] .= "{$data['account']}:{$data['transID']}:";
$data['signature'] .= "{$data['key1']}:{$data['key2']}";

$hashing_method = isset($config['hashing_method']) ? $config['hashing_method'] : 'md5';
$hashed = ($hashing_method=='md5') ? $hashing_method($data['signature']) : $hashing_method('sha256',$data['signature'], $data['key1'].$data['key2']);

$data['signature'] = strtoupper( $hashed );


unset($data['key1']);
unset($data['key2']);

$act_url = $config['epos_operate_url'];

$data['frontend_uri'] = $config['frontend_uri'];
$data['shop_uri'] = $config['shop_uri'];

$client = new \GuzzleHttp\Client();

$response = $client->post( $act_url , [
	'body'    => $data,
	'verify'  => false
] );

$resp_data = $response->json();

include_once('header.php');
?>
<h1>РЕЗУЛЬТАТ ОПЕРАЦИИ</h1>

<?php
var_dump($resp_data);

include_once('footer.php');