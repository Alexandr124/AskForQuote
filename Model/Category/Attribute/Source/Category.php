<?php
/**
 * Created by PhpStorm.
 * User: alexander
 * Date: 2019-11-07
 * Time: 14:56
 */

namespace Vaimo\QuoteModule\Model\Category\Attribute\Source;


class Category implements \Magento\Framework\Option\ArrayInterface
{
    //Below function is supposed to return options.
    public function toOptionArray()
    {
        return [
            ['value' => 'pending', 'label' => 'pending'],
            ['value' => 'open',    'label' => 'open'],
            ['value' => 'closed',  'label' => 'closed']
        ];
    }
}