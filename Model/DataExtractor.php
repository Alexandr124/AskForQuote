<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Vaimo\QuoteModule\Model;

use Vaimo\QuoteModule\Api\Data\DataExtractorInterface;
/**
 * Extract data from an object using available getters
 */
class DataExtractor implements DataExtractorInterface
{
    /**
     * Extract data from an object using available getters (does not process extension attributes)
     *
     * @param object $object
     * @param string|null $interface
     *
     * @return array
     * @throws \ReflectionException
     */
    public function extract($object, string $interface = null): array
    {
        $data = [];
        $reflectionClass = new \ReflectionClass($interface ?? $object);
        foreach ($reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            $methodName = $method->getName();
            if (strpos($methodName, 'get') !== 0
                || !empty($method->getParameters())
                || strpos($methodName, 'getExtensionAttributes') !== false
            ) {
                continue;
            }
            $value = $object->$methodName();
            if (!empty($value)) {
                $key = strtolower(preg_replace("/([a-z])([A-Z])/", "$1_$2", substr($methodName, 3)));
                $data[$key] = $value;
            }
        }
        return $data;
    }
}