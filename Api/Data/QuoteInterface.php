<?php
/**
 * Created by PhpStorm.
 * User: alexander
 * Date: 2019-11-10
 * Time: 21:55
 */

namespace Vaimo\QuoteModule\Api\Data;

/**
 * Interface QuoteInterface
 * @package Vaimo\Quote\Api\Data
 */

interface  QuoteInterface
{
    /**
     *table name in my database
     */
    const TABLE_NAME                = 'vaimo_quote_module';

    const ID_FIELD                  = 'quote_id';

    const FIRST_NAME                = 'customer_first_name';

    const LAST_NAME                 = 'customer_last_name';

    const PHONE_NUMBER              = 'customer_phone_number';

    const MAIL                      = 'customer_email';

    const COMMENT                   = 'customer_comment';

    const QUOTE_DATE                = 'quote_date';

    const QUOTE_STATUS              = 'status';



    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return mixed
     */
    public function getFirstName();

    /**
     * @param $first_name
     * @return mixed
     */
    public function setFirstName($first_name);

    /**
     * @return mixed
     */
    public function getLastName();

    /**
     * @param $name
     * @return mixed
     */
    public function setLastName($name);

    /**
     * @return mixed
     */
    public function getPhoneNumber();

    /**
     * @param $number
     * @return mixed
     */
    public function setPhoneNumber($number);

    /**
     * @return mixed
     */
    public function getMail();

    /**
     * @param $number
     * @return mixed
     */
    public function setMail($mail);

    /**
     * @return mixed
     */
    public function getComment();

    /**
     * @param $number
     * @return mixed
     */
    public function setComment($comment);

    /**
     * @return mixed
     */
    public function getQuoteStatus();

    /**
     * @param $status
     * @return mixed
     */
    public function setQuoteStatus($status);

    public function getQuoteDate();

    public function setQuoteDate($quote_date);

}