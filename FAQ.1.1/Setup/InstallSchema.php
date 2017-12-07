<?php
namespace Magestore\FAQ\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
/**
 * Class InstallSchema
 * @package Magestore\Magestore_FAQ\Setup
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

//        die('123');
        $installer = $setup;
        $installer->startSetup();
        /*
         * Drop tables if exists
         */
        $installer->
        getConnection()->dropTable($installer->getTable('faq'));
        $installer->getConnection()->dropTable($installer->getTable('faq_category'));
        $installer->getConnection()->dropTable($installer->getTable('faq_category_value'));
        $installer->getConnection()->dropTable($installer->getTable('faq_value'));

        /*
         * Create table
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('faq')
        )->addColumn(
            'faq_id',Table::TYPE_INTEGER,null,
            ['identity'=>true,'nullable'=>false,'primary'=>true],
            'faq ID'
        )->addColumn(
            'title',Table::TYPE_TEXT,255,
            ['nullable'=>false,'default'=>''],
            'faq Title'
        )->addColumn(
            'category_id',Table::TYPE_INTEGER,null,
            ['nullable'=>false,'default'=>'0'],
            'faq_category id'
        )->addColumn(
            'description',Table::TYPE_TEXT,null,
            ['nullable'=>false],
            'faq_description '
        )->addColumn(
            'status',Table::TYPE_SMALLINT,null,
            ['nullable'=>false,'default'=>'1'],
            'faq Status'
        )->addColumn(
            'create_time',Table::TYPE_DATETIME,null,
            ['nullable'=>true],
            'faq create_time'
        )->addColumn(
            'update_time',Table::TYPE_DATETIME,null,
            ['nullable'=>true],
            'faq update_time'
        )->addColumn(
            'url_key',Table::TYPE_TEXT,255,
            ['nullable'=>false,'default'=>''],
            'faq url_key'
        )->addColumn(
            'ordering',Table::TYPE_INTEGER,null,
            ['nullable'=>false,'default'=>'0'],
            'faq ordering'
        )->addColumn(
            'most_frequently',Table::TYPE_SMALLINT,null,
            ['nullable'=>false,'default'=>'1'],
            'faq most_frequently'
        )->addColumn(
            'tag',Table::TYPE_TEXT,255,
            ['nullable'=>true],
            'faq tag'
        )->addColumn(
            'metakeyword',Table::TYPE_TEXT,null,
            ['nullable'=>true],
            'faq metakeyword'
        )->addColumn(
            'metadescription',Table::TYPE_TEXT,null,
            ['nullable'=>true],
            'faq metadescription'
        )->addForeignKey(
            $installer->getFkName(
                'faq',
                'category_id',
                'faq_category',
                'category_id'
            ),
            'category_id',
            $installer->getTable('faq_category'),
            'category_id',
            Table::ACTION_CASCADE
        )->addIndex(
            $installer->getIdxName('faq',['category_id']),
            ['category_id']
        );
        //create table
        $installer->getConnection()->createTable($table);
        //create new table

        $table = $installer->getConnection()->newTable(
            $installer->getTable('faq_category')
        )->addColumn(
            'category_id',Table::TYPE_INTEGER,null,
            ['identity'=>true,'nullable'=>false,'primary'=>true],
            'category ID'
        )->addColumn(
            'name',Table::TYPE_TEXT,255,
            ['nullable'=>false],
            'category name'
        )->addColumn(
            'ordering',Table::TYPE_INTEGER,null,
            ['nullable'=>false,'default'=>'1'],
            'category ordering'
        )->addColumn(
            'status',Table::TYPE_SMALLINT,null,
            ['nullable'=>false,'default'=>'0'],
            'category status'
        );
        //create Table
        $installer->getConnection()->createTable($table);
        //create new table
        $table = $installer->getConnection()->newTable(
            $installer->getTable('faq_value')
        )->addColumn(
            'faq_value_id',Table::TYPE_INTEGER,null,
            ['identity'=>true,'nullable'=>false,'primary'=>true],
            'faq_value ID'
        )->addColumn(
            'faq_id',Table::TYPE_INTEGER,null,
            ['nullable'=>false],
            'faq_value faq_id'
        )->addColumn(
            'store_id',Table::TYPE_SMALLINT,null,
            ['nullable'=>false,'unsigned'=>true],
            'faq_value store_id'
        )->addColumn(
            'attribute_code',Table::TYPE_TEXT,255,
            ['nullable'=>false],
            'faq_value attribute_code'
        )->addColumn(
            'value',Table::TYPE_TEXT,null,
            ['nullable'=>false],
            'faq_value value'
        )->addForeignKey(
            $installer->getFkName(
                'faq_value',
                'faq_id',
                'faq',
                'faq_id'
            ),
            'faq_id',
            $installer->getTable('faq'),
            'faq_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName(
                'faq_value',
                'store_id',
                'store',
                'store_id'
            ),
            'store_id',
            $installer->getTable('store'),
            'store_id',
            Table::ACTION_CASCADE
        )->addIndex($installer->getIdxName('faq_value',['faq_id']),
            ['faq_id']
        );

        //create Table
        $installer->getConnection()->createTable($table);

        //create table
        $table = $installer->getConnection()->newTable(
            $installer->getTable('faq_category_value')
        )->addColumn(
            'category_value_id',Table::TYPE_INTEGER,null,
            ['identity'=>false,'nullable'=>false,'primary'=>true],
            'faq_c_v category_value_id'
        )->addColumn(
            'category_id',Table::TYPE_INTEGER,null,
            ['nullable'=>false],
            'faq_c_v category_id'
        )->addColumn(
            'store_id',Table::TYPE_SMALLINT,null,
            ['nullable'=>false,'unsigned'=>true],
            'faq_c_v store_id'
        )->addColumn(
            'attribute_code',Table::TYPE_TEXT,255,
            ['nullable'=>false],
            'faq_c_v attribute_code'
        )->addColumn(
            'value',Table::TYPE_TEXT,null,
            ['nullable'=>false],
            'faq_c_v value'
        )->addForeignKey(
            $installer->getFkName(
                'faq_category_value',
                'category_id',
                'faq_category',
                'category_id'
            ),
            'category_id',
            $installer->getTable('faq_category'),
            'category_id',
            Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName(
                'faq_category_value',
                'store_id',
                'store',
                'store_id'
            ),
            'store_id',
            $installer->getTable('store'),
            'store_id',
            Table::ACTION_CASCADE
        )
        ;

        $installer->getConnection()->createTable($table);
        $installer->endSetup();
    }
}