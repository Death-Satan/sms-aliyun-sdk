<?php

declare(strict_types=1);
/**
 * this file Author is Death-Satan.
 * Sms Aliyun Library
 * @homepage https://github.com/Death-Satan
 * @link https://github.com/Death-Satan/sms-sdk
 */
namespace DeathSatan\SmsAliyunSdk;

class Response implements \DeathSatan\SmsSdk\Contracts\Server\Response
{
    protected ?int $code;

    protected bool $status;

    protected array $data = [];

    protected array $headers = [];

    public function __construct(
        int $code,
        bool $status,
        array $data,
        array $headers
    ) {
        $this->code = $code;
        $this->status = $status;
        $this->data = $data;
        $this->headers = $headers;
    }

    /**
     * {@inheritDoc}
     */
    public function code(): int
    {
        return $this->code;
    }

    /**
     * {@inheritDoc}
     */
    public function status(): bool
    {
        return $this->status;
    }

    /**
     * {@inheritDoc}
     */
    public function data(): array
    {
        return $this->data;
    }

    /**
     * {@inheritDoc}
     */
    public function headers(): array
    {
        return $this->headers;
    }
}
