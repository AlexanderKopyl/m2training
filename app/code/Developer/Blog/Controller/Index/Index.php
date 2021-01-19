<?php
declare(strict_types=1);

namespace Developer\Blog\Controller\Index;

class Index implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $pageResultFactory;

    private $_url;

    public function __construct(
        \Magento\Framework\View\Result\PageFactory $pageResultFactory,
        \Magento\Framework\UrlInterface $urlBuilder
    ) {
        $this->pageResultFactory = $pageResultFactory;
        $this->_url = $urlBuilder;
    }

    public function execute()
    {
        $page = $this->pageResultFactory->create();

        // Add title which is got by the configuration via backend
        $page->getConfig()->getTitle()->set(
            __('Posts List')
        );

        // Add breadcrumb
        /** @var \Magento\Theme\Block\Html\Breadcrumbs */
        $breadcrumbs = $page->getLayout()->getBlock('breadcrumbs');
        $breadcrumbs->addCrumb(
            'home',
            [
                'label' => __('Home'),
                'title' => __('Home'),
                'link' => $this->_url->getUrl('')
            ]
        );
        $breadcrumbs->addCrumb(
            'blog',
            [
                'label' => __('Posts'),
                'title' => __('Posts')
            ]
        );
        return $page;
    }
}
