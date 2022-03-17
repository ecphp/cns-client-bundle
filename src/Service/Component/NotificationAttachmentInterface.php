<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\CnsClientBundle\Service\Component;

interface NotificationAttachmentInterface
{
    public function getContentBase64(): string;

    public function getLength(): int;

    public function getMimeType(): ?string;

    public function getName(): string;

    public function isInline(): bool;

    public function setContentBase64(string $contentBase64): NotificationAttachmentInterface;

    public function setInline(bool $inline): NotificationAttachmentInterface;

    public function setLength(int $length): NotificationAttachmentInterface;

    public function setMimeType(?string $mimeType): NotificationAttachmentInterface;

    public function setName(string $name): NotificationAttachmentInterface;
}
