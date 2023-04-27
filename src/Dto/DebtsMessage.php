<?php

declare(strict_types=1);

namespace Starternh\MyTestBundle\Dto;

class DebtsMessage extends ExternalMessage
{
    protected float $saldoGas;

    protected ?string $createdAt = null;

    protected ?string $filialName = null;

    protected ?string $filialPhones = null;

    public function __construct(float $saldoGas)
    {
        $this->saldoGas = $saldoGas;
    }

    public function getSaldoGas(): float
    {
        return $this->saldoGas;
    }

    public function setSaldoGas(float $saldoGas): self
    {
        $this->saldoGas = $saldoGas;

        return $this;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getFilialName(): ?string
    {
        return $this->filialName;
    }

    public function setFilialName(string $filialName): self
    {
        $this->filialName = $filialName;

        return $this;
    }

    public function getFilialPhones(): ?string
    {
        return $this->filialPhones;
    }

    public function setFilialPhones(string $filialPhones): self
    {
        $this->filialPhones = $filialPhones;

        return $this;
    }
}
