<?php
declare(strict_types=1);


namespace Developer\Blog\Controller\Post;


use Developer\Blog\Api\PostDescriptionRepositoryInterfaceFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;


class View implements HttpGetActionInterface, HttpPostActionInterface
{
    /**
     * @var RequestInterface
     */
    private $request;
    /**
     * @var PageFactory
     */
    protected $pageResultFactory;

    /**
     * @var \Developer\Blog\Api\PostDescriptionRepositoryInterfaceFactory
     */
    private $_postDescriptionRepositoryFactory;


    public function __construct(
        RequestInterface $request,
        \Developer\Blog\Api\PostDescriptionRepositoryInterfaceFactory $_postDescriptionRepositoryFactory,
        \Magento\Framework\View\Result\PageFactory $pageResultFactory
    ) {
        $this->request = $request;
        $this->_postDescriptionRepositoryFactory = $_postDescriptionRepositoryFactory;
        $this->pageResultFactory = $pageResultFactory;
    }

    public function execute()
    {
        $resultPage = $this->pageResultFactory->create();
        $post = $this->_postDescriptionRepositoryFactory->create();
        $postData = $post->getById($this->getPostId());
        return $resultPage;
    }

    /**
     * Returns Post ID if provided or null
     *
     * @return int|null
     */
    private function getPostId(): ?int
    {
        $id = $this->request->getParam('post_id') ?? $this->request->getParam('id');

        return $id ? (int)$id : null;
    }
}
