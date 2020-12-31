<?php

declare(strict_types=1);
namespace Developer\RequestPrice\Controller\Adminhtml\Index;

use Magento\Framework\App\Request\DataPersistorInterface;

class Index extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Developer_RequestPrice::request';

    private $resultPageFactory;
    private $dataPersistor;
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        DataPersistorInterface $dataPersistor
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }
    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage
            ->setActiveMenu('Developer_RequestPrice::requestprice')
            ->addBreadcrumb(__('Request_Price'), __('Requests'))
            ->getConfig()->getTitle()->prepend(__('Requests'));
        $this->dataPersistor->clear('developer_requestPrice');
        return $resultPage;
    }
}
