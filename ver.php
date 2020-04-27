<?php
	require_once('dbop.php');
	function _GET($n) { return isset($_GET[$n]) ? $_GET[$n] : NULL; }
	$uinfo = versb(_GET("id"));
	if($uinfo){
		echo("<span style='color:darkgreen'>".$uinfo->uname.":".$uinfo->uphone."</span>");	
	}else{
		echo("<span style='color:red'>未见此申报人!</span>");
	}
	
?>