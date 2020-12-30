<?php

namespace Training\Test\Plugin\Controller\Product;

class View
{
    protected $customerSession;
    protected $redirectFactory;

    /**
     * View constructor.
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
    ) {
        $this->customerSession = $customerSession;
        $this->redirectFactory = $redirectFactory;
    }

    public function aroundExecute(
        \Magento\Catalog\Controller\Product\View $subject,
        \Closure $procced
    ) {
        if (!$this->customerSession->isLoggedIn()) {
            return $this->redirectFactory->create()->setPath('customer/account/login');
        }

        return $procced();
    }
}
