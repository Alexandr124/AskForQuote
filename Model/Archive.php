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

    public function getId()
    {
        return $this->getData(QuoteInterface::ID_FIELD);
    }

    public function getFirstName()
    {
        return $this->getData(QuoteInterface::FIRST_NAME);
    }

    public function setFirstName($first_name)
    {
        $this->setData(QuoteInterface::FIRST_NAME, $first_name);
    }

    public function getLastName()
    {
        return $this->getData(QuoteInterface::LAST_NAME);
    }

    public function setLastName($name)
    {
        $this->setData(QuoteInterface::LAST_NAME, $name);
    }

    public function getPhoneNumber()
    {
        return $this->getData(QuoteInterface::PHONE_NUMBER);
    }

    public function setPhoneNumber($number)
    {
        $this->setData(QuoteInterface::PHONE_NUMBER, $number);
    }

    public function getComment()
    {
        return $this->getData(QuoteInterface::COMMENT);
    }

    public function setComment($comment)
    {
        $this->setData(QuoteInterface::COMMENT, $comment);
    }

    public function getQuoteStatus()
    {
        return $this->getData(QuoteInterface::QUOTE_STATUS);
    }

    public function setQuoteStatus($status)
    {
        $this->setData(QuoteInterface::QUOTE_STATUS, $status);
    }

    public function getMail()
    {
        return $this->getData(QuoteInterface::MAIL);
    }

    public function setMail($mail)
    {
        $this->setData(QuoteInterface::MAIL, $mail);
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