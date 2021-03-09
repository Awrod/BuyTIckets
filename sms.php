<?php
header("Content-Type:text/html;charset=utf-8");
session_start();
//生成验证码
$mobile = $_POST['moblie'];
$code = rand ( 1000, 9999 );
//发送短信
$sms = new Sms();
//保存手机号、验证码
$_SESSION['code_re']=$code;
$_SESSION['moblie_re']=$mobile;
//测试模式
$status = $sms->send_verify($mobile, $code);
if (!$status) {
    echo $code;
}
class Sms {
// 保存错误信息
    public $error;
// Access Key ID
    private $accessKeyId = '';
// Access Access Key Secret\
    private $accessKeySecret = '';
// 签名
    private $signName = '';
// 模版ID
    private $templateCode = '';

    public function __construct($cofig = array()) {

        $cofig = array (

            'accessKeyId' => 'exmwI1PlVLbmpdOA',

            'accessKeySecret' => 'DUqMlzzIn8BWvSJLVYOFP0ik6WfDAK',

            'signName' => 'ABC商城',

            'templateCode' => 'SMS_202806638'

        );

// 配置参数

        $this->accessKeyId = $cofig ['accessKeyId'];

        $this->accessKeySecret = $cofig ['accessKeySecret'];

        $this->signName = $cofig ['signName'];

        $this->templateCode = $cofig ['templateCode'];

    }

    private function Encode($string) {

        $string = urlencode ( $string );

        $string = preg_replace ( '/\+/', '%20', $string );

        $string = preg_replace ( '/\*/', '%2A', $string );

        $string = preg_replace ( '/%7E/', '~', $string );

        return $string;

    }
//签名
    private function cpSignature($parameters, $accessKeySecret) {

        ksort ( $parameters );

        $canonicalizedQueryString = '';

        foreach ( $parameters as $key => $value ) {

            $canonicalizedQueryString .= '&' . $this->Encode ( $key ) . '=' . $this->Encode ( $value );

        }

        $stringToSign = 'GET&%2F&' . $this->Encode ( substr ( $canonicalizedQueryString, 1 ) );

        $signature = base64_encode ( hash_hmac ( 'sha1', $stringToSign, $accessKeySecret . '&', true ) );

        return $signature;

    }
    public function send_verify($mobile, $verify_code) {

        $params = array (

            'SignName' => $this->signName,

            'Format' => 'JSON',

            'Version' => '2017-05-25',

            'AccessKeyId' => $this->accessKeyId,

            'SignatureVersion' => '1.0',

            'SignatureMethod' => 'HMAC-SHA1',

            'SignatureNonce' => uniqid (),

            'Timestamp' => gmdate("Y-m-d\TH:i:s\Z"),

            'Action' => 'SendSms',

            'TemplateCode' => $this->templateCode,

            'PhoneNumbers' => $mobile,
            'TemplateParam' => (json_encode(array(
                "code"=>$verify_code,
                "product"=>"dsd"
            ), JSON_UNESCAPED_UNICODE))
        );
        $params ['Signature'] = $this->cpSignature ( $params, $this->accessKeySecret );
        $url = 'http://dysmsapi.aliyuncs.com/?' . http_build_query ( $params );
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_TIMEOUT, 10 );
        $result = curl_exec ( $ch );
        curl_close ( $ch );
        $result = json_decode ( $result, true );
        if (isset ( $result ['Code'] )) {
            $this->error = $this->getErrorMessage ( $result ['Code'] );
            return false;
        }
        return true;

    }
    public function getErrorMessage($status) {
        $message = array (

            'InvalidDayuStatus.Malformed' => '账户短信开通状态不正确',

            'InvalidSignName.Malformed' => '短信签名不正确或签名状态不正确',

            'InvalidTemplateCode.MalFormed' => '短信模板Code不正确或者模板状态不正确',

            'InvalidRecNum.Malformed' => '目标手机号不正确，单次发送数量不能超过100',

            'InvalidParamString.MalFormed' => '短信模板中变量不是json格式',

            'InvalidParamStringTemplate.Malformed' => '短信模板中变量与模板内容不匹配',

            'InvalidSendSms' => '触发业务流控',

            'InvalidDayu.Malformed' => '变量不能是url，可以将变量固化在模板中'

        );

        if (isset ( $message [$status] )) {

            return $message [$status];

        }

        return $status;

    }
}
