<?php
declare(strict_types=1);

namespace Training\Render\ViewModel;

class Form implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    private $urlBuilder;

    /**
     * Form constructor.
     * @param \Magento\Framework\UrlInterface $urlBuilder
     */
    public function __construct(
        \Magento\Framework\UrlInterface $urlBuilder
    ) {
        $this->urlBuilder = $urlBuilder;
    }

    public function getSubmitUrl()
    {
        return $this->urlBuilder->getUrl('customer/account/login');
    }
}
