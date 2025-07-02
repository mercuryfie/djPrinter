<?php
$hex_gong=strToHex(" ");
//$hex_gong1= "20 ";  //공백이 아닌듯 0x20
$hex_name=$hex_patient;
$bakhex_medical=$hex_medical;
$noMarking = false;
$prtversion = 1.0;
$stringlength = 16;
$limitedcount = 24; //프린트 할 곳의 문자열 최대 입력 (파우치 가로에 비  )

if($prtversion == 1.0){
	//jasonlee 테스트를 위하여 작성한 코드임============
	if($prtype == marking07 || $prtype == marking14 || $prtype == marking15 ){
		$messagetype = 203;//한줄짜리
	}elseif($prtype == marking08 || $prtype == marking09 ||$prtype == marking10 ||$prtype == marking11 || $prtype == marking12 ||$prtype == marking13 ||$prtype == marking16 ||$prtype == marking17){
	  $messagetype = 211;//두줄짜리
	}else{
		$messagetype = 201;
	}

 switch($messagetype){
	case "201":
	   //메시지를 로드하고 저장해야 하나 저장하고 로그해야 하나 확인 필123
		$sendTxt = "02 33 32 30 31 0D 04";  //201번방을 로드해 본다.
		$txt = str_replace(" ","",$sendTxt);
	 	$json["markingsetting_senddata_1_txt"]=$txt;
	 	$res1=prt_sendrecv($socket, $txt);
	 	break;
	case "202":
		$sendTxt = "02 33 32 30 32 0D 04";  //203번방을 로드해 본다.
		$txt = str_replace(" ","",$sendTxt);
		$json["markingsetting_senddata_1_txt"]=$txt;
		$res1=prt_sendrecv($socket, $txt);

		if($res1["state"]==true){
			//massage edit
			if($prtype == marking07){
				$stringlength = strlen($hex_odcode);
				//$hex_gong1 = hexblankstring($hex_odcode);
				//$hex_num00=$hex_gong1.$hex_odcode;
				$hex_num00=$hex_odcode;

			}elseif ($prtype == marking14) { //한의원명
				//$hex_gong1 = hexblankstring($bakhex_medical);
				//$hex_num00=$hex_gong1.$bakhex_medical;
				$hex_num00=$bakhex_medical;

			}elseif ($prtype == marking15) {//환자명
				//$hex_gong1 = hexblankstring($hex_patient);
				//$hex_num00=$hex_gong1.$hex_patient;
				$hex_num00=$hex_patient;
			}else{

			}
			 $sendTxt="02 4A ";
			 $sendTxt.="3030 2C ".$hex_num00." 0D ";
			 $sendTxt.="04";

			 $sendTxt.="02 5A 04";  //"Z"명령어 현재 메시지를 이미지화 하여 보여줌
			 $txt = str_replace(" ","",$sendTxt);
			 $json["markingsetting_senddata_2_txt"]=$txt;
			 $res1=prt_sendrecv($socket, $txt);
		}
	 	break;
	case "203"://환자명
     //massage call
		$sendTxt = "02 33 32 30 33 0D 04";  //203번방을 로드해 본다.
		$txt = str_replace(" ","",$sendTxt);
	 	$json["markingsetting_senddata_1_txt"]=$txt;
	 	$res1=prt_sendrecv($socket, $txt);

		if($res1["state"]==true){
			//massage edit
	      if($prtype == marking07){
				$stringlength = strlen($hex_odcode);
				//$hex_gong1 = hexblankstring($hex_odcode);
				//$hex_num00=$hex_gong1.$hex_odcode;
				$hex_num00=$hex_odcode;

			}elseif ($prtype == marking14) { //한의원명
				//$hex_gong1 = hexblankstring($bakhex_medical);
				//$hex_num00=$hex_gong1.$bakhex_medical;
				$hex_num00=$bakhex_medical;

			}elseif ($prtype == marking15) {//환자명
				//$hex_gong1 = hexblankstring($hex_patient);
				//$hex_num00=$hex_gong1.$hex_patient;
				$hex_num00=$hex_patient;
			}else{

			}
			 $sendTxt="02 4A ";
			 $sendTxt.="3030 2C ".$hex_num00." 0D ";
			 $sendTxt.="04";

			 $sendTxt.="02 5A 04";  //"Z"명령어 현재 메시지를 이미지화 하여 보여줌
			 $txt = str_replace(" ","",$sendTxt);
		 	 $json["markingsetting_senddata_2_txt"]=$txt;
		 	 $res1=prt_sendrecv($socket, $txt);
		}
		 break;
	case "211"://21
	  	//massage call
		$sendTxt = "02 33 32 31 31 0D 04";  //211번방을 로드해 본다.
		$txt = str_replace(" ","",$sendTxt);
	 	$json["markingsetting_senddata_1_txt"]=$txt;
	 	$res1=prt_sendrecv($socket, $txt);
		//massage edit
		if($res1["state"]==true){
			if($prtype == marking08){     //입력문구1, 입력문구2
				$nuni_line1=$hex_line1;
				$nuni_line2=$hex_line2;
			}elseif ($prtype == marking09) { //입력문구, 한의원+한의원연락처
				$nuni_line1=$hex_line1;
				$nuni_line2=$bakhex_medical.$hex_gong."2F".$hex_gong.$hex_medicalphone;
		 	}elseif ($prtype == marking10) {//한의원명 + 한의원연락처, 환자명
		 		$nuni_line1=$bakhex_medical.$hex_gong."2F".$hex_gong.$hex_medicalphone;
				$nuni_line2=$hex_patient;
	 		}elseif ($prtype == marking11) {//환자명, 조제일
				$nuni_line1=$hex_patient;
				$nuni_line2=$hex_markingdate;
	 		}elseif ($prtype == marking12) {//한의원명, 한의원연락처
				$nuni_line1=$bakhex_medical;
				$nuni_line2=$hex_medicalphone;
	 		}elseif ($prtype == marking13) {//환자명 + 조제일,  한의원명
				$nuni_line1=$bakhex_medical;
				$nuni_line2=$hex_patient.$hex_gong."2F".$hex_gong.$hex_markingdate;
	 		}elseif ($prtype == marking16) {//한의원명+ 연락처, 환자명 + 조제일
	 		 	$nuni_line1=$bakhex_medical.$hex_gong."2F".$hex_gong.$hex_medicalphone;
				$nuni_line2=$hex_patient.$hex_gong."2F".$hex_gong.$hex_markingdate;;
	 		}elseif ($prtype == marking17) {//한의원명 + 연락처,  조제일
	 			$nuni_line1=$bakhex_medical.$hex_gong."2F".$hex_gong.$hex_medicalphone;
				$nuni_line2=$hex_markingdate;;
	 		}else{

	 		}

			$inputmessage1 = mb_convert_encoding(Hex2String($nuni_line1),'UTF-8','Unicode');
			$stringlength1=mb_strlen($inputmessage1, 'euc-kr');
			$inputmessage2 = mb_convert_encoding(Hex2String($nuni_line2),'UTF-8','Unicode');
			$stringlength2=mb_strlen($inputmessage2, 'euc-kr');

			if($stringlength1>$stringlength2){
				//$hex_gong1 = hexblankstring($nuni_line1);
				$count=$stringlength1-$stringlength2;
				$hex_num00=$nuni_line1;
				$hex_gong2 = hexblankstring1($count);
				$hex_num01=$hex_gong2.$nuni_line2;

			}elseif($stringlength1==$stringlength2){
				$hex_num00=$nuni_line1;
				$hex_num01=$nuni_line2;
			}else{
				$count=$stringlength2-$stringlength1;
				$hex_gong1 = hexblankstring1($count);
				$hex_num00=$hex_gong1.$nuni_line1;
				$hex_num01=$nuni_line2;
			}

			$sendTxt="02 4A ";
			$sendTxt.="3030 2C ".$hex_num00." 0D ";//1
			$sendTxt.="3031 2C ".$hex_num01." 0D ";//2
			$sendTxt.="04";
			$txt = str_replace(" ","",$sendTxt);
		 	$json["markingsetting_senddata_1_txt"]=$txt;
		 	$res1=prt_sendrecv($socket, $txt);
		}
		break;

	 default: //QR코드, 주문번호 marking03
	 	$noMarking = true;
	  break;
 }
}else{
	switch($prtype){
	case "marking15"://환자명
		$hex_qrcode=$hex_gong;
		$hex_odcode=$hex_gong;
		$hex_medical=$hex_gong;
		break;
	case "marking14"://한의원명
		$hex_qrcode=$hex_gong;
		$hex_odcode=$hex_gong;
		$hex_name=$hex_gong;
		break;
	case "marking13"://환자명 + 조제일 + 한의원명
		$hex_qrcode=$hex_gong;
		$hex_odcode=$hex_gong;
		$hex_name=$hex_patient.$hex_space.$hex_markingdate;
		break;
	case "marking12"://한의원명 + 한의원연락처
		$hex_qrcode=$hex_gong;
		$hex_odcode=$hex_gong;
		$hex_medical=$bakhex_medical;
		$hex_name=$hex_medicalphone;
		break;
	case "marking11"://환자명 + 조제일
		$hex_qrcode=$hex_gong;
		$hex_odcode=$hex_gong;
		$hex_medical=$hex_patient;
		$hex_name=$hex_markingdate;
		break;
	case "marking10"://한의원명 + 한의원연락처 + 환자명
		$hex_qrcode=$hex_gong;
		$hex_odcode=$hex_gong;
		$hex_medical=$bakhex_medical.$hex_space.$hex_medicalphone;
		break;
	case "marking09": //입력문구 + 한의원 + 한의원연락처
		$hex_qrcode=$hex_gong;
		$hex_odcode=$hex_gong;
		$hex_medical=$hex_line1;
		$hex_name=$bakhex_medical.$hex_space.$hex_medicalphone;
		break;
	case "marking08"://입력문구1 + 입력문구2
		$hex_qrcode=$hex_gong;
		$hex_medical=$hex_line1;
		$hex_name=$hex_line2;
		$hex_odcode=$hex_gong;
		break;
	case "marking16"://한의원명 + 환자명 + 연락처 + 조제일
		$hex_qrcode=$hex_gong;
		$hex_odcode=$hex_gong;
		$hex_medical=$bakhex_medical.$hex_space.$hex_medicalphone;
		$hex_name=$hex_patient.$hex_space.$hex_markingdate;
		break;
	case "marking17"://한의원명 + 연락처 + 조제일
		$hex_qrcode=$hex_gong;
		$hex_odcode=$hex_gong;
		$hex_medical=$bakhex_medical.$hex_space.$hex_medicalphone;
		$hex_name=$hex_markingdate;
		break;
	//여기부터는 예전에 쓰던 마킹
	case "marking07"://주문번호
		$hex_qrcode=$hex_gong;
		$hex_medical=$hex_gong;
		$hex_name=$hex_gong;
		break;
	case "marking01"://주문번호+한의원
		$hex_qrcode=$hex_gong;
		$hex_medical=$hex_gong;
		break;
	case "marking02"://주문번호+한의원+복용자
		$hex_qrcode=$hex_gong;
		break;
	case "marking00"://QR
		$hex_medical=$hex_gong;
		$hex_name=$hex_gong;
		$hex_odcode=$hex_gong;
		break;
	case "marking06"://QR코드, 주문번호
		$hex_medical=$hex_gong;
		$hex_name=$hex_gong;
		break;
	case "marking05"://QR코드, 주문번호+한의원
		$hex_name=$hex_gong;
		break;
	case "marking03"://QR코드, 주문번호+한의원+복용자
		break;
	case "marking04"://No Marking - count 하기
		break;
	default: //QR코드, 주문번호 marking03
		$noMarking = true;
		break;
	}

	// 무조건 마킹은 이렇게 데이터가 들어가기!
	if($noMarking==true){
		$res1["state"] = true;
	}else{
		$sendTxt="02 4A ";
		$sendTxt.="3030 2C ".$hex_qrcode." 0D ";//QR : URL코드
		$sendTxt.="3031 2C ".$hex_odcode." 0D ";//주문번호
		$sendTxt.="3032 2C ".$hex_medical." 0D ";//한의원
		$sendTxt.="3033 2C ".$hex_name." 0D ";//환자명
		$sendTxt.="04 02 5A 04";
		$txt = str_replace(" ","",$sendTxt);
		$json["markingsetting_senddata_1_txt123"]=$txt;
		//echo '<br>보내는 데이터 1 txt : '.$txt.'<br>';
		$res1=prt_sendrecv($socket, $txt);
	}

}

//사용안하고 있음
function sendData($sendTxt){
	$txt = str_replace(" ","",$sendTxt);
	$json["markingsetting_senddata_txt"]=$txt;
	//echo '<br>보내는 데이터 1 txt : '.$txt.'<br>';
	$res1=prt_sendrecv($socket, $txt);
}

function hexblankstring1($count) {
	$hex_gong=strToHex(" ");
	$hex_gongbak= "";
	if($count>1){
		for($i=0;$i<$count/2;$i++){
			$hex_gongbak.=$hex_gong;
		}
	}
	return $hex_gongbak;
}

function hexblankstring($inputmessage) {
  global $limitedcount;
  $inputmessage = mb_convert_encoding(Hex2String($inputmessage),'UTF-8','Unicode');
	//echo "inputmessage=".$inputmessage;
  //echo mb_strlen( '가나다', 'euc-kr' ); --> 6을 출력
  //echo mb_strlen( '가나다', 'utf-8' ); --> 3을 출력
	$stringlength=mb_strlen($inputmessage, 'euc-kr');

  if($stringlength > $limitedcount){
      $limitedcount = $stringlength;
      $blankcount = 0;
  }else{
    $blankcount = ($limitedcount - $stringlength)/2;
  }

	$hex_gong= strToHex(" ");
	$hex_gong1= strToHex("");
	for($i=0;$i<$blankcount;$i++){
		$hex_gong1.=$hex_gong;
	}
	return $hex_gong1;
}

?>
