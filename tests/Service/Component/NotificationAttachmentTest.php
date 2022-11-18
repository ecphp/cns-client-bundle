<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace Tests\EcPhp\CnsClientBundle\Service;

use EcPhp\CnsClientBundle\Service\Component\NotificationAttachment;
use EcPhp\CnsClientBundle\Service\Component\NotificationAttachmentInterface;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\HttpFoundation\File\UploadedFile;

// phpcs:disable Generic.Files.LineLength.TooLong

/**
 * @internal
 *
 * @coversDefaultClass \EcPhp\CnsClientBundle\
 */
final class NotificationAttachmentTest extends TestCase
{
    private const FIXTURE = __DIR__ . '/../../fixtures/uploadedFile.txt';

    public function constructorProvider()
    {
        yield [new NotificationAttachment()];

        $uploadedFile = new UploadedFile(self::FIXTURE, 'originalName');

        yield [NotificationAttachment::fromFile($uploadedFile)];
    }

    public function jsonSerializeProvider()
    {
        $subject = new NotificationAttachment();
        $subject->setMimeType('setMimeType');
        $subject->setInline(true);
        $subject->setLength(123);
        $subject->setName('setName');
        $subject->setContentBase64('setContentBase64');

        yield [
            $subject,
            [
                'mimeType' => 'setMimeType',
                'inline' => true,
                'length' => 123,
                'name' => 'setName',
                'contentBase64' => 'setContentBase64',
            ],
        ];

        $uploadedFile = new UploadedFile(self::FIXTURE, 'originalName');

        yield [
            NotificationAttachment::fromFile($uploadedFile),
            [
                'mimeType' => 'text/plain',
                'inline' => true,
                'length' => 12,
                'name' => 'originalName',
                'contentBase64' => 'dXBsb2FkZWRGaWxl',
            ],
        ];
    }

    /**
     * @dataProvider constructorProvider
     */
    public function testConstructor(NotificationAttachmentInterface $notificationAttachment)
    {
        self::assertInstanceOf(NotificationAttachmentInterface::class, $notificationAttachment);
    }

    /**
     * @dataProvider jsonSerializeProvider
     */
    public function testJsonSerialize(NotificationAttachment $notificationAttachment, array $expected)
    {
        self::assertInstanceOf(stdClass::class, $notificationAttachment->jsonSerialize());
        self::assertEquals(json_encode($expected), json_encode($notificationAttachment));
    }

    public function testStaticConstructor()
    {
        self::assertInstanceOf(NotificationAttachmentInterface::class, NotificationAttachment::fromFile(new UploadedFile(self::FIXTURE, 'f')));
    }
}
