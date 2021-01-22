<?php
declare(strict_types=1);

namespace Developer\Blog\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Developer_Blog::post_save';
    private $dataPersistor;
    private $postRepository;
    private $postFactory;
    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param \Developer\Blog\Api\PostRepositoryInterface $postRepository
     * @param \Developer\Blog\Model\PostFactory  $postFactory
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        \Developer\Blog\Api\PostRepositoryInterface $postRepository,
        \Developer\Blog\Model\PostFactory $postFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->postRepository = $postRepository;
        $this->postFactory = $postFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            if (empty($data['post_id'])) {
                $data['post_id'] = null;
            }
            $model = $this->postFactory->create();
            $id = $this->getRequest()->getParam('post_id');
            if ($id) {
                try {
                    $model = $this->postFactory->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This post no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
            $model->setData($data);
            try {
                $this->postRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the post.'));
                $this->dataPersistor->clear('post');
                return $this->processRedirect($model, $data, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager
                    ->addExceptionMessage($e, __('Something went wrong while saving the post.'));
            }
            $this->dataPersistor->set('post', $data);
            return $resultRedirect->setPath(
                '*/*/edit',
                ['post_id' => $this->getRequest()->getParam('post_id')]
            );
        }
        return $resultRedirect->setPath('*/*/');
    }

    private function processRedirect($model, $data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';
        if ($redirect === 'continue') {
            $resultRedirect->setPath('*/*/edit', ['post_id' => $model->getId()]);
        } elseif ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        }
        return $resultRedirect;
    }
}
