<?php
declare(strict_types=1);

namespace Developer\Blog\Block\Post;

use Magento\Framework\View\Element\Template;

class Index extends Template
{
    /**
     * @var \Developer\Blog\Model\ResourceModel\Post\CollectionFactory
     */
    private $postsCollectionFactory;

    /**
     * Index constructor.
     * @param \Developer\Blog\Model\ResourceModel\Post\CollectionFactory $postCollectionFactory
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Developer\Blog\Model\ResourceModel\Post\CollectionFactory $postCollectionFactory,
        Template\Context $context,
        array $data = []
    ) {
        $this->postsCollectionFactory = $postCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getCollectionPosts()
    {
        $collection = $this->postsCollectionFactory->create();
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 4;

        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);

//        $collection->getSelect()->join(
//            ['bpd' => $collection->getTable('blog_posts_description')],
//            "main_table.post_id=bpd.post_id"
//        );

        return $collection;
    }

    /**
     * @return $this|Index
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getCollectionPosts()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'blog.post.pager'
            )->setShowAmounts(false)
            ->setAvailableLimit(
                [4 => 4, 8 => 8, 16 => 16, 32 => 32]
            )->setShowPerPage(true)
            ->setCollection($this->getCollectionPosts());
            $this->setChild('pager', $pager);
            $this->getCollectionPosts();
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
}
