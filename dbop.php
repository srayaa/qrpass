<?php
//require_once('funs.php');
$host = '127.0.0.1';
$database = 'cgsqr';
$username = 'root';
$password = '123456';

date_default_timezone_set("PRC");
function inject_check($Sql_Str) {$check=preg_match('/select|insert|update|delete|\'|\\*|\*|\.\.\/|\.\/|union|into|load_file|outfile/i',$Sql_Str);if ($check) {return false;}else{return true;}}
function getPdo(){
	global $host,$database,$username,$password;
	$pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);//创建一个pdo对象
	$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//PDO::exec("SET NAMES 'utf8';"); 
	$pdo->exec('set names gbk;');
	return $pdo;
}
function mbg2u($str){
    return mb_convert_encoding($str,"utf-8","gbk");
}
function u2mbg($str){
    return mb_convert_encoding($str,"gbk","utf-8");
}
function shenbao($uinfo){
  $id=0;
	try {
		$pdo = getPdo();
		//$surl = "http://qr.test.com/s/t.php?u=".str_rand(6);
	  $stmt = $pdo->prepare("insert into sb(uname,uphone) values(?,?)"); 
	  $stmt->execute(array(u2mbg($uinfo->uname),u2mbg($uinfo->uphone)));
    $id=$pdo->lastInsertId();
	  $pdo = null;
	}catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
	}
  return $id;
}
function versb($id){
  $idori = base64_decode($id);
  
  if(!inject_check($idori)||!is_numeric($idori)){
    return null;
  }

	$pdo = getPdo();
  $stmt = $pdo->prepare("select uname,uphone from sb where id = ?"); 

  $stmt->execute(array($idori));
  $count = $stmt->rowCount();
  $uinfo=null;
  $urlLong="";
  if($count>0){
  	$udb = $stmt->fetch(PDO::FETCH_ASSOC);
    $uinfo->uname = mbg2u($udb["uname"]);
  	$uinfo->uphone = mbg2u($udb["uphone"]);
  }
  $pdo = null;
  return $uinfo;
}

?>