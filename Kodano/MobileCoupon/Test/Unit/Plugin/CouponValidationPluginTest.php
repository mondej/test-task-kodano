<?php
declare(strict_types=1);

namespace Kodano\MobileCoupon\Test\Unit\Plugin;

use Kodano\MobileCoupon\Api\MobileRequestDetectorInterface;
use Kodano\MobileCoupon\Plugin\CouponValidationPlugin;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Quote\Model\CouponManagement;
use Magento\SalesRule\Model\Coupon;
use Magento\SalesRule\Model\CouponFactory;
use Magento\SalesRule\Model\ResourceModel\Coupon as CouponResource;
use Magento\SalesRule\Model\ResourceModel\Rule as RuleResource;
use Magento\SalesRule\Model\Rule;
use Magento\SalesRule\Model\RuleFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CouponValidationPluginTest extends TestCase
{
    private CouponValidationPlugin $plugin;
    private MobileRequestDetectorInterface|MockObject $mobileRequestDetectorMock;
    private CouponFactory|MockObject $couponFactoryMock;
    private CouponResource|MockObject $couponResourceMock;
    private RuleFactory|MockObject $ruleFactoryMock;
    private RuleResource|MockObject $ruleResourceMock;
    private CouponManagement|MockObject $subjectMock;

    protected function setUp(): void
    {
        $this->mobileRequestDetectorMock = $this->createMock(MobileRequestDetectorInterface::class);
        $this->couponFactoryMock = $this->createMock(CouponFactory::class);
        $this->couponResourceMock = $this->createMock(CouponResource::class);
        $this->ruleFactoryMock = $this->createMock(RuleFactory::class);
        $this->ruleResourceMock = $this->createMock(RuleResource::class);
        $this->subjectMock = $this->createMock(CouponManagement::class);

        $this->plugin = new CouponValidationPlugin(
            $this->mobileRequestDetectorMock,
            $this->couponFactoryMock,
            $this->couponResourceMock,
            $this->ruleFactoryMock,
            $this->ruleResourceMock
        );
    }

    public function testBeforeSetAllowsNonMobileCoupon(): void
    {
        $cartId = 1;
        $couponCode = 'REGULAR_COUPON';

        $couponMock = $this->createMock(Coupon::class);
        $couponMock->method('getId')->willReturn(1);
        $couponMock->method('getRuleId')->willReturn(10);

        $ruleMock = $this->createMock(Rule::class);
        $ruleMock->method('getData')->with('on_mobile')->willReturn(0);

        $this->couponFactoryMock->method('create')->willReturn($couponMock);
        $this->ruleFactoryMock->method('create')->willReturn($ruleMock);

        $result = $this->plugin->beforeSet($this->subjectMock, $cartId, $couponCode);

        $this->assertEquals([$cartId, $couponCode], $result);
    }

    public function testBeforeSetAllowsMobileCouponFromMobileApp(): void
    {
        $cartId = 1;
        $couponCode = 'MOBILE_COUPON';

        $couponMock = $this->createMock(Coupon::class);
        $couponMock->method('getId')->willReturn(1);
        $couponMock->method('getRuleId')->willReturn(10);

        $ruleMock = $this->createMock(Rule::class);
        $ruleMock->method('getData')->with('on_mobile')->willReturn(1);

        $this->couponFactoryMock->method('create')->willReturn($couponMock);
        $this->ruleFactoryMock->method('create')->willReturn($ruleMock);
        $this->mobileRequestDetectorMock->method('isMobileRequest')->willReturn(true);

        $result = $this->plugin->beforeSet($this->subjectMock, $cartId, $couponCode);

        $this->assertEquals([$cartId, $couponCode], $result);
    }

    public function testBeforeSetBlocksMobileCouponFromFrontend(): void
    {
        $cartId = 1;
        $couponCode = 'MOBILE_COUPON';

        $couponMock = $this->createMock(Coupon::class);
        $couponMock->method('getId')->willReturn(1);
        $couponMock->method('getRuleId')->willReturn(10);

        $ruleMock = $this->createMock(Rule::class);
        $ruleMock->method('getData')->with('on_mobile')->willReturn(1);

        $this->couponFactoryMock->method('create')->willReturn($couponMock);
        $this->ruleFactoryMock->method('create')->willReturn($ruleMock);
        $this->mobileRequestDetectorMock->method('isMobileRequest')->willReturn(false);

        $this->expectException(CouldNotSaveException::class);
        $this->expectExceptionMessage('This coupon code is valid only for mobile app purchases.');

        $this->plugin->beforeSet($this->subjectMock, $cartId, $couponCode);
    }
}
