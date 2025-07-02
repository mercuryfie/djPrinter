<?php
	$root="../spoutprt";
?>
<style>
	#pouchImg{z-index:-1;}
	#pouchImg img{width:180px;}
</style>
<div class="work workDetail">
  <div class="wrap">
	<div id="stattxt" class="detail"></div>
	<div class="work__tit">
	  작업설정
	</div>
	<div class="qrcodeWrap">
	  <div class="qrcode" id="markingData"></div>
	  <div class="qrBtn">
		<a href="javascript:markingcounttest()">치트키</a>
		<a href="javascript:$('#startBtn').fadeOut(0);start(1);" id="startBtn">시작</a>
		<a href="javascript:setting('label')" class="border-style">설정</a>
		<a href="javascript:settingCancel()" class="border-style">취소</a>
	  </div>
	</div>

	<div class="workDetail__info">
	  <div class="col">
		<div class="info__head">파우치명</div>
		<div class="info__body">
		  <div class="inn">
			<div class="name" id="pouchName"></div>
		  </div>
		</div>
	  </div>
	  <div class="col">
		<div class="info__head">파우치 사진</div>
		<div class="info__body">
		  <div class="inn">
			<div class="photo" id="pouchImg">
			  <img src="./assets/images/photo.png" alt="">
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
			  <span class="gray" id="odPackcnt">0</span>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</div>
