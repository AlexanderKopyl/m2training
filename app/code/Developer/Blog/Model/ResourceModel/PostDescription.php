<?php
declare(strict_types=1);


namespace Developer\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class PostDescription extends AbstractDb
{

    protected function _construct()
    {
        $this->_init('blog_posts_description', 'post_id');
    }
}
