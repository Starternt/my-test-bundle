<?php

declare(strict_types=1);

namespace Starternh\MyTestBundle\Dto;

abstract class ExternalMessageWithAccount extends ExternalMessage
{
    protected ?string $account = null;

    public function getAccount(): ?string
    {
        return $this->account;
    }

    public function setAccount(string $account): self
    {
        $this->account = $account;

        return $this;
    }

    public function toArray(): array
    {
        $result = parent::toArray();
        if (null !== $this->getAccount()) {
            $result['account'] = $this->getAccount();
        }

        return $result;
    }
}
