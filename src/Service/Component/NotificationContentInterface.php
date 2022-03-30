<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\CnsClientBundle\Service\Component;

use JsonSerializable;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface NotificationContentInterface extends JsonSerializable
{
    public function addAttachment(
        NotificationAttachmentInterface $notificationAttachment
    ): NotificationContentInterface;

    /**
     * @param array<array-key, UploadedFile> $uploadedFiles
     */
    public function addAttachmentsFromUpload(
        array $uploadedFiles
    ): NotificationContentInterface;

    /**
     * @return array<int, NotificationAttachmentInterface>
     */
    public function getAttachments(): array;

    public function getBody(): string;

    public function getLanguage(): string;

    public function getSubject(): string;

    public function setBody(string $body): NotificationContentInterface;

    public function setLanguage(string $language): NotificationContentInterface;

    public function setSubject(string $subject): NotificationContentInterface;
}
