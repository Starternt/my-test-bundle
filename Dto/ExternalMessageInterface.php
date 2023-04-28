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

    public const TYPE_UPSALE = 'upsale';

    public const TYPE_DEBTS = 'debts';

    public const TYPE_INVOICE = 'invoice';

    public const TYPE_DIGITAL = 'digital';

    public const TYPE_METER_VERIFICATION = 'meterVerification';

    public const TYPE_TECH_SERVICE_NOTIFIER = 'techServiceNotifier';

    public const TYPE_SUPR_INTEGRATION = 'suprIntegration';

    public const TYPE_FEEDBACK = 'feedback';

    public const TYPE_EMEGRENCY_REQUEST = 'emergency_request';

    public const TYPE_SAUPG_INDEBTEDNESS = 'saupg_indebtedness';

    public const TYPE_SUVK = 'suvk';

    public const TYPE_POVERKA_KAK_TO = 'poverka_kak_to';

    public const TYPE_IOT_BASIC = 'iot_basic';

    public const TYPE_IOT_ALERT = 'iot_alert';

    public const TYPE_SAUPG_BONUSES = 'saupg_bonuses';

    public const TYPE_EQUIPMENT_LIFETIME = 'equipment_lifetime';

    public const TYPE_TECH_MAINTENANCE_AS_VERIFICATION_AS_TECH_MAINTENANCE = 'tech_maintenance_as_verification_as_tech_maintenance';

    public const TYPE_VERIFICATION = 'verification';

    public const TYPE_TECH_MAINTENANCE = 'tech_maintenance';

    public const TYPE_GAS_DEBT = 'gas_debt';

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

    public function toArray(): array;
}
