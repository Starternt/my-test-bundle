<?php

declare(strict_types=1);

namespace Starternh\MyTestBundle\Resources\Response;

abstract class AbstractResponse
{
    protected int $statusCode = 0;

    protected bool $success = false;

    protected ?string $originalResponseBody = null;

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function setSuccess(bool $success): self
    {
        $this->success = $success;

        return $this;
    }

    public function getOriginalResponseBody(): ?string
    {
        return $this->originalResponseBody;
    }

    public function setOriginalResponseBody(?string $originalResponseBody): self
    {
        $this->originalResponseBody = $originalResponseBody;

        return $this;
    }
}
