<?php

if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == false) { 
      header("Location: error.php"); 
    }
?>
<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
<title>绑定成功</title>
<link rel="stylesheet" href="./css/weui.css">
<link rel="stylesheet" href="./css/example.css">
  	<script type="text/javascript">
		document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
			WeixinJSBridge.call('hideOptionMenu');
		});
	</script>
<style id="style-1-cropbar-clipper">
.en-markup-crop-options {
    top: 18px !important;
    left: 50% !important;
    margin-left: -100px !important;
    width: 200px !important;
    border: 2px rgba(255,255,255,.38) solid !important;
    border-radius: 4px !important;
}

.en-markup-crop-options div div:first-of-type {
    margin-left: 0px !important;
}
</style></head>
<body >
<div class="page msg">
                <div class="weui_msg">
                    <div class="weui_icon_area"><i class="weui_icon_success weui_icon_msg"></i></div>
                    <div class="weui_text_area">
                        <h2 class="weui_msg_title">绑定成功</h2>
                        <p class="weui_msg_desc">请点击确定关闭本页面，再次查询发送指令</p>
                    </div>
                    <div class="weui_opr_area">
                        <p class="weui_btn_area">
                            <a  class="weui_btn weui_btn_primary" onclick="WeixinJSBridge.call('closeWindow');">确定</a>
                        </p>
                    </div>
                </div>
            </div>    
</body></html>