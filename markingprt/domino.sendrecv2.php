<?php
$prtversion =1.0;

if($prtversion == 1.0){
 if($prtype == marking07 || $prtype == marking14 || $prtype == marking15 ){
 	 //한줄짜리

 	 $messagetype = 203;
	 $prno ="323033";
  }elseif ($prtype == marking08 || $prtype == marking09 ||$prtype == marking10
         ||$prtype == marking11 || $prtype == marking12 ||$prtype == marking13
 				||$prtype == marking16 ||$prtype == marking17) {
 	 //두줄짜리
 	 $messagetype = 211;
	 $prno ="323131";  //
 }else{
 	 $messagetype = 201;
	 $prno ="323031";
 }
}
	//프린터인에이블
	$sendTxt="1B5131 59 04";
	$txt = str_replace(" ","",$sendTxt);
	$json["markingsetting_senddata_in_txt"]=$txt;
	$res3=prt_sendrecv($socket, $txt);
	if($res3["state"]==true)
	{
		//$sendTxt="1B 4F4E 3130333030".$prno." 04";
		$sendTxt="1B 4F4E 313033 ".$prno." 04";//방활성화
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
	}
	else
	{
		prt_close($socket);
		$json["resultCode"]="392";
		$json["resultMessage"]="프린터 인에이블 실패! [".$res3["msg"]."(".$res3["code"].")]";//프린터 인에이블 실패 
	}

?>
