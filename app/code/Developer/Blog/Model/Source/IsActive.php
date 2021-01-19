<?php


namespace Developer\Blog\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Developer\Blog\Model\Post;


class IsActive implements OptionSourceInterface
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
                'label' => __('Published'),
                'value' => Post::STATUS_ACTIVE
            ],
            [
                'label' => __('Not published'),
                'value' => Post::STATUS_INACTIVE
            ]
        ];
    }
}
