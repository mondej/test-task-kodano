<?php
declare(strict_types=1);

namespace Kodano\MobileCoupon\Api;

/**
 * Interface for detecting mobile app requests
 */
interface MobileRequestDetectorInterface
{
    /**
     * HTTP header name that identifies mobile app requests
     */
    public const MOBILE_APP_HEADER = 'X-Mobile-App';

    /**
     * Expected value of the mobile app header
     */
    public const MOBILE_APP_HEADER_VALUE = 'true';

    /**
     * Check if the current request is from a mobile app
     *
     * @return bool
     */
    public function isMobileRequest(): bool;
}
