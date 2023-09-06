<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace Tests\EcPhp\CnsClientBundle\Service;

use EcPhp\CnsClientBundle\Exception\NotificationException;
use EcPhp\CnsClientBundle\Service\Component\Notification;
use EcPhp\CnsClientBundle\Service\Component\NotificationContent;
use EcPhp\CnsClientBundle\Service\Component\NotificationInterface;
use EcPhp\CnsClientBundle\Service\Component\NotificationRecipient;
use EcPhp\CnsClientBundle\Service\NotificationService;
use EcPhp\CnsClientBundle\Service\NotificationServiceInterface;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @internal
 *
 * @coversDefaultClass \EcPhp\CnsClientBundle\
 */
final class NotificationServiceTest extends TestCase
{
    public function notificationProvider(): iterable
    {
        $notification = new Notification();

        yield [
            $notification,
        ];

        $recipient = new NotificationRecipient();
        $recipient->setName('recipient');

        $content = new NotificationContent();
        $content->setBody('notificationContent');

        $notification->addRecipient($recipient);
        $notification->setContent($content);

        yield [
            $notification,
        ];
    }

    public function testConstructor()
    {
        $parameterBag = $this->getParameterBag();
        $configuration = $parameterBag->get('cns_client');
        $client = $this->getHttpClient(__FUNCTION__, $configuration);

        $subject = new NotificationService($client, $parameterBag);

        self::assertInstanceOf(NotificationServiceInterface::class, $subject);
    }

    /**
     * @dataProvider notificationProvider
     */
    public function testContentToArrayException(NotificationInterface $notification)
    {
        // TODO: Create a separate exception class, so we can test it better.
        $this->expectException(NotificationException::class);

        $parameterBag = $this->getParameterBag();
        $configuration = $parameterBag->get('cns_client');
        $client = $this->getHttpClient(__FUNCTION__, $configuration);

        $subject = new NotificationService($client, $parameterBag);

        self::assertEquals(1, $subject->send($notification));
    }

    /**
     * @dataProvider notificationProvider
     */
    public function testNotificationIdKeyMissingException(NotificationInterface $notification)
    {
        // TODO: Create a separate exception class, so we can test it better.
        $this->expectException(NotificationException::class);

        $parameterBag = $this->getParameterBag();
        $configuration = $parameterBag->get('cns_client');
        $client = $this->getHttpClient(__FUNCTION__, $configuration);

        $subject = new NotificationService($client, $parameterBag);

        self::assertEquals(1, $subject->send($notification));
    }

    /**
     * @dataProvider notificationProvider
     */
    public function testStatusCodeErrorException(NotificationInterface $notification)
    {
        // TODO: Create a separate exception class, so we can test it better.
        $this->expectException(NotificationException::class);

        $parameterBag = $this->getParameterBag();
        $configuration = $parameterBag->get('cns_client');
        $client = $this->getHttpClient(__FUNCTION__, $configuration);

        $subject = new NotificationService($client, $parameterBag);

        self::assertEquals(1, $subject->send($notification));
    }

    /**
     * @dataProvider notificationProvider
     */
    public function testSuccessfulSend(NotificationInterface $notification)
    {
        $parameterBag = $this->getParameterBag();
        $configuration = $parameterBag->get('cns_client');
        $client = $this->getHttpClient(__FUNCTION__, $configuration, $notification);

        $subject = new NotificationService($client, $parameterBag);

        self::assertEquals(123, $subject->send($notification));
    }

    /**
     * @dataProvider notificationProvider
     */
    public function testTransportException(NotificationInterface $notification)
    {
        // TODO: Create a separate exception class, so we can test it better.
        $this->expectException(NotificationException::class);

        $parameterBag = $this->getParameterBag();
        $configuration = $parameterBag->get('cns_client');
        $client = $this->getHttpClient(__FUNCTION__, $configuration);

        $subject = new NotificationService($client, $parameterBag);

        self::assertEquals(1, $subject->send($notification));
    }

    private function getHttpClient(string $type, array $configuration, ?NotificationInterface $notification = null): HttpClientInterface
    {
        $callback = static function ($method, $url, $options) use ($type, $configuration, $notification): MockResponse {
            $builtUrl = sprintf('%s/sv1/notifications', $configuration['base_url']);

            if ($url !== $builtUrl) {
                throw new Exception('Invalid request URL structure.');
            }

            switch ($type) {
                case 'testContentToArrayException':
                    return new MockResponse('foo', ['http_code' => Response::HTTP_CREATED]);

                case 'testNotificationIdKeyMissingException':
                    return new MockResponse(json_encode(['foo' => 'bar']), ['http_code' => Response::HTTP_CREATED]);

                case 'testSuccessfulSend':
                    if (null === $notification) {
                        return new MockResponse(json_encode(['notificationId' => '123']), ['http_code' => Response::HTTP_CREATED]);
                    }

                    $expected = [
                        'notificationGroupCode' => 'group_code',
                        'recipients' => $notification->getRecipients(),
                        'defaultContent' => $notification->getContent(),
                    ];

                    // Check that the request body is equal to ...
                    if (json_encode($expected) !== $options['body']) {
                        throw new Exception('Invalid request structure.');
                    }

                    return new MockResponse(json_encode(['notificationId' => '123']), ['http_code' => Response::HTTP_CREATED]);

                case 'testTransportException':
                    throw new TransportException('Error during request');

                case 'testStatusCodeErrorException':
                    return new MockResponse(json_encode(['notificationId' => '123']), ['http_code' => Response::HTTP_BAD_REQUEST]);

                default:
                    throw new Exception(sprintf('Test case missing: %s', $type));
            }
        };

        return new MockHttpClient($callback);
    }

    private function getParameterBag(): ParameterBagInterface
    {
        $parameterBag = $this
            ->getMockBuilder(ParameterBagInterface::class)
            ->getMock();

        $parameterBag
            ->method('get')
            ->with('cns_client')
            ->willReturn([
                'group_code' => 'group_code',
                'base_url' => 'https://example.com',
                'system_key' => 'system_key',
                'system_password' => 'system_password',
            ]);

        return $parameterBag;
    }
}
