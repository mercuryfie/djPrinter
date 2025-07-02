<?php
$root="../spoutprt";
?>
<link rel="stylesheet" href="/assets/web/css/main.css">
<!--<link rel="stylesheet" href="./assets/web/css/main.css">-->
<style>
    .setlabel{background:#eee;}
    .setlabel.on{background:#fff;}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

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
                <a href="javascript:settingCancel();" class="border-style">취소</a>
            </div>
        </div>

        <div class="settingWrap">
            <form action="" id="settingForm" class="setting">
                <div class="form flexType3">
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
                    <div class="flexType2">
                        <div class="col tabBox wrapBox" id="tabBox2">
                            <div class="setting__head tabHead2" id="tabHead2">
                                <a href="#" class="tabBtn label2 active" data-target="label2"><span>포장기</span></a>
                                <a href="#" class="tabBtn print2" data-target="print2"><span>인쇄 설정</span></a>
                            </div>
                            <div class="bodyWrap">
                                <div class="setting__body tabContent2" id="label2">
                                    <div class="input flexType1">
                                        <p class="title">처방 번호</p>
                                        <input type="text" class="data"
                                               name="" id="" placeholder="작약감초탕 가감(디제이한의원)">
                                    </div>
                                    <div class="input flexType1">
                                        <p class="title">처방명</p>
                                        <input type="text" class="data"
                                               name="" id="" placeholder="작약감초탕 가감(디제이한의원)">
                                        <!--                            <input type="text" id="setindelay2" name="setindelay2" placeholder="입력해주세요." onclick="setkeyboardInput2(this);">-->
                                    </div>
                                    <div class="input flexType1">
                                        <p class="title">처방 수량</p>
                                        <input type="text" class="data"
                                               name="" id="" placeholder="작약감초탕 가감(디제이한의원)">
                                        <p class="unit">팩</p>
                                    </div>
                                    <div class="input flexType1">
                                        <p class="title">팩 당 용량</p>
                                        <input type="text" class="data"
                                               name="" id="" placeholder="작약감초탕 가감(디제이한의원)">
                                        <p class="unit">cc</p>
                                    </div>
                                    <div class="inputBtn">
                                        <a href="javascript:setmarkingprtdelay2();">포장기 전송</a>
                                    </div>
                                </div>
                                <div class="setting__body tabContent2" id="print2" style="display:none;">
                                    <div class="input">
                                        <select name="selprint2" id="selprint2" class="reqdata" onchange="selectPrint2();">
                                            <option value="">포장 프린터 선택</option>
                                        </select>
                                    </div>
                                    <div class="input">
                                        <span>프린터 IP</span>
                                        <input type="text" name="printip2" id="printip2" placeholder="입력해주세요." onclick="setkeyboardInput2(this);">
                                    </div>
                                    <div class="input">
                                        <span>프린터 PORT</span>
                                        <input type="text" name="printport2" id="printport2" placeholder="입력해주세요." onclick="setkeyboardInput2(this);">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col tabBox" id="tabBox">
                            <div class="setting__head tabHead" id="tabHead">
                                <a href="#" class="tabBtn label active" data-target="label"><span>마킹기</span></a>
                                <a href="#" class="tabBtn print" data-target="print"><span>인쇄 설정</span></a>
                            </div>
                            <div class="bodyWrap">
                                <div class="setting__body tabContent" id="label">
                                    <div class="input flexType1">
                                        <p class="title">마킹 타입</p>
                                        <select name="sellabel" id="sellabel" class="reqdata" onchange="selectLabel()">
                                            <option value="">라벨타입선택</option>
                                            <option value="">1</option>
                                            <option value="">2</option>
                                        </select>
                                    </div>
                                    <div class="input longInput flexType1">
                                        <p class="title">마킹 문구</p>
                                        <div class="mkText flexType3">
                                            <input type="text" class="data data1"
                                                   name="" id="" placeholder="hello">
                                            <input type="text" class="data"
                                                   name="" id="" placeholder="hello">
                                        </div>
                                        <!--                            <span>인쇄지연 값</span>-->
                                        <!--                            <input type="text" id="setindelay" name="setindelay" placeholder="입력해주세요." onclick="setkeyboardInput(this);">-->
                                    </div>
                                    <div class="input flexType1">
                                        <p class="title">마킹 갯수</p>
                                        <input type="text" class="data"
                                               name="" id="" placeholder="hello">
                                        <p class="unit">개</p>
                                    </div>
                                    <div class="inputBtn">
                                        <a href="javascript:setmarkingprtdelay();">마킹 전송</a>
                                    </div>
                                </div>
                                <div class="setting__body tabContent" id="print" style="display:none;">
                                    <div class="input">
                                        <select name="selprint" id="selprint" class="reqdata" onchange="selectPrint();">
                                            <option value="">마킹프린터 선택</option>
                                        </select>
                                    </div>
                                    <div class="input title-type">
                                        <span>프린터 IP</span>
                                        <input type="text" name="printip" id="printip" placeholder="입력해주세요." onclick="setkeyboardInput(this);">
                                    </div>
                                    <div class="input title-type">
                                        <span>프린터 PORT</span>
                                        <input type="text" name="printport" id="printport" placeholder="입력해주세요." onclick="setkeyboardInput(this);">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="submitBox">
                        <a href="javascript:setmarkingprtdelay(); " class="submit">모두 전송</a>
                    </div>
                    <!--		  <div class="col tabBox"  id="tabBox">-->
                    <!--			<div class="setting__head tabHead" id="tabHead">-->
                    <!--			  <a href="javascript:settab('label')" class="tabBtn label active"-->
                    <!--                 data-target="label">-->
                    <!--				<span>마킹기</span>-->
                    <!--			  </a>-->
                    <!--			  <a href="javascript:settab('print')" class="print  "-->
                    <!--                 data-target="print">-->
                    <!--                  <span>인쇄 설정</span>-->
                    <!--			  </a>-->
                    <!--			</div>-->
                    <!--			<div class="bodyWrap">-->
                    <!--			  <div class="setting__body" id="label">-->
                    <!--				<div class="input">-->
                    <!--				  <select name="sellabel" id="sellabel" class="reqdata" onchange="selectLabel()">-->
                    <!--					<option value="">라벨타입선택</option>-->
                    <!--				  </select>-->
                    <!--				</div>-->
                    <!--				<div class="input title-type">-->
                    <!--				  <span>인쇄지연 값</span>-->
                    <!--				  <input type="text"  id="setindelay" name="setindelay"  placeholder="입력해주세요." onclick="setkeyboardInput(this);">-->
                    <!--				</div>-->
                    <!--				<div class="inputBtn">-->
                    <!--				  <a href="javascript:setmarkingprtdelay();">인쇄지연설정</a>-->
                    <!--				</div>-->
                    <!--			  </div>-->
                    <!--			  <div class="setting__body" id="print">-->
                    <!--				<div class="input">-->
                    <!--				  <select name="selprint" id="selprint" class="reqdata" onchange="selectPrint()">-->
                    <!--					<option value="">마킹프린터 선택</option>-->
                    <!--				  </select>-->
                    <!--				</div>-->
                    <!--				<div class="input title-type">-->
                    <!--				  <span>프린터 IP</span>-->
                    <!--				  <input type="text" name="printip" placeholder="입력해주세요." onclick="setkeyboardInput(this);">-->
                    <!--				</div>-->
                    <!--				<div class="input title-type">-->
                    <!--				  <span>프린터 PORT</span>-->
                    <!--				  <input type="text" name="printport" placeholder="입력해주세요." onclick="setkeyboardInput(this);">-->
                    <!--				</div>-->
                    <!--			  </div>-->
                    <!--			</div>-->
                    <!--		  </div>-->
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        // $('#tabBox2').css('color','orange');

        // tabBox2 (위쪽)
        $('#tabBox2 .tabBtn').on('click', function(e) {
            e.preventDefault();
            var $tabs = $('#tabBox2 .tabBtn');
            var $contents = $('#tabBox2 .tabContent2');
            var targetId = $(this).data('target');

            $tabs.removeClass('active');
            $(this).addClass('active');
            $contents.hide();
            $('#tabBox2 #' + targetId).show();
        });
        // 초기화
        $('#tabBox2 .tabBtn').each(function() {
            var targetId = $(this).data('target');
            if ($(this).hasClass('active')) {
                $('#tabBox2 #' + targetId).show();
            } else {
                $('#tabBox2 #' + targetId).hide();
            }
        });

        // tabBox (아래쪽)
        $('#tabBox .tabBtn').on('click', function(e) {
            e.preventDefault();
            var $tabs = $('#tabBox .tabBtn');
            var $contents = $('#tabBox .tabContent');
            var targetId = $(this).data('target');

            $tabs.removeClass('active');
            $(this).addClass('active');
            $contents.hide();
            $('#tabBox #' + targetId).show();
        });
        // 초기화
        $('#tabBox .tabBtn').each(function() {
            var targetId = $(this).data('target');
            if ($(this).hasClass('active')) {
                $('#tabBox #' + targetId).show();
            } else {
                $('#tabBox #' + targetId).hide();
            }
        });

    });

</script>