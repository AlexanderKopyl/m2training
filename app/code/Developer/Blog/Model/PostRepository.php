<?php
namespace Developer\Blog\Model;

use Developer\Blog\Api\PostRepositoryInterface;
use Developer\Blog\Api\Data\PostInterface;
use Developer\Blog\Model\ResourceModel\Post as ObjectResourceModel;
use Developer\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\EntityManager\HydratorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class PostRepository
 */
class PostRepository implements PostRepositoryInterface
{
    protected $objectFactory;
    /**
     * @var ObjectResourceModel
     */
    protected $objectResourceModel;
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
    /**
     * @var SearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;
    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;
    /**
     * @var HydratorInterface|null
     */
    private ?HydratorInterface $hydrator;

    /**
     * PostRepository constructor.
     *
     * @param PostFactory $objectFactory
     * @param ObjectResourceModel $objectResourceModel
     * @param StoreManagerInterface $storeManager
     * @param CollectionFactory $collectionFactory
     * @param HydratorInterface|null $hydrator
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        PostFactory $objectFactory,
        ObjectResourceModel $objectResourceModel,
        StoreManagerInterface $storeManager,
        CollectionFactory $collectionFactory,
        ?HydratorInterface $hydrator = null,
        SearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->objectFactory        = $objectFactory;
        $this->storeManager = $storeManager;
        $this->objectResourceModel  = $objectResourceModel;
        $this->collectionFactory    = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->hydrator = $hydrator;
    }

    /**
     * @inheritDoc
     *
     * @throws CouldNotSaveException
     */
    public function save(PostInterface $object)
    {
        if ($object->getStoreId() === null) {
            $storeId = $this->storeManager->getStore()->getId();
            $object->setStoreId($storeId);
        }
        $postId = $object->getId();
        try {
            if ($postId) {
                $data_hydrator = $this->hydrator->extract($object);
                $object = $this->hydrator->hydrate($this->getById($postId), $data_hydrator);
            }
            $this->objectResourceModel->save($object);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $object;
    }

    /**
     * @inheritDoc
     */
    public function getById($id)
    {
        $object = $this->objectFactory->create();
        $this->objectResourceModel->load($object, $id);
        if (!$object->getId()) {
            throw new NoSuchEntityException(__('Object with id "%1" does not exist.', $id));
        }
        return $object;
    }

    /**
     * @inheritDoc
     */
    public function delete(PostInterface $object)
    {
        try {
            $this->objectResourceModel->delete($object);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $collection = $this->collectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            $fields = [];
            $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $fields[] = $filter->getField();
                $conditions[] = [$condition => $filter->getValue()];
            }
            if ($fields) {
                $collection->addFieldToFilter($fields, $conditions);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $objects = [];
        foreach ($collection as $objectModel) {
            $objects[] = $objectModel;
        }
        $searchResults->setItems($objects);
        return $searchResults;
    }
}
