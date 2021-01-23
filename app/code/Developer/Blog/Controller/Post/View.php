<?php
declare(strict_types=1);


namespace Developer\Blog\Controller\Post;


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



    public function __construct(
        RequestInterface $request,
        \Magento\Framework\View\Result\PageFactory $pageResultFactory
    ) {
        $this->request = $request;
        $this->pageResultFactory = $pageResultFactory;
    }

    public function execute()
    {
        $resultPage = $this->pageResultFactory->create();
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
