<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\CnsClientBundle\Service;

use EcPhp\CnsClientBundle\Exception\NotificationException;
use EcPhp\CnsClientBundle\Service\Component\NotificationInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

use const JSON_THROW_ON_ERROR;

final class NotificationService implements NotificationServiceInterface
{
    private const API_ENDPOINT = 'v1/notifications?clientSystemKey=%s&clientSystemPassword=%s';

    private array $configuration;

    private HttpClientInterface $httpClient;

    private LoggerInterface $logger;

    public function __construct(
        HttpClientInterface $httpClient,
        LoggerInterface $logger,
        ParameterBagInterface $parameterBag
    ) {
        $this->httpClient = $httpClient;
        $this->logger = $logger;
        $this->configuration = $parameterBag->get('cns_client');
    }

    public function send(NotificationInterface $notification): int
    {
        try {
            $response = $this->httpClient->request(
                'POST',
                sprintf(
                    $this->configuration['base_url'] . self::API_ENDPOINT,
                    $this->configuration['system_key'],
                    $this->configuration['system_password']
                ),
                [
                    'json' => [
                        'notificationGroupCode' => $this->configuration['group_code'],
                        'recipients' => $notification->getRecipients(),
                        'defaultContent' => $notification->getContent(),
                    ],
                ],
            );
        } catch (Throwable $e) {
            $this->logger->error(sprintf('[CNS NOTIFICATION] %s', $e->getMessage()), ['exception' => $e]);

            return 0;
        }

        if (201 === $response->getStatusCode()) {
            return (int) json_decode($response->getContent(), false, 512, JSON_THROW_ON_ERROR)
                ->notificationId;
        }

        throw new NotificationException(
            sprintf('Wrong status code from CNS: %s', $response->getStatusCode()),
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}
