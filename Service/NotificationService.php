<?php

namespace Starternh\MyTestBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Starternh\MyTestBundle\Dto\ExternalMessageInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NotificationService
{
    private const URL_SEND_JSON = '/api-admin/external-messages/send/json/{{type}}/{{channel}}';
    private const URL_SEND_GZIP = '/api-admin/external-messages/send/gzip/{type}/{channel}';
    private const URL_JOB_RESULTS = '/api-admin/external-messages/results/{job}';
    private const URL_ERRORS_REPORT = '/api-admin/external-messages/results/{{jobId}}/report';
    private const URL_CHANNELS_REPORT = '/api-admin/external-messages/results/{job}/report-channel';

    private HttpClientInterface $httpClient;

    private array $config;

    private string $token;

    private string $baseUrl;

    protected ArrayCollection $messagesCollection;

    public function __construct(HttpClientInterface $httpClient, $config)
    {
        $this->httpClient = $httpClient;
        $this->baseUrl = $this->config['credentials']['base_url'] ?? '';
        $this->token = $this->config['credentials']['token'] ?? '';
        $this->config = (array) $config;
        $this->messagesCollection = new ArrayCollection();
    }

    public function sendJson(ExternalMessageInterface $externalMessage): void
    {
        try {
            $url = str_replace('{{jobId}}', 123, self::URL_SEND_JSON);
            $response = $this->httpClient->request('GET', $this->baseUrl.$url, [
                'headers' => [
                    'token' => $this->token,
                    'Content-Type' => 'application/json'
                ]
            ]);
            dump($response->getStatusCode(), $response->getContent(false)); exit();
        } catch (\Exception $e) {
            dump($e->getMessage()); exit();
        }
    }

    public function addMessageToQueue(): self
    {
        return $this;
    }

    public function sendGzip(): void
    {

    }

    public function getJobResults(): void
    {

    }

    /**
     * @throws TransportExceptionInterface
     */
    public function getErrorsReport(int $jobId): void
    {
        try {
            $url = str_replace('{{jobId}}', $jobId, self::URL_ERRORS_REPORT);
            $response = $this->httpClient->request('GET', $this->baseUrl.$url, [
                'headers' => [
                    'token' => $this->token,
                    'Content-Type' => 'application/json'
                ]
            ]);
            dump($response->getStatusCode(), $response->getContent(false)); exit();
        } catch (\Exception $e) {
            dump($e->getMessage()); exit();
        }
    }

    public function getChannelsReport(int $jobId): void
    {

    }
}
