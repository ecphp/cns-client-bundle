<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\CnsClientBundle\Service;

use EcPhp\CnsClientBundle\Exception\NotificationException;
use EcPhp\CnsClientBundle\Service\Component\NotificationInterface;

interface NotificationServiceInterface
{
    public const GROUP_CODE_DEFAULT = 'default';

    /**
     * @throws NotificationException
     */
    public function send(
        NotificationInterface $notification,
        string $groupCode = NotificationService::GROUP_CODE_DEFAULT
    ): int;
}
