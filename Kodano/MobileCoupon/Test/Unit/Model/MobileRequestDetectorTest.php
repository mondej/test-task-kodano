<?php
declare(strict_types=1);

namespace Kodano\MobileCoupon\Test\Unit\Model;

use Kodano\MobileCoupon\Api\MobileRequestDetectorInterface;
use Kodano\MobileCoupon\Model\MobileRequestDetector;
use Magento\Framework\App\Request\Http;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class MobileRequestDetectorTest extends TestCase
{
    private MobileRequestDetector $detector;
    private Http|MockObject $requestMock;

    protected function setUp(): void
    {
        $this->requestMock = $this->createMock(Http::class);
        $this->detector = new MobileRequestDetector($this->requestMock);
    }

    public function testIsMobileRequestReturnsTrueWhenHeaderIsPresent(): void
    {
        $this->requestMock
            ->expects($this->once())
            ->method('getHeader')
            ->with(MobileRequestDetectorInterface::MOBILE_APP_HEADER)
            ->willReturn(MobileRequestDetectorInterface::MOBILE_APP_HEADER_VALUE);

        $this->assertTrue($this->detector->isMobileRequest());
    }

    public function testIsMobileRequestReturnsFalseWhenHeaderIsMissing(): void
    {
        $this->requestMock
            ->expects($this->once())
            ->method('getHeader')
            ->with(MobileRequestDetectorInterface::MOBILE_APP_HEADER)
            ->willReturn(false);

        $this->assertFalse($this->detector->isMobileRequest());
    }

    public function testIsMobileRequestReturnsFalseWhenHeaderHasWrongValue(): void
    {
        $this->requestMock
            ->expects($this->once())
            ->method('getHeader')
            ->with(MobileRequestDetectorInterface::MOBILE_APP_HEADER)
            ->willReturn('false');

        $this->assertFalse($this->detector->isMobileRequest());
    }
}
