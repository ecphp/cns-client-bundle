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
use StdClass;

final class NotificationAttachment implements JsonSerializable, NotificationAttachmentInterface
{
    private string $contentBase64 = '';

    private bool $inline = true;

    private int $length = 0;

    private ?string $mimeType = null;

    private string $name = '';

    public function getContentBase64(): string
    {
        return $this->contentBase64;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isInline(): bool
    {
        return $this->inline;
    }

    public function jsonSerialize(): StdClass
    {
        $content = new StdClass();

        $content->mimeType = $this->getMimeType();
        $content->inline = $this->isInline();
        $content->length = $this->getLength();
        $content->name = $this->getName();
        $content->contentBase64 = $this->getContentBase64();

        return $content;
    }

    public function setContentBase64(string $contentBase64): self
    {
        $this->contentBase64 = $contentBase64;

        return $this;
    }

    public function setInline(bool $inline): self
    {
        $this->inline = $inline;

        return $this;
    }

    public function setLength(int $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function setMimeType(?string $mimeType): self
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
