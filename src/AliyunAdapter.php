<?php

declare(strict_types=1);
/**
 * this file Author is Death-Satan.
 * Sms Aliyun Library
 * @homepage https://github.com/Death-Satan
 * @link https://github.com/Death-Satan/sms-sdk
 */
namespace DeathSatan\SmsAliyunSdk;

use AlibabaCloud\SDK\Dysmsapi\V20170525\Dysmsapi;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\SendSmsResponse;
use Closure;
use Darabonba\OpenApi\Models\Config;
use DeathSatan\SmsAliyunSdk\Params\Send\BatchSend;
use DeathSatan\SmsSdk\Contracts\Server\Params;
use DeathSatan\SmsSdk\Contracts\Server\Response;
use DeathSatan\SmsSdk\Contracts\Sms\Query;
use DeathSatan\SmsSdk\Contracts\Sms\Send;
use DeathSatan\SmsSdk\Contracts\Sms\Sign;
use DeathSatan\SmsSdk\Contracts\Sms\Template;
use DeathSatan\SmsSdk\Exceptions\SmsException;
use Exception;

class AliyunAdapter extends \DeathSatan\SmsSdk\SmsAdapter implements Send, Query, Sign, Template
{
    /**
     * {@inheritDoc}
     * @throws SmsException
     */
    public function smsSend(Params $params): Response
    {
        $this->if_throws_params(
            $params instanceof \DeathSatan\SmsAliyunSdk\Params\Send\Send,
            Send::class
        );

        return $this->capture(function () use ($params) {
            $client = $this->clinet();
            $response = $client->sendSms($params->smsRequest());
            return $this->parseResponse($response);
        });
    }

    /**
     * {@inheritDoc}
     */
    public function smsBatchSend(Params $params): Response
    {
        $this->if_throws_params($params instanceof BatchSend, BatchSend::class);

        $this->capture(function () use ($params) {
            $client = $this->clinet();
            $response = $client->sendBatchSms($params->smsBatchRequest());
        });
    }

    public function queryStatistics(Params $params): Response
    {
        // TODO: Implement queryStatistics() method.
    }

    public function queryDetail(Params $params): Response
    {
        // TODO: Implement queryDetail() method.
    }

    public function signAdd(Params $params): Response
    {
        // TODO: Implement signAdd() method.
    }

    public function signDel(Params $params): Response
    {
        // TODO: Implement signDel() method.
    }

    public function signModify(Params $params): Response
    {
        // TODO: Implement signModify() method.
    }

    public function signLst(Params $params): Response
    {
        // TODO: Implement signLst() method.
    }

    public function signStatus(Params $params): Response
    {
        // TODO: Implement signStatus() method.
    }

    public function templateAdd(Params $params): Response
    {
        // TODO: Implement templateAdd() method.
    }

    public function templateDel(Params $params): Response
    {
        // TODO: Implement templateDel() method.
    }

    public function templateModify(Params $params): Response
    {
        // TODO: Implement templateModify() method.
    }

    public function templateLst(Params $params): Response
    {
        // TODO: Implement templateLst() method.
    }

    protected function initialize(): void
    {
        if (empty($this->config['accessKeyId'])
            || empty($this->config['accessKeySecret'])
            || empty($this->config['endpoint'])
        ) {
            throw new SmsException('配置项错误');
        }
    }

    protected function clinet()
    {
        $config = new Config([
            'accessKeyId' => $this->config['accessKeyId'],
            'accessKeySecret' => $this->config['accessKeySecret'],
        ]);
        $config->endpoint = $this->config['endpoint'];
        return new Dysmsapi($config);
    }

    protected function parseResponse($response): Response
    {
        if ($response instanceof SendSmsResponse) {
            return new \DeathSatan\SmsAliyunSdk\Response(
                (int) $response->statusCode,
                (bool) $response->statusCode,
                $response->body->toMap(),
                $response->headers
            );
        }

        throw new SmsException('Error NotFound Response Type');
    }

    protected function if_throws_params(bool $condition, $params)
    {
        if (! $condition) {
            throw new SmsException('The required parameters are is:' . $params);
        }
    }

    /**
     * @throws SmsException
     */
    protected function capture(Closure $callable)
    {
        try {
            $callable = Closure::bind($callable, $this);
            return $callable();
        } catch (Exception $e) {
            throw new SmsException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }
}
