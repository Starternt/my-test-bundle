<?php

declare(strict_types=1);

namespace Starternh\MyTestBundle\Resources\Response;

class ChannelReportResponse extends AbstractResponse
{
    public array $content = [];

    public function getContent(): array
    {
        return $this->content;
    }

    public function setContent(array $content): self
    {
        $this->content = $content;

        return $this;
    }
}
