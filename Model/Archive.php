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

/**
 * Class Archive
 * @package Vaimo\QuoteModule\Model
 */
class Archive extends AbstractModel implements QuoteInterface
{


    /**
     *
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @return mixed
     */
    public function getQuoteId()
    {
        return $this->getData(QuoteInterface::ID_FIELD);
    }

    /**
     * @return mixed
     */
    public function getCustomerFirstName()
    {
        return $this->getData(QuoteInterface::CUSTOMER_FIRST_NAME);
    }

    /**
     * @param $customer_first_name
     * @return mixed|void
     */
    public function setCustomerFirstName($customer_first_name)
    {
        $this->setData(QuoteInterface::CUSTOMER_FIRST_NAME, $customer_first_name);
    }

    /**
     * @return mixed
     */
    public function getCustomerLastName()
    {
        return $this->getData(QuoteInterface::LAST_NAME);
    }

    /**
     * @param $name
     * @return mixed|void
     */
    public function setCustomerLastName($name)
    {
        $this->setData(QuoteInterface::LAST_NAME, $name);
    }

    /**
     * @return mixed
     */
    public function getCustomerPhoneNumber()
    {
        return $this->getData(QuoteInterface::PHONE_NUMBER);
    }

    /**
     * @param $number
     * @return mixed|void
     */
    public function setCustomerPhoneNumber($number)
    {
        $this->setData(QuoteInterface::PHONE_NUMBER, $number);
    }

    /**
     * @return mixed
     */
    public function getCustomerComment()
    {
        return $this->getData(QuoteInterface::COMMENT);
    }

    /**
     * @param $comment
     * @return mixed|void
     */
    public function setCustomerComment($comment)
    {
        $this->setData(QuoteInterface::COMMENT, $comment);
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->getData(QuoteInterface::QUOTE_STATUS);
    }

    /**
     * @param $quote_status
     * @return mixed|void
     */
    public function setStatus($quote_status)
    {
        $this->setData(QuoteInterface::QUOTE_STATUS, $quote_status);
    }

    /**
     * @return mixed
     */
    public function getCustomerEmail()
    {
        return $this->getData(QuoteInterface::MAIL);
    }

    /**
     * @param $customer_email
     * @return mixed|void
     */
    public function setCustomerEmail($customer_email)
    {
        $this->setData(QuoteInterface::MAIL, $customer_email);
    }

    /**
     * @return mixed
     */
    public function getQuoteDate()
    {
        return $this->getData(QuoteInterface::QUOTE_DATE);
    }

    /**
     * @param $quote_date
     */
    public function setQuoteDate($quote_date)
    {
        $this->setData(QuoteInterface::QUOTE_DATE, $quote_date);
    }
}