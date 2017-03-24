<?php

define("TOKEN", "ahpuccit");

$wechatObj = new wechatCallbackapiTest();
if (!isset($_GET['echostr'])) {
    $wechatObj->responseMsg();
    }else{
        $wechatObj->valid();
        }

class wechatCallbackapiTest{
    public function valid(){
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            exit;
            }
        }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if($tmpStr == $signature){
            return true;
        }else{
            return false;
        }
    }

    public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);

            //用户发送的消息类型判断
            switch ($RX_TYPE)
            {
                case "text":
                    $result = $this->receiveText($postObj);
                    break;
                case "image":
                    $result = $this->receiveImage($postObj);
                    break;
                case "voice":
                    $result = $this->receiveVoice($postObj);
                    break;
                case "video":
                    $result = $this->receiveVideo($postObj);
                    break;
                default:
                    $result = "unknow msg type: ".$RX_TYPE;
                    break;
            }
            echo $result;
        }else {
            echo "";
            exit;
        }
    }
    
    private function receiveText($object)
    {
        $openid=$object->FromUserName;
        $keyword= $object->Content; 
        preg_match('/G@(.*?)@(.*?)-(.*?)-(.*?)#/',$keyword, $match); 
      $stu_num = $match[1];
      session_id("$stu_num");
      	session_start();
     
      //$_SESSION['islogin']="test";
	$islogin=$_SESSION['islogin'];
        while(1){
            if($islogin=="yes") {
               $stu_num = $match[1];
                $stu_xn=$match[2];
                $stu_xq=$match[3];
                $get_page=$match[4];
                $next_xn=$stu_xn+1;
                //$url = "APIURL";
                $curl=curl_init();
                curl_setopt($curl,CURLOPT_URL,$url);
                curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
                $str=curl_exec($curl);
                curl_close($curl);
                $patterns_1 = array();
                $patterns_1[0] = '/"/';
                $patterns_1[1] = '/,/';
                $patterns_1[2] = '/:/';
                $patterns_1[3] = '/ /';
                $str=preg_replace($patterns_1,'',$str);
                $pattern='/{id.*?stu_code(.*?)gradeyear.*?user_name(.*?)xkkh.*?kcmc(.*?)csfs.*?xf(.*?)jd(.*?)cj(.*?)pscj.*?000Z}/';
                preg_match_all($pattern, $str, $matches,PREG_PATTERN_ORDER);
                $data_page=floor((sizeof($matches[1])/5))+1;
                $content = array();
                if($get_page<=$data_page&&$get_page>0){ 
                    $data_limit=sizeof($matches[1]);
                    $page_limit=Min($get_page*5,$data_limit);
                    $content[] = array("Title"=>"📝亲，你查询的学号为 ".$stu_num." 在".$stu_xn."-".$next_xn."学年第".$stu_xq."学期成绩如下所示：", 
                                        "Description"=>"【格式】：G@学号@学年-学期-页码#\n【注意】：页码起始值为1\n【页码】：这是第".$get_page."页/共".$data_page."页", 
                                        "PicUrl"=>"", 
                                        "Url" =>"http://wx.ahpuccit.cn/jw");
                    for($i=($get_page-1)*5;$i<$page_limit;$i++){
                        $xh=$matches[1][$i];
                        $xm=$matches[2][$i];
                        $kc=$matches[3][$i];
                        $xf=$matches[4][$i];
                        $jd=$matches[5][$i];
                        $cj=$matches[6][$i];
                      $content[] = array("Title"=>"课程：".$kc."\n成绩：".$cj."      学分：".$xf."      绩点：".$jd,  
                                            "Description"=>"", 
                                            "PicUrl"=>"", 
                                            "Url" =>"");
                        }
                    $content[] = array("Title"=>"👉请发送指令获取下一页\n【格式】：G@学号@学年-学期-页码#\n【注意】：页码起始值为1",  
                                       "Description"=>"", 
                                        "PicUrl"=>"", 
                                        "Url" =>"");
                    }elseif($get_page>$data_page){
                        $content[] = array("Title"=>"⚠亲，没有下一页了！请检查页码是否正确，再重新输入指令！",  
                                       "Description"=>"【格式】：G@学号@学年-学期-页码#\n【注意】：页码起始值为1\n【页码】：共".$data_page."页", 
                                        "PicUrl"=>"", 
                                        "Url" =>"");
                 
                    }elseif($get_page<=0){
                        $content[] = array("Title"=>"⚠亲，你输入的页码有误！请检查页码是否正确，再重新输入指令！",  
                                       "Description"=>"【格式】：G@学号@学年-学期-页码#\n【注意】：页码起始值为1\n【页码】：共".$data_page."页", 
                                        "PicUrl"=>"", 
                                        "Url" =>"");
                    }
                    $result = $this->transmitNews($object, $content);
                    return $result;
            }else{
              $content = array();
        	$content[] = array("Title"=>"⚠亲，你还没有登录用户！请先登录！",  
                            "Description"=>"👉亲，点击此处完成登录", 
                            "PicUrl"=>"", 
                            "Url" =>"http://wx.ahpuccit.cn/api/getgrade/login.php");
              $result = $this->transmitNews($object, $content);
              return $result;
            }
      }
    }
  
     private function Min($num_1, $num_2){
        $num=0;
        $num=$num_1;
        if($num>=$num_2)
            $num=$num_2;
        else
            $num=$num_1;
        return $num;
    }

    /*
     * 回复文本消息
     */
    private function transmitText($object, $content)
    {
        $textTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[text]]></MsgType>
        <Content><![CDATA[%s]]></Content>
        </xml>";
        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }
    
    /*
     * 回复图文消息
     */
    private function transmitNews($object, $arr_item)
    {
        if(!is_array($arr_item))
            return;

        $itemTpl = "    <item>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
        </item>";
        $item_str = "";
        foreach ($arr_item as $item)
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);

        $newsTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[news]]></MsgType>
        <Content><![CDATA[]]></Content>
        <ArticleCount>%s</ArticleCount>
        <Articles>
        $item_str</Articles>
        </xml>";

        $result = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($arr_item));
        return $result;
    }
}
?>
