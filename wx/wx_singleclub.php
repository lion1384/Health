<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "A4ds5854Hrt3gjUdss24Ks");
$wechatObj = new wechatCallbackapiTest();

/* mail('chaochen83@163.com', 'wechat', 'test'); */


//$wechatObj->valid();
//$wechatObj->responseAction();
$massage=$wechatObj->getMsg();
if ($massage['keyword']=='1')
{
        $wechatObj->responseMsg($massage['OpenID'],'1 is ok');
}else{
        $mongo = new MongoClient();
        $q=$massage['keyword'];
        $respond = $mongo->dsjlb->messages->find( array("Time" => new MongoRegex("/^$q/")));
        $msg_arr = iterator_to_array($respond);
	$respond = $mongo->dsjlb->users->find( array("CreatedTime" => new MongoRegex("/^$q/")));
        $usr_arr = iterator_to_array($respond);
        $wechatObj->responseMsg($massage['OpenID'],"Msg:".count($msg_arr)."\nUsr:".count($usr_arr));
}

        
class wechatCallbackapiTest
{
        var $ID;
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
/*
        	exit;*/
        }
    }

    public function responseMsg($openID,$contentStr)
    {

		//get post data, May be due to the different environments
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";             
                $msgType = "text";
                //$contentStr = "Welcome to Single club!";
                $resultStr = sprintf($textTpl, $openID, $this->ID, $time, $msgType, $contentStr);
                echo $resultStr;
    }
        public function getMsg()

        {
                if(!$this->checkSignature())exit;
                
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

		if (!empty($postStr)){
                
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $data['OpenID'] = $postObj->FromUserName;
                $this->ID = $postObj->ToUserName;
                $data['keyword'] = trim($postObj->Content);
                
                return $data;
                }
        }
        
    public function responseAction()
    {
		if(!$this->checkSignature())exit;

		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

		if (!empty($postStr)){
                
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);

/* mail('chaochen83@163.com', 'wechathttp://www.itouyan.net/wx/wx_lee.php', 'MsgType:'.$postObj->MsgType.'  Event:'.$postObj->Event.' EventKey:'.$postObj->EventKey); */

                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";   
							
				if($postObj->MsgType == 'event' and $postObj->Event == 'CLICK' and $postObj->EventKey == 'V1001_GY')			
                {
              		$msgType = "text";
                	$contentStr = "欢迎来到单身俱乐部！";
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	echo $resultStr;
                }							
							          
				if(!empty( $keyword ))
                {
              		$msgType = "text";
                	$contentStr = "Welcome to Lee's world!".$toUsername;
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }

        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        $signature = $_REQUEST["signature"];
        $timestamp = $_REQUEST["timestamp"];
        $nonce = $_REQUEST["nonce"];	
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>