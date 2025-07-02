<?php
	$json_string = file_get_contents('setting.json');
	$fdata=json_decode(urldecode($json_string),true);
	$selected="";
	var_dump($fdata);
?>
<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>Document1</title>

  <script src="jquery-2.2.4.js"></script>

 </head>
 <body>

	<table>
	<tr>
		<td>마킹프린터</td>
		<td>
			<select name="mprinter" id="mprinter" class="ajaxdata">
				<?php $arr=array("도미노","HP");?>
				<?php $carr=array("domino","hp");?>
				<?php for($i=0;$i<count($arr);$i++){?>
				<? if($fdata["printer"]==$carr[$i]){$selected="selected";}else{$selected="";} ?>
				<option value="<?=$carr[$i]?>" <?=$selected?>><?=$arr[$i]?></option>
				<?php }?>
			</select>
		</td>
		<td rowspan="3">
			<button type="button" onclick="javascript:saveAsFile();"><span>설정</span></button>
		</td>
	</tr>
	<tr>
		<td>IP</td>
		<td>
			<input type="text" name="mIP" id="mIP" class="ajaxdata" value="<?=$fdata["ip"]?>">
		</td>
	</tr>
	<tr>
		<td>PORT</td>
		<td>
			<input type="text" name="mPort" id="mPort" class="ajaxdata" value="<?=$fdata["port"]?>">
		</td>
	</tr>
	<tr>
		<td>라벨선택</td>
		<td>
			<select name="mlabel" id="mlabel" class="ajaxdata" onchange="changeAsLabel();">
				<?php $arr=array("No Marking","204방","주문번호","주문번호 + 한의원","주문번호 + 한의원 + 복용자","QR","QR + 주문번호","QR + 주문번호 + 한의원","QR + 주문번호 + 한의원 + 환자명");?>
				<?php $carr=array("marking04","marking08","marking07","marking01","marking02","marking00","marking06","marking05","marking03");?>
				<?php for($i=0;$i<count($arr);$i++){?>
				<option value="<?=$carr[$i]?>"><?=$arr[$i]?></option>
				<?php }?>
			</select>
		</td>
	</tr>
	</table>
	<br><br>
	<table>
		<tr id="trodcoe" style="display:none;">
			<td>주문번호</td>
			<td><input type="text" name="modcode" id="modcode" class="ajaxdata" value=""></td>
		</tr>
		<tr id="trmedical" style="display:none;">
			<td>한의원</td>
			<td><input type="text" name="mmedical" id="mmedical" class="ajaxdata" value=""></td>
		</tr>
		<tr id="trpatient" style="display:none;">
			<td>복용자</td>
			<td><input type="text" name="mpatient" id="mpatient" class="ajaxdata" value=""></td>
		</tr>

		<tr id="trline1" style="display:none;">
			<td>입력문구1</td>
			<td><input type="text" name="mline1" id="mline1" class="ajaxdata" value=""></td>
		</tr>
		<tr id="trline2" style="display:none;">
			<td>입력문구2</td>
			<td><input type="text" name="mline2" id="mline2" class="ajaxdata" value=""></td>
		</tr>

		<tr id="trbutton" style="display:none;">
			<td colspan="2"><button type="button" onclick="javascript:markingprint();"><span>프린터전송</span></button></td>
		</tr>
	</table>



 </body>
</html>
<script>
	function callmarkingapi(data)
	{
		var url="http://localhost/markingprt/markingwork.php?"+data;//getUrlData("API_TBMS")+group+"/"+code+".php";

		console.log("callmarkingapi url : "+url);

		$.ajax({
			type : "GET", //method
			url : url,
			data : "",
			success : function (result) {
				console.log(result);
				markingmakepage(result);
			},
			error:function(request,status,error){
				console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
			}
	   });
	}
	function markingmakepage(json)
	{
		console.log("-------------------------------------------------------- ")
		var obj = JSON.parse(json);
		console.log("markingmakepage apiCode : " + obj["apiCode"])
		console.log("-------------------------------------------------------- ")

		if(obj["apiCode"]=="markingsetting") //마킹프린터 셋팅
		{
			var mstxt="";

			if(obj["resultCode"]=="200" && obj["resultMessage"]=="OK") //마킹프린터 설정 완료
			{
				console.log("마킹프린터 설정 완료");
				alert("마킹프린터 설정 완료");
			}
			else
			{
				if(obj["resultCode"]=="397")
				{
					alert('주문번호 확인 요망!'+obj["resultMessage"]);//주문번호 확인요망!
				}
				else if(obj["resultCode"]=="396")//프린터를 사용할수 없습니다.
				{
					mstxt="프린터를 사용할수 없습니다. ";
					alert(mstxt+" "+obj["resultMessage"]);
				}
				else if(obj["resultCode"]=="395")//문구확인요망
				{
					mstxt="문구 설정 확인요망!";
					alert(mstxt+" "+obj["resultMessage"]);
				}
				else if(obj["resultCode"]=="394")//카운터리셋 확인요망!
				{
					mstxt="카운터리셋 확인요망!";
					alert(mstxt+" "+obj["resultMessage"]);
				}
				else if(obj["resultCode"]=="393")//프린터 초기화 확인요망!
				{
					mstxt="프린터 초기화 확인요망!";
					alert(mstxt+" "+obj["resultMessage"]);
				}
				else if(obj["resultCode"]=="9999")
				{
					mctxt="권한이 없습니다. 관리자에게 문의하시기 바랍니다.";
					alert(mctxt); //권한이 없습니다. 관리자에게 문의하시기 바랍니다.
				}
				else if(obj["resultCode"]=="398")
				{
					mctxt="마킹프린터 연결 실패(2)";
					alert(mctxt+" "+obj["resultMessage"]); //마킹프린터 소켓 연결 실패
				}
				else if(obj["resultCode"]=="399")
				{
					mctxt="마킹프린터 연결 실패(1)";
					alert(mctxt+" "+obj["resultMessage"]); //마킹프린터 소켓 연결 실패
				}
			}
		}
	}
	function markingprint()
	{
		var mprinter=$("select[name=mprinter]").val();
		var prtype=$("select[name=mlabel]").val();
		var code=$("input[name=modcode]").val();
		var medical=$("input[name=mmedical]").val();
		var patient=$("input[name=mpatient]").val();
		var mline1=$("input[name=mline1]").val();
		var mline2=$("input[name=mline2]").val();
		var mrType=$("#mprinter").val();
		var url="apiCode=markingsetting&code="+code+"&medical="+encodeURI(medical)+"&patient="+encodeURI(patient)+"&prtype="+encodeURI(prtype)+"&line1="+encodeURI(mline1)+"&line2="+encodeURI(mline2)+"&mrType="+encodeURI(mrType);
		console.log(url);
		callmarkingapi(url);
	}

	function changeAsLabel()
	{
		var mprinter=$("select[name=mprinter]").val();
		var mlabel=$("select[name=mlabel]").val();

		$("#trodcoe").hide();
		$("#trmedical").hide();
		$("#trpatient").hide();
		$("#trbutton").hide();

		if(mprinter=="domino")
		{
			if(mlabel=="marking03" || mlabel=="marking02")//3줄일경우 
			{
				alert("도미노 프린터는 3줄을 찍을수 없습니다.");
				return false;
			}
		}

		switch(mlabel)
		{
		case "marking00"://QR
		case "marking07"://주문번호
		case "marking06"://QR코드, 주문번호
			$("#trodcoe").show();
			$("#trbutton").show();
			break;
		case "marking05"://QR코드, 주문번호+한의원
		case "marking01"://주문번호+한의원
			$("#trodcoe").show();
			$("#trmedical").show();
			$("#trbutton").show();
			break;
		case "marking03"://QR코드, 주문번호+한의원+복용자
		case "marking02"://주문번호+한의원+복용자
			$("#trodcoe").show();
			$("#trmedical").show();
			$("#trpatient").show();
			$("#trbutton").show();
			break;
		case "marking08":
			$("#trline1").show();
			$("#trline2").show();
			$("#trbutton").show();
			break;
		}

	}
	function saveAsFile()
	{
		//{"printer":"domino","ip":"192.168.0.200","port":"200"}
		var mprinter=$("select[name=mprinter]").val();
		var mIP=$("input[name=mIP]").val();
		var mPort=$("input[name=mPort]").val();

		var jsondata={};
		jsondata["printer"]=mprinter;
		jsondata["ip"]=mIP;
		jsondata["port"]=mPort;
		var jdata=JSON.stringify(jsondata);

		console.log("jdata : " + jdata);

		var hiddenElement = document.createElement('a');
		hiddenElement.href = 'data:attachment/text,' + encodeURI(jdata);
		hiddenElement.target = '_blank';
		hiddenElement.download = 'setting.json';
		hiddenElement.click();
	}
</script>
