<?php
declare(strict_types=1);

namespace Kodano\MobileCoupon\Api;

/**
 * Interface for managing mobile-only coupons via REST API
 *
 * @api
 */
interface MobileCouponManagementInterface
{
    /**
     * Get list of all cart price rules marked as mobile-only
     *
     * @return \Kodano\MobileCoupon\Api\Data\MobileRuleInterface[]
     */
    public function getList(): array;

    /**
     * Mark a cart price rule as mobile-only
     *
     * @param int $ruleId
     * @return \Kodano\MobileCoupon\Api\Data\MobileRuleInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function markAsMobile(int $ruleId): \Kodano\MobileCoupon\Api\Data\MobileRuleInterface;

    /**
     * Remove mobile-only flag from a cart price rule
     *
     * @param int $ruleId
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function unmarkAsMobile(int $ruleId): bool;
}
