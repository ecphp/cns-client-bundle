<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace Lib\CnsNotificationsBundle\Service\Component;

use JsonSerializable;
use StdClass;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class NotificationContent implements JsonSerializable, NotificationContentInterface
{
    public const DEFAULT_LANGUAGE = 'EN';

    private ?NotificationAttachmentInterface $attachment;

    /**
     * @var array<NotificationAttachmentInterface>|null
     */
    private ?array $attachments = [];

    private ?string $body = '';

    private ?string $language = self::DEFAULT_LANGUAGE;

    private ?string $subject = '';

    public function __construct(?NotificationAttachmentInterface $attachment)
    {
        $this->attachment = $attachment;
    }

    /**
     * @param array<int, UploadedFile>|null $files
     */
    public function addAttachmentsFromUpload(array $files): self
    {
        if (null !== $files) {
            foreach ($files as $file) {
                $attachment = clone $this->attachment;
                $attachment
                    ->setName($file->getClientOriginalName())
                    ->setMimeType($file->getMimeType())
                    ->setLength($file->getSize())
                    ->setContentBase64(base64_encode($file->getContent()));
                $this->attachments[] = $attachment;
            }
        }

        return $this;
    }

    public function getAttachments(): ?array
    {
        return $this->attachments;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function getSubject(): ?string
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

    public function setBody(?string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function setLanguage(?string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }
}
