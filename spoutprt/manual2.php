<?php
	$root="../spoutprt";
?>
<link rel="stylesheet" href="<?php echo $root?>/assets/css/keyboard.css"/>
<script src="<?php echo $root?>/assets/js/keyboard.js"></script>
<style>
	.setlabel{background:#eee;}
	.setlabel.on{background:#fff;}
	.settingWrap .col{width:50%;padding:1%;}
	.count .btn a{font-size:35px;width:100px;border-radius:5px;padding:5px 10px;border:1px solid #333;margin:10px 0 0 10px;vertical-align:middle;}
	#setCountdiv input{width:100px;height:64px;margin-left:20px;padding:2px;border:1px solid #333;vertical-align:middle;text-align:center;}
	#markingData{width:400px;overflow:hidden;}
</style>
<div class="work">
  <div class="wrap">
	<div id="stattxt" class="manual"></div>
	<div class="work__tit">
	  작업설정
	</div>
	<div class="qrcodeWrap">
	  <div class="qrcode" id="markingData"></div>
	  <div class="qrBtn">
		<a href="javascript:markingcounttest()">치트키</a>
		<a href="javascript:settingManual()" class="border-style" id="startBtn">시작</a>
		<a href="javascript:manual();" class="border-style" id="resetBtn">초기화</a>
		<a href="javascript:list()" class="border-style">취소</a>
	  </div>
	</div>

	<div class="workDetail__info settingWrap">
	  <div class="col">
		  <div class="inputBox">
			<div class="setting__head"></div>
			<div class="setting__body">
			  <div class="input">
				<input type="text" placeholder="입력문구 1 을 입력하세요" name="setText0" id="setText0" class="reqdata setlabel on" maxlength="16" onkeyup="setTxt()" onclick="setkeyboardInput(this);" value="">
			  </div>
			  <div class="input">
				<input type="text" placeholder="입력문구 2 를 입력하세요" name="setText1" id="setText1" class="reqdata setlabel on" maxlength="16" onkeyup="setTxt()"  onclick="setkeyboardInput(this);" value="">
			  </div>
			  <div class="input">
				<input type="text" placeholder="" name="setText2" id="setText2" readonly class="reqdata setlabel" maxlength="16" onkeyup="setTxt()" >
			  </div>
			</div>
		  </div>
	  </div>
	  <div class="col">
		<div class="info__head">마킹카운트</div>
		<div class="info__body">
		  <div class="inn">
			<div class="count">
			  <span class="blue" id="cnt">0</span>
			  <span class="slash">/</span>
			  <span class="gray" id="odPackcnt">45</span>
			  <span class="btn" id="setCountdiv"><a href="javascript:setCount()">팩수설정</a></span>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</div>
<script>//settab('label')</script>
<script>
	function setCount(){
		var cnt=$("#odPackcnt").text();
		$("#odPackcnt").text("");
		var txt="<input type=text' name='totCount' value='"+cnt+"' onclick='setkeyboardInput(this);'> <a href='javascript:setCountdone()'>확인</a>";
		$("#setCountdiv").html(txt);
	}

	function setCountdone(){
		$("#odPackcnt").text($("input[name=totCount]").val());
		var txt="<a href='javascript:setCount()'>팩수설정</a>";
		$("#setCountdiv").html(txt);
	}

	function settingManual(){
		console.log("settingManualsettingManualsettingManualsettingManual");
		var txt0=$("input[name=setText0]").val();
		var txt1=$("input[name=setText1]").val();
		if(txt0=="" || txt1==""){
			alert("입력된 문구가 없습니다.");
		}else{
			var cnt=$("#odPackcnt").text();
			if(cnt=="" || cnt < 1 ){
				alert("입력된 팩수가 없습니다.");
			}else{
				$("#code").val("ODD000000");//수동
				$("#prtype").val("marking08");//입력1+입력2
				$("#mr_linetxt1").val($("input[name=setText0]").val());//입력1
				$("#mr_linetxt2").val($("input[name=setText1]").val());//입력2
				$("#startBtn").removeClass("border-style").attr("href","javascript:$('#startBtn').fadeOut(0);start(3);").text("시작");//수동
				//$("#resetBtn").css("display","block");
				start(4);
			}
		}
	}
</script>
