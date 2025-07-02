///jquery cookie set
function setCookie(cname, cvalue) 
{
	var ck_ip=$("input[name=ck_ip]").val();
	var nowdate = new Date();//1시간 
	nowdate.setTime(nowdate.getTime() + 24 * 60 * 60  * 1000);
	//Cookies.set(cname, cvalue, { expires: nowdate, path: '/',  secure: false });
	//Cookies.set(cname, cvalue, { expires: 365, path: '/', domain: "127.0.0.1", secure: false });
	Cookies.set(cname, cvalue, { expires: 365, path: '/', secure: false });
} 

///jquery cookie get
function getCookie(cname) 
{
	if(Cookies.get(cname)==undefined){
		var ckname ="";
	}else{
		var ckname =Cookies.get(cname);
	}
	return ckname;
}
///juqery cookie delete
function deleteAllCookies()
{
	var cookies = Cookies.get();
	//console.log(cookies);
	for(var cookie in cookies) 
	{
		var ckpop=cookie.substring(0,6);
		if(cookie == "mck_language" || cookie == "mck_languageName" || ckpop=="mck_pop" || cookie=="mck_saveid"){}
		else
		{
			deleteCookie(cookie);
		}
	}
}
function deleteCookie(name)
{
	setCookie(name,null,-1);
	Cookies.remove(name);
	location.reload();
	//setCookie(name,null,-1); //$.removeCookie(cookie);
}

//빈값체크
function isEmpty(value)
{
	if( value == "" || value == null || typeof value == undefined || ( value != null && typeof value == "object" && !Object.keys(value).length ) )
	{
		return true;
	}
	else
	{
		return false;
	}
}

///자릿수
function pad(n, width)
{
	n = n + '';
	return n.length >= width ? n : new Array(width - n.length + 1).join('0') + n;
}

function getdata(){
	var str="";
	$(".reqdata").each(function(){
		var tit=$(this).attr("name");
		str+="&"+tit+"="+$(this).val();
	});
	return str;
}

function postdata(){
	var str={};
	$(".reqdata").each(function(){
		var tit=$(this).attr("name");
		str[tit]=$(this).val();
	});
	return str;
}

//------------------------------------------------------------------------------------
// session : 일단은 이렇게 작업하되 나중에 도메인이 달라지거나 했을 경우에는 session 관련 작업을 다시 해야함..
//------------------------------------------------------------------------------------
function setSession(obj)
{
	var url="/spoutprt/session.php";
		url+="?seq="+obj["seq"];
		url+="&stName="+encodeURI(obj["stName"]);
		url+="&stUserid="+obj["stUserid"];
		url+="&stStaffid="+obj["stStaffid"];
		url+="&stAuth="+obj["stAuth"];
		url+="&stDepart="+encodeURI(obj["stDepart"]);
		url+="&stLogin="+encodeURI(obj["stLogin"]);
		url+="&url="+encodeURI(obj["locationURL"]);
		url+="&stAuthKey="+encodeURI(obj["stAuthKey"]);

	$.ajax({
		type : "GET", //method
		url : url,
		data : [],
		success : function (result) {
			console.log("result = "+result+", getCookie ck_stUserid : "+getCookie("ck_stUserid")+", depart = "+obj["stDepart"]);
			window.location.href=result;
		},
		error:function(request,status,error){
			console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
	});
}
function removeSession(url)
{
	var url="/spoutprt/session.php";
		url+="?type=logout&url="+url;
	$.ajax({
		type : "GET", //method
		url : url,
		data : [],
		success : function (result) {
			//--------------------------------------------
			//쿠키삭제 
			//--------------------------------------------
			deleteAllCookies();
			//--------------------------------------------
			window.location.href=result;
		},
		error:function(request,status,error){
			console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
	});
}
function getUrlData(name)
{
	var ugly = document.getElementById('urldata').value;
	var txtdt = JSON.parse(ugly);
	console.log(txtdt);
	return txtdt[name];
}
//------------------------------------------------------------------------------------
// api 호출
//------------------------------------------------------------------------------------
function callapi(type,group,data)
{
	var url=getUrlData("API")+group+"/";
	//var url="https://api.djmedi.net/"+group+"/";
	//var url="https://api.djmedi.net/"+group+"/";
	var timestamp = new Date().getTime();
	//var ck_cfcode=getCookie("ck_cfcode");
	var ck_cfcode=$("input[name=cfcode]").val();//"hs";
	//if(isEmpty(language)){language="kor";}
	var language="kor";

	switch(type)
	{
	case "GET": case "DELETE":
		url+="?v="+timestamp+"&language="+language+"&"+data+"&ckCfcode="+ck_cfcode;
		data="";
		break;
	case "POST":
		data["language"]=language;
		data["ckCfcode"]=ck_cfcode;
		console.log(data);
		data=JSON.stringify(data);
		break;
	}

	console.log("callapi url = " + url);
	console.log(data);

	$.ajax({
		type : type, //method
		url : url,
		data : data,
		//headers : {"ck_authkey" : key, "ck_meLoginid" : id },
		success : function (result) {
			makepage(result);
		},
		error:function(request,status,error){
			console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
   });
	 return;
}

	function setStaffLogin(obj)
	{
		if(obj["resultMessage"] == 'OK')
		{
			if(obj["stUse"] == 'Y')
			{
				if(obj["stDepart"])
				{
					var d = new Date();
					var stLogin = pad((d.getMonth() + 1), 2)+"-"+pad(d.getDate(),2)+" / "+d.getHours()+":"+d.getMinutes();

					//쿠키저장
					setCookie('ck_staffseq', obj["seq"], 365);
					setCookie('ck_stUserid', obj["stUserid"], 365);
					setCookie('ck_stStaffid', obj["stStaffid"], 365);
					setCookie('ck_stName', obj["stName"], 365);
					setCookie('ck_stDepart', obj["stDepart"], 365);
					setCookie('ck_stAuth', obj["stAuth"], 365);
					setCookie('ck_stLogin', stLogin, 365);
					setCookie('ck_authkey', obj["stAuthKey"], 365);
					if($("#agree_autologin").prop("checked")==true)//아이디 저장이 클릭되어 있다면
					{
						setCookie("ck_saveid", obj["stUserid"], 365);
					}
					else
					{
						setCookie("ck_saveid", "", 365);
					}

					//세션 			
					setSession(obj);

				}
				else
				{
					layersign('danger',getTxtData("ACCESSERR"), getTxtData("CHECKDATA"),'top');//'접속오류',' 올바른 정보를 입력하세요.'
				}
			}
			else if(obj["stUse"]=='A')
			{
				layersign('warning',getTxtData("CONFIRMWAIT"), getTxtData("EMAILOKLOGIN"),'top');//인증대기, 이메일 인증 후 로그인 가능합니다.
			}
			else
			{
				layersign('danger',getTxtData("INFONO"), getTxtData("CHECKDATA"),'top');//정보없음, 올바른 정보를 입력하세요
			}
		}
	}

//------------------------------------------------------------------------------------
// 리스트형 페이징
//------------------------------------------------------------------------------------
function getpage(pgid, tpage, page, block, psize)
{
	block=parseInt(block);
	psize=parseInt(psize);

	var prev=next=0;
	var inloop = (parseInt((page - 1) / block) * block) + 1;
	//console.log(" getpage   pgid : " + pgid +", tpage = "+tpage+", page = "+page+", block = "+block+", psize = "+psize+", inloop = "+inloop );
	prev = inloop - 1;
	next = inloop + block;
	var txt="";
	var link = "";

	if(prev<1)
	{
		link = "";
		prev = 1;
	}
	else
	{
		link = "gopage("+prev+")";
	}

	txt+="<a href='javascript:"+link+";' class='btn prev'>이전</a>";

	if(tpage == 0)//데이터가 없을 경우
	{
	}
	else
	{
		for (var i=inloop;i < inloop + block;i++)
		{
			if (i <= tpage){
				link = "gopage("+i+")";
				if(i==page){var cls="active";link="";}else{var cls="";}
				txt+="<a href='javascript:"+link+";' class='number no"+i+" "+cls+"'>"+i+"</a></li>";
			}
		}
	}

	if(next>tpage)
	{
		link = "";
		next=tpage;
	}
	else
	{
		link = "gopage("+next+")";
	}
	txt+="<a href='javascript:"+link+";' class='btn next'>다음</a>";
//console.log(pgid+" : "+txt);
	$("#"+pgid).html(txt);

	return false;
}

function gopage(page){
	$("input[name=page]").val(page);
	$("#pagediv a").removeClass("active");
	$("#pagediv a.no"+page).addClass("active");
	list();
}