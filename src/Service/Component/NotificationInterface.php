<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\CnsClientBundle\Service\Component;

interface NotificationInterface
{
    public function addRecipient(NotificationRecipientInterface $recipient): NotificationInterface;

    public function getContent(): NotificationContentInterface;

    /**
     * @return array<int, NotificationRecipientInterface>
     */
    public function getRecipients(): array;

    public function setContent(NotificationContentInterface $content): NotificationInterface;
}
