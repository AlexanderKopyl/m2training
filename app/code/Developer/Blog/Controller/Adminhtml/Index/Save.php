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
    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;
    /**
     * @var \Developer\Blog\Api\PostRepositoryInterface
     */
    private $postRepository;
    /**
     * @var \Developer\Blog\Model\PostFactory
     */
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
        $data = $this->_filterFoodData($data);

        if ($data) {
            if (empty($data['post_id'])) {
                $data['post_id'] = null;
            }
            $model = $this->postFactory->create();

            $this->_eventManager->dispatch(
                'developer_blog_post_prepare_save',
                ['post' => $model, 'request' => $this->getRequest()]
            );

            $id = $this->getRequest()->getParam('post_id');
            if ($id) {
                try {
                    $model = $this->postRepository->getById($id);
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

    public function _filterFoodData(array $rawData)
    {
        //Replace icon with fileuploader field name
        $data = $rawData;
        if (isset($data['thumb'][0]['name'])) {
            $data['thumb'] = $data['thumb'][0]['name'];
        } else {
            $data['thumb'] = null;
        }
        return $data;
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
