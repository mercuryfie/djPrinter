<?php
	//2. 프린터 인에이블 
	//<STX>['K'][프린트 인에이블 (1Bytes)<CR>]<EOT> 

	$sendTxt="02 4B 31 0D 04";
	$txt = str_replace(" ","",$sendTxt);
	$json["markingsetting_senddata_in_txt"]=$txt;
	$res4=prt_sendrecv($socket,$txt);
	if($res4["state"]==true)
	{
		//----------------------------------------
		//3. 총카운트 설정(L) - 0으로 셋팅 하자 
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
	}
	else
	{
		prt_close($socket);
		$json["resultCode"]="392";
		$json["resultMessage"]="프린터 인에이블 실패! [".$res3["msg"]."(".$res3["code"].")]";//프린터 인에이블 실패 
	}

?>