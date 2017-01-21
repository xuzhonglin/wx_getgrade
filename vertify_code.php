<?php

session_start();
$cookie_jar=tempnam("temp","webbeast");
setcookie('cookie_jar',$cookie_jar);
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,"http://211.86.224.21/CheckCode.aspx");
curl_setopt($ch,CURLOPT_COOKIEJAR,$cookie_jar);
curl_setopt($ch,CURLOPT_COOKIEFILE,$cookie_jar);
curl_setopt($ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,false);
if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'msie')===false)
{
    header("content-type:image/jpg");
}
curl_exec($ch);
curl_close($ch);

?>