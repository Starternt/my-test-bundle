<?php

declare(strict_types=1);

namespace Starternh\MyTestBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Starternh\MyTestBundle\Dto\ExternalMessageInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
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

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function sendJson(?string $systemName = null, ?string $globalType = null, ?string $globalChannel = null): void
    {
        try {
            $url = self::URL_SEND_JSON;
            if (null !== $globalType) {
                $url .= "/$globalType";
            }

            if (null !== $globalChannel) {
                $url .= "/$globalChannel";
            }

            if (null !== $systemName) {
                $url .= "?systemName=$systemName";
            }

            $response = $this->httpClient->request('POST', $url, [
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
            $url = str_replace('{{jobId}}', (string) $jobId, self::URL_ERRORS_REPORT);
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

    public function addMessageToQueue(ExternalMessageInterface $externalMessage): self
    {
        $this->messagesCollection->add($externalMessage);

        return $this;
    }
}
