<?php
namespace Vaimo\QuoteModule\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\CouldNotSaveException;
use Vaimo\QuoteModule\Model\ArchiveFactory;

use Vaimo\QuoteModule\Model\ArchiveRepository as Repository;


class AddToArchive implements ObserverInterface
{
    protected $repository;
    protected $modelFactory;

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

        $model->setFirstName($deletedQuote->getFirstName());
        $model->setLastName($deletedQuote->getLastName());
        $model->setPhoneNumber($deletedQuote->getPhoneNumber());
        $model->setMail($deletedQuote->getMail());
        $model->setComment($deletedQuote->getComment());
        $model->setQuoteDate($deletedQuote->getQuoteDate());


        try {
            $this->repository->save($model);
        } catch (CouldNotSaveException $e) {
        }

    }
}