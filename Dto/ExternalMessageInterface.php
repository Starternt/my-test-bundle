<?php

declare(strict_types=1);

namespace Starternh\MyTestBundle\Dto;

interface ExternalMessageInterface
{
    public const EMAIL_CHANNEL = 'email';
    public const SMS_CHANNEL = 'sms';
    public const ONLINE_CHANNEL = 'online';
    public const PUSH_CHANNEL = 'push';
    public const PHONE_CHANNEL = 'phone';
    public const MESSENGER_CHANNEL = 'messenger';

    public function getContractNumber(): ?string;

    public function setContractNumber(string $contractNumber): self;

    public function getPhone(): ?string;

    public function setPhone(string $phone): self;

    public function getEmail(): ?string;

    public function setEmail(string $email): self;

    public function getTitle(): ?string;

    public function setTitle(string $title): self;

    public function getText(): ?string;

    public function setText(string $text): self;

    public function getChannel(): ?string;

    public function setChannel(string $channel = null): self;

    public function getType(): ?string;

    public function setType(string $type): self;

    public function getPriority(): ?int;

    public function setPriority(int $priority): self;

    /**
     * Приоритет каналов. Первый по списку будет более приоритетным,
     * например:
     * ```
     * [
     *     ExternalMessageInterface::EMAIL_CHANNEL,
     *     ExternalMessageInterface::SMS_CHANNEL,
     * ];
     * ```.
     */
    public function getChannelsPriority(): array;

    public function setChannelsPriority(array $channels): self;
}
