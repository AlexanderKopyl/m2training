<?php

declare(strict_types=1);

namespace Developer\Blog\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class Edit extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Developer_Blog::post_save';
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;

    /**
     * @var \Developer\Blog\Api\PostRepositoryInterface
     */
    private $postRepository;
    /**
     * @var \Developer\Blog\Model\PostFactory
     */
    private $requestFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Developer\Blog\Api\PostRepositoryInterface $postRepository
     * @param \Developer\Blog\Model\PostFactory $postFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Developer\Blog\Api\PostRepositoryInterface $postRepository,
        \Developer\Blog\Model\PostFactory $requestFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->postRepository = $postRepository;
        $this->requestFactory = $requestFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */

    public function execute()
    {
        $id = $this->getRequest()->getParam('post_id');
        $model = $this->requestFactory->create();
        if ($id) {
            try {
                $model = $this->postRepository->getById($id);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('This post no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $resultPage = $this->resultPageFactory->create();
        $resultPage
            ->setActiveMenu('Developer_Blog::blog')
            ->addBreadcrumb(__('Blog'), __('Post'))
            ->addBreadcrumb(
                $id ? __('Edit Post') : __('New Post'),
                $id ? __('Edit Post') : __('New Post')
            );
        return $resultPage;
    }
}
