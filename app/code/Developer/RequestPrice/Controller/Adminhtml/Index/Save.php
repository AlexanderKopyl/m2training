<?php
declare(strict_types=1);

namespace Developer\RequestPrice\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Developer_RequestPrice::request_save';
    private $dataPersistor;
    private $requestRepository;
    private $requestFactory;
    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param \Developer\RequestPrice\Api\RequestRepositoryInterface $requestRepository
     * @param \Developer\RequestPrice\Model\RequestFactory  $requestFactory
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        \Developer\RequestPrice\Api\RequestRepositoryInterface $requestRepository,
        \Developer\RequestPrice\Model\RequestFactory $requestFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->requestRepository = $requestRepository;
        $this->requestFactory = $requestFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            if (empty($data['request_price_id'])) {
                $data['request_price_id'] = null;
            }
            $model = $this->requestFactory->create();
            $id = $this->getRequest()->getParam('request_price_id');
            if ($id) {
                try {
                    $model = $this->requestRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This request no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
            $model->setData($data);
            try {
                $this->requestRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the request.'));
                $this->dataPersistor->clear('request_price');
                return $this->processRedirect($model, $data, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager
                    ->addExceptionMessage($e, __('Something went wrong while saving the request.'));
            }
            $this->dataPersistor->set('request_price', $data);
            return $resultRedirect->setPath(
                '*/*/edit',
                ['request_price_id' => $this->getRequest()->getParam('request_price_id')]
            );
        }
        return $resultRedirect->setPath('*/*/');
    }

    private function processRedirect($model, $data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';
        if ($redirect === 'continue') {
            $resultRedirect->setPath('*/*/edit', ['request_price_id' => $model->getId()]);
        } elseif ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        }
        return $resultRedirect;
    }
}
