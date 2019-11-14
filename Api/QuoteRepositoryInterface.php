<?php
/**
 * Created by PhpStorm.
 * User: alexander
 * Date: 2019-11-10
 * Time: 22:03
 */

namespace Vaimo\QuoteModule\Api;


interface QuoteRepositoryInterface
{
    /**
     * @param $id
     * @return mixed
     */
    public function getById($id);

    /**
     * @param $id
     * @return mixed
     */
    public function deleteById($id);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * @param Data\QuoteInterface $quote
     * @return mixed
     */
    public function delete(\Vaimo\QuoteModule\Api\Data\QuoteInterface $quote);

    /**
     * @param Data\QuoteInterface $quote
     * @return mixed
     */
    public function save(\Vaimo\QuoteModule\Api\Data\QuoteInterface $quote);
}