<?php

namespace Vaimo\QuoteModule\Model\Command;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Reports\Test\Block\Adminhtml\Viewed\Action;
use Vaimo\QuoteModule\Api\Data\QuoteInterface;

use Psr\Log\LoggerInterface;

class DeleteByPath
{
    /**
     *
     */
    const TABLE_MEDIA_GALLERY_ASSET = 'vaimo_quote_module';

    private $resourceConnection;

    private $logger;

    public function __construct(
        ResourceConnection $resourceConnection,
        LoggerInterface $logger
    ) {
        $this->resourceConnection = $resourceConnection;
        $this->logger = $logger;
    }

    public function execute($id)
    {
        try {
            /** @var AdapterInterface $connection */
            $connection = $this->resourceConnection->getConnection();
            $tableName = $this->resourceConnection->getTableName(self::TABLE_MEDIA_GALLERY_ASSET);
            $connection->delete($tableName, [QuoteInterface::ID_FIELD . ' = ?' => $id]);
        } catch (\Exception $exception) {
            $this->logger->critical($exception);
            $message = __(
                'Could not delete media asset with path %path: %error',
                ['path' => $id, 'error' => $exception->getMessage()]
            );
            throw new CouldNotDeleteException($message, $exception);
        }

    }
}