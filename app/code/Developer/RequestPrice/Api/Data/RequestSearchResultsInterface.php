<?php


namespace Developer\RequestPrice\Api\Data;
use Magento\Framework\Api\SearchResultsInterface;

interface RequestSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get Request list.
     *
     * @return \Developer\RequestPrice\Api\Data\RequestInterface[]
     */
    public function getItems();
    /**
     * Set Request list.
     *
     * @param \Developer\RequestPrice\Api\Data\RequestInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
