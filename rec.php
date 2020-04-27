<?php
	include "vendor/autoload.php";
	use Endroid\QrCode\ErrorCorrectionLevel;
	use Endroid\QrCode\LabelAlignment;
	use Endroid\QrCode\QrCode;
	use Endroid\QrCode\Response\QrCodeResponse;
	require_once('dbop.php');
	function _GET($n) { return isset($_GET[$n]) ? $_GET[$n] : NULL; }
 	function _P($n) { return isset($_POST[$n]) ? $_POST[$n] : _GET($n); }
	function _POST($n){return isset($_POST[$n]) ? $_POST[$n] : NULL;}
	function benco($str){
		$bstr = base64_encode($str);
		return $bstr;
	}
	function bdeco($bstr){
		return base64_decode($bstr);
	}
	
	function recsb(){
		$uinfo = null;
		$uinfo->uname=_POST("uname");
		$uinfo->uphone=_POST("uphone");
		if(inject_check($uinfo->uname)&&inject_check($unifo->uphone)){
			$id=shenbao($uinfo);
			$bstr = benco($id);
			if($id>0){
				$qrCode = new QrCode('http://qr.test.com:82/ver.php?id='.$bstr);
				$qrCode->setLabel($uinfo->uname.'@'.date("Y-m-d H:i:s"), 16, __DIR__.'/vendor/endroid/qr-code/assets/fonts/noto_sans.otf', LabelAlignment::CENTER());
				$qrCode->setLogoPath(__DIR__.'/img/gh.png');
				$qrCode->setLogoSize(50, 50);
				$qrCode->setForegroundColor(['r' => 0, 'g' => 139, 'b' => 0, 'a' => 0]);
				header('Content-Type: '.$qrCode->getContentType());
				echo $qrCode->writeString();
			}
		}else{
			echo("非法字符~已记录");
		}
				
	}
	recsb();

?>