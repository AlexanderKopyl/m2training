<?php /** @noinspection PhpSignatureMismatchDuringInheritanceInspection */

namespace Training\Test\Plugin\Block\Product\View;

class Description extends \Magento\Catalog\Block\Product\View\Description
{
    public function beforeToHtml(
        \Magento\Catalog\Block\Product\View\Description $subject
    ) {
        $subject->getProduct()->setDescription('Test Description');
    }
}
