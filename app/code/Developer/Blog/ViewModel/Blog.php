<?php
declare(strict_types=1);

namespace Developer\Blog\ViewModel;

class Blog implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $urlBuilder;

    public function __construct(
        \Magento\Framework\UrlInterface $urlBuilder
    ) {
        $this->urlBuilder = $urlBuilder;
    }

    public function getUrl($post_id)
    {
        return $this->urlBuilder->getUrl('blog/post/' . $post_id);
    }
}
