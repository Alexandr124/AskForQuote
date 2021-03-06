<?php
/**
 * Created by PhpStorm.
 * User: alexander
 * Date: 2019-11-06
 * Time: 09:34
 */

namespace Vaimo\QuoteModule\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

use Vaimo\QuoteModule\Api\Data\QuoteInterface;
use Vaimo\QuoteModule\Api\QuoteRepositoryInterface;
use Vaimo\QuoteModule\Model\ResourceModel\Archive as ResourceModel;
use Vaimo\QuoteModule\Model\ResourceModel\Archive\CollectionFactory;


/**
 * Class ArchiveRepository
 * @package Vaimo\QuoteModule\Model
 */
class ArchiveRepository implements QuoteRepositoryInterface
{

    /**
     * @var ResourceModel
     */
    protected $resource;
    /**
     * @var ArchiveFactory
     */
    protected $archiveFactory;
    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var ResourceModel
     */
    private $resourceModel;

    /**
     * ArchiveRepository constructor.
     * @param ResourceModel $resource
     * @param ArchiveFactory $archiveFactory
     * @param ResourceModel $resourceModel
     * @param CollectionProcessorInterface $collectionProcessor
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        ResourceModel $resource,
        ArchiveFactory $archiveFactory,
        \Vaimo\QuoteModule\Model\ResourceModel\Archive $resourceModel,
        CollectionProcessorInterface $collectionProcessor,
        CollectionFactory $collectionFactory

    ) {
        $this->resource                 = $resource;
        $this->resourceModel            = $resourceModel;
        $this->archiveFactory           = $archiveFactory;
        $this->collectionProcessor      = $collectionProcessor;
        $this->collectionFactory        = $collectionFactory;
    }


    /**
     * @param $id
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $quote = $this->archiveFactory->create();
        $this->resource->load($quote, $id);
        if (!$quote->getId()) {
            throw new NoSuchEntityException(__('Quote with id "%1" does not exist.', $id));
        }
        return $quote;
    }


    /**
     * @param $id
     * @return mixed|void
     */
    public function deleteById($id)
    {
        try {
            $this->delete($this->getById($id));
        } catch (CouldNotDeleteException $e) {
        } catch (NoSuchEntityException $e) {
        }
    }


    /**
     * @param QuoteInterface $archive
     * @return mixed|QuoteInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(QuoteInterface $archive)
    {
        try {
            $this->resourceModel->save($archive);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__($exception->getMessage()));
        }
        return $archive;

    }
    /** {@inheritdoc} */
    public function delete(QuoteInterface $archive)
    {
        try {
            $this->resource->delete($archive);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return $this;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        // TODO: Implement getList() method.
    }
}