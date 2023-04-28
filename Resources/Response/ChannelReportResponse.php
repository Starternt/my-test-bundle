<?php

declare(strict_types=1);

namespace Starternh\MyTestBundle\Resources\Response;

class ChannelReportResponse extends AbstractResponse
{
    public array $contentArray = [];

    public string $contentCsv = '';

    public function getContentArray(): array
    {
        return $this->contentArray;
    }

    public function setContentArray(array $contentArray): self
    {
        $this->contentArray = $contentArray;

        return $this;
    }

    public function getContentCsv(): string
    {
        return $this->contentCsv;
    }

    public function setContentCsv(string $contentCsv): self
    {
        $this->contentCsv = $contentCsv;

        return $this;
    }
}
