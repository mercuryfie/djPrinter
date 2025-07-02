<?php

$prtversion =1.0;
$limitedcount = 16; //프린트 할 곳의 문자열 최대 입력 (파우치 가로에 비  )

if($prtversion == 1.0){
 if($prtype == marking07 || $prtype == marking14 || $prtype == marking15 ){
 	 //한줄짜리

 	 $messagetype = 203;
  }elseif ($prtype == marking08 || $prtype == marking09 ||$prtype == marking10
         ||$prtype == marking11 || $prtype == marking12 ||$prtype == marking13
 				||$prtype == marking16 ||$prtype == marking17) {
 	 //두줄짜리
 	 $messagetype = 211;  //
 }else{
 	 $messagetype = 201;
 }
 switch($messagetype){
	case "201":
		$res1["state"] = true;
	 	break;
	case "202":
 	 	break;
	case "203"://메세지타입을 로드한다.
		//메지시 정보를 가져온다.
		if($prtype == marking07){
			$nuni_line1=$hex_odcode;
		}
		$hex_gong1 = hexblankstring($nuni_line1);
		$nuni_line1=$hex_gong1.$nuni_line1;
		$prno="32 30 33 ";//203
		//메시지를 수정한다.
		$sendTxt="1B 53 ";
		$sendTxt.=$prno;
		//$sendTxt.=" 1B72 1B7532 ";  //erroe
		$sendTxt.=" 1B7532";   //1B72 1B7532
	  //$sendTxt.=" 1B7531 1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E";
	  $sendTxt.=$nuni_line1;
	  //$sendTxt.="30 31 32 33 34";
		$sendTxt.=" 04";
		$txt=str_replace(" ","",$sendTxt);
	  //echo "txt=".$txt;
		$json["markingsetting_senddata_1_txt"]=$txt;
		$res1=prt_sendrecv($socket, $txt);
	  //$json["markingsetting_senddata_1_res"]=$res1;
		//카운트를 초기화 한다.
	break;
case "204":
	global $limitedcount;
    $inputmessage1 = mb_convert_encoding(Hex2String($nuni_line1),'UTF-8','Unicode');
    $stringlength1=mb_strlen($inputmessag1e, 'euc-kr');
	
	$inputmessage2 = mb_convert_encoding(Hex2String($nuni_line2),'UTF-8','Unicode');
    $stringlength2=mb_strlen($inputmessage, 'euc-kr');
	
	if($limitedcount<$stringlength1){
		$limitedcount=$stringlength1;
	}
	if($limitedcount<$stringlength2){
		$limitedcount=$stringlength2;
	}

	if($stringlength1>$stringlength2){
		$hex_gong1 = hexblankstring($nuni_line1);
		$nuni_line1=$hex_gong1.$nuni_line1;
		$hex_gong2 = hexblankstring($nuni_line2);
		$nuni_line2=$hex_gong2.$nuni_line2;

	}else{
		$hex_gong2 = hexblankstring($nuni_line2);
		$nuni_line2=$hex_gong2.$nuni_line2;
		$hex_gong1 = hexblankstring($nuni_line1);
		$nuni_line1=$hex_gong1.$nuni_line1;

	}
	
	//메시지를 수정한다.
  //1B 53 32 30 04 1B7E4E 1B7531 31 1B72 1B7E4E 1B7532 41 04

	$prno="32 30 34";//211
	$sendTxt="1B 53 ";
	$sendTxt.=$prno;
	$sendTxt.=" 1B7E4E 1B7532 ";
	$sendTxt.=$hex_gong1;  //1B7E4E
	//$sendTxt.="1B7532";
	$sendTxt.=$nuni_line1;
	//$send.Txt.="1B72 1B7E4E 1B7532 ";
	$sendTxt.="1B72 1B72  1B7532";  //
	$sendTxt.=$hex_gong2;  //1B7E4E
	$sendTxt.=$nuni_line2;
	$sendTxt.=" 04";
	$txt=str_replace(" ","",$sendTxt);
	$json["markingsetting_senddata_1_txt"]=$txt;
	$res1=prt_sendrecv($socket, $txt);
  $json["markingsetting_senddata_1_res"]=$res1;
	//카운트를 초기화 한다.
	break;
case "211":
	//메세지타입을 로드한다.
	//메지시 정보를 가져온다.
	/*
	$hex_gong1 = hexblankstring($nuni_line1);
	$nuni_line1=$hex_gong1.$nuni_line1;
	$hex_gong2 = hexblankstring($nuni_line2);
	$nuni_line2=$hex_gong2.$nuni_line2;
    */
	$inputmessage1 = mb_convert_encoding(Hex2String($nuni_line1),'UTF-8','Unicode');
    $stringlength1=mb_strlen($inputmessage1, 'euc-kr');
	
	$inputmessage2 = mb_convert_encoding(Hex2String($nuni_line2),'UTF-8','Unicode');
    $stringlength2=mb_strlen($inputmessage2, 'euc-kr');

	/*
	if($limitedcount<$stringlength1){
		$limitedcount=$stringlength1;
	}
	if($limitedcount<$stringlength2){
		$limitedcount=$stringlength2;
	}
	*/

	if($stringlength1>$stringlength2){
		//$hex_gong1 = hexblankstring($nuni_line1);
		$count=$stringlength1-$stringlength2;
		$nuni_line1=$nuni_line1;
		$hex_gong2 = hexblankstring1($count);
		$nuni_line2=$hex_gong2.$nuni_line2;

	}else{
		$count=$stringlength2-$stringlength1;
		$hex_gong1 = hexblankstring1($count);
		$nuni_line1=$hex_gong1.$nuni_line1;
		$nuni_line2=$nuni_line2;

	}

	$json["markingsetting_senddata_1_txt_count"]=$count;
	$json["markingsetting_senddata_1_txt_stringlength1"]=$stringlength1;
	$json["markingsetting_senddata_1_txt_stringlength2"]=$stringlength2;


	//메시지를 수정한다.
	$prno="32 31 31";//211
	$sendTxt="1B 53 ";
	$sendTxt.=$prno;
	$sendTxt.="1B7532 ";
	//$sendTxt.=$hex_gong1;  //1B7E4E
	//$sendTxt.="1B7532";
	$sendTxt.=$nuni_line1;
	//$send.Txt.="1B72 1B7E4E 1B7532 ";
	$sendTxt.="1B72 1B72 ";  //한글2줄을 찍기 위해서는
	//$sendTxt.=$hex_gong2;  //1B7E4E
	$sendTxt.="1B7532";
	$sendTxt.=$nuni_line2;
	$sendTxt.=" 04";
	$txt=str_replace(" ","",$sendTxt);
	$json["markingsetting_senddata_1_txt"]=$txt;
	$res1=prt_sendrecv($socket, $txt);
	//카운트를 초기화 한다.
	break;
	default:
		$res1["state"] = true;
		break;
 }




}else{
	switch($prtype)
	{
	case "marking08": case "marking09": case "marking10": case "marking11": case "marking12": case "marking13": case "marking16": case "marking17":
		$prno="34";//204
		$sendTxt="1B 53 32 30 ".$prno." 1B7E4E 1B7531 ".$nuni_line1." 1B72 1B7E4E 1B7532 ".$nuni_line2." 04";
		break;
	case "marking07":case "marking14":case "marking15":
		$prno="33";//203
		$sendTxt="1B 53 32 30 ".$prno." 1B72 1B7532 ".$nuni_line1." 04";
		break;

	//여기부터는 예전에 쓰던 마킹
	case "marking007"://주문번호
		$prno="32";
		$sendTxt="1B 53444A30".$prno." 1B72 1B7532 ".$uni_medical." 04";
		break;
	case "marking01"://주문번호+한의원
		$prno="34";//204
		$sendTxt="1B 53 32 30 ".$prno." 1B7E4E 1B7531 ".$hex_odcode." 1B72 1B7E4E 1B7532 ".$uni_medical." 04";
		break;
	case "marking02"://주문번호+한의원+복용자
		$prno="32";
		$sendTxt="1B 53444A30".$prno." 1B7E4E 1B7531 ".$hex_odcode." 1B72 1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E 1B7532 ".$uni_medical." 1B72  1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E 1B7533 ".$uni_patient." 04";
		break;
	case "marking00"://QR
		$prno="30";
		$sendTxt="1B 53444A30".$prno." 1B7A323130303239323930303030 ".$hex_qrcode." 1B7A30 04";//바코드29
	break;
	case "marking06"://QR코드, 주문번호
		$prno="36";
		$sendTxt="1B 53444A30".$prno." 1B7A323130303239323930303030 ".$hex_qrcode." 1B7A30 1B72 1B7532 ".$uni_medical." 04";
	break;
	case "marking03"://QR코드, 주문번호+한의원
		$prno="35";
		$sendTxt="1B 53444A30".$prno." 1B7534 1B7A323130303239323930303030 ".$hex_qrcode." 1B7A30 1B7E4E 1B7531 ".$hex_odcode." 1B72 1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E 1B7532 ".$uni_medical." 04";
	break;
	case "marking05"://QR코드, 주문번호+한의원
		$prno="33";
		$sendTxt="1B 53444A30".$prno." 1B7534 1B7A 3232 3030 3239 3239 30 30 30 30 ".$hex_qrcode." 1B7A30 1B7E4E 1B7531 ".$hex_odcode." 1B72 1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E 1B7532 ".$uni_medical." 1B72 1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E1B7E4E 1B7533 ".$uni_patient." 04";
	break;
	case "marking04"://No Marking - count 하기
	default: //QR코드, 주문번호 marking03
		$noMarking = true;
		$prno="34";
		$sendTxt = "1B 53444A30".$prno." 04";
	break;
	}

	// 무조건 마킹은 이렇게 데이터가 들어가기!
	if($noMarking==true)
	{
		$res1["state"] = true;
	}
	else
	{
		$txt=str_replace(" ","",$sendTxt);
		$json["markingsetting_senddata_1_txt"]=$txt;
		$res1=prt_sendrecv($socket, $txt);
	}

}

function hexblankstring1($count) {
    
	$hex_gong= "1B7E4E";
	$hex_gongbak= "";
  for($i=0;$i<$count;$i++){
		$hex_gongbak.=$hex_gong;
	}
  return $hex_gongbak;
}

function hexblankstring($inputmessage) {
  global $limitedcount;
  $inputmessage = mb_convert_encoding(Hex2String($inputmessage),'UTF-8','Unicode');
  $stringlength=mb_strlen($inputmessage, 'euc-kr');

  if($stringlength > $limitedcount){
      $limitedcount = $stringlength;
      $blankcount = 0;
  }else{
    $blankcount = ($limitedcount - $stringlength)/2;
  }


  $hex_gong= "1B7E4E";
	$hex_gong1= "";
  for($i=0;$i<$blankcount*2;$i++){
		$hex_gong1.=$hex_gong;
	}
  return $hex_gong1;
}



?>
