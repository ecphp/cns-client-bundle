<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\CnsClientBundle\Service\Component;

use StdClass;
use Symfony\Component\HttpFoundation\File\UploadedFile;

// phpcs:disable Generic.Files.LineLength.TooLong

final class NotificationContent implements NotificationContentInterface
{
    public const DEFAULT_LANGUAGE = 'EN';

    /**
     * @var array<int, NotificationAttachmentInterface>
     */
    private array $attachments = [];

    private string $body = '';

    private string $language = self::DEFAULT_LANGUAGE;

    private string $subject = '';

    public function addAttachment(
        NotificationAttachmentInterface $notificationAttachment,
        string $attachmentBase64Content,
        string $name,
        int $length,
        ?string $mimeType = null
    ): NotificationContentInterface {
        $this->attachments[] = $notificationAttachment
            ->setName($name)
            ->setMimeType($mimeType)
            ->setLength($length)
            ->setContentBase64($attachmentBase64Content);

        return $this;
    }

    /**
     * @param array<int, UploadedFile> $files
     */
    public function addAttachmentsFromUpload(
        NotificationAttachmentInterface $notificationAttachment,
        array $files
    ): NotificationContentInterface {
        return array_reduce(
            $files,
            static function (NotificationContentInterface $notificationContent, UploadedFile $file) use ($notificationAttachment): NotificationContentInterface {
                return $notificationContent
                    ->addAttachment(
                        $notificationAttachment,
                        base64_encode($file->getContent()),
                        $file->getClientOriginalName(),
                        $file->getSize(),
                        $file->getMimeType()
                    );
            },
            $this
        );
    }

    public function getAttachments(): array
    {
        return $this->attachments;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function jsonSerialize(): StdClass
    {
        $content = new StdClass();

        $content->subject = $this->getSubject();
        $content->body = $this->getBody();
        $content->language = $this->getLanguage();
        $content->attachments = $this->getAttachments();

        return $content;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }
}
