<?php
declare(strict_types=1);

namespace Kodano\MobileCoupon\Model;

use Kodano\MobileCoupon\Api\Data\MobileRuleInterface;
use Kodano\MobileCoupon\Api\Data\MobileRuleInterfaceFactory;
use Kodano\MobileCoupon\Api\MobileCouponManagementInterface;
use Magento\SalesRule\Model\ResourceModel\Rule as RuleResource;
use Magento\SalesRule\Model\ResourceModel\Rule\CollectionFactory as RuleCollectionFactory;
use Magento\SalesRule\Model\RuleFactory;

/**
 * Management class for mobile-only coupons REST API
 */
class MobileCouponManagement implements MobileCouponManagementInterface
{
    public function __construct(
        private readonly RuleFactory $ruleFactory,
        private readonly RuleResource $ruleResource,
        private readonly RuleCollectionFactory $ruleCollectionFactory,
        private readonly MobileRuleInterfaceFactory $mobileRuleFactory
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getList(): array
    {
        $collection = $this->ruleCollectionFactory->create();
        $collection->addFieldToFilter('on_mobile', 1);

        $result = [];
        foreach ($collection as $rule) {
            $result[] = $this->convertToMobileRule($rule);
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function markAsMobile(int $ruleId): MobileRuleInterface
    {
        $rule = $this->ruleFactory->create();
        $this->ruleResource->load($rule, $ruleId);

        if (!$rule->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(
                __('Rule with ID "%1" does not exist.', $ruleId)
            );
        }

        $rule->setData('on_mobile', 1);
        $this->ruleResource->save($rule);

        return $this->convertToMobileRule($rule);
    }

    /**
     * @inheritDoc
     */
    public function unmarkAsMobile(int $ruleId): bool
    {
        $rule = $this->ruleFactory->create();
        $this->ruleResource->load($rule, $ruleId);

        if (!$rule->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(
                __('Rule with ID "%1" does not exist.', $ruleId)
            );
        }

        $rule->setData('on_mobile', 0);
        $this->ruleResource->save($rule);

        return true;
    }

    /**
     * Convert rule model to MobileRuleInterface DTO
     */
    private function convertToMobileRule(\Magento\SalesRule\Model\Rule $rule): MobileRuleInterface
    {
        $mobileRule = $this->mobileRuleFactory->create();
        $mobileRule->setRuleId((int) $rule->getId());
        $mobileRule->setName((string) $rule->getName());
        $mobileRule->setCouponCode($rule->getData('code'));
        $mobileRule->setOnMobile((bool) $rule->getData('on_mobile'));

        return $mobileRule;
    }
}
