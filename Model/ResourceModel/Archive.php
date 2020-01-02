<?php

namespace Vaimo\QuoteModule\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;


/**
 * Class Archive
 * @package Vaimo\QuoteModule\Model\ResourceModel
 */
class Archive extends AbstractDb
{

    /**
     *
     */
    protected function _construct()
    {
        $this->_init('vaimo_quote_archive', 'quote_id');
    }

}