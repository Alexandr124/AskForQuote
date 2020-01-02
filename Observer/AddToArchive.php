<?php
namespace Vaimo\QuoteModule\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\CouldNotSaveException;
use Vaimo\QuoteModule\Model\ArchiveFactory;

use Vaimo\QuoteModule\Model\ArchiveRepository as Repository;


/**
 * Class AddToArchive
 * @package Vaimo\QuoteModule\Observer
 */
class AddToArchive implements ObserverInterface
{
    /**
     * @var Repository
     */
    protected $repository;
    /**
     * @var ArchiveFactory
     */
    protected $modelFactory;

    /**
     * AddToArchive constructor.
     * @param Repository $repostitory
     * @param ArchiveFactory $factory
     */
    public function __construct(

        Repository $repostitory,
        ArchiveFactory $factory
    ) {
        $this->repository = $repostitory;
        $this->modelFactory   = $factory;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $deletedQuote = $observer->getData('deletedModel');
        $model = $this->modelFactory->create();


        $model->setCustomerFirstName($deletedQuote->getCustomerFirstName());
        $model->setCustomerLastName($deletedQuote->getCustomerLastName());
        $model->setCustomerPhoneNumber($deletedQuote->getCustomerPhoneNumber());
        $model->setCustomerEmail($deletedQuote->getCustomerEmail());
        $model->setCustomerComment($deletedQuote->getCustomerComment());
        $model->setQuoteDate($deletedQuote->getQuoteDate());



        try {
            $this->repository->save($model);
        } catch (CouldNotSaveException $e) {
        }

    }
}