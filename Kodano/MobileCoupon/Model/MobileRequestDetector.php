<?php
declare(strict_types=1);

namespace Kodano\MobileCoupon\Model;

use Kodano\MobileCoupon\Api\MobileRequestDetectorInterface;
use Magento\Framework\App\RequestInterface;

/**
 * Detects if the current HTTP request is from a mobile app
 *
 * Mobile app must send header: X-Mobile-App: true
 */
class MobileRequestDetector implements MobileRequestDetectorInterface
{
    public function __construct(
        private readonly RequestInterface $request
    ) {
    }

    /**
     * @inheritDoc
     */
    public function isMobileRequest(): bool
    {
        $headerValue = $this->request->getHeader(self::MOBILE_APP_HEADER);
        return $headerValue === self::MOBILE_APP_HEADER_VALUE;
    }
}
