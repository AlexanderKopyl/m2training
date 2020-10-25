<?php

namespace Developer\Customer\Plugin\Checkout\Controller\Cart;

use Magento\Store\Model\ScopeInterface;

class Add
{
    const XML_PATH_CUSTOMER_ACTION_ADD = 'developer_customer_rights/rights_settings/action_add';
    /**
     * @var \Magento\Store\Model\ScopeInterface
     */
    private $scopeConfig;

    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory
     */
    private $resultRedirectFactory;
    private $messageManager;
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scope,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory
    ) {
        $this->scopeConfig = $scope;
        $this->messageManager = $messageManager;
        $this->customerSession = $customerSession;
        $this->resultRedirectFactory = $resultRedirectFactory;
    }

    public function aroundExecute(
        \Magento\Checkout\Controller\Cart\Add $subject,
        \Closure $procced
    ) {
        $storeScope = ScopeInterface::SCOPE_STORE;

        $configAction = $this->scopeConfig->getValue(self::XML_PATH_CUSTOMER_ACTION_ADD, $storeScope);

        if (($configAction && !$this->customerSession->isLoggedIn()) || $this->customerSession->isLoggedIn()) {
            return $procced();
        } else {
            $resultRedirect = $this->resultRedirectFactory->create();

            $this->messageManager->addErrorMessage(
                __('Your cannot add product without login')
            );

            $resultRedirect->setPath('customer/account/login');

            return $resultRedirect;
        }
    }
}
