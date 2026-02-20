<?php
declare(strict_types=1);

namespace Kodano\MobileCoupon\Plugin;

use Kodano\MobileCoupon\Api\MobileRequestDetectorInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\SalesRule\Model\CouponFactory;
use Magento\SalesRule\Model\ResourceModel\Coupon as CouponResource;
use Magento\SalesRule\Model\ResourceModel\Rule as RuleResource;
use Magento\SalesRule\Model\RuleFactory;

/**
 * Plugin to validate mobile-only coupons during application
 *
 * Blocks coupons marked with on_mobile=1 from being applied on frontend.
 * Only allows them when X-Mobile-App: true header is present.
 */
class CouponValidationPlugin
{
    public function __construct(
        private readonly MobileRequestDetectorInterface $mobileRequestDetector,
        private readonly CouponFactory $couponFactory,
        private readonly CouponResource $couponResource,
        private readonly RuleFactory $ruleFactory,
        private readonly RuleResource $ruleResource
    ) {
    }

    /**
     * Validate mobile-only coupon before applying to cart (REST API)
     *
     * @param \Magento\Quote\Model\CouponManagement $subject
     * @param int $cartId
     * @param string $couponCode
     * @return array
     * @throws CouldNotSaveException
     */
    public function beforeSet(
        \Magento\Quote\Model\CouponManagement $subject,
        $cartId,
        $couponCode
    ): array {
        $this->validateMobileCoupon($couponCode);
        return [$cartId, $couponCode];
    }

    /**
     * Check if coupon is mobile-only and block if not from mobile app
     *
     * @param string $couponCode
     * @throws CouldNotSaveException
     */
    private function validateMobileCoupon(string $couponCode): void
    {
        if ($this->isMobileOnlyCoupon($couponCode) && !$this->mobileRequestDetector->isMobileRequest()) {
            throw new CouldNotSaveException(
                __('This coupon code is valid only for mobile app purchases.')
            );
        }
    }

    /**
     * Check if coupon belongs to a rule with on_mobile=1
     *
     * @param string $couponCode
     * @return bool
     */
    private function isMobileOnlyCoupon(string $couponCode): bool
    {
        $coupon = $this->couponFactory->create();
        $this->couponResource->load($coupon, $couponCode, 'code');

        if (!$coupon->getId()) {
            return false;
        }

        $rule = $this->ruleFactory->create();
        $this->ruleResource->load($rule, $coupon->getRuleId());

        return (bool) $rule->getData('on_mobile');
    }
}
