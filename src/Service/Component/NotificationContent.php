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
        NotificationAttachmentInterface $notificationAttachment
    ): NotificationContentInterface {
        $this->attachments[] = $notificationAttachment;

        return $this;
    }

    public function addAttachmentsFromUpload(
        array $uploadedFiles
    ): NotificationContentInterface {
        foreach ($uploadedFiles as $uploadedFile) {
            $this->addAttachment(NotificationAttachment::fromFile($uploadedFile));
        }

        return $this;
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
