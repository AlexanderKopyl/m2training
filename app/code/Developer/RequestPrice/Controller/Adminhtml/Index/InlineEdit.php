<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Developer\RequestPrice\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Developer\RequestPrice\Api\RequestRepositoryInterface as RequestRepository;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Developer\RequestPrice\Api\Data\RequestInterface;

class InlineEdit extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Developer_RequestPrice::inline_save';

    /**
     * @var \Developer\RequestPrice\Api\RequestRepositoryInterface
     */
    protected $requestRepository;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    /**
     * @param Context $context
     * @param RequestRepository $blockRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        RequestRepository $requestRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->requestRepository = $requestRepository;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $requestId) {
                    $request_item = $this->requestRepository->getById($requestId);
                    try {
                        $request_item->setData(array_merge($request_item->getData(), $postItems[$requestId]));
                        $this->requestRepository->save($request_item);
                    } catch (\Exception $e) {
                        $messages[] = $this->getErrorWithBlockId(
                            $request_item,
                            __($e->getMessage())
                        );
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add block title to error message
     *
     * @param RequestInterface $request_item
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithBlockId(RequestInterface $request_item, $errorText)
    {
        return '[Block ID: ' . $request_item->getId() . '] ' . $errorText;
    }
}
