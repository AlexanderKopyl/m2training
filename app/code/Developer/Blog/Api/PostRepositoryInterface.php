<?php
namespace Developer\Blog\Api;

use Developer\Blog\Api\Data\PostInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface RequestRepositoryInterface
 *
 * @api
 */
interface PostRepositoryInterface
{
    /**
     * Create or update a Request.
     *
     * @param PostInterface $page
     * @return PostInterface
     */
    public function save(PostInterface $page);

    /**
     * Get a Request by Id
     *
     * @param int $id
     * @return PostInterface
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
     * @param PostInterface $page
     * @return PostInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If Request with the specified ID does not exist.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(PostInterface $page);

    /**
     * Delete a Request by Id
     *
     * @param int $id
     * @return PostInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If customer with the specified ID does not exist.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($id);
}
