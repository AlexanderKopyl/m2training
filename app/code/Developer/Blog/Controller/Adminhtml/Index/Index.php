<?php
declare(strict_types=1);

namespace Developer\Blog\Controller\Adminhtml\Index;

use Magento\Framework\View\Result\PageFactory;

class Index implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * Page result factory
     *
     * @var PageFactory
     */
    public $resultPageFactory;

    public function __construct(
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Posts'));

        return $resultPage;
    }
}
