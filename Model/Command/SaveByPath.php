<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vaimo\QuoteModule\Model\Command;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\CouldNotSaveException;
use Psr\Log\LoggerInterface;

use Vaimo\QuoteModule\Api\Data\QuoteInterface;
use Vaimo\QuoteModule\Model\DataExtractorInterface;

/**
 * Class SaveByPath
 */
class SaveByPath
{
    const TABLE_MEDIA_GALLERY_ASSET = 'vaimo_quote_module';

    private $resourceConnection;

    private $extractor;

    private $logger;

    public function __construct(
        ResourceConnection $resourceConnection,
        DataExtractorInterface $extractor,
        LoggerInterface $logger
    ) {
        $this->resourceConnection = $resourceConnection;
        $this->extractor = $extractor;
        $this->logger = $logger;
    }

    public function execute(QuoteInterface $quote)
    {
        try {
            /** @var \Magento\Framework\DB\Adapter\Pdo\Mysql $connection */
            $connection = $this->resourceConnection->getConnection();
            $tableName = $this->resourceConnection->getTableName(self::TABLE_MEDIA_GALLERY_ASSET);
            $connection->insertOnDuplicate($tableName, $this->extractor->extract($quote, QuoteInterface::class));
            return $quote;

        } catch (\Exception $exception) {
            $this->logger->critical($exception);
            $message = __('An error occurred during media asset save: %1', $exception->getMessage());
            throw new CouldNotSaveException($message, $exception);
        }
    }
}