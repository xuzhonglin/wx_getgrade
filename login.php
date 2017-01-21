<?php 

if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == false) { 
      header("Location: error.php"); 
    }

session_start();
$error=empty($_SESSION['error'])?"":$_SESSION['error'];
$message="";

if ($error==="errorLogin") {
  $message="对不起！登录失败!";
  $_SESSION['error']="";
}else if ($error==="errorNet") {
  $message="对不起！网络错误！";
  $_SESSION['error']="";
}

?>

<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
<title>成绩绑定</title>
<link rel="stylesheet" href="./css/weui.css">
<link rel="stylesheet" href="./css/example.css">
  	<script type="text/javascript">
		document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
			WeixinJSBridge.call('hideOptionMenu');
		});
	</script>
  <style type="text/css">
  .tip{
    color:#f00;
    display: block;
    text-align:center;
    font-size: 1rem;
  }
</style>
</head>
<body>
<div class="page cell">
            <div class="hd">
                <h1 class="page_title">成绩绑定</h1>
            </div>
  	<span class="tip"><?php echo $message; ?></span>
            <div class="bd">
                <div class="weui_cells_title">请认真填写教务账号信息</div>
                <div></div>
                <form action="getlogin.php" method="post" id="loginForm">
                <div class="weui_cells weui_cells_form">
                    <div class="weui_cell">
                        <div class="weui_cell_hd"><label class="weui_label">学号</label></div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" type="text" placeholder="请输入学号" name="jwid">
                        </div>
                    </div>
                    
                    <div class="weui_cell">
                        <div class="weui_cell_hd"><label class="weui_label">密码</label></div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" type="password" placeholder="请输入密码" name="jwpw">
                        </div>
                    </div>

                    <div class="weui_cell weui_vcode">
                        <div class="weui_cell_hd"><label class="weui_label">验证码</label></div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <input class="weui_input" type="text" placeholder="请输入验证码" name="jwsc">
                        </div>
                        <div class="weui_cell_ft weui_vimg_wrp">
                            <img class="code" src="vertify_code.php">
                        </div>
                    </div>
                </div>	    
	    <div class="weui_btn_area">
	    	<button class="weui_btn weui_btn_primary">  绑  定  </button>
	    </div>
    </form>
            </div>
        </div>
</body></html>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
    	$(".weui_btn_area button").on("click",function(){
    		i = 0;
	    	$("input").each(function(){
	    		if(!$(this).is(":hidden")&&$(this).val()==""){
	    			//$(this).focus();
	    			$(".tip").text("请将信息填写完整！").show().delay(2000).hide(0);
	    			i++;
	    			return false;
	    		}
	    	});
	    	if(i==0){
	    		console.log(1);
	    		$(".input").hide();
	    		$("button").hide();
	    		$(".tip").hide();
	    		$("#loginForm").submit();
	    	}else{
	    		return false;
	    	}
    	});
    	$(".code").on("click",function(){
    	$(".code").attr("src","vertify_code.php");
    	});
    });
    </script>