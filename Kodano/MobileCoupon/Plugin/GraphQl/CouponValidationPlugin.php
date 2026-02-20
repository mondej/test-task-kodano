<?php
declare(strict_types=1);

namespace Kodano\MobileCoupon\Plugin\GraphQl;

use Kodano\MobileCoupon\Api\MobileRequestDetectorInterface;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Quote\Model\Quote;
use Magento\QuoteGraphQl\Model\Cart\SetCouponCodeOnCart;
use Magento\SalesRule\Model\CouponFactory;
use Magento\SalesRule\Model\ResourceModel\Coupon as CouponResource;
use Magento\SalesRule\Model\ResourceModel\Rule as RuleResource;
use Magento\SalesRule\Model\RuleFactory;

/**
 * Plugin to validate mobile-only coupons in GraphQL requests
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
     * Validate mobile-only coupon before applying via GraphQL
     *
     * @param SetCouponCodeOnCart $subject
     * @param Quote $cart
     * @param string $couponCode
     * @return array
     * @throws GraphQlInputException
     */
    public function beforeExecute(
        SetCouponCodeOnCart $subject,
        Quote $cart,
        string $couponCode
    ): array {
        if ($this->isMobileOnlyCoupon($couponCode) && !$this->mobileRequestDetector->isMobileRequest()) {
            throw new GraphQlInputException(
                __('This coupon code is valid only for mobile app purchases.')
            );
        }

        return [$cart, $couponCode];
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
