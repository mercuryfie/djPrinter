<?php
$hex_gong=strToHex(" ");
//$hex_gong1= "20 ";  //공백이 아닌듯 0x20
$hex_name=$hex_patient;
$bakhex_medical=$hex_medical;
$noMarking = false;
$prtversion = 1.0;
$stringlength = 16;
$limitedcount = 24; //프린트 할 곳의 문자열 최대 입력 (파우치 가로에 비  )

if($prtversion == 2.0){
	//멧시지로드 및 메시지 변경에 대하여 추가

}else if($prtversion == 1.0){
 //jasonlee 테스트를 위하여 작성한 코드임============

 if($prtype == marking07 || $prtype == marking14 || $prtype == marking15 ){
	 //한줄짜리
	 $messagetype = 203;
 }elseif ($prtype == marking08 || $prtype == marking09 ||$prtype == marking10
        ||$prtype == marking11 || $prtype == marking12 ||$prtype == marking13
				||$prtype == marking16 ||$prtype == marking17) {
	 //두줄짜리
	 $messagetype = 211;
}else{
	 $messagetype = 201;
}


 switch($messagetype){
	case "201":
		$sendTxt = "02 33 32 30 31 0D 04";  //201번방을 로드해 본다.
		$txt = str_replace(" ","",$sendTxt);
	 	$json["markingsetting_senddata_1_txt"]=$txt;
	 	$res1=prt_sendrecv($socket, $txt);
	 	break;
	case "202":
 	 	break;
	case "203"://환자명
     //massage call
		 $sendTxt = "02 33 32 30 33 0D 04";  //203번방을 로드해 본다.
		 $txt = str_replace(" ","",$sendTxt);
	 	 $json["markingsetting_senddata_1_txt"]=$txt;
	 	 $res1=prt_sendrecv($socket, $txt);
		 //massage edit
     if($prtype == marking07){
			 $stringlength = strlen($hex_odcode);
			 $hex_gong1 = hexblankstring($hex_odcode);
			 $hex_num00=$hex_gong1.$hex_odcode;

		 }elseif ($prtype == marking14) { //한의원명
			 $hex_gong1 = hexblankstring($bakhex_medical);
			 $hex_num00=$hex_gong1.$bakhex_medical;

		}elseif ($prtype == marking15) {//환자명
			$hex_gong1 = hexblankstring($hex_patient);
			$hex_num00=$hex_gong1.$hex_patient;
		}else{

		}
		 $sendTxt="02 4A ";
		 $sendTxt.="3030 2C ".$hex_num00." 0D ";
		 $sendTxt.="04 02 5A 04";
		 $txt = str_replace(" ","",$sendTxt);
	 	 $json["markingsetting_senddata_1_txt"]=$txt;
	 	 $res1=prt_sendrecv($socket, $txt);
		 //sendData($sendTxt);
		 //count Reset
		 $sendTxt="02 4C 303030303030303030 0D 04";
		 $txt = str_replace(" ","",$sendTxt);
	 	 $json["markingsetting_senddata_1_txt"]=$txt;
	 	 $res1=prt_sendrecv($socket, $txt);
		 //sendData($sendTxt);
		 break;
	case "211"://21
	  //massage call
		 $sendTxt = "02 33 32 31 31 0D 04";  //211번방을 로드해 본다.
		 $txt = str_replace(" ","",$sendTxt);
	 	 $json["markingsetting_senddata_1_txt"]=$txt;
	 	 $res1=prt_sendrecv($socket, $txt);
		 //massage edit
	  if($prtype == marking08){     //입력문구1, 입력문구2
     $hex_gong1 = hexblankstring($hex_line1);
		 $hex_num00=$hex_gong1.$hex_line1;
		 $hex_gong1 = hexblankstring($hex_line2);
		 $hex_num01=$hex_gong1.$hex_line2;
	 }elseif ($prtype == marking9) { //입력문구, 한의원+한의원연락처
		 $hex_gong1 = hexblankstring($hex_line1);
		 $hex_num00=$hex_gong1.$hex_line1;
		 $hex_line2=$bakhex_medical.$hex_gong.$hex_medicalphone;
		 $hex_gong1 = hexblankstring($hex_line2);
		 $hex_num01=$hex_gong1.$hex_line2;
	 }elseif ($prtype == marking10) {//한의원명 + 한의원연락처, 환자명
		 $hex_line1=$bakhex_medical.$hex_medicalphone;
		 $hex_gong1 = hexblankstring($hex_line1);
		 $hex_num00=$hex_gong1.$hex_line1;
		 $hex_line2=$hex_patient;
		 $hex_gong1 = hexblankstring($hex_line2);
		 $hex_num01=$hex_gong1.$hex_line2;
	 }elseif ($prtype == marking11) {//환자명, 조제일
		 $hex_line1=$hex_patient;
		 $hex_gong1 = hexblankstring($hex_line1);
		 $hex_num00=$hex_gong1.$hex_line1;
		 $hex_line2=$hex_markingdate;
		 $hex_gong1 = hexblankstring($hex_line2);
		 $hex_num01=$hex_gong1.$hex_line2;
	 }elseif ($prtype == marking12) {//한의원명, 한의원연락처
		 $hex_line1=$bakhex_medical;
		 $hex_gong1 = hexblankstring($hex_line1);
		 $hex_num00=$hex_gong1.$hex_line1;
		 $hex_line2=$hex_medicalphone;
		 $hex_gong1 = hexblankstring($hex_line2);
		 $hex_num01=$hex_gong1.$hex_line2;
	 }elseif ($prtype == marking13) {//환자명 + 조제일,  한의원명
		 $hex_line1=$hex_patient.$hex_markingdate;
 		 $hex_gong1 = hexblankstring($hex_line1);
 		 $hex_num00=$hex_gong1.$hex_line1;
 		 $hex_line2=$bakhex_medical;
 		 $hex_gong1 = hexblankstring($hex_line2);
 		 $hex_num01=$hex_gong1.$hex_line2;
		}elseif ($prtype == marking16) {//한의원명+ 연락처, 환자명 + 조제일
		 	 $hex_line1=$bakhex_medical.$hex_medicalphone;
  		 $hex_gong1 = hexblankstring($hex_line1);
  		 $hex_num00=$hex_gong1.$hex_line1;
  		 $hex_line2=$hex_patient.$hex_markingdate;
  		 $hex_gong1 = hexblankstring($hex_line2);
  		 $hex_num01=$hex_gong1.$hex_line2;
		}elseif ($prtype == marking17) {//한의원명 + 연락처,  조제일
			$hex_line1=$bakhex_medical.$hex_medicalphone;
			$hex_gong1 = hexblankstring($hex_line1);
			$hex_num00=$hex_gong1.$hex_line1;
			$hex_line2=$hex_markingdate;
			$hex_gong1 = hexblankstring($hex_line2);
			$hex_num01=$hex_gong1.$hex_line2;
		}else{

		}
		 //$hex_num01=$hex_gong;
		 //$hex_num02=$hex_gong;
		 $sendTxt="02 4A ";
		 $sendTxt.="3030 2C ".$hex_num00." 0D ";//1
		 $sendTxt.="3031 2C ".$hex_num01." 0D ";//2
		 $sendTxt.="04 02 5A 04";
		 $txt = str_replace(" ","",$sendTxt);
	 	 $json["markingsetting_senddata_1_txt"]=$txt;
	 	 $res1=prt_sendrecv($socket, $txt);
		 //sendData($sendTxt);
		 //count Reset
		 //$sendTxt="02 4C 303030303030303030 0D 04";
		 //$txt = str_replace(" ","",$sendTxt);
	 	 //$json["markingsetting_senddata_1_txt"]=$txt;
	 	 //$res1=prt_sendrecv($socket, $txt);
		 //sendData($sendTxt);
		 break;

	 default: //QR코드, 주문번호 marking03
	 	$noMarking = true;
	  break;
 }



  /*
  //해당메시지 로드일때.
	$sendTxt = "02 33 32 30 33 0D 04";  //203번방을 로드해 본다.

	//메시지의 내용을 수정한다.
	$sendTxt="02 4A ";
	$sendTxt.="3030 2C 41 41 41 42 43 0D ";//QR : URL코드
	$sendTxt.="04 02 5A 04";

	//카운트를 초기화 한다.
		$sendTxt="02 4C 303030303030303030 0D 04";

	//카운트를 읽어 온다.
		$sendTxt="02 6C 04";



	$txt = str_replace(" ","",$sendTxt);

	$json["markingsetting_senddata_1_txt"]=$txt;
  //echo '<br>보내는 데이터 1 txt : '.$txt.'<br>';
	$res1=prt_sendrecv($socket, $txt);
	*/
	//================================================

}else{  //이전소스
	switch($prtype)
	{
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
	default: //QR코드, 주문번호 marking03
		$noMarking = true;
	break;
	}

	// 무조건 마킹은 이렇게 데이터가 들어가기!
	if($noMarking==true)
	{
		$res1["state"] = true;
	}
	else
	{
		$sendTxt="02 4A ";
		$sendTxt.="3030 2C ".$hex_qrcode." 0D ";//QR : URL코드
		$sendTxt.="3031 2C ".$hex_odcode." 0D ";//주문번호
		$sendTxt.="3032 2C ".$hex_medical." 0D ";//한의원
		$sendTxt.="3033 2C ".$hex_name." 0D ";//환자명
		$sendTxt.="04 02 5A 04";

	 //jasonlee 테스트를 위하여 작성한 코드임============


	  //해당메시지 로드일때.
		$sendTxt = "02 33 32 30 33 0D 04";  //203번방을 로드해 본다.

		//메시지의 내용을 수정한다.
		$sendTxt="02 4A ";
		$sendTxt.="3030 2C 41 41 41 42 43 0D ";//QR : URL코드
		$sendTxt.="04 02 5A 04";

		//카운트를 초기화 한다.
			$sendTxt="02 4C 303030303030303030 0D 04";

		//카운트를 읽어 온다.
			$sendTxt="02 6C 04";

		//================================================

		$txt = str_replace(" ","",$sendTxt);

		$json["markingsetting_senddata_1_txt"]=$txt;
	  //echo '<br>보내는 데이터 1 txt : '.$txt.'<br>';
		$res1=prt_sendrecv($socket, $txt);
	}

}

function sendData($sendTxt){
	$txt = str_replace(" ","",$sendTxt);
	$json["markingsetting_senddata_1_txt"]=$txt;
	//echo '<br>보내는 데이터 1 txt : '.$txt.'<br>';
	$res1=prt_sendrecv($socket, $txt);
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
