<?php

namespace Vaimo\QuoteModule\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Quote
 * @package Vaimo\QuoteModule\Model\ResourceModel
 */
class Quote extends AbstractDb
{

    /**
     *
     */
    protected function _construct()
    {
        $this->_init('vaimo_quote_module', 'quote_id');
    }
}