<?php
$result = $_REQUEST;

function logStr($str, $dest=0, $debug_level=9)
{
  $f=null;
  if ($dest) // Лог в файл
  {
    $f="logs/{$dest}.log";
    $dest=3;
    $str.="\n";
    $str = date('c').' '.$str;
  }
  $raddr = isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'?';
  $saddr = isset($_SERVER['SERVER_ADDR'])?$_SERVER['SERVER_ADDR']:'?';
  $str = "{$raddr} {$saddr} $str";

  error_log($str, $dest, $f);

}

if($result['status']=='error') {
	$str = sprintf("Произошла ошибка [%s] %s", $result['errorcode'], $result['errortext']);
	if($_SERVER['REQUEST_METHOD']=='POST') {
		logStr($str, 'php_error');
	} else {
		echo $str;
	}

}