<?php

require 'environment.php';

$config = array();

define('RAIZ', '/Romuliso/classificados_mvc/');

if(ENVIRONMENT == 'development') {
	define("BASE_URL","http://localhost/classificados_mvc/");
	$config['dbname'] = 'mundodireito';
	$config['host'] = 'http://cloud272.configrapp.com';
	$config['dbuser'] = 'root';
	$config['dbpass'] = '';
} else {
	define("BASE_URL","http://webapp11051.cloud272.configrapp.com/");
	$config['dbname'] = 'mundodireito';
	$config['host'] = 'http://cloud272.configrapp.com';
	$config['dbuser'] = 'mundodireito';
	$config['dbpass'] = 'MfyK5RHDMTqqCvrJf8pxDh';
}

global $db;
try {
	$db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'],$config['dbuser'],$config['dbpass']);
} catch(PDOException $e) {
	echo "ERRO: ".$e->getMessage();
	exit;
}