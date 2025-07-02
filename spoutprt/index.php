<?php
	$root="../spoutprt";	
	include_once $root."/_head.php";
?>
<input type="hidden" id="code" name="code" value="" />
<input type="hidden" id="medical" name="medical" value="" />
<input type="hidden" id="patient" name="patient" value="" />
<input type="hidden" id="prtype" name="prtype" value="" />
<input type="hidden" id="mr_linetxt1" name="mr_linetxt1" value="" />
<input type="hidden" id="mr_linetxt2" name="mr_linetxt2" value="" />
<input type="hidden" id="medicalphone" name="medicalphone" value="" />
<input type="hidden" id="markingdate" name="markingdate" value="" />
<input type="hidden" id="ismarkstar" name="ismarkstar" value="" />
<input type="hidden" id="printertype" name="printertype" value="" />

<textarea name="jsondata" rows="3" cols="" style="position:fixed;bottom:0;height:100px;width:100%;margin:auto;border:1px solid red;display:none;"></textarea>
<div class="container" id="container"></div>
<?php include_once $root."/_tail.php";?>

<script>


	function pad(n, width)
	{
	   n = n + '';
	   return n.length >= width ? n : new Array(width - n.length + 1).join('0') + n;
	}
	function blursetindelay()
	{
		var pdelay=$("input[name=setindelay]").val();
		if(!isEmpty(pdelay))
		{
			if(parseInt(pdelay)>=0 && parseInt(pdelay)<=50000)
			{
			}
			else
			{
				alert("인쇄지연 값을 50000 이상은 입력하실수 없습니다.");
			}
		}
		else
		{
		}
	}
	function setmarkingprtdelay()
	{
		var pdelay=$("input[name=setindelay]").val();
		pdelay=pad(pdelay, 5);
		console.log("pdelay = " + pdelay);
		callmarkingapi("apiCode=markingdelay&pdelay="+pdelay);
	}
	function setmarkingprtenable()
	{
		callmarkingapi("apiCode=markingenable");
	}
	var printID;
	//HP마킹프린터 작업 
	function callmarkingapi(data)
	{
		var ck_ip=$("input[name=ck_ip]").val();
		var url="http://"+ck_ip+"/markingprt/markingwork.php?"+data;

		console.log("callmarkingapi url : "+url);

		$.ajax({
			type : "GET", //method
			url : url,
			data : "",
			success : function (result) {
				console.log("callmarkingapi  result " + result);
				markingmakepage(result);
			},
			error:function(request,status,error){
				console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
			}
	   });
	}
	function markingmakepage(json)
	{
		console.log("markingmakepagemarkingmakepagemarkingmakepage ");
		console.log(json);
		if(!isEmpty(json))
		{
			var obj = JSON.parse(json);
			console.log("markingmakepage apiCode : " + obj["apiCode"])

			if(obj["apiCode"]=="markingsetting") //마킹프린터 셋팅
			{
				var mstxt="";

				if(obj["resultCode"]=="200" && obj["resultMessage"]=="OK") //마킹프린터 설정 완료
				{
					setTimeout(function(){
						intrevalprint();
					},300);
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
					else if(obj["resultCode"]=="400")
					{
						mctxt="마킹프린터 연결 실패(2)";
						alert(mctxt+" "+obj["resultMessage"]); //마킹프린터 소켓 연결 실패
					}
				}
			}
		}
		else
		{
			mctxt="마킹프린터 연결 실패(3)";
			alert(mctxt); //마킹프린터 소켓 연결 실패
		}
	}
	function gettxtnamestar(odname)
	{
		var nlen=odname.length;
		var reNameS="";
		if(nlen==2)
		{
			reNameS=odname.substring(0, (odname.length)-1)+"*";
		}
		else if(nlen==3)
		{
			reNameS=odname.substring(0, (odname.length)-2)+"*"+odname.substring((odname.length)-1);
		}
		else if(nlen==4 || nlen==5)
		{
			reNameS=odname.substring(0, (odname.length)-2)+"*"+odname.substring((odname.length)-1);
		}
		else if(nlen>=6)
		{
			var len=nlen-4;
			var restar="";
			for(i=0;i<len;i++)
			{
				restar+="*";
			}
			reNameS=odname.substring(0, 4)+restar;
		}
		return reNameS;
	}
	function intrevalprint()
	{
		stattxt("* 마킹 프린터가 설정완료 되었습니다. 마킹을 시작하세요.", 2);
		printID=setInterval("getpouchcnt()",2000);
	}
	function clearIntervalPrint()
	{
		if(!isEmpty(printID))
		{
			clearInterval(printID);
			printID="";
		}		
	}
	function getpouchcnt()
	{	
		var code=$("input[name=code]").val();
		var mrPrinter=$("#marking").attr("value");
		var packcnt=parseInt($("#odPackcnt").text());
		var pouchcnt=parseInt($("#cnt").text());
		var jsondata={};
		//console.log("getpouchcnt packcnt = " + packcnt + ", pouchcnt = " + pouchcnt);		

		//--------------------------------------
		//카운터 될때마다 API 호출
		//--------------------------------------
		jsondata["odCode"] = code;
		jsondata["mrPrinter"] = mrPrinter;
		jsondata["odCount"]=pouchcnt;

		//console.log(JSON.stringify(jsondata));
		//callapi('POST','marking','markingcountupdate',jsondata);
		//--------------------------------------

		callmarkingapi("apiCode=markingcount");

		if((pouchcnt>=packcnt))
		{
			//--------------------------------------
			//카운터 될때마다 API 호출
			//--------------------------------------
			jsondata["odCode"] = code;
			jsondata["mrPrinter"] = mrPrinter;

			//console.log(JSON.stringify(jsondata));
			//callapi('POST','marking','markingfinishupdate',jsondata);
			//--------------------------------------
			//마킹 없을 시 아랫부분 정리
			//layersign("success",getTxtdt("step44"),'','1000');//마킹이 종료되었습니다.
			clearIntervalPrint();
			stattxt("* 마킹이 종료되었습니다.", 2);
			//alert("마킹이 종료되었습니다.");
			$("#barcode").focus();
			
		}
	}
	function markingcounttest()
	{
		var packcnt=parseInt($("#odPackcnt").text());
		$("#cnt").text(packcnt);
	}
	//==========================================================================
	function main(){
		getprintertype();
		var chk=getCookie("ck_stStaffid");
		console.log(chk);
		if(chk!=""){
			list();
		}else{
			login();
		}
	}

	function login(){
		console.log('1');
		$("#container").load("login.php");
	}
	function list(){
		console.log('22');
		clearIntervalPrint();
		// $("#container").load("list.php",function(){
		// 	getlist();
		// });
        $("#container").load("manual.php",function(){
            getmanual(code);
        });
	}
	function detail(code){
		console.log('3');
		clearIntervalPrint();
		$("#container").load("detail.php",function(){
			getdetail(code);
		});
	}
	function setting(type){
		console.log('4');
		clearIntervalPrint();
		$("#container").load("setting.php",function(){
			getsetting(type);
		});
	}

	function manual(){
        console.log('5');
		clearIntervalPrint();
		$("#container").load("manual.php",function(){
			getmanual(code);
		});
	}	

	function settab(id){
		//if(id=="label" && $("input[name=odCode]").val()==""){
		//	setting(id);
		//}else{
			$(".bodyWrap .setting__body").fadeOut(0);
			$("#"+id).fadeIn(0);
			$("#tab a").removeClass("active");
			$("#tab a."+id).addClass("active");
			switch(id){
				case "label":
					$("#updateBtn").attr("href","javascript:settingUpdate()").text("설정");
					callapi("GET","marking","apiCode=label");
					break;
				case "print":
					$("#updateBtn").attr("href","javascript:settingPrint()").text("저장");
					//local
					$.ajax({
						type : "GET", //method
						url : "/spoutprt/markingprt/setting.json",
						data : "",
						cache:false,
						success : function (result) {
							console.log(result);
							var data="<option value=''>마킹프린터 선택";
							$(result).each(function(idx, val){
								if(val["use"]=="Y"){
									var selected=" selected";
									$("input[name=printip]").val(val["ip"]);
									$("input[name=printport]").val(val["port"]);
									$("input[name=printertype]").val(val["printer"]);
								}else{
									var selected=" ";
								}
								data+="<option value='"+val["printer"]+"' data-ip='"+val["ip"]+"' data-port='"+val["port"]+"' "+selected+">"+val["printer"].toUpperCase();
							});
							$("#selprint").html(data);
						},
						error:function(request,status,error){
							console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
						}
				   });
					break;
			}
		//}
	}

	function start(type){
		console.log("startstartstart type = " + type);
		stattxt("* 마킹 프린터 설정 중 입니다. 잠시 기다려 주세요....", 1);
		var code=$("input[name=code]").val();
		var ismarkstar=$("input[name=ismarkstar]").val();
		ismarkstar=!isEmpty(ismarkstar)?ismarkstar:"N";
		if(type==2)//수동마킹이라면 
		{
			var patient=medical=mr_linetxt1=mr_linetxt2=medicalphone=markingdate="";
			var prtype=$("#sellabel").val();
			console.log("prtype = " + prtype );
			switch(prtype)
			{
			case "marking15": //환자명
				patient=$("input[name=setText0]").val();
				break;
			case "marking14"://한의원명
				medical=$("input[name=setText0]").val();
				break;
			case "marking13"://환자명 + 조제일 + 한의원명
				patient=$("input[name=setText0]").val();
				markingdate=$("input[name=setText1]").val();
				medical=$("input[name=setText2]").val();
				break;
			case "marking12"://한의원명 + 한의원연락처
				medical=$("input[name=setText0]").val();
				medicalphone=$("input[name=setText1]").val();
				break;
			case "marking11"://환자명 + 조제일
				patient=$("input[name=setText0]").val();
				markingdate=$("input[name=setText1]").val();
				break;
			case "marking10"://한의원명 + 한의원연락처 + 환자명
				medical=$("input[name=setText0]").val();
				medicalphone=$("input[name=setText1]").val();
				patient=$("input[name=setText2]").val();
				break;
			case "marking09"://입력문구 + 한의원 + 한의원연락처
				mr_linetxt1=$("input[name=setText0]").val();
				medical=$("input[name=setText1]").val();
				medicalphone=$("input[name=setText2]").val();
				break;
			case "marking08"://입력문구1 + 입력문구2
				mr_linetxt1=$("input[name=setText0]").val();
				mr_linetxt2=$("input[name=setText1]").val();
				break;
			case "marking16"://한의원명 + 환자명 + 연락처 + 조제일
				medical=$("input[name=setText0]").val();
				patient=$("input[name=setText1]").val();
				medicalphone=$("input[name=setText2]").val();
				markingdate=$("input[name=setText3]").val();
				break;
			case "marking17"://한의원명 + 연락처 + 조제일
				medical=$("input[name=setText0]").val();
				medicalphone=$("input[name=setText1]").val();
				markingdate=$("input[name=setText2]").val();
				break;
			}
			if(ismarkstar=="Y") //Y이면 환자명 별표시 
			{
				var backpatient=patient;
				patient=gettxtnamestar(backpatient);
			}
		}
		else
		{
			var medical=$("input[name=medical]").val();
			var patient=$("input[name=patient]").val();
			
			var prtype=$("input[name=prtype]").val();
			if(ismarkstar=="Y") //Y이면 환자명 별표시 
			{
				patient=gettxtnamestar($("input[name=patient]").val());
			}

			var mr_linetxt1=$("input[name=mr_linetxt1]").val();
			var mr_linetxt2=$("input[name=mr_linetxt2]").val();

			var medicalphone=$("input[name=medicalphone]").val();
			var markingdate=$("input[name=markingdate]").val();
		}

		var url="apiCode=markingsetting&code="+code+"&medical="+encodeURI(medical)+"&patient="+encodeURI(patient)+"&prtype="+prtype+"&line1="+encodeURI(mr_linetxt1)+"&line2="+encodeURI(mr_linetxt2)+"&medicalphone="+encodeURI(medicalphone)+"&markingdate="+encodeURI(markingdate)
		console.log(url);
		callmarkingapi(url);
	}

	function getlogin(){
		var data=postdata();
		data["apiCode"]="stafflogin";
		callapi("POST","marking",data);
	}	

	function getlist(){
		var page=$("input[name=page]").val();
		var data="apiCode=list&page="+page;
		callapi("GET","marking",data);
	}	

	function getdetail(code){
		var data="apiCode=detail&code="+code;
		callapi("GET","marking",data);
	}	

	function getsetting(type){
		var chk=getCookie("ck_stStaffid");
		if(chk!=""){
			var code=$("#code").val();
			var data="apiCode=setting&code="+code+"&type="+type;
			callapi("GET","marking",data);
		}else{
			login();
		}
	}	

	function getmanual(){
		var data="apiCode=manual";
		callapi("GET","marking",data);
	}	

	function getprintertype()
	{
		$.ajax({
			type : "GET", //method
			url : "/spoutprt/markingprt/setting.json",
			data : "",
			cache:false,
			success : function (result) {
				$(result).each(function(idx, val){
					if(val["use"]=="Y"){
						$("input[name=printip]").val(val["ip"]);
						$("input[name=printport]").val(val["port"]);
						$("input[name=printertype]").val(val["printer"]);
					}
				});
			},
			error:function(request,status,error){
				console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
			}
	   });
	}

	function viewdominohplabel(printertype)
	{
		var txt01=$("input[name=setText0]").val();
		var txt02=$("input[name=setText1]").val();
		var txt03=$("input[name=setText2]").val();
		var txt04=$("input[name=setText3]").val();
		var prtype=$("#sellabel").val();
		var nuni_line1=nuni_line2="";
		var patient=markingdate=medical=medicalphone="";
		console.log("printertype = " + printertype);
		if(printertype=="domino")
		{
			switch(prtype)
			{
			case "marking15": //환자명
				nuni_line1=$("input[name=setText0]").val();
				break;
			case "marking14"://한의원명
				nuni_line1=$("input[name=setText0]").val();
				break;
			case "marking13"://환자명 + 조제일 + 한의원명
				patient=$("input[name=setText0]").val();
				markingdate=$("input[name=setText1]").val();
				medical=$("input[name=setText2]").val();
				nuni_line1=markingdate;
				nuni_line2=patient+" / "+medical;
				break;
			case "marking12"://한의원명 + 한의원연락처
				nuni_line2=$("input[name=setText0]").val();
				nuni_line1=$("input[name=setText1]").val();
				break;
			case "marking11"://환자명 + 조제일
				nuni_line2=$("input[name=setText0]").val();
				nuni_line1=$("input[name=setText1]").val();
				break;
			case "marking10"://한의원명 + 한의원연락처 + 환자명
				medical=$("input[name=setText0]").val();
				medicalphone=$("input[name=setText1]").val();
				patient=$("input[name=setText2]").val();
				nuni_line1=medicalphone;
				nuni_line2=medical+" / "+patient;
				break;
			case "marking09"://입력문구 + 한의원 + 한의원연락처
				mr_linetxt1=$("input[name=setText0]").val();
				medical=$("input[name=setText1]").val();
				medicalphone=$("input[name=setText2]").val();
				nuni_line1=medicalphone;
				nuni_line2=mr_linetxt1+" / "+medical;
				break;
			case "marking08"://입력문구1 + 입력문구2
				nuni_line1=$("input[name=setText0]").val();
				nuni_line2=$("input[name=setText1]").val();
				break;
			case "marking16"://한의원명 + 환자명 + 연락처 + 조제일
				medical=$("input[name=setText0]").val();
				patient=$("input[name=setText1]").val();
				medicalphone=$("input[name=setText2]").val();
				markingdate=$("input[name=setText3]").val();
				nuni_line1=medicalphone+" / "+markingdate;
				nuni_line2=medical+" / "+patient;
				break;
			case "marking17"://한의원명 + 연락처 + 조제일
				medical=$("input[name=setText0]").val();
				medicalphone=$("input[name=setText1]").val();
				markingdate=$("input[name=setText2]").val();
				nuni_line1=medicalphone+" / "+markingdate;
				nuni_line2=medical;
				break;
			}
		}
		else
		{
			switch(prtype)
			{
			case "marking15": //환자명
				nuni_line1=$("input[name=setText0]").val();
				break;
			case "marking14"://한의원명
				nuni_line1=$("input[name=setText0]").val();
				break;
			case "marking13"://환자명 + 조제일 + 한의원명
				patient=$("input[name=setText0]").val();
				markingdate=$("input[name=setText1]").val();
				medical=$("input[name=setText2]").val();
				nuni_line1=medical;
				nuni_line2=patient+" / "+markingdate;
				break;
			case "marking12"://한의원명 + 한의원연락처
				nuni_line1=$("input[name=setText0]").val();
				nuni_line2=$("input[name=setText1]").val();
				break;
			case "marking11"://환자명 + 조제일
				nuni_line1=$("input[name=setText0]").val();
				nuni_line2=$("input[name=setText1]").val();
				break;
			case "marking10"://한의원명 + 한의원연락처 + 환자명
				medical=$("input[name=setText0]").val();
				medicalphone=$("input[name=setText1]").val();
				patient=$("input[name=setText2]").val();
				nuni_line1=medical+" / "+medicalphone;
				nuni_line2=patient;
				break;
			case "marking09"://입력문구 + 한의원 + 한의원연락처
				mr_linetxt1=$("input[name=setText0]").val();
				medical=$("input[name=setText1]").val();
				medicalphone=$("input[name=setText2]").val();
				nuni_line1=mr_linetxt1;
				nuni_line2=medical+" / "+medicalphone;
				break;
			case "marking08"://입력문구1 + 입력문구2
				nuni_line1=$("input[name=setText0]").val();
				nuni_line2=$("input[name=setText1]").val();
				break;
			case "marking16"://한의원명 + 환자명 + 연락처 + 조제일
				medical=$("input[name=setText0]").val();
				patient=$("input[name=setText1]").val();
				medicalphone=$("input[name=setText2]").val();
				markingdate=$("input[name=setText3]").val();
				nuni_line1=medical+" / "+medicalphone;
				nuni_line2=patient+" / "+markingdate;
				break;
			case "marking17"://한의원명 + 연락처 + 조제일
				medical=$("input[name=setText0]").val();
				medicalphone=$("input[name=setText1]").val();
				markingdate=$("input[name=setText2]").val();
				nuni_line1=medical+" / "+medicalphone;
				nuni_line2=markingdate;
				break;
			}
		}
		var txtdata="<div class='preview'><strong class='code'>"+nuni_line1+"</strong><br><strong>"+nuni_line2+"</strong></div>";
		return txtdata;
	}
	function setTxt(){
		var selprint=$("input[name=printertype]").val();
		var txt01=$("input[name=setText0]").val();
		var txt02=$("input[name=setText1]").val();
		var txt03=$("input[name=setText2]").val();
		var txt04=$("input[name=setText3]").val();
		var txtData="";
		console.log("selprint = " + selprint);
		if(selprint=="domino" || selprint=="hp")
		{
			txtData=viewdominohplabel(selprint);
		}
		else
		{
			var line1=lin2="";
			if(!isEmpty(txt04))
			{
				line1=txt02+" "+txt02;
				line2=txt03+" "+txt04;
			}
			else
			{
				if(!isEmpty(txt03))
				{
					line1=txt01;
					line2=txt02+" "+txt03;
				}
				else
				{
					line1=txt01;
					line2=txt02;
				}
			}
			txtData="<div class='preview'><strong class='code'>"+line1+"</strong><br><strong>"+line2+"</strong></div>";
		}

		$("#markingData").html(txtData);
	}
	function clearkeyboardInput()
	{
		$(".keyboardInputInitiator").remove();
		$("#eng_text").val("");
		$(".keyboardInput").removeClass("keyboardInput");
	}
	function setkeyboardInput(obj)
	{
		clearkeyboardInput();
		$("#keyboardInputClose").trigger("click");

		var name=obj.name;
		$("input[name="+name+"]").addClass("keyboardInput");
		$("input[name="+name+"]").focus();
		var baktxt=$("input[name="+name+"]").val();
		$("#eng_text").val(baktxt);

		callkeyboard();
	}

	function selectLabel(){
		var code=$("input[name=odCode]").val();
		var label=$("#sellabel").val();
		$("input[name=mrCode]").val(label);
		var data="apiCode=resetlabel&code="+code+"&label="+label;
		callapi("GET","marking",data);
	}

	function selectPrint(){
		var ip=$("#selprint option:selected").attr("data-ip");
		var port=$("#selprint option:selected").attr("data-port");
		var printertype=$("#selprint option:selected").val();
		$("input[name=printip]").val(ip);
		$("input[name=printport]").val(port);
		$("input[name=printertype]").val(printertype);
	}

	function settingUpdate(){
		var odcode=$("input[name=odCode]").val();
		if(isEmpty(odcode)){
			var chk=$("#sellabel").val();
			var chk2="1";
			var chk2txt="";
			$("input.on").each(function(){
				if(isEmpty($(this).val())){
					alert("["+$(this).attr("placeholder")+"] 입력해주세요");
					chk2="";chk2txt="["+$(this).attr("placeholder")+"] 입력해주세요"
					return false;
				}
			});
			if(isEmpty(chk)){
				alert("라벨을 선택해 주세요");
			}else if(isEmpty(chk2)){
				alert(chk2txt);
			}else{
				$("#updateBtn").attr("href","javascript:$('#startBtn').fadeOut(0);start(2);").text("시작");
				$("#updateBtn").attr("id","startBtn")
			}
		}else{
			var data=postdata();
			data["apiCode"]="labelupdate";
			callapi("POST","marking",data);
		}
	}

	function settingCancel(){
		$("input[name=code]").val("");
		list();
	}
	function settingPrint(){
		var printArr=[]
		$("#selprint").find("option").each(function(){
			//[{"printer":"hp","ip":"192.168.0.100","port":"100","use":"Y"},{"printer":"domino","ip":"192.168.0.200","port":"101","use":"N"}]
			if($(this).val()!=""){
				if($(this).prop("selected")==true){
					var ip=$("input[name=printip").val();
					var port=$("input[name=printport").val();
					var sel="Y";
					$("input[name=printertype]").val($(this).val());
				}else{
					var ip=$(this).attr("data-ip");
					var port=$(this).attr("data-port");
					var sel="N";
				}
				var arr={"printer":$(this).val(),"ip":ip,"port":port,"use":sel};
				printArr.push(arr);
			}
		});
		printArr=JSON.stringify(printArr);

		$.ajax({
			type : "POST", //method
			url : "/spoutprt/markingprt/upload.php",
			data : "data="+printArr,
			success : function (result) {
				console.log(result);
				stattxt("* 프린터 설정이 완료되었습니다", 0);
				if($("input[name=odCode]").val()!=""){
					settab("label");
				}
			},
			error:function(request,status,error){
				console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
			}
	   });
	}

	function makepage(json){
		var obj = JSON.parse(json);
		console.log(obj)
		if(obj["resultCode"]=="200"){
			switch(obj["apiCode"])
			{
				case "stafflogin":
					setStaffLogin(obj);
					break;
				case "companyinfo":
					$("#logo").html(obj["logo"]);
					$("#barcode").focus();
					break;
				case "list":
					var data="";
					if(!isEmpty(obj["list"]))
					{
						$(obj["list"]).each(function( index, value )
						{
							data+="<tr onclick=\"detail('"+value["odCode"]+"')\">";
							//주문코드
							data+="	<td><span>"+value["odCode"]+"</span></td>";
							//한의원/주문자 
							data+="	<td><span>"+value["odName"]+"</span></td>";
							//처방명
							data+="	<td><span>"+value["odTitle"]+"</span></td>";
							data+="</tr>";

						});
					}
					else
					{
						data+="<tr>";
						data+="	<td colspan='3'>데이터가 없습니다.</td>";
						data+="</tr>";
					}
					//테이블에 넣기
					$("#listtbl tbody").html(data);
					//총갯수
					$("#tcnt").text("( "+obj["tcnt"]+" )");
					//페이징
					getpage("pagediv",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
					break;
				case "detail":
					var dataurl="https://data.djmedi.net/";
					$("input.setlabel").val("").removeClass("on");
					$("input[name=odCode]").val(obj["data"]["odCode"]);
					$("#odPackcnt").text(obj["data"]["odPackcnt"])
					$("input[name=mrCode]").val(obj["data"]["mrCode"]);
					$("#markingData").html(obj["data"]["markingData"]);
					$("#pouchName").text(obj["data"]["pouchName"]);
					$("#pouchImg").html("<img src='"+dataurl+obj["data"]["pouchImg"]+"'>");

					$("input[name=code]").val(obj["data"]["odCode"]);
					$("input[name=medical]").val(obj["data"]["mi_name"]);
					$("input[name=patient]").val(obj["data"]["od_name"]);
					$("input[name=prtype]").val(obj["data"]["mrCode"]);
					$("input[name=ismarkstar]").val(obj["data"]["odCode"]);
					$("input[name=mr_linetxt1]").val(obj["data"]["mr_linetxt1"]);
					$("input[name=mr_linetxt2]").val(obj["data"]["mr_linetxt2"]);
					$("input[name=medicalphone]").val(obj["data"]["mi_phone"]);
					$("input[name=markingdate]").val(obj["data"]["markingdate"]);
					break;
				case "setting":
					console.log(obj["data"]["odCode"]);
					//if(isEmpty(obj["data"]["odCode"])){
					//	settab('print')
					//}
					//else
					{
						$("input.setlabel").val("").removeClass("on");
						$("input[name=odCode]").val(obj["data"]["odCode"]);
						$("#markingData").html(obj["data"]["markingData"]);
						//setting chk
						var chk=$("#settingForm").hasClass("setting");
						if(chk==true){
							var n=0;
							$(obj["data"]["mrCnt"]["mrData"]).each(function(idx, data){
								console.log(obj["data"]["mrCnt"]["mrData"][n]);
								if(obj["data"]["mrCnt"]["mrLabel"][n]=="mr_linetxt1" || obj["data"]["mrCnt"]["mrLabel"][n]=="mr_linetxt2"){
									$("input[name=setText"+n+"]").addClass("on").attr("readonly",false);
								}
								$("input[name=setText"+n+"]").val(data);
								n++;
							});
						}
						settab(obj["type"]);
					}
					break;
				case "label":
					var mrcode=$("input[name=mrCode]").val();
					var data="<option value=''>리벨타입선택";
					//console.log("DOO:: mrcode = " + mrcode);
					$(obj["list"]).each(function(idx, val){
						if(mrcode==val["cdCode"]){var selected=" selected";}else{var selected=" ";}
						data+="<option value='"+val["cdCode"]+"' data-value='"+val["cdValue"]+"' "+selected+">"+val["cdDesc"];
					});
					$("#sellabel").html(data);
					if(!isEmpty(mrcode))
					{
						selectLabel();
					}
					break;
				case "print"://로컬로변경
					var data="<option value=''>마킹프린터 선택";
					$(obj["list"]).each(function(idx, val){
						data+="<option value='"+val["mpSeq"]+"' data-ip='"+val["mpIP"]+"' data-port='"+val["mpPort"]+"'>["+val["mpType"]+"] "+val["mpTitle"];
					});
					$("#selprint").html(data);
					break;
				case "resetlabel":
					if(isEmpty(obj["odCode"])){
						$("input.setlabel").attr("readonly",false);
					}
					$("input.setlabel").val("").removeClass("on").attr("placeholder","");
					$("#markingData").html(obj["markingData"]);
					$("#prtype").html(obj["mrCode"]);
					//setting chk
					var chk=$("#settingForm").hasClass("setting");
					if(chk==true){
						var n=0;
						$(obj["mrCnt"]["mrData"]).each(function(idx, data){
							//console.log(obj["mrCnt"]["mrData"][n]);
							if(obj["mrCnt"]["mrLabel"][n]=="mr_linetxt1" || obj["mrCnt"]["mrLabel"][n]=="mr_linetxt2"){
								$("input[name=setText"+n+"]").addClass("on").attr("readonly",false);
							}
							if(obj["mrCnt"]["mrText"][n]!="No Marking"){
								$("input[name=setText"+n+"]").val(data);
								$("input[name=setText"+n+"]").attr("placeholder",obj["mrCnt"]["mrText"][n]);
								$("input[name=setText"+n+"]").addClass("on");
								n++;
							}
						});
					}
					break;
				case "labelupdate":
					detail(obj["odCode"]);
					break;
			}
		}else{
			var msg="["+obj["resultCode"]+"] "+obj["resultMessage"];
			$("input[name=stLoginId]").val("");
			alert(msg);
		}
		$("#barcode").focus();
	}
	main();
	callapi("GET","marking","apiCode=companyinfo");
</script>