<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\CnsClientBundle\Service\Component;

use EcPhp\CnsClientBundle\Exception\NotificationException;
use JsonSerializable;
use StdClass;

final class NotificationRecipient implements JsonSerializable, NotificationRecipientInterface
{
    private string $name = '';

    private string $smtpAddress = '';

    private string $type = 'TO';

    public function getName(): string
    {
        return $this->name;
    }

    public function getSmtpAddress(): string
    {
        return $this->smtpAddress;
    }

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @throws NotificationException
     */
    public function jsonSerialize(): StdClass
    {
        $recipient = new StdClass();

        $recipient->name = $this->getName();
        $recipient->type = $this->getType();
        $recipient->smtpAddress = $this->getSmtpAddress();

        return $recipient;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setSmtpAddress(string $smtpAddress): self
    {
        $this->smtpAddress = $smtpAddress;

        return $this;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
