<?php
	$setting=fopen("setting.json","w");
	fwrite($setting, $_POST["data"]);
	fclose($setting);
	//$txt=file_get_contents($_SERVER['DOCUMENT_ROOT']."/markingprt/setting.json");
	$json=array("resultCode"=>"200","resulrMessege"=>"OK");
	$json["_POST"]=$_POST;
	echo json_encode($json);
?>