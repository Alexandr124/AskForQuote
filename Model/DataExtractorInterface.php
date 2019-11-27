<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vaimo\QuoteModule\Model;
/**
 * Extract data from an object using available getters
 */
interface DataExtractorInterface
{
    /**
     * Extract data from an object using available getters (does not process extension attributes)
     *
     * @param object $object
     * @param string|null $interface
     * @return array
     */
    public function extract($object, string $interface = null): array;
}