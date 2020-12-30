<?php
declare(strict_types=1);

namespace Training\Feedback\Block\Adminhtml\Feedback\Edit;

use Magento\Backend\Block\Widget\Context;

class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @param Context $context
     * @param BlockRepositoryInterface $blockRepository
     */
    public function __construct(
        Context $context
    ) {
        $this->context = $context;
    }

    public function getFeedbackId()
    {
        return (int)$this->context->getRequest()->getParam('feedback_id');
    }
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
