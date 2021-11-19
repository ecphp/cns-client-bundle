<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\CnsClientBundle\Service\Component;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface NotificationContentInterface
{
    public function getAttachments(): ?array;

    public function getBody(): string;

    public function getLanguage(): string;

    public function getSubject(): string;

    public function setBody(string $body): self;

    public function setLanguage(string $language): self;

    public function setSubject(string $subject): self;

    public function withNotificationAttachment(
        string $attachmentBase64Content,
        string $name,
        string $mimeType,
        int $length
    ): self;

    /**
     * @param array<int, UploadedFile> $files
     */
    public function withNotificationAttachmentsFromUpload(array $files): self;
}
