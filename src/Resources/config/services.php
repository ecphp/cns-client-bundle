<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use EcPhp\CnsClientBundle\Service\Component\Notification;
use EcPhp\CnsClientBundle\Service\Component\NotificationAttachment;
use EcPhp\CnsClientBundle\Service\Component\NotificationAttachmentInterface;
use EcPhp\CnsClientBundle\Service\Component\NotificationContent;
use EcPhp\CnsClientBundle\Service\Component\NotificationContentInterface;
use EcPhp\CnsClientBundle\Service\Component\NotificationInterface;
use EcPhp\CnsClientBundle\Service\Component\NotificationRecipient;
use EcPhp\CnsClientBundle\Service\Component\NotificationRecipientInterface;
use EcPhp\CnsClientBundle\Service\NotificationService;
use EcPhp\CnsClientBundle\Service\NotificationServiceInterface;

return static function (ContainerConfigurator $container) {
    $services = $container->services();

    $services
        ->defaults()
        ->autoconfigure(true)
        ->autowire(true);

    $services
        ->set(NotificationService::class)
        ->alias(NotificationServiceInterface::class, NotificationService::class);

    $services
        ->set(Notification::class)
        ->alias(NotificationInterface::class, Notification::class);

    $services
        ->set(NotificationRecipient::class)
        ->alias(NotificationRecipientInterface::class, NotificationRecipient::class);

    $services
        ->set(NotificationContent::class)
        ->alias(NotificationContentInterface::class, NotificationContent::class);

    $services
        ->set(NotificationAttachment::class)
        ->alias(NotificationAttachmentInterface::class, NotificationAttachment::class);
};
