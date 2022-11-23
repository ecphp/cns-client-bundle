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
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

use function array_key_exists;

// phpcs:disable Generic.Files.LineLength.TooLong

final class NotificationService implements NotificationServiceInterface
{
    private const API_ENDPOINT_PATTERN = '%s/v1/notifications?clientSystemKey=%s&clientSystemPassword=%s';

    /**
     * @var array<string, string>
     */
    private array $configuration;

    private HttpClientInterface $httpClient;

    public function __construct(
        HttpClientInterface $httpClient,
        ParameterBagInterface $parameterBag
    ) {
        $this->httpClient = $httpClient;
        $this->configuration = $parameterBag->get('cns_client');
    }

    public function send(NotificationInterface $notification, string $groupCode = NotificationServiceInterface::GROUP_CODE_DEFAULT): int
    {
        if (!array_key_exists($groupCode, $this->configuration['group_code'])) {
            throw NotificationException::unknownGroupCode($groupCode);
        }

        try {
            $response = $this
                ->httpClient
                ->request(
                    Request::METHOD_POST,
                    sprintf(
                        self::API_ENDPOINT_PATTERN,
                        $this->configuration['base_url'],
                        $this->configuration['system_key'],
                        $this->configuration['system_password']
                    ),
                    [
                        'json' => [
                            'notificationGroupCode' => $this->configuration['group_code'][$groupCode],
                            'recipients' => $notification->getRecipients(),
                            'defaultContent' => $notification->getContent(),
                        ],
                    ],
                );
        } catch (TransportExceptionInterface $e) {
            throw NotificationException::requestError($e);
        }

        if (Response::HTTP_CREATED !== $statusCode = $response->getStatusCode()) {
            // TODO: Create a separate exception class, so we can test it better.
            throw NotificationException::statusCodeError($statusCode);
        }

        try {
            $body = $response->toArray();
        } catch (Throwable $e) {
            throw NotificationException::decodeResponseError($e);
        }

        if (false === array_key_exists('notificationId', $body)) {
            throw NotificationException::notificationIdKeyMissing();
        }

        return (int) $body['notificationId'];
    }
}
