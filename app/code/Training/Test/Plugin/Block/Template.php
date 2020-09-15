<?php

namespace Training\Test\Plugin\Block;

class Template
{
    public function afterToHtml(
        \Magento\Framework\View\Element\Template $subject,
        $result
    ) {
        if ($subject->getTemplate() == 'Magento_Search::form.mini.phtml') {
            $result = '<div><p>' . $subject->getTemplate() . '</p>' .
                '<p>' . get_class($subject) . '</p>' . $result . "</div>";
        }

        return $result;
    }
}
