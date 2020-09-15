<?php

namespace Training\Test\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class RedirectToLogin implements ObserverInterface
{

    /**
     * @var \Magento\Framework\App\Response\RedirectInterface
     */
    private $redirect;

    /**
     * @var  \Magento\Framework\App\ActionFlag
     */
    private $actionFlag;

    /**
     * @param \Magento\Framework\App\Response\RedirectInterface $redirect
     * @param \Magento\Framework\App\ActionFlag $actionFlag
     */
    public function __consturct(
        \Magento\Framework\App\Response\RedirectInterface $redirect,
        \Magento\Framework\App\ActionFlag $actionFlag
    )
    {
        $this->actionFlag = $actionFlag;
        $this->redirect = $redirect;
    }

    public function execute(Observer $observer)
    {
        $request = $observer->getEvent()->getData('request');

        if (
            $request->getModuleName() == 'catalog'
            && $request->getControllerName() == 'product'
            && $request->getActionName() == 'view'

        ) {
            $observer->getControllerAction()->getResponse()->setRedirect('customer/account/login');
        }
    }
}
