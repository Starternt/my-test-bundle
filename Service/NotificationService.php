<?php

namespace Starternh\MyTestBundle\Service;

use Doctrine\ORM\EntityManagerInterface;

class NotificationService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
    }

    public function sendJson(): void
    {
        var_dump('NOT_SERVICE'); exit();
    }
}
