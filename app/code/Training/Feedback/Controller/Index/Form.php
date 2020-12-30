<?php

namespace Training\Feedback\Controller\Index;

class Form implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    private $pageResultFactory;


    public function __construct(
        \Magento\Framework\View\Result\PageFactory $pageResultFactory
    ) {
        $this->pageResultFactory = $pageResultFactory;
    }

    public function execute()
    {
        $result = $this->pageResultFactory->create();
        return $result;
    }
}
