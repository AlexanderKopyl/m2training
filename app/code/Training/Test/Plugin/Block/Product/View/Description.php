<?php /** @noinspection PhpSignatureMismatchDuringInheritanceInspection */

namespace Training\Test\Plugin\Block\Product\View;

class Description
{
    public function afterGetProduct(
        \Magento\Catalog\Block\Product\View\Description $subject,
        $result
    ) {
        $result->setDescription('Test Description');
        return $result;
    }
}
