<?
	header("Access-Control-Allow-Origin: *"); 
	header("Access-Control-Allow-Methods: POST, GET, DELETE, OPTIONS"); 
	header("Access-Control-Allow-Headers: Content-Type, Accept"); 

	/*$accepip=array("59.7.50.122","13.124.6.219","210.92.202.3","106.255.204.203","45.119.147.146"); //djmedi ip, 버키 ip
	$ip=$_SERVER["REMOTE_ADDR"];
	if(in_array($ip,$accepip))
	{*/
		$json["resultCode"]="204";
		$json["resultMessage"]="";
		$language="kor";
	/*}
	else
	{
		$json["apiCode"]=$_GET["apiCode"];
		$json["resultCode"]="9999";
		$json["resultMessage"]="권한이 없습니다. 관리자에게 문의하시기 바랍니다.";

		include_once $root.$folder."/tail.php";
		exit;
	}*/
?>