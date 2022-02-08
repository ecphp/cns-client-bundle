<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\CnsClientBundle\Service\Component;

interface NotificationRecipientInterface
{
    public function getName(): string;

    public function getSmtpAddress(): string;

    public function getType(): string;

    public function setName(string $name): NotificationRecipientInterface;

    public function setSmtpAddress(string $smtpAddress): NotificationRecipientInterface;

    public function setType(string $type): NotificationRecipientInterface;
}
