<?php

namespace Developer\Customer\Plugin\Block;

use Magento\Store\Model\ScopeInterface;

class Template
{
    const XML_PATH_CUSTOMER_BASKET = 'developer_customer_rights/rights_settings/basket';

    const XML_PATH_CUSTOMER_BUTTON = 'developer_customer_rights/rights_settings/button_add';

    const XML_PATH_CUSTOMER_ACTION_ADD = 'developer_customer_rights/rights_settings/action_add';
    /**
     * @var \Magento\Store\Model\ScopeInterface
     */
    private $scopeConfig;
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scope,
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->scopeConfig = $scope;
        $this->customerSession = $customerSession;
    }

    public function beforeToHtml(
        \Magento\Framework\View\Element\Template $subject
    ) {
        $storeScope = ScopeInterface::SCOPE_STORE;

        $configBasket = $this->scopeConfig->getValue(self::XML_PATH_CUSTOMER_BASKET, $storeScope);

        $configBUTTON = $this->scopeConfig->getValue(self::XML_PATH_CUSTOMER_BUTTON, $storeScope);

        if ($subject->getTemplate() == 'Magento_Checkout::cart/minicart.phtml' && (!$configBasket && !$this->customerSession->isLoggedIn())) {
            $subject->setTemplate('');
        }

        if ($subject->getTemplate() == 'Magento_Catalog::product/view/addtocart.phtml' && (!$configBUTTON && !$this->customerSession->isLoggedIn())) {
            $subject->setTemplate('');
        }

        return [];
    }
}
