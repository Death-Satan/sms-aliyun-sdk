<?php

declare(strict_types=1);
/**
 * this file Author is Death-Satan.
 * Sms Aliyun Library
 * @homepage https://github.com/Death-Satan
 * @link https://github.com/Death-Satan/sms-sdk
 */
namespace DeathSatan\SmsAliyunSdk\Params\Send;

use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\SendSmsRequest;
use DeathSatan\SmsSdk\Contracts\Server\Params;

/**
 * @description 发送短信的参数类
 */
class Send implements Params
{
    protected array $params = [];

    /**
     * @param string $PhoneNumbers 接收短信的手机号码
     * @param string $signName 短信签名名称
     * @param string $templateCode 短信模板CODE
     * @param array $templateParam 短信模板变量对应的实际值
     * @param array $extras 其他额外字段
     */
    public function __construct(string $PhoneNumbers, string $signName, string $templateCode, array $templateParam, array $extras = [])
    {
        $templateParam = json_encode($templateParam, JSON_UNESCAPED_UNICODE);
        $this->params = array_merge(
            compact('PhoneNumbers', 'signName', 'templateCode', 'templateParam'),
            $extras
        );
    }

    public function params(): array
    {
        return $this->params;
    }

    public function smsRequest(): SendSmsRequest
    {
        return new SendSmsRequest($this->params());
    }
}
