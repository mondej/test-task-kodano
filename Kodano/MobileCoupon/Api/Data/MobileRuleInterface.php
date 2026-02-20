<?php
declare(strict_types=1);

namespace Kodano\MobileCoupon\Api\Data;

/**
 * Interface for mobile rule data transfer object
 *
 * @api
 */
interface MobileRuleInterface
{
    public const RULE_ID = 'rule_id';
    public const NAME = 'name';
    public const COUPON_CODE = 'coupon_code';
    public const ON_MOBILE = 'on_mobile';

    /**
     * Get rule ID
     *
     * @return int
     */
    public function getRuleId(): int;

    /**
     * Set rule ID
     *
     * @param int $ruleId
     * @return $this
     */
    public function setRuleId(int $ruleId): self;

    /**
     * Get rule name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Set rule name
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self;

    /**
     * Get coupon code
     *
     * @return string|null
     */
    public function getCouponCode(): ?string;

    /**
     * Set coupon code
     *
     * @param string|null $couponCode
     * @return $this
     */
    public function setCouponCode(?string $couponCode): self;

    /**
     * Get on_mobile flag
     *
     * @return bool
     */
    public function getOnMobile(): bool;

    /**
     * Set on_mobile flag
     *
     * @param bool $onMobile
     * @return $this
     */
    public function setOnMobile(bool $onMobile): self;
}
