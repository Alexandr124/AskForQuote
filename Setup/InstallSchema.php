<?php

namespace Vaimo\QuoteModule\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

/**
 * Class InstallSchema
 * @package Vaimo\QuoteModule\Setup
 */
class InstallSchema implements InstallSchemaInterface
{


    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $table = $setup->getConnection()->newTable(
            $setup->getTable('vaimo_quote_module')
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
        )->addColumn(
            'status',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['default' => 'pending'],
            'Quote Status'

        )->setComment(
            'Table'
        );
        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}