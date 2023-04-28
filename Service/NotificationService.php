<?php

declare(strict_types=1);

namespace Starternh\MyTestBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Starternh\MyTestBundle\Dto\ExternalMessageInterface;
use Starternh\MyTestBundle\Resources\Response\ChannelReportResponse;
use Starternh\MyTestBundle\Resources\Response\ReportErrorsResponse;
use Starternh\MyTestBundle\Resources\Response\SendJsonResponse;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NotificationService
{
    private const URL_SEND_JSON = '/api-admin/external-messages/send/json';
    private const URL_SEND_GZIP = '/api-admin/external-messages/send/gzip';
    private const URL_JOB_RESULTS = '/api-admin/external-messages/results/{{jobId}}';
    private const URL_ERRORS_REPORT = '/api-admin/external-messages/results/{{jobId}}/report';
    private const URL_CHANNELS_REPORT = '/api-admin/external-messages/results/{{jobId}}/report-channel';

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
    public function sendJson(?string $systemName = null, ?string $globalType = null, ?string $globalChannel = null): SendJsonResponse
    {
        $result = new SendJsonResponse();
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

            $content = [];
            /** @var ExternalMessageInterface $externalMessage */
            foreach ($this->messagesCollection as $externalMessage) {
                $content[] = $externalMessage->toArray();
            }

            $response = $this->httpClient->request('POST', $url, [
                'headers' => [
                    'token' => $this->token,
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'body' => $content,
            ]);

            $result->setStatusCode($response->getStatusCode());
            $result->setOriginalResponseBody($response->getContent());

            $responseContent = json_decode($response->getContent(), true);
            if (isset($responseContent['success']) && true === $responseContent['success']
                && array_key_exists(
                    'data',
                    $responseContent
                )
                && array_key_exists('jobId', $responseContent)
            ) {
                $result
                    ->setSuccess(true)
                    ->setJobId((int)$responseContent['data']['jobId']);
            } else {
                $result->setSuccess(false);
            }

            $this->messagesCollection->clear();

            return $result;
        } catch (\Exception $e) {
            return $result->setOriginalResponseBody($e->getMessage());
        }
    }

    public function sendGzip(): void
    {

    }

    public function getJobResults(): void
    {

    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function getErrorsReport(int $jobId, string $contentType): ReportErrorsResponse
    {
        $result = new ReportErrorsResponse();
        try {
            $url = str_replace('{{jobId}}', (string) $jobId, self::URL_ERRORS_REPORT);
            $response = $this->httpClient->request('GET', $this->baseUrl.$url, [
                'headers' => [
                    'token' => $this->token,
                    'Content-Type' => $contentType,
                ],
            ]);

            $result->setStatusCode($response->getStatusCode());
            $result->setOriginalResponseBody($response->getContent());

            $responseContent = json_decode($response->getContent(), true);
            if (isset($responseContent['success']) && true === $responseContent['success']) {
                $result->setSuccess(true);
                if (array_key_exists('data', $responseContent) && is_array($responseContent['data'])) {
                    $result->setContent($responseContent['data']);
                }
            } else {
                $result->setSuccess(false);
            }

            return $result;
        } catch (\Exception $e) {
            return $result->setOriginalResponseBody($e->getMessage());
        }
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function getChannelsReport(int $jobId): ChannelReportResponse
    {
        $result = new ChannelReportResponse();
        try {
            $url = str_replace('{{jobId}}', (string) $jobId, self::URL_CHANNELS_REPORT);
            $response = $this->httpClient->request('GET', $this->baseUrl.$url, [
                'headers' => [
                    'token' => $this->token,
                    'Content-Type' => 'application/json',
                ],
            ]);

            $result->setStatusCode($response->getStatusCode());
            $result->setOriginalResponseBody($response->getContent());

            $responseContent = json_decode($response->getContent(), true);
            if (isset($responseContent['success']) && true === $responseContent['success']) {
                $result->setSuccess(true);
                if (array_key_exists('data', $responseContent) && is_array($responseContent['data'])) {
                    $result->setContent($responseContent['data']);
                }
            } else {
                $result->setSuccess(false);
            }

            return $result;
        } catch (\Exception $e) {
            return $result->setOriginalResponseBody($e->getMessage());
        }
    }

    public function addMessageToQueue(ExternalMessageInterface $externalMessage): self
    {
        $this->messagesCollection->add($externalMessage);

        return $this;
    }
}
