<?php
//	error_reporting( E_ALL );
//	ini_set( "display_errors", 1 );

	$root="";
	include_once $root."head.php";

	if($_POST["apiCode"]!="")
	{
		@extract($_POST);
	}
	else
	{
		@extract($_GET);
	}

	$json["apiCode"]=$apiCode;

	$json_string = file_get_contents($root.'setting.json');
	$fdata=json_decode(urldecode($json_string),true);

	$mrType=$_GET["mrType"];//타입
	if(($mrType=="domino") || ($mrType=="hp"))
	{
		$mrprinter=$mrType;
	}
	else
	{
		$mrprinter=($fdata["printer"])?$fdata["printer"]:"domino";
	}

	$json["mrprinter"]=$mrprinter;

	switch($apiCode)
	{
	case "markingdelay":
		include $root."socket.lib.php";
		$socket_delay = prt_connect();

		$pdelay=$_GET["pdelay"];//지연시간 
		if($pdelay)
		{
			$delay0="3".substr($pdelay, 0, 1);
			$delay1="3".substr($pdelay, 1, 1);
			$delay2="3".substr($pdelay, 2, 1);
			$delay3="3".substr($pdelay, 3, 1);
			$delay4="3".substr($pdelay, 4, 1);

			$delaydata=$delay0.$delay1.$delay2.$delay3.$delay4;

			switch($mrprinter)
			{
			case "domino":
				//지연 
				$sendTxt="1B4631 ".$delaydata." 04";
				$dtxt = str_replace(" ","",$sendTxt);
				$json["markingsetting_senddata_delay_txt11111111111111111"]=$dtxt;
				$res3=prt_sendrecv($socket_delay, $dtxt);

				if($res3["state"]==true)
				{
					$json["resultCode"]="200";
					$json["resultMessage"]="OK";
				}
				else
				{
					$json["resultCode"]="391";
					$json["resultMessage"]="[markingnodelay22222".$res3["msg"]."(".$res3["code"].")]";//카운터 확인요망!
				}
				break;
			case "hp":
				//지연
				//<STX>['A']00010,00010<CR><EOT>
				$sendTxt="02 41 ".$delaydata." 0D 04";
				$txt = str_replace(" ","",$sendTxt);
				$json["markingsetting_senddata_delay_txt"]=$txt;
				$res3=prt_sendrecv($socket_delay, $txt);
				if($res3["state"]==true)
				{
					$json["resultCode"]="200";
					$json["resultMessage"]="OK";
				}
				else
				{
					$json["resultCode"]="391";
					$json["resultMessage"]="[마킹지연".$res3["msg"]."(".$res3["code"].")]";//카운터 확인요망!
				}
				break;
			}
		}
		break;
	case "markingenable":
		include $root."socket.lib.php";
		switch($mrprinter)
		{
		case "domino":
			$sendTxt="1B5131 59 04";
			$txt = str_replace(" ","",$sendTxt);
			$json["markingsetting_senddata_delay_txt"]=$txt;
			$res3=prt_sendrecv($socket, $txt);

			if($res3["state"]==true)
			{
				$json["resultCode"]="200";
				$json["resultMessage"]="OK";
			}
			else
			{
				$json["resultCode"]="390";
				$json["resultMessage"]="[마킹enable".$res3["msg"]."(".$res3["code"].")]";//카운터 확인요망!
			}
			break;
		case "hp":
			$sendTxt="02 4B 31 0D 04";
			$txt = str_replace(" ","",$sendTxt);
			$json["markingsetting_senddata_delay_txt"]=$txt;
			$res3=prt_sendrecv($socket, $txt);
			if($res3["state"]==true)
			{
				$json["resultCode"]="200";
				$json["resultMessage"]="OK";
			}
			else
			{
				$json["resultCode"]="390";
				$json["resultMessage"]="[마킹enable".$res3["msg"]."(".$res3["code"].")]";//카운터 확인요망!
			}
			break;
		}
		break;
//#######################################################
	case "markingcount":
		include $root."socket.lib.php";
		$TestConn=array();
		$socket_cnt = prt_connect();
		$json["prt_connect"]=$TestConn;

		if($socket_cnt)
		{
			//총 카운트 읽기 (l)
			//$sendTxt="02 6C 04";
			$txt=getCountRecvTxt();//str_replace(" ","",$sendTxt);
			$res=prt_sendrecv($socket_cnt, $txt);

			if($res["state"]==true)
			{
				prt_close($socket_cnt);
				$count=intval($res["msg"]);
				$json["markingcount_msg"]=$res["msg"];
				$json["markingcount_count"]=$count;
				$json["resultCode"]="200";
				$json["resultMessage"]="OK";
			}
			else
			{
				prt_close($socket_cnt);
				$json["resultCode"]="393";
				$json["resultMessage"]="[".$res["msg"]."(".$res["code"].")]";//카운터 확인요망!
			}
		}
		else
		{
			prt_close($socket_cnt);
			$json["resultCode"]="392";
			$json["resultMessage"]="ERR_PRINT_NOT_FOUND";//프린터 접속 불가
		}
		break;
//#######################################################
	case "markingsetting":
		include $root."socket.lib.php";
		//--------------------------------------------------------------------------
		// 받아온 odcode 로 쿼리
		//--------------------------------------------------------------------------
		$godcode=$_GET["code"];//주문번호
		$medical=$_GET["medical"];//한의원
		$patient=$_GET["patient"];//복용자
		$prtype=$_GET["prtype"];//타입

		$medicalphone=$_GET["medicalphone"];//한의원연락처
		$markingdate=$_GET["markingdate"];//조제일

		$line1=$_GET["line1"];//타입
		$line2=$_GET["line2"];//타입

		$json["markingsetting godcode"]=$godcode;
		$json["markingsetting medical"]=$medical;
		$json["markingsetting patient"]=$patient;
		$json["markingsetting prtype"]=$prtype;

		$qrurl="https://tbms.djmedi.net/report/?key=".$godcode;
		switch($mrprinter)
		{
		case "domino":
			$odcode=getodCode($godcode); //ODD제거
			$cmedical=chkText($medical);//8자리로 맞춤
			$cpatient=chkText($patient);//8자리로 맞춤
			$hex_odcode=strToHex($odcode);//ODD제거한 주문코드 hex코드로 변환

			/*
			$uni_medical=setUnicode($cmedical);//UTF-16로 컨버팅 후 hex로 바구기
			$uni_patient=setUnicode($cpatient);//UTF-16로 컨버팅 후 hex로 바구기
			$hex_qrcode=strToHex($qrurl);

			$uni_line1=setUnicode($line1);//UTF-16로 컨버팅 후 hex로 바구기
			$uni_line2=setUnicode($line2);//UTF-16로 컨버팅 후 hex로 바구기

			$uni_medicalphone=setUnicode($medicalphone);//UTF-16로 컨버팅 후 hex로 바구기
			$uni_markingdate=setUnicode($markingdate);//UTF-16로 컨버팅 후 hex로 바구기
			*/

			//최종적으로 여기서 nuni_line1과 nuni_line2 두개의 변수에 각각 세팅하여 데이터 보내기
			switch($prtype)
			{
			case "marking15"://환자명
				$nuni_line1=setUnicode($cpatient);
				$nuni_line2="";
				break;
			case "marking14"://한의원명
				$nuni_line1=setUnicode($cmedical);
				$nuni_line2="";
				break;
			case "marking13"://환자명 + 조제일 + 한의원명
				$nuni_line1=setUnicode($markingdate);
				$nuni_line2=setUnicode($cpatient."/".$cmedical);
				break;
			case "marking12"://한의원명 + 한의원연락처
				$nuni_line1=setUnicode($medicalphone);
				$nuni_line2=setUnicode($cmedical);
				break;
			case "marking11"://환자명 + 조제일
				$nuni_line1=setUnicode($markingdate);
				$nuni_line2=setUnicode($cpatient);
				break;
			case "marking10"://한의원명 + 한의원연락처 + 환자명
				$nuni_line1=setUnicode($medicalphone);
				$nuni_line2=setUnicode($cmedical."/".$cpatient);
				break;
			case "marking09"://입력문구 + 한의원 + 한의원연락처
				$nuni_line1=setUnicode($medicalphone);
				$nuni_line2=setUnicode($line1."/".$cmedical);
				break;
			case "marking08"://입력문구1 + 입력문구2
				$nuni_line1=setUnicode($line1);
				$nuni_line2=setUnicode($line2);
				break;
			case "marking07"://입력문구1 + 입력문구2
			  //$hex_odcode=strToHex($odcode);//ODD제거한 주문코드 hex코드로 변환
				$nuni_line1=setUnicode($odcode);				
				break;
			case "marking16"://한의원명 + 환자명 + 연락처 + 조제일
				$nuni_line1=setUnicode($medicalphone."/".$markingdate);
				$nuni_line2=setUnicode($cmedical."/".$cpatient);
				break;
			case "marking17"://한의원명 + 연락처 + 조제일
				$nuni_line1=setUnicode($medicalphone."/".$markingdate);
				$nuni_line2=setUnicode($cmedical);
				break;
			}
			break;
		case "hp":
			$odcode=getodCode($godcode); //ODD제거
			$euc_patient = iconv('UTF-8', 'EUC-KR', $patient); //복용자
			$euc_medical = iconv('UTF-8', 'EUC-KR', $medical); //한의원
			$euc_line1 = iconv('UTF-8', 'EUC-KR', $line1); //복용자
			$euc_line2 = iconv('UTF-8', 'EUC-KR', $line2); //한의원
			$euc_medicalphone = iconv('UTF-8', 'EUC-KR', $medicalphone); //복용자
			$euc_markingdate = iconv('UTF-8', 'EUC-KR', $markingdate); //한의원

			$hex_odcode=strToHex($odcode);//ODD제거한 주문코드 hex코드로 변환
			$hex_patient=strToHex($euc_patient);
			$hex_medical=strToHex($euc_medical);
			$hex_qrcode=strToHex($qrurl);
			$hex_line1=strToHex($euc_line1);
			$hex_line2=strToHex($euc_line2);
			$hex_medicalphone=strToHex($euc_medicalphone);
			$hex_markingdate=strToHex($euc_markingdate);
			$euc_space=iconv('UTF-8', 'EUC-KR', " ");
			$hex_space=strToHex($euc_space);
			break;
		}
		//--------------------------------------------------------------------------

		//주문번호자리가 16자리일 경우에만 할수 있게 하자
		//(예외처리:주문번호가 16자리로 고정이기때문에 거의 들어올일이 없다. 그전 주문번호(12자리) 데이터 일경우가 있다.)
		$noMarking = false;
		if($prtype=="marking04")//no marking
		{
			$noMarking=true;
		}

		if(chkodCodelen($odcode))
		{
			$TestConn=array();
			$socket = prt_connect();
			$json["prt_connect"]=$TestConn;

			if($socket)
			{
				//step 1. 문구설정
				if($noMarking == true) //No Marking일때는 문구설정 패스
				{
					$res1["state"] = true;
				}
				else
				{
					switch($mrprinter)
					{
					case "domino":
						include $root."domino.sendrecv.php";
						break;
					case "hp":
						include $root."hp.sendrecv.php";
						break;
					}
				}

				if($res1["state"] == true)
				{
					switch($mrprinter)
					{
					case "domino":
						include $root."domino.sendrecv2.php";
						break;
					case "hp":
						include $root."hp.sendrecv2.php";
						break;
					}
				}
				else
				{
					prt_close($socket);
					$json["resultCode"]="395";
					$json["resultMessage"]="[".$res1["msg"]."(".$res1["code"].")]";//문구확인요망
				}
			}
			else
			{
				prt_close($socket);

				$json["resultCode"]="396";
				$json["resultMessage"]="ERR_PRINT_NOT_FOUND";//프린터를 사용할 수 없습니다.
			}
		}
		else
		{
			$json["resultCode"]="397";
			$json["resultMessage"]="(".$godcode.")";//주문번호확인요망
		}
	break;
	}

	include_once $root."tail.php";
?>
