<?php

namespace Training\Test\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class RedirectToLogin implements ObserverInterface
{

    private $redirect;

    private $actionFlag;

    public function __construct(
        \Magento\Framework\App\Response\RedirectInterface $redirect,
        \Magento\Framework\App\ActionFlag $actionFlag
    ) {
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
            $controller = $observer->getEvent()->getData('controller_action');
            $this->actionFlag->set('', \Magento\Framework\App\Action\Action::FLAG_NO_DISPATCH, true);
            $this->redirect->redirect($controller->getResponse(), 'customer/account/login');
            //->getResponse()->setRedirect('customer/account/login');
        }
    }
}
