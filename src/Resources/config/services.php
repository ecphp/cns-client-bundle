<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use EcPhp\CnsClientBundle\Service\NotificationService;
use EcPhp\CnsClientBundle\Service\Component\Notification;
use EcPhp\CnsClientBundle\Service\Component\NotificationAttachment;
use EcPhp\CnsClientBundle\Service\Component\NotificationAttachmentInterface;
use EcPhp\CnsClientBundle\Service\Component\NotificationContent;
use EcPhp\CnsClientBundle\Service\Component\NotificationContentInterface;
use EcPhp\CnsClientBundle\Service\Component\NotificationInterface;
use EcPhp\CnsClientBundle\Service\Component\NotificationRecipient;
use EcPhp\CnsClientBundle\Service\Component\NotificationRecipientInterface;
use EcPhp\CnsClientBundle\Service\NotificationServiceInterface;

return static function (ContainerConfigurator $container) {
    $container
        ->services()
        ->set('cns.service', NotificationService::class)
        ->arg('$configuration', '%cns_client%')
        ->autowire(true)
        ->autoconfigure(true);
    $container
        ->services()
        ->alias(NotificationServiceInterface::class, 'cns.service');

    $container
        ->services()
        ->set('cns.notification', Notification::class)
        ->autowire(true)
        ->autoconfigure(true);
    $container
        ->services()
        ->alias(NotificationInterface::class, 'cns.notification');

    $container
        ->services()
        ->set('cns.notification.recipient', NotificationRecipient::class)
        ->autowire(true)
        ->autoconfigure(true);
    $container
        ->services()
        ->alias(NotificationRecipientInterface::class, 'cns.notification.recipient');

    $container
        ->services()
        ->set('cns.notification.content', NotificationContent::class)
        ->autowire(true)
        ->autoconfigure(true);
    $container
        ->services()
        ->alias(NotificationContentInterface::class, 'cns.notification.content');

    $container
        ->services()
        ->set('cns.notification.content.attachment', NotificationAttachment::class)
        ->autowire(true)
        ->autoconfigure(true);
    $container
        ->services()
        ->alias(NotificationAttachmentInterface::class, 'cns.notification.content.attachment');
};
