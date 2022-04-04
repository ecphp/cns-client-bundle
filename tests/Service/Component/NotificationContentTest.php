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
use EcPhp\CnsClientBundle\Service\Component\NotificationContent;
use EcPhp\CnsClientBundle\Service\Component\NotificationContentInterface;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\HttpFoundation\File\UploadedFile;

// phpcs:disable Generic.Files.LineLength.TooLong

/**
 * @internal
 * @coversDefaultClass \EcPhp\CnsClientBundle\
 */
final class NotificationContentTest extends TestCase
{
    private const FIXTURE = __DIR__ . '/../../fixtures/uploadedFile.txt';

    public function testConstructor()
    {
        $subject = new NotificationContent();

        self::assertInstanceOf(NotificationContentInterface::class, $subject);
    }

    public function testJsonSerialize()
    {
        $subject = new NotificationContent();
        $subject->setBody('setBody');
        $subject->setLanguage('setLanguage');
        $subject->setSubject('setSubject');

        $attachment = new NotificationAttachment();
        $attachment->setMimeType('setMimeType');
        $attachment->setInline(true);
        $attachment->setLength(123);
        $attachment->setName('setName');
        $attachment->setContentBase64('setContentBase64');

        $uploadedFile = new UploadedFile(self::FIXTURE, 'originalName');

        $subject->addAttachment($attachment);
        $subject->addAttachmentsFromUpload([$uploadedFile]);

        $expected = [
            'subject' => 'setSubject',
            'body' => 'setBody',
            'language' => 'setLanguage',
            'attachments' => [
                $attachment,
                [
                    'mimeType' => 'text/plain',
                    'inline' => true,
                    'length' => 12,
                    'name' => 'originalName',
                    'contentBase64' => 'dXBsb2FkZWRGaWxl',
                ],
            ],
        ];

        self::assertInstanceOf(stdClass::class, $subject->jsonSerialize());
        self::assertEquals(json_decode(json_encode($expected), true), json_decode(json_encode($subject), true));
    }
}
