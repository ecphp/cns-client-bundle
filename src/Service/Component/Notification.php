<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\CnsClientBundle\Service\Component;

final class Notification implements NotificationInterface
{
    private NotificationContentInterface $content;

    /**
     * @var array<NotificationRecipientInterface>
     */
    private array $recipients;

    public function addContent(NotificationContentInterface $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function addRecipient(NotificationRecipientInterface $recipient): self
    {
        $this->recipients[] = $recipient;

        return $this;
    }

    public function getContent(): NotificationContentInterface
    {
        return $this->content;
    }

    public function getRecipients(): array
    {
        return $this->recipients;
    }
}
