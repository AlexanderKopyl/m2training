<?php

namespace Training\Test\Controller\Page;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\LayoutFactory;
use Magento\Framework\View\Result\PageFactory;

class Block extends Action
{
    /**
     * @var LayoutFactory
     */
    private $layoutFactory;

    private $resultPageFactory;

    /**
     * Block constructor.
     * @param Context $context
     * @param LayoutFactory $layoutFactory
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        LayoutFactory $layoutFactory,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->layoutFactory = $layoutFactory;
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        // TODO: Implement execute() method.

//        $layout = $this->layoutFactory->create();
//        $block = $layout->createBlock('Training\Test\Block\Test');
//        $this->getResponse()->appendBody($block->toHtml());

        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }
}
