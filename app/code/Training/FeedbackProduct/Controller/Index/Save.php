<?php

namespace Training\FeedbackProduct\Controller\Index;

use Magento\Framework\Exception\LocalizedException;

class Save implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    private $feedbackFactory;
    private $feedbackResource;
    private $feedbackDataLoader;
    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory
     */
    private $resultRedirectFactory;
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    private $_request;
    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    private $messageManager;

    public function __construct(
        \Training\Feedback\Model\FeedbackFactory $feedbackFactory,
        \Training\Feedback\Model\ResourceModel\Feedback $feedbackResource,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory,
        \Training\FeedbackProduct\Model\FeedbackDataLoader $feedbackDataLoader
    ) {
        $this->feedbackFactory = $feedbackFactory;
        $this->feedbackResource = $feedbackResource;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->feedbackDataLoader = $feedbackDataLoader;
        $this->_request = $request;
        $this->messageManager = $messageManager;
    }

    public function execute()
    {
        $result = $this->resultRedirectFactory->create();
        if ($post = $this->_request->getPostValue()) {
            try {
                $this->validatePost($post);
                $feedback = $this->feedbackFactory->create();
                $feedback->setData($post);
                $this->setProductsToFeedback($feedback, $post);
                $this->feedbackResource->save($feedback);
                $this->messageManager->addSuccessMessage(
                    __('Thank you for your feedback.')
                );
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
                    __('An error occurred while processing your form. Please try again later.')
                );
                $result->setPath('*/*/form');
            }
        }
        $result->setPath('*/*/index');
        return $result;
    }

    private function setProductsToFeedback($feedback, $post)
    {
        $skus = [];
        if (isset($post['products_skus']) && !empty($post['products_skus'])) {
            $skus = explode(',', $post['products_skus']);
            $skus = array_map('trim', $skus);
            $skus = array_filter($skus);
        }
        $this->feedbackDataLoader->addProductsToFeedbackBySkus($feedback, $skus);
    }

    private function validatePost($post)
    {
        if (!isset($post['author_name']) || trim($post['author_name']) === '') {
            throw new LocalizedException(__('Name is missing'));
        }
        if (!isset($post['message']) || trim($post['message']) === '') {
            throw new LocalizedException(__('Comment is missing'));
        }

        if (!isset($post['author_email']) || false === \strpos($post['author_email'], '@')) {
            throw new LocalizedException(__('Invalid email address'));
        }
        if (trim($this->_request->getParam('hideit')) !== '') {
            throw new \Exception();
        }
    }
}
