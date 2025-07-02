<?php



$mrIP="192.168.0.100";
$mrPort="100";
$mrprinter="hp";

include "socket.lib.php";

$socket_delay = prt_connect();
//방을 로드 (메시지로드 "3"명령어)
//202번방을 로드 한다.
$sendTxt="02 33 32 30 33 0D 04"; //02 STX 33 메시지로드 32 30 31 방번호   0D CR 04 EOT

//필드 데이터 변경(‘J’)
//02:STX  4A:J 0D:CR 2C:, 04:EOT
//필드번호 2자리 프린트 데이터 번호[',']프린트 데이터<CR>
//$sendTxt="02 4A 3030 2C 303132333435 0D 04";
//024A 3030 2C 200D30312C200D30322C200D30332CC8ABB1E6B5BF 0D04 025A04

$txt = str_replace(" ","",$sendTxt);
$json["markingsetting_senddata_delay_txt"]=$txt;

$res3=prt_sendrecv($socket_delay, $txt);

if($res3["state"]==true)
{
   $json["resultCode"]="200";
   $json["resultMessage"]="";
   $json["res3"]=$res3;
}
else
{
   //$json["resultCode"]="200";
   $json["resultMessage"]=$res3["msg"]."(".$res3["code"].")";//카운터 확인요망!
}

$jsondata=json_encode($json);
echo  $jsondata;





$sendTxt="02 4A 3030 2C 303132333435 0D 04";
$txt = str_replace(" ","",$sendTxt);
$json["markingsetting_senddata_delay_txt"]=$txt;

$res3=prt_sendrecv($socket_delay, $txt);

if($res3["state"]==true)
{
   $json["resultCode"]="200";
   $json["resultMessage"]="";
   $json["res3"]=$res3;
}
else
{
   //$json["resultCode"]="200";
   $json["resultMessage"]=$res3["msg"]."(".$res3["code"].")";//카운터 확인요망!
}

$jsondata=json_encode($json);
echo  $jsondata;

?>
