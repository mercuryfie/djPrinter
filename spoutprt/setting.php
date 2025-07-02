<?php
	$root="../spoutprt";
?>
<!--<link rel="stylesheet" href="/assets/css/main.css">-->
<style>
	.setlabel{background:#eee;}
	.setlabel.on{background:#fff;}
	input.on{background:#fff;}

	div.input a.pstateBtn{height: 60px;border-top-right-radius: 6px;border-bottom-right-radius: 6px;color: #fff;font-size: 20px;background: #0E7A9E;text-align:center;line-height:60px;cursor:Default;display:inline-block;width:25%;}
	div.input .setBtn{height: 60px;border-top-right-radius: 6px;border-bottom-right-radius: 6px;color: #fff;font-size: 20px;background: #0E7A9E;text-align:center;width:25%;line-height:60px;}
	div.input a.disBtn{background: gray;}

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
		<a href="javascript:settingUpdate()" id="updateBtn">저장</a>
		<a href="javascript:list();" class="border-style">취소</a>
	  </div>
	</div>

	<div class="settingWrap">
	  <form action="" id="settingForm" class="setting">
		<div class="form">
<!--		  <div class="col inputBox">-->
<!--			<div class="setting__head"></div>-->
<!--			<div class="setting__body">-->
<!--			  <div class="input">-->
<!--				<input type="text" placeholder="" name="setText0" class="reqdata setlabel" readonly onblur="setTxt()" onclick="setkeyboardInput(this);">-->
<!--			  </div>-->
<!--			  <div class="input">-->
<!--				<input type="text" placeholder="" name="setText1" class="reqdata setlabel" readonly onblur="setTxt()" onclick="setkeyboardInput(this);">-->
<!--			  </div>-->
<!--			  <div class="input">-->
<!--				<input type="text" placeholder="" name="setText2" class="reqdata setlabel" readonly onblur="setTxt()" onclick="setkeyboardInput(this);">-->
<!--			  </div>-->
<!--			  <div class="input">-->
<!--				<input type="text" placeholder="" name="setText3" class="reqdata setlabel" readonly onblur="setTxt()" onclick="setkeyboardInput(this);">-->
<!--			  </div>-->
<!--			</div>-->
<!--		  </div>-->
		  <div class="col tabBox">
			<div class="setting__head" id="tab">
			  <a href="javascript:settab('label')" class="label">
				<span>라벨 및 인쇄설정dd</span>
			  </a>
			  <a href="javascript:settab('print')" class="print active">
				<span>프린터설정</span>
			  </a>
			</div>
			<div class="bodyWrap">
			  <div class="setting__body" id="label">
				<div class="input">
				  <select name="sellabel" id="sellabel" class="reqdata" onchange="selectLabel()">
					<option value="">라벨타입선택</option>
				  </select>
				</div>
				<div class="input title-type">
				  <span style="width:45%;padding-right:5px;">인쇄지연 값</span>
				  <input type="number" id="setindelay" name="setindelay" class="setVal" style="width:30%;padding:0;text-align:center;font-size:20px;"   placeholder="00000" onclick="setkeyboardInput(this);" maxlength=5 value="00000" min="0" max="50000" onblur="blursetindelay();">
				  <a href="javascript:setmarkingprtdelay();" class="setBtn">SET</a>
				</div>
				<div class="input title-type">
				  <span style="width:50%;">프린터 상태</span>
				  <span style="width:25%;"></span>
				  <a href="#" class="pstateBtn" onclick="setmarkingprtenable();">Enable</a>
				  <!-- <a href="#" class="pstateBtn disBtn" onclick="">Disable</a> -->
				</div>
			  </div>
			  <div class="setting__body" id="print">
				<div class="input">
				  <select name="selprint" id="selprint" class="reqdata" onchange="selectPrint()">
					<option value="">마킹프린터 선택</option>
				  </select>
				</div>
				<div class="input title-type">
				  <span>프린터 IP</span>
				  <input type="text" name="printip" placeholder="입력해주세요." onclick="setkeyboardInput(this);">
				</div>
				<div class="input title-type">
				  <span>프린터 PORT</span>
				  <input type="text" name="printport" placeholder="입력해주세요." onclick="setkeyboardInput(this);">
				</div>
			  </div>
			</div>
		  </div>
		</div>
	  </form>
	</div>
  </div>
</div>
