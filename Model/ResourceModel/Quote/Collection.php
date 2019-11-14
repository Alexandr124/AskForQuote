<?php
/**
 * Created by PhpStorm.
 * User: alexander
 * Date: 2019-11-10
 * Time: 22:21
 */

namespace Vaimo\QuoteModule\Model\ResourceModel\Quote;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Vaimo\QuoteModule\Model\Quote;
use Vaimo\QuoteModule\Model\ResourceModel\Quote as GridResource;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Quote::class, GridResource::class);
    }
}