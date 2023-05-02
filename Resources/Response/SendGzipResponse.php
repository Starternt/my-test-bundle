<?php

declare(strict_types=1);

namespace Starternh\MyTestBundle\Resources\Response;

class SendGzipResponse extends AbstractResponse
{
    protected ?int $jobId = null;

    public function getJobId(): ?int
    {
        return $this->jobId;
    }

    public function setJobId(?int $jobId): self
    {
        $this->jobId = $jobId;

        return $this;
    }
}
