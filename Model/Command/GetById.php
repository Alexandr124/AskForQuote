<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vaimo\QuoteModule\Model\Command;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\IntegrationException;
use Magento\Framework\Exception\NoSuchEntityException;

use Vaimo\QuoteModule\Api\Data\QuoteInterface;
use Vaimo\QuoteModule\Model\QuoteFactory;

use Psr\Log\LoggerInterface;
/**
 * Class GetById
 */
class GetById
{
    const TABLE_VAIMO_QUOTE_ASSET = 'vaimo_quote_module';
    /**
     * @var ResourceConnection
     */
    private $resourceConnection;
    /**
     * @var QuoteInterface
     */
    private $assetFactory;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * GetById constructor.
     *
     * @param ResourceConnection $resourceConnection
     * @param QuoteFactory $assetFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        ResourceConnection $resourceConnection,
        QuoteFactory $assetFactory,
        LoggerInterface $logger
    ) {
        $this->resourceConnection = $resourceConnection;
        $this->assetFactory = $assetFactory;
        $this->logger = $logger;
    }
    /**
     * Get media asset.
     *
     * @param int $mediaAssetId
     *
     * @return QuoteInterface
     * @throws NoSuchEntityException
     * @throws IntegrationException
     */
    public function execute(int $mediaAssetId): QuoteInterface
    {
        try {
            $mediaAssetTable = $this->resourceConnection->getTableName(self::TABLE_VAIMO_QUOTE_ASSET);
            $connection = $this->resourceConnection->getConnection();
            $select = $connection->select()
                ->from(['amg' => $mediaAssetTable])
                ->where('quote_id = ?', $mediaAssetId);
            $mediaAssetData = $connection->query($select)->fetch();
        } catch (\Exception $exception) {
            $this->logger->critical($exception);
            $message = __(
                'En error occurred during get media asset data by id %id: %error',
                ['id' => $mediaAssetId, 'error' => $exception->getMessage()]
            );
            throw new IntegrationException($message, $exception);
        }
        if (empty($mediaAssetData)) {
            $message = __('There is no such media asset with id %id', ['id' => $mediaAssetId]);
            throw new NoSuchEntityException($message);
        }
        try {
            return $this->assetFactory->create(['data' => $mediaAssetData]);
        } catch (\Exception $exception) {
            $this->logger->critical($exception);
            $message = __(
                'En error occurred during initialize media asset with id %id: %error',
                ['id' => $mediaAssetId, 'error' => $exception->getMessage()]
            );
            throw new IntegrationException($message, $exception);
        }
    }
}