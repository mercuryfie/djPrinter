<?php
	include_once $root."/_define.php";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>DJMEDI 마킹프린터</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;400;600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo $root?>/assets/plugins/slick/slick.css"/>
    <link rel="stylesheet" href="<?php echo $root?>/assets/plugins/jquery-ui-1.12.1/jquery-ui.css"/>
    <link rel="stylesheet" href="<?php echo $root?>/assets/css/main.css"/>
    <link rel="stylesheet" href="<?php echo $root?>/assets/css/keyboard.css"/>
    <script src="<?php echo $root?>/assets/plugins/jquery/jquery.js"></script>
    <script src="<?php echo $root?>/assets/plugins/jquery-ui-1.12.1/jquery-ui.js"></script>
 	<script src="<?php echo $root?>/assets/plugins/jquery/jquery.cookie.js"></script>
	<script src="<?php echo $root?>/assets/plugins/slick/slick.js"></script>
    <script src="<?php echo $root?>/assets/js/ui.js"></script>
    <script src="<?php echo $root?>/assets/js/djmedi.js?v=<?=$YmdHis?>"></script>
    <script src="<?php echo $root?>/assets/js/keyboard.js"></script>
  </head>
<style>
	#logo{width:200px;}
	#logo img{height:50px;}
	.logout{margin-left:20px;cursor:pointer;}
	#stattxt{float:right;font-size:20px;font-weight:bold;color:blue;}
	#stattxt.red{color:red;}
	.wrap {width: 95%;}
	.work__tit{display:block;}
	.work__tit .manual{float:right;padding:2px 10px;border-radius:5px;background:#0E7A9E;color:#fff;font-size:17px;}
	#uploaddiv{display:none;}
</style>
<script>
	function barcode(){
		var code=$("#barcode").val();
		var chkcode=code.substring(0,3);
		switch(chkcode){
			case "MEM":
				$("input[name=nopasschk]").val(0);
				$("input[name=stLoginId]").val(code);
				getlogin();
				break;
			case "ODD":
				var stattxt=$("#stattxt").hasClass("detail");
				if(stattxt==true){
					list();
					//callapi("완료업데이트 api")
					//완료 업ㄷ이트 호출 후 list(); 호출필요
				}else{
					var stattxt2=$("#stattxt").hasClass("manual");
					if(stattxt==true){
						manual();
					}else{
						detail(code);
					}
				}
				break;
		}
		$("#barcode").val("").focus();
	}

	function stattxt(txt, hold){
		$("#stattxt").text(txt);
		if(hold==0 || hold==1){
			$("#stattxt").addClass("red").removeClass("manual");
			if(hold==0){
				setTimeout("$('#stattxt').text('')",1000);
			}
		}else{
			$("#stattxt").addClass("manual").removeClass("red");
		}
	}
</script>
  <body>
	<input type="hidden" name="cfcode" value="<?=$ck_cfcode?>" class="reqdata">
	<input type="hidden" name="ck_language" value="<?=$ck_language?>" class="reqdata">
	<input type="hidden" name="ck_ip" value="<?=$ck_ip?>" class="reqdata">
	<input type="hidden" name="odCode" value="" class="reqdata">
	<input type="hidden" name="mrCode" value="" class="reqdata">
	<input type="hidden" name="page" value="1" class="reqdata">
	<input type="hidden" id="eng_text" readonly>
	<textarea id="urldata" cols="100" rows="100" style="display:none;"><?=json_encode($NetURL)?></textarea>
    <div class="wrapper">
	<header class="header">
	   <div class="wrap">
		  <div class="header__logo">
			 <h1>
				<a href="javascript:main()" id="logo"></a>
			 </h1>
			 <div class="barcode">
				<input placeholder="BAR CODE SCAN" id="barcode" onchange="barcode()" class="" />
			 </div>
		  </div>
		  <div class="header__etc">
			 <div class="userInfo">
			 <?php if($_COOKIE["ck_stStaffid"]){?>
				<span><?=$_COOKIE["ck_stName"]?></span>님 안녕하세요.
				<span class="logout" onclick="removeSession('')">로그아웃</span>
			 <?php }else{?>
				<a href="javascript:main();" class="form__btn">로그인</a>
			 <?php }?>
			 </div>
			 <div class="links">
				<a href="" class="active">ETHERNET</a>
				<a href="javascript:setting('print')" class="active">PRINT</a>
			 </div>
		  </div>
	   </div>
	</header>