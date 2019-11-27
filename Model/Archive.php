<?php
/**
 * Created by PhpStorm.
 * User: alexander
 * Date: 2019-11-10
 * Time: 21:53
 */

namespace Vaimo\QuoteModule\Model;

use Magento\Framework\Model\AbstractModel;
use Vaimo\QuoteModule\Model\ResourceModel\Archive as ResourceModel;
use Vaimo\QuoteModule\Api\Data\QuoteInterface;

class Archive extends AbstractModel implements QuoteInterface
{

    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    public function getQuoteId()
    {
        return $this->getData(QuoteInterface::ID_FIELD);
    }

    public function getCustomerFirstName()
    {
        return $this->getData(QuoteInterface::CUSTOMER_FIRST_NAME);
    }

    public function setCustomerFirstName($customer_first_name)
    {
        $this->setData(QuoteInterface::CUSTOMER_FIRST_NAME, $customer_first_name);
    }

    public function getCustomerLastName()
    {
        return $this->getData(QuoteInterface::LAST_NAME);
    }

    public function setCustomerLastName($name)
    {
        $this->setData(QuoteInterface::LAST_NAME, $name);
    }

    public function getCustomerPhoneNumber()
    {
        return $this->getData(QuoteInterface::PHONE_NUMBER);
    }

    public function setCustomerPhoneNumber($number)
    {
        $this->setData(QuoteInterface::PHONE_NUMBER, $number);
    }

    public function getCustomerComment()
    {
        return $this->getData(QuoteInterface::COMMENT);
    }

    public function setCustomerComment($comment)
    {
        $this->setData(QuoteInterface::COMMENT, $comment);
    }

    public function getStatus()
    {
        return $this->getData(QuoteInterface::QUOTE_STATUS);
    }

    public function setStatus($quote_status)
    {
        $this->setData(QuoteInterface::QUOTE_STATUS, $quote_status);
    }

    public function getCustomerEmail()
    {
        return $this->getData(QuoteInterface::MAIL);
    }

    public function setCustomerEmail($customer_email)
    {
        $this->setData(QuoteInterface::MAIL, $customer_email);
    }

    public function getQuoteDate()
    {
        return $this->getData(QuoteInterface::QUOTE_DATE);
    }

    public function setQuoteDate($quote_date)
    {
        $this->setData(QuoteInterface::QUOTE_DATE, $quote_date);
    }
}