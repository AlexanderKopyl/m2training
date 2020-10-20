<?php


namespace Training\Feedback\Api\Data;


interface FeedbackExtensionInterface extends \Magento\Framework\Api\ExtensionAttributesInterface
{
    public function get();

    public function set();
}
