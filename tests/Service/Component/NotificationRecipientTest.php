<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace Tests\EcPhp\CnsClientBundle\Service;

use EcPhp\CnsClientBundle\Service\Component\NotificationRecipient;
use EcPhp\CnsClientBundle\Service\Component\NotificationRecipientInterface;
use PHPUnit\Framework\TestCase;
use stdClass;

// phpcs:disable Generic.Files.LineLength.TooLong

/**
 * @internal
 * @coversDefaultClass \EcPhp\CnsClientBundle\
 */
final class NotificationRecipientTest extends TestCase
{
    public function testConstructor()
    {
        $subject = new NotificationRecipient();

        self::assertInstanceOf(NotificationRecipientInterface::class, $subject);
    }

    public function testJsonSerialize()
    {
        $subject = new NotificationRecipient();
        $subject->setName('setName');
        $subject->setSmtpAddress('setSmtpAddress');
        $subject->setType('setType');

        $expected = [
            'name' => 'setName',
            'type' => 'setType',
            'smtpAddress' => 'setSmtpAddress',
        ];

        self::assertInstanceOf(stdClass::class, $subject->jsonSerialize());
        self::assertEquals(json_decode(json_encode($expected), true), json_decode(json_encode($subject), true));
    }
}
