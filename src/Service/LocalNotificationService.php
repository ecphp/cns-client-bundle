<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\CnsClientBundle\Service;

use EcPhp\CnsClientBundle\Service\Component\NotificationInterface;

class LocalNotificationService implements NotificationServiceInterface
{
    public function send(NotificationInterface $notification): int
    {
        return 1;
    }
}
