<?php
declare(strict_types=1);

namespace Developer\Blog\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\LocalizedException;

class Delete extends \Magento\Backend\App\Action implements HttpPostActionInterface, HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Developer_Blog::post_delete';

    private $postRepository;
    /**
     * @param \Developer\Blog\Controller\Adminhtml\Index\Context $context
     * @param \Dveloper\Blog\Api\PostRepositoryInterface $postRepository
     */
    public function __construct(
        Context $context,
        \Developer\Blog\Api\PostRepositoryInterface $postRepository
    ) {
        $this->postRepository = $postRepository;
        parent::__construct($context);
    }
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('post_id');
        if ($id) {
            try {
                $this->postRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('You deleted the post.'));
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['post_id' => $id]);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('We can\'t delete the post.'));
                return $resultRedirect->setPath('*/*/edit', ['post_id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a post to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
