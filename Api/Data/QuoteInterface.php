<?php
/**
 * Created by PhpStorm.
 * User: alexander
 * Date: 2019-11-10
 * Time: 21:55
 */

namespace Vaimo\QuoteModule\Api\Data;

interface  QuoteInterface
{

    const TABLE_NAME                = 'vaimo_quote_module';

    const ID_FIELD                  = 'quote_id';

    const CUSTOMER_FIRST_NAME       = 'customer_first_name';

    const LAST_NAME                 = 'customer_last_name';

    const PHONE_NUMBER              = 'customer_phone_number';

    const MAIL                      = 'customer_email';

    const COMMENT                   = 'customer_comment';

    const QUOTE_DATE                = 'quote_date';

    const QUOTE_STATUS              = 'status';


    /**
     * @return mixed
     */
    public function getQuoteId();

    public function getCustomerFirstName();

    public function setCustomerFirstName($customer_first_name);

    public function getCustomerLastName();


    public function setCustomerLastName($name);

    /**
     * @return mixed
     */
    public function getCustomerPhoneNumber();

    /**
     * @param $number
     * @return mixed
     */
    public function setCustomerPhoneNumber($number);

    /**
     * @return mixed
     */
    public function getCustomerEmail();

    public function setCustomerEmail($customer_email);

    /**
     * @return mixed
     */
    public function getCustomerComment();

    /**
     * @param $number
     * @return mixed
     */
    public function setCustomerComment($comment);

    /**
     * @return mixed
     */
    public function getStatus();

    /**
     * @param $quote_status
     * @return mixed
     */
    public function setStatus($quote_status);

    public function getQuoteDate();

    public function setQuoteDate($quote_date);

}