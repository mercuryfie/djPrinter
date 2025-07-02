<?php

	//$sendTxt="1B 4F4E 3130333030".$prno." 04";
	$sendTxt="1B 4F4E 313033 3230".$prno." 04";//방활성화 
	$txt = str_replace(" ","",$sendTxt);
	$json["markingsetting_senddata_2_txt"]=$txt;
	$res2=prt_sendrecv($socket, $txt);
	if($res2["state"]==true)
	{
		$sendTxt="1B 543130 04";
		$txt = str_replace(" ","",$sendTxt);
		$json["markingsetting_senddata_3_txt"]=$txt;
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
	}
	else
	{
		prt_close($socket);
		$json["resultCode"]="393";
		$json["resultMessage"]="[".$res2["msg"]."(".$res2["code"].")]";//프린터 초기화 확인요망!
	}

?>