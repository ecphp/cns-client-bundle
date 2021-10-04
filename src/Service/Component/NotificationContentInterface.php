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
    /**
     * @param array<int, UploadedFile>|null $files
     */
    public function addAttachmentsFromUpload(array $files): self;

    public function getAttachments(): ?array;

    public function getBody(): ?string;

    public function getLanguage(): ?string;

    public function getSubject(): ?string;

    public function setBody(?string $body): self;

    public function setLanguage(?string $language): self;

    public function setSubject(?string $subject): self;
}
