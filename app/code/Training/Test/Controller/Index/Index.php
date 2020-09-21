<?php

namespace Training\Test\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\RawFactory;

class Index extends Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    private $resultRawFactory;

    public function __construct(
        Context $context,
        RawFactory $resultRawFactory
    ) {
        $this->resultRawFactory = $resultRawFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        // TODO: Implement execute() method.
//      $this->getResponse()->appendBody('simple Text;');

        $resultRaw = $this->resultRawFactory->create();
        $resultRaw->setContents('simple Text;');

        return $resultRaw;
    }
}
