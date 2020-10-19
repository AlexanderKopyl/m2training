<?php


namespace Training\CustomerPersonalSite\ViewModel;


class CustomerAttribute implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    public function getPersonalSite($customerData)
    {
        $attribute = $customerData->getCustomAttribute('personal_site');
        if ($attribute) {
            return $attribute->getValue();
        }
        return '';
    }
}
