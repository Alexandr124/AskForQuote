<?php

namespace Vaimo\QuoteModule\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

/**
 * Class UpgradeSchema
 * @package Vaimo\QuoteModule\Setup
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        //handle all possible upgrade versions

        if(!$context->getVersion()) {
            //no previous version found, installation, InstallSchema was just executed
            //be careful, since everything below is true for installation !
        }

        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('vaimo_quote_module'),
                'customer_email',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => false,
                    'default' => '',
                    'comment' => 'Customer eMail'
                ]
            );
        }

        if (version_compare($context->getVersion(), '1.0.3', '<')) {
            $table = $setup->getConnection()->newTable(
                $setup->getTable('vaimo_quote_archive')
            )->addColumn(
                'quote_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Id'
            )->addColumn(
                'customer_first_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'First Name'
            )->addColumn(
                'customer_last_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Last Name'
            )->addColumn(
                'customer_phone_number',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Phone Number'
            )->addColumn(
                'customer_email',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Phone email'
            )->addColumn(
                'customer_comment',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Comment'
            )->addColumn(
                'quote_date',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATE,
                255,
                [],
                'Date of receiving a quote'
            )->setComment(
                'Table'
            );
            $setup->getConnection()->createTable($table);

        }

        $setup->endSetup();
    }
}