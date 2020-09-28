<?php

namespace Training\Test\Controller\Action;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\View\LayoutFactory;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var RawFactory
     */
    private $resultRawFactory;

    /**
     * @var LayoutFactory
     */
    private $layoutFactory;

    /**
     * Index constructor.
     * @param Context $context
     * @param RawFactory $resultRawFactory
     * @param LayoutFactory $layoutFactory
     */
    public function __construct(
        Context $context,
        RawFactory $resultRawFactory,
        LayoutFactory $layoutFactory
    ) {

        $this->resultRawFactory = $resultRawFactory;
        $this->layoutFactory = $layoutFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        // TODO: Implement execute() method.
        $layout = $this->layoutFactory->create();
        $block = $layout->createBlock('Training\Test\Block\Test');
        $block->setTemplate('test.phtml');

        $resultRaw = $this->resultRawFactory->create();
        $resultRaw->setContents($block->toHtml());
        return $resultRaw;
    }
}
