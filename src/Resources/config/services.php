<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Lib\CnsNotificationsBundle\Service\CnsNotificationService;
use Lib\CnsNotificationsBundle\Service\Component\Notification;
use Lib\CnsNotificationsBundle\Service\Component\NotificationAttachment;
use Lib\CnsNotificationsBundle\Service\Component\NotificationAttachmentInterface;
use Lib\CnsNotificationsBundle\Service\Component\NotificationContent;
use Lib\CnsNotificationsBundle\Service\Component\NotificationContentInterface;
use Lib\CnsNotificationsBundle\Service\Component\NotificationInterface;
use Lib\CnsNotificationsBundle\Service\Component\NotificationRecipient;
use Lib\CnsNotificationsBundle\Service\Component\NotificationRecipientInterface;
use Lib\CnsNotificationsBundle\Service\NotificationServiceInterface;

return static function (ContainerConfigurator $container) {
    $container
        ->services()
        ->set('cns.service', CnsNotificationService::class)
        ->arg('$configuration', '%lib_cns_notifications%')
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
