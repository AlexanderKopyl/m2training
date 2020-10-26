<?php


namespace Developer\ManyStore\Model\Config\Source;


use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Language extends AbstractSource
{
    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $this->_options = [
                ['value' => '', 'label' => __('Please Select')],
                ['value' => '1', 'label' => __('En')],
                ['value' => '2', 'label' => __('De')],
                ['value' => '3', 'label' => __('Fr')]
            ];
        }
        return $this->_options;
    }

    /**
     * Get text of the option value
     *
     * @param string|integer $value
     * @return string|bool
     */
    public function getOptionValue($value)
    {
        foreach ($this->getAllOptions() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return false;
    }
}
