<?php

declare(strict_types=1);

namespace Starternh\MyTestBundle\Dto;

final class FeedbackMessage extends ExternalMessageWithAccount
{
    protected ?string $emailSubject = null;

    protected ?string $emailContent = null;

    protected ?string $phoneContent = null;

    protected ?string $onlineSubject = null;

    protected ?string $onlineLink = null;

    public function getEmailSubject(): ?string
    {
        return $this->emailSubject;
    }

    public function setEmailSubject(string $emailSubject): self
    {
        $this->emailSubject = $emailSubject;

        return $this;
    }

    public function getEmailContent(): ?string
    {
        return $this->emailContent;
    }

    public function setEmailContent(string $emailContent): self
    {
        $this->emailContent = $emailContent;

        return $this;
    }

    public function getPhoneContent(): ?string
    {
        return $this->phoneContent;
    }

    public function setPhoneContent(string $phoneContent): self
    {
        $this->phoneContent = $phoneContent;

        return $this;
    }

    public function getOnlineSubject(): ?string
    {
        return $this->onlineSubject;
    }

    public function setOnlineSubject(string $onlineSubject): self
    {
        $this->onlineSubject = $onlineSubject;

        return $this;
    }

    public function getOnlineLink(): ?string
    {
        return $this->onlineLink;
    }

    public function setOnlineLink(string $onlineLink): self
    {
        $this->onlineLink = $onlineLink;

        return $this;
    }

    public function toArray(): array
    {
        $result = parent::toArray();
        if (null !== $this->getEmailSubject()) {
            $result['emailSubject'] = $this->getEmailSubject();
        }

        if (null !== $this->getEmailContent()) {
            $result['emailContent'] = $this->getEmailContent();
        }

        if (null !== $this->getPhoneContent()) {
            $result['phoneContent'] = $this->getPhoneContent();
        }

        if (null !== $this->getOnlineSubject()) {
            $result['onlineSubject'] = $this->getOnlineSubject();
        }

        if (null !== $this->getOnlineLink()) {
            $result['onlineLink'] = $this->getOnlineLink();
        }

        return $result;
    }
}
