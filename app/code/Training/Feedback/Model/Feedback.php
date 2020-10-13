<?php


namespace Training\Feedback\Model;

use Magento\Framework\Model\AbstractModel;

class Feedback extends AbstractModel
{

    protected $_eventPrefix = 'training_feedback';

    protected function _construct()
    {
        $this->_init(\Training\Feedback\Model\ResourceModel\Feedback::class);
    }
}
