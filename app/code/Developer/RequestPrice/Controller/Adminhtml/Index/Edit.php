<?php

declare(strict_types=1);

namespace Developer\RequestPrice\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class Edit extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Developer_RequestPrice::request_save';
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;

    /**
     * @var \Developer\RequestPrice\Api\RequestRepositoryInterface
     */
    private $requestRepository;
    /**
     * @var \Developer\RequestPrice\Model\RequestFactory
     */
    private $requestFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Developer\RequestPrice\Api\RequestRepositoryInterface $requestRepository
     * @param \Developer\RequestPrice\Model\RequestFactory $requestFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Developer\RequestPrice\Api\RequestRepositoryInterface $requestRepository,
        \Developer\RequestPrice\Model\RequestFactory $requestFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->requestRepository = $requestRepository;
        $this->requestFactory = $requestFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */

    public function execute()
    {
        $id = $this->getRequest()->getParam('request_price_id');
        $model = $this->requestFactory->create();
        if ($id) {
            try {
                $model = $this->requestRepository->getById($id);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('This request no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $resultPage = $this->resultPageFactory->create();
        $resultPage
            ->setActiveMenu('Developer_RequestPrice::requestprice')
            ->addBreadcrumb(__('Request_Price'), __('Requests'))
            ->addBreadcrumb(
                $id ? __('Edit Requests') : __('New Requests'),
                $id ? __('Edit Requests') : __('New Requests')
            );
        return $resultPage;
    }
}
