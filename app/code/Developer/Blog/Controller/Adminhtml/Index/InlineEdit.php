<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Developer\Blog\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Developer\Blog\Api\PostRepositoryInterface as PostRepository;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Developer\Blog\Api\Data\PostInterface;

class InlineEdit extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Developer_Blog::inline_save';

    /**
     * @var \Developer\Blog\Api\PostRepositoryInterface
     */
    protected $postRepository;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    /**
     * @param Context $context
     * @param PostRepository $blockRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        PostRepository $postRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->postRepository = $postRepository;
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
                foreach (array_keys($postItems) as $postId) {
                    $post_item = $this->postRepository->getById($postId);
                    try {
                        $post_item->setData(array_merge($post_item->getData(), $postItems[$postId]));
                        $this->postRepository->save($post_item);
                    } catch (\Exception $e) {
                        $messages[] = $this->getErrorWithBlockId(
                            $post_item,
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
     * @param PostInterface $post_item
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithBlockId(PostInterface $post_item, $errorText)
    {
        return '[Block ID: ' . $post_item->getId() . '] ' . $errorText;
    }
}
