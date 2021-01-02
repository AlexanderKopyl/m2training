<?php
declare(strict_types=1);

namespace Developer\RequestPrice\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\LocalizedException;

class Delete extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Developer_RequestPrice::request_delete';

    private $requestRepository;
    /**
     * @param \Developer\RequestPrice\Controller\Adminhtml\Index\Context $context
     * @param \Dveloper\RequestPrice\Api\RequestRepositoryInterface $feedbackRepository
     */
    public function __construct(
        Context $context,
        \Developer\RequestPrice\Api\RequestRepositoryInterface $requestRepository
    ) {
        $this->requestRepository = $requestRepository;
        parent::__construct($context);
    }
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('request_price_id');
        if ($id) {
            try {
                $this->requestRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('You deleted the request.'));
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['request_price_id' => $id]);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('We can\'t delete the request.'));
                return $resultRedirect->setPath('*/*/edit', ['request_price_id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a request to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
