<?php 

$jwid=$_POST['jwid'];
$jwpw=$_POST['jwpw'];
$jwsc=$_POST['jwsc'];

$login=getLogin($jwid,$jwpw,$jwsc);

if ($login=="yes") {
  	session_start();
      	session_id("$jwid");
	$_SESSION['islogin']="yes";
  	echo "<script>alert(' 绑定成功 ');location.href='close.php';</script>";
    }else{
        session_start();
        $_SESSION['error']="errorLogin";
        echo "<script>alert(' 绑定失败 ');location.href='login.php';</script>";
    }

function getLogin($jwid,$jwpw,$jwsc){
  
    define('INDEX_URL', 'http://211.86.224.21/');
    if(empty($_COOKIE['cookie_jar'])) exit();
    $cookie_jar=$_COOKIE['cookie_jar'];
    $view1 = "dDwyODE2NTM0OTg7Oz5WGcjiIRQTDwm7xHkK8Vk93U/eBA==";
    $post = "__VIEWSTATE={$view1}&txtUserName={$jwid}&TextBox2={$jwpw}&txtSecretCode={$jwsc}&RadioButtonList1=%D1%A7%C9%FA&Button1=&lbLanguage=&hidPdrs=&hidsc=";
    
    $ch=curl_init();
    curl_setopt($ch,CURLOPT_URL,INDEX_URL);
    curl_setopt($ch,CURLOPT_POST,1);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$post);
    curl_setopt($ch,CURLOPT_COOKIEJAR,$cookie_jar);
    curl_setopt($ch,CURLOPT_COOKIEFILE,$cookie_jar);
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    $result=curl_exec($ch);
    curl_close($ch);
    if(preg_match("/xs_main/",$result)){
        return "yes";
    }else{
        return "no";
    }
}

?>