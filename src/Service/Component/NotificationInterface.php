<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace Lib\CnsNotificationsBundle\Service\Component;

interface NotificationInterface
{
    public function addContent(NotificationContentInterface $content): self;

    public function addRecipient(NotificationRecipientInterface $recipient): self;

    public function getContent(): NotificationContentInterface;

    /**
     * @return array|NotificationRecipient[]
     */
    public function getRecipients(): ?array;
}
