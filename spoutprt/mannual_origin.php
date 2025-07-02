<?php
$root="../spoutprt";
?>
<style>
    /*.setlabel{background:#eee;}*/
    /*.setlabel.on{background:#fff;}*/
    .setlabel{background:#eee;}
    .setlabel.on{background:#fff;}


</style>
<scrtipt src="">

</scrtipt>
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
                                <span>포장기</span>
                            </a>
                            <a href="javascript:settab('print')" class="print active">
                                <span>인쇄 설정</span>
                            </a>
                        </div>
                        <div class="bodyWrap">
                            <div class="setting__body" id="label2">
                                <div class="input">
                                    <select name="sellabel2" id="sellabel2" class="reqdata" onchange="selectLabel()">
                                        <option value="">라벨타입선택</option>
                                    </select>
                                </div>
                                <div class="input title-type">
                                    <span>인쇄지연 값</span>
                                    <input type="text"  id="setindelay" name="setindelay"  placeholder="입력해주세요." onclick="setkeyboardInput(this);">
                                </div>
                                <div class="inputBtn">
                                    <a href="javascript:setmarkingprtdelay();">인쇄지연설정</a>
                                </div>
                            </div>
                            <div class="setting__body" id="print">
                                <div class="input">
                                    <select name="selprint" id="selprint" class="reqdata" onchange="selectPrint();">
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
                    <div class="col tabBox">
                        <div class="setting__head" id="tab">
                            <a href="javascript:settab('label')" class="label">
                                <span>마킹기</span>
                            </a>
                            <a href="javascript:settab('print')" class="print active">
                                <span>인쇄 설정</span>
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
                                    <span>인쇄지연 값</span>
                                    <input type="text"  id="setindelay" name="setindelay"  placeholder="입력해주세요." onclick="setkeyboardInput(this);">
                                </div>
                                <div class="inputBtn">
                                    <a href="javascript:setmarkingprtdelay();">인쇄지연설정</a>
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
