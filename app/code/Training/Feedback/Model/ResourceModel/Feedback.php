<?php


namespace Training\Feedback\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Feedback extends AbstractDb
{

    protected function _construct()
    {
        // TODO: Implement _construct() method.
        $this->_init('training_feedback', 'feedback_id');
    }
}
