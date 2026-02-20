<?php
declare(strict_types=1);

namespace Kodano\MobileCoupon\Model\Data;

use Kodano\MobileCoupon\Api\Data\MobileRuleInterface;
use Magento\Framework\DataObject;

/**
 * Mobile rule data transfer object
 */
class MobileRule extends DataObject implements MobileRuleInterface
{
    /**
     * @inheritDoc
     */
    public function getRuleId(): int
    {
        return (int) $this->getData(self::RULE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setRuleId(int $ruleId): MobileRuleInterface
    {
        return $this->setData(self::RULE_ID, $ruleId);
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return (string) $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): MobileRuleInterface
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getCouponCode(): ?string
    {
        return $this->getData(self::COUPON_CODE);
    }

    /**
     * @inheritDoc
     */
    public function setCouponCode(?string $couponCode): MobileRuleInterface
    {
        return $this->setData(self::COUPON_CODE, $couponCode);
    }

    /**
     * @inheritDoc
     */
    public function getOnMobile(): bool
    {
        return (bool) $this->getData(self::ON_MOBILE);
    }

    /**
     * @inheritDoc
     */
    public function setOnMobile(bool $onMobile): MobileRuleInterface
    {
        return $this->setData(self::ON_MOBILE, $onMobile);
    }
}
