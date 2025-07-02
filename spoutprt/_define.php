<?php
	//$ck_cfcode="ch";
	$ck_language="kor";
	//$ck_ip="192.168.1.61/spoutprt";
	$ck_ip="localhost/spoutprt";

	$NET_URL_API = "https://api.djmedi.net/";
	$NET_URL_API_MEMBER = $NET_URL_API."member/";

	$NetURL = array(
		"API"=>$NET_URL_API,
		"API_MEMBER"=>$NET_URL_API_MEMBER
		);

	$ipresult=curl_get($NET_URL_API_MEMBER,"setting","companyipcheck","companyip=marking&sumarking=Y");
	$ipresultdata=json_decode($ipresult,true);

	$ip_company=$ip_group=$ip_type="";
	$resultCode=$ipresultdata["resultCode"];
	
	if($resultCode=="200")//IP가 있을 경우 
	{
		$ck_cfcode=$ipresultdata["cf_code"];
		$_COOKIE["ck_cfcode"]=$ck_cfcode;
		setcookie('ck_cfcode', $ck_cfcode, 365);
	}
	else
	{
		echo "<script>alert('".$ipresultdata["resultMessage"]."');</script>";
	}
?>
<?php 
	function curl_get($domain,$url,$code,$data)
	{
		$language="kor";
		if(!$language){$language="kor";}		
		$url=$domain."".$url."/?apiCode=".$code."&language=".$language."&".$data;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec ($ch);
		curl_close ($ch);
		return $result;
	}

	function get_client_ip() 
	{
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
			$ipaddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}
?>
