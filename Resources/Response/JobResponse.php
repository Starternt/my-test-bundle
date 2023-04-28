<?php

declare(strict_types=1);

namespace Starternh\MyTestBundle\Resources\Response;

class JobResponse extends AbstractResponse
{
    public ?JobResponseContent $content = null;

    public function getContent(): JobResponseContent
    {
        return $this->content;
    }

    public function setContent(JobResponseContent $content): self
    {
        $this->content = $content;

        return $this;
    }
}
