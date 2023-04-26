<?php

namespace Starternh\MyTestBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NotificationService
{
    private const URL_ERRORS_REPORT = '/api-admin/external-messages/results/{jobId}/report';

    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function sendJson(): void
    {
        var_dump('NOT_SERVICE'); exit();
    }

    public function sendGzip(): void
    {

    }

    public function getGobResults(): void
    {

    }

    /**
     * @throws TransportExceptionInterface
     */
    public function getErrorsReport(int $jobId): void
    {
        try {
            $url = str_replace('{{jobId}}', $jobId, self::URL_ERRORS_REPORT);
            $this->httpClient->request('GET', $url);
        } catch (\Exception $e) {
            dump($e->getMessage()); exit();
        }
    }

    public function getChannelsReport(int $jobId): void
    {

    }
}
