<?php
declare(strict_types=1);

namespace Developer\Blog\Block\Adminhtml\Post\Edit;

use Magento\Backend\Block\Widget\Context;

class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        $this->context = $context;
    }

    public function getRequestId()
    {
        return (int)$this->context->getRequest()->getParam('post_id');
    }
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
