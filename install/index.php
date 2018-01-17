<?php

if (file_exists("../includes/config.php") AND file_exists("./look.int"))
{ 
	die('The system is already installed');
}

require_once './core.php';
$Cor = new coreInc();

if(file_exists('../includes/config.php')){
	require_once '../includes/config.php';
    define('TABLE_PREFIX', $config['table_prefix']);
    define('_host', $config['hostname']);
    define('_user', $config['username']);
    define('_pass', $config['password']);
    define('_base', $config['database']);

	require_once '../includes/db_mysqli.php';
	
    $db = new database(); 
    $db->connect();
}

if (isset($_GET['fase']) AND $_GET['fase'] == 'conect_db') {
	
	if(isset($_GET['ms']))
		$ms = 'Unable to connect to database';
	else
        $ms = false;
	
    $title = "Database Configuration";
    $Content_Body = ''.$ms.''; 	
    $Content_Body .= '<form action="index.php" method="post">';
    $Content_Body .= '<div class="table"><input type="text" name="host" placeholder="Database Host" size="30"></div>';
    $Content_Body .= '<div class="table"><input type="text" name="database" placeholder="Database Name" size="30"></div>';
    $Content_Body .= '<div class="table"><input type="text" name="username" placeholder="Database User Name" size="30"></div>';
    $Content_Body .= '<div class="table"><input type="text" name="password" placeholder="Database Password" size="30"></div>';
    $Content_Body .= '<div class="table"><input type="text" name="table_prefix" value="zdk_" placeholder="Table Prefix" size="30"></div>';
    $Content_Body .= '<div class="table_clear"><input type="submit" name="btn_inc_db_conf" value="siguiente" class="button"></div>';
    $Content_Body .= '</form>';
	
    include '../templates/Default_index.html';
	
} elseif (isset($_GET['fase']) AND $_GET['fase'] == 'insert_tables') {
	include './insert_db_tables.php';
	
    $title = "insert tables";
	$Content_Body = '<div class="container">'.$insert.'</div>';
    $Content_Body .= '<a href="./index.php?fase=insert_data">';
    $Content_Body .= '<div class="table_clear"><input type="submit" value="siguiente" class="button"></div></a>';

    include '../templates/Default_index.html';	
} elseif (isset($_GET['fase']) AND $_GET['fase'] == 'insert_data') {
	include './insert_db_data.php';
	
    $title = "insert data";
	$Content_Body = '<div class="container">'.$insert.'</div>';
    $Content_Body .= '<a href="./index.php?fase=aduser">';
    $Content_Body .= '<div class="table_clear"><input type="submit" value="siguiente" class="button"></div></a>';

    include '../templates/Default_index.html';		
} elseif (isset($_GET['fase']) AND $_GET['fase'] == 'aduser') {
    $title = "create user admin";	
	
	$Content_Body = '<form action="index.php" method="post">';
    $Content_Body .= '<div class="table"><input type="text" name="username" placeholder="username" size="30"></div>';
    $Content_Body .= '<div class="table"><input type="password" name="password" placeholder="password" size="30"></div>';
    $Content_Body .= '<div class="table"><input type="text" name="email" placeholder="email" size="30"></div>';
    $Content_Body .= '<div class="table_clear"><input type="submit" name="regist" value="siguiente" class="button"></div>';
    $Content_Body .= '</form>';
    include '../templates/Default_index.html';		
}

if (isset($_POST['btn_inc_db_conf'])) {
	$Cor->createConf();
	exit;
}

if (isset($_POST['regist'])) {
	$Cor->InserUser();
	exit;
}

if (!isset($_GET['fase']) 
	AND !isset($_POST['btn_inc_db_conf'])
    AND !isset($_POST['regist'])){
		
	$title = 'Welcome';
	$Content_Body = '<div class="container">';
	$Content_Body .= 'Welcome to the installation of Nametest Script<br/><br/>';
  
    $Content_Body .= 'Click on Start to Continue';
	$Content_Body .= '</div>';
	$Content_Body .= '<div class="table_clear"><a href="index.php?fase=conect_db"><input type="submit" value="Start" class="button"></a></div>';
    
	include '../templates/Default_index.html';	
}

?>