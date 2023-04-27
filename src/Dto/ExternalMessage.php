<?php

declare(strict_types=1);

namespace Starternh\MyTestBundle\Dto;

abstract class ExternalMessage implements ExternalMessageInterface
{
    protected ?string $contractNumber = null;

    protected ?string $phone = null;

    protected ?string $email = null;

    protected ?string $title = null;

    protected ?string $text = null;

    protected ?string $channel = null;

    protected ?string $type = null;

    protected ?int $priority = null;

    protected array $channelsPriority = [];

    public function getContractNumber(): ?string
    {
        return $this->contractNumber;
    }

    public function setContractNumber(string $contractNumber): self
    {
        $this->contractNumber = $contractNumber;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getChannel(): ?string
    {
        return $this->channel;
    }

    public function setChannel(string $channel = null): ExternalMessageInterface
    {
        $this->channel = $channel;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getChannelsPriority(): array
    {
        return $this->channelsPriority;
    }

    public function setChannelsPriority(array $channels): self
    {
        $this->channelsPriority = $channels;

        return $this;
    }
}
