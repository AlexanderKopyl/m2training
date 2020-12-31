<?php
namespace Developer\RequestPrice\Api;

use Developer\RequestPrice\Api\Data\RequestInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface RequestRepositoryInterface
 *
 * @api
 */
interface RequestRepositoryInterface
{
    /**
     * Create or update a Request.
     *
     * @param RequestInterface $page
     * @return RequestInterface
     */
    public function save(RequestInterface $page);

    /**
     * Get a Request by Id
     *
     * @param int $id
     * @return RequestInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If Request with the specified ID does not exist.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($id);

    /**
     * Retrieve Requests which match a specified criteria.
     *
     * @param SearchCriteriaInterface $criteria
     */
    public function getList(SearchCriteriaInterface $criteria);

    /**
     * Delete a Request
     *
     * @param RequestInterface $page
     * @return RequestInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If Request with the specified ID does not exist.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(RequestInterface $page);

    /**
     * Delete a Request by Id
     *
     * @param int $id
     * @return RequestInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If customer with the specified ID does not exist.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($id);
}
