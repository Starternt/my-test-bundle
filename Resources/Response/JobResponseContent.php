<?php

declare(strict_types=1);

namespace Starternh\MyTestBundle\Resources\Response;

final class JobResponseContent
{
    private ?int $id = null;

    private ?int $messagesQuantity = null;

    private ?int $successfulMessagesQuantity = null;

    private ?int $errorsQuantity = null;

    private ?bool $completed = null;

    private ?int $emailsFound = null;

    private ?int $phonesFound = null;

    private ?string $dateCreated = null;

    private ?string $dateUpdated = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getMessagesQuantity(): ?int
    {
        return $this->messagesQuantity;
    }

    public function setMessagesQuantity(?int $messagesQuantity): self
    {
        $this->messagesQuantity = $messagesQuantity;

        return $this;
    }

    public function getSuccessfulMessagesQuantity(): ?int
    {
        return $this->successfulMessagesQuantity;
    }

    public function setSuccessfulMessagesQuantity(?int $successfulMessagesQuantity): self
    {
        $this->successfulMessagesQuantity = $successfulMessagesQuantity;

        return $this;
    }

    public function getErrorsQuantity(): ?int
    {
        return $this->errorsQuantity;
    }

    public function setErrorsQuantity(?int $errorsQuantity): self
    {
        $this->errorsQuantity = $errorsQuantity;

        return $this;
    }

    public function getCompleted(): ?bool
    {
        return $this->completed;
    }

    public function setCompleted(?bool $completed): self
    {
        $this->completed = $completed;

        return $this;
    }

    public function getEmailsFound(): ?int
    {
        return $this->emailsFound;
    }

    public function setEmailsFound(?int $emailsFound): self
    {
        $this->emailsFound = $emailsFound;

        return $this;
    }

    public function getPhonesFound(): ?int
    {
        return $this->phonesFound;
    }

    public function setPhonesFound(?int $phonesFound): self
    {
        $this->phonesFound = $phonesFound;

        return $this;
    }

    public function getDateCreated(): ?string
    {
        return $this->dateCreated;
    }

    public function setDateCreated(?string $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateUpdated(): ?string
    {
        return $this->dateUpdated;
    }

    public function setDateUpdated(?string $dateUpdated): self
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }
}
