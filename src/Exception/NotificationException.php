<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\CnsClientBundle\Exception;

use Exception;
use Throwable;

final class NotificationException extends Exception
{
    public static function decodeResponseError(Throwable $previous): self
    {
        return new self(
            'Unable to decode the response body',
            0,
            $previous
        );
    }

    public static function notificationIdKeyMissing(): self
    {
        return new self('notificationId key missing');
    }

    public static function requestError(Throwable $previous): self
    {
        return new self(
            'Unable to fulfil the request',
            0,
            $previous
        );
    }

    public static function statusCodeError(int $statusCode): self
    {
        return new self(
            sprintf('Wrong status code from CNS: %s', $statusCode)
        );
    }
}
