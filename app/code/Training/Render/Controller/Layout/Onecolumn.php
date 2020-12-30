<?php

namespace Training\Render\Controller\Layout;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Onecolumn extends \Magento\Framework\App\Action\Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{

    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * Onecolumn constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        // TODO: Implement execute() method.
        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }
}
