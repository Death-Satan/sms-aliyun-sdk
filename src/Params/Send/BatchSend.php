<?php

declare(strict_types=1);
/**
 * this file Author is Death-Satan.
 * Sms Aliyun Library
 * @homepage https://github.com/Death-Satan
 * @link https://github.com/Death-Satan/sms-sdk
 */
namespace DeathSatan\SmsAliyunSdk\Params\Send;

use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\SendBatchSmsRequest;

/**
 * @description 批量发送短信参数
 */
class BatchSend implements \DeathSatan\SmsSdk\Contracts\Server\Params
{
    protected array $params = [];

    public function __construct(
        array $PhoneNumbers,
        array $signNames,
        array $templateCodes,
        array $templateParams,
        array $extras = []
    ) {
        $this->params = [
            'PhoneNumberJson' => $this->toJson($PhoneNumbers),
            'SignNameJson' => $this->toJson($signNames),
            'TemplateCode' => $this->toJson($templateCodes),
            'TemplateParamJson' => $this->toJson($templateParams),
        ];
        $this->params = array_merge($this->params, $extras);
    }

    public function params(): array
    {
        return $this->params;
    }

    public function smsBatchRequest(): SendBatchSmsRequest
    {
        return new SendBatchSmsRequest(
            $this->params()
        );
    }

    protected function toJson(array $data): string
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}
