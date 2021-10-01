<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace Lib\CnsNotificationsBundle\Service\Component;

interface NotificationAttachmentInterface
{
    public function getContentBase64(): ?string;

    public function getInline(): ?bool;

    public function getLength(): ?int;

    public function getMimeType(): ?string;

    public function getName(): ?string;

    public function setContentBase64(?string $contentBase64): self;

    public function setInline(?bool $inline): self;

    public function setLength(?int $length): self;

    public function setMimeType(?string $mimeType): self;

    public function setName(?string $name): self;
}
