<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Weixin extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
	}

	public function index()
	{
		$this->valid();
		$this->responseMsg();
	}

	public function valid()
    {
        $echoStr = $this->input->get("echostr");//$_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	//exit;
        }
    }

    public function responseMsg()
    {
        //get post data, May be due to the different environments
        //$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $postStr = file_get_contents('php://input');
        //$apiurl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".APPID."&redirect_uri=https://svrx.herokuapp.com/index.php/weixin/oauth2&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
        //$contentStr = "<a href=\"".$apiurl."\">测试</a>";
      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";             
				if(!empty( $keyword ))
                {
              		$msgType = "text";
                	$data['users']=$this->user_model->get_users($keyword);
                	if(!empty($data['users']))
                	   $contentStr = $data['users']['url']."\n".$data['users']['username']."\n".$data['users']['password']."\n";
                	else
                	   $contentStr = $keyword;
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
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $this->input->get("signature");//$_GET["signature"];
        $timestamp = $this->input->get("timestamp");//$_GET["timestamp"];
        $nonce = $this->input->get("nonce");//$_GET["nonce"];

		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
    
 	public function oauth2()
	{
		if (isset($_GET['code'])){
		    echo $_GET['code'];
		}else{
		    echo "NO CODE";
		}
	}
}
