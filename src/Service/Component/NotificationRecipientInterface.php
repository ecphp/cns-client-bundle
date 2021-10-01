<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace Lib\CnsNotificationsBundle\Service\Component;

interface NotificationRecipientInterface
{
    public function getName(): ?string;

    public function getSmtpAddress(): ?string;

    public function getType(): ?string;

    public function setName(string $name): self;

    public function setSmtpAddress(string $smtpAddress): self;

    public function setType(string $type): self;
}
