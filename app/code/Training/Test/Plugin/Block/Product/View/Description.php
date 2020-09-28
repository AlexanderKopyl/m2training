<?php /** @noinspection PhpSignatureMismatchDuringInheritanceInspection */

namespace Training\Test\Plugin\Block\Product\View;

class Description extends \Magento\Catalog\Block\Product\View\Description
{
    public function beforeToHtml(
        \Magento\Catalog\Block\Product\View\Description $subject
    ) {
        // exercise 3.4
//        $subject->getProduct()->setDescription('Test Description');
        // exercise 3.7
        $subject->setTemplate('Training_Test::description.phtml');
    }
}
