<?php

declare(strict_types=1);

namespace Starternh\MyTestBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Starternh\MyTestBundle\Dto\ExternalMessageInterface;
use Starternh\MyTestBundle\Resources\Response\ChannelReportResponse;
use Starternh\MyTestBundle\Resources\Response\JobResponse;
use Starternh\MyTestBundle\Resources\Response\JobResponseContent;
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

    private string $token;

    private string $baseUrl;

    protected ArrayCollection $messagesCollection;

    public function __construct(HttpClientInterface $httpClient, $config)
    {
        $this->httpClient = $httpClient;
        $this->baseUrl = $config['credentials']['base_url'] ?? '';
        $this->token = $config['credentials']['token'] ?? '';
        $this->messagesCollection = new ArrayCollection();
    }

    /**
     * @param string|null $systemName Имя системы, в которую будет отправлено сообщение.
     * @param string|null $globalType Если указан, перезапишет типы, указанные в сообщениях.
     * @param string|null $globalChannel Если указан, перезапишет каналы, указанные в сообщениях.
     *
     * @return SendJsonResponse
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function sendJson(
        ?string $systemName = null,
        ?string $globalType = null,
        ?string $globalChannel = null
    ): SendJsonResponse {
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
                    'token'        => $this->token,
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'body'    => $content,
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

    /**
     * @param int $jobId Идентификатор, полученный при отправке сообщений.
     *
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function getJobResults(int $jobId): JobResponse
    {
        $result = new JobResponse();
        try {
            $url = str_replace('{{jobId}}', (string)$jobId, self::URL_JOB_RESULTS);
            $response = $this->httpClient->request('GET', $this->baseUrl.$url, [
                'headers' => [
                    'token'        => $this->token,
                    'Content-Type' => 'application/json',
                ],
            ]);

            $result->setStatusCode($response->getStatusCode());
            $result->setOriginalResponseBody($response->getContent());

            $responseContent = json_decode($response->getContent(), true);
            if (isset($responseContent['success']) && true === $responseContent['success']) {
                $result->setSuccess(true);
                if (array_key_exists('data', $responseContent) && is_array($responseContent['data'])) {
                    $jobResponseContent = (new JobResponseContent())
                        ->setId($responseContent['data']['id'] ?? null)
                        ->setMessagesQuantity($responseContent['data']['messages_quantity'] ?? null)
                        ->setSuccessfulMessagesQuantity($responseContent['successful_messages_quantity']['id'] ?? null)
                        ->setErrorsQuantity($responseContent['data']['errors_quantity'] ?? null)
                        ->setCompleted($responseContent['data']['completed'] ?? null)
                        ->setEmailsFound($responseContent['data']['emails_found'] ?? null)
                        ->setPhonesFound($responseContent['data']['phones_found'] ?? null)
                        ->setDateCreated($responseContent['data']['date_created'] ?? null)
                        ->setDateUpdated($responseContent['data']['date_updated'] ?? null);
                    $result->setContent($jobResponseContent);
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
     * @param int $jobId Идентификатор, полученный при отправке сообщений.
     * @param bool $getResultAsCsv Если true, ответ будет в формате csv файла, иначе json.
     *
     * @return ReportErrorsResponse
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getErrorsReport(int $jobId, bool $getResultAsCsv = false): ReportErrorsResponse
    {
        $result = new ReportErrorsResponse();
        try {
            $url = str_replace('{{jobId}}', (string)$jobId, self::URL_ERRORS_REPORT);
            $headers = [
                'token'        => $this->token,
                'Content-Type' => 'application/json',
            ];
            if ($getResultAsCsv) {
                $headers['Accept'] = 'text/csv';
            }

            $response = $this->httpClient->request('GET', $this->baseUrl.$url, [
                'headers' => $headers,
            ]);

            $result->setStatusCode($response->getStatusCode());
            $result->setOriginalResponseBody($response->getContent());

            if ($getResultAsCsv) {
                if (200 === $response->getStatusCode()) {
                    $result
                        ->setSuccess(true)
                        ->setContentCsv($response->getContent());
                } else {
                    $result->setSuccess(false);
                }
            } else {
                $responseContent = json_decode($response->getContent(), true);
                if (isset($responseContent['success']) && true === $responseContent['success']) {
                    $result->setSuccess(true);
                    if (array_key_exists('data', $responseContent) && is_array($responseContent['data'])) {
                        $result->setContentArray($responseContent['data']);
                    }
                } else {
                    $result->setSuccess(false);
                }
            }

            return $result;
        } catch (\Exception $e) {
            return $result->setOriginalResponseBody($e->getMessage());
        }
    }

    /**
     * @param int $jobId Идентификатор, полученный при отправке сообщений.
     * @param bool $getResultAsCsv Если true, ответ будет в формате csv файла, иначе json.
     *
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function getChannelsReport(int $jobId, bool $getResultAsCsv = false): ChannelReportResponse
    {
        $result = new ChannelReportResponse();
        try {
            $url = str_replace('{{jobId}}', (string)$jobId, self::URL_CHANNELS_REPORT);
            $headers = [
                'token'        => $this->token,
                'Content-Type' => 'application/json',
            ];
            if ($getResultAsCsv) {
                $headers['Accept'] = 'text/csv';
            }

            $response = $this->httpClient->request('GET', $this->baseUrl.$url, [
                'headers' => $headers,
            ]);

            $result->setStatusCode($response->getStatusCode());
            $result->setOriginalResponseBody($response->getContent());

            if ($getResultAsCsv) {
                if (200 === $response->getStatusCode()) {
                    $result
                        ->setSuccess(true)
                        ->setContentCsv($response->getContent());
                } else {
                    $result->setSuccess(false);
                }
            } else {
                $responseContent = json_decode($response->getContent(), true);
                if (isset($responseContent['success']) && true === $responseContent['success']) {
                    $result->setSuccess(true);
                    if (array_key_exists('data', $responseContent) && is_array($responseContent['data'])) {
                        $result->setContentArray($responseContent['data']);
                    }
                } else {
                    $result->setSuccess(false);
                }
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
