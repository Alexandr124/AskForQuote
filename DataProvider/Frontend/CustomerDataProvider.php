<?php

namespace Vaimo\QuoteModule\DataProvider\Frontend;

use Magento\Customer\Model\SessionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

use Vaimo\QuoteModule\Model\ResourceModel\Quote\CollectionFactory;
use Vaimo\QuoteModule\Model\QuoteFactory;

/**
 * Class CustomerDataProvider
 * @package Vaimo\QuoteModule\DataProvider\Frontend
 */
class CustomerDataProvider extends AbstractDataProvider
{
    /**
     * @var QuoteFactory
     */
    private $quoteFactory;
    /**
     * @var SessionFactory
     */
    private $sessionFactory;



    public function __construct(SessionFactory $sessionFactory,
                                QuoteFactory $quoteFactory,
                                CollectionFactory $collectionFactory ,
                                \Magento\Framework\Stdlib\DateTime\DateTime $date,
                                $name,
                                $primaryFieldName,
                                $requestFieldName,
                                array $meta = [],
                                array $data = []
    ) {
        $this->sessionFactory    = $sessionFactory;
        $this->quoteFactory = $quoteFactory;
        $this->date = $date;
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        if ($this->sessionFactory->create()->getCustomer()) {
            $name  = $this->sessionFactory->create()->getCustomer()->getCustomerFirstName();
            $surname  = $this->sessionFactory->create()->getCustomer()->getCustomerLastname();
            $email = $this->sessionFactory->create()->getCustomer()->getEmail();

            $date = $this->date->gmtDate('Y-m-d');
            $model = $this->quoteFactory->create();
            $model->setCustomerFirstName($name);
            $model->setCustomerLastName($surname);
            $model->setQuoteDate($date);
            $model->setCustomerEmail($email);

            return [$model->getId() => $model->getData()];
        }
        return [0 =>['hello'=>'chose please date and time']];
    }
}