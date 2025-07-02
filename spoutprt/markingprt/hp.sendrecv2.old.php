<?php

	//----------------------------------------
	//2. 총카운트 설정(L) - 0으로 셋팅 하자 
	$sendTxt="02 4C 303030303030303030 0D 04";
	$txt = str_replace(" ","",$sendTxt);
	$json["markingsetting_senddata_2_txt"]=$txt;
	//echo '보내는 데이터 2 txt : '.$txt.'<br>';
	$res3=prt_sendrecv($socket,$txt);
	if($res3["state"]==true)
	{
		prt_close($socket);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
	else
	{
		prt_close($socket);
		$json["resultCode"]="394";
		$json["resultMessage"]="[".$res3["msg"]."(".$res3["code"].")]";//카운터리셋 확인요망!
	}
	//----------------------------------------

?>