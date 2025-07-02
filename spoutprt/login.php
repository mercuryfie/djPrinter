<?php
	$root="../spoutprt";
?>
<div class="login">
	<div class="wrap">
		<div class="login__form">
			<form action="">
				<div class="login__head">사이트 이용정보</div>
				<div class="login__body">
					<div class="form__row">
						<div class="input">
							<input type="hidden" name="nopasschk" class="reqdata" value="1">
							<input type="text" placeholder="회원카드를 스캔해 주세요" name="stLoginId" class="reqdata" value=""  onclick="setkeyboardInput(this);" >
						</div>
						<div class="input">
							<input type="password" placeholder="비밀번호" name="stPasswd" class="reqdata" value=""  onclick="setkeyboardInput(this);">
						</div>
					</div>
					<div class="alert">
						아이디 또는 비밀번호가 잘못 입력 되었습니다.<br/>
						<span>아이디</span>와 <span>비밀번호</span>를 정확히 입력해주세요.
					</div>
				</div>
				<div class="login__foot">
					<a href="javascript:getlogin()" class="form__btn">로그인</a>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	function focusbarcode(){
		$("#barcode").focus();
	}
</script>