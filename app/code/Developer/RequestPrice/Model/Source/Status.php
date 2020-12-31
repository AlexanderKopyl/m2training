<?php

namespace Developer\RequestPrice\Model\Source;

use Developer\RequestPrice\Model\Request;
use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'label' => __('New'),
                'value' => Request::STATUS_NEW
            ],
            [
                'label' => __('In Progress'),
                'value' => Request::STATUS_IN_PROGRESS
            ],
            [
                'label' => __('Closed'),
                'value' => Request::STATUS_CLOSED
            ]
        ];
    }
}
