<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace Tests\EcPhp\CnsClientBundle\Service;

use EcPhp\CnsClientBundle\Service\Component\Notification;
use EcPhp\CnsClientBundle\Service\Component\NotificationContent;
use EcPhp\CnsClientBundle\Service\Component\NotificationInterface;
use EcPhp\CnsClientBundle\Service\Component\NotificationRecipient;
use PHPUnit\Framework\TestCase;

// phpcs:disable Generic.Files.LineLength.TooLong

/**
 * @internal
 *
 * @coversDefaultClass \EcPhp\CnsClientBundle\
 */
final class NotificationTest extends TestCase
{
    public function testAddGetRecipient()
    {
        $subject = new Notification();

        $recipient = new NotificationRecipient();

        $subject->addRecipient($recipient);

        $recipients = $subject->getRecipients();

        self::assertEquals([$recipient], $recipients);
    }

    public function testConstructor()
    {
        $subject = new Notification();

        self::assertInstanceOf(NotificationInterface::class, $subject);
    }

    public function testSetGetContent()
    {
        $subject = new Notification();

        $content = new NotificationContent();
        $content->setBody('foo');

        $subject->setContent($content);

        $getContent = $subject->getContent();

        self::assertEquals($content, $getContent);
        self::assertEquals('foo', $getContent->getBody());
    }
}
