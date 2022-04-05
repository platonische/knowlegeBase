<?php

namespace Smart\CustomerValidate\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

class UpgradeData implements UpgradeDataInterface
{
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.1', '<')) {

            $setup->startSetup();
            $connection = $setup->getConnection();

            $connection->update(
                $connection->getTableName('eav_attribute'),
                ['frontend_class'=> 'validate-alphanum'],
                ['attribute_code IN(?)' => ['firstname','lastname']]
            );

            $connection->update(
                $connection->getTableName('eav_attribute'),
                ['frontend_class'=> 'validate-phone'],
                ['attribute_code = ?' => 'telephone']
            );

            $connection->update(
                $connection->getTableName('customer_eav_attribute'),
                ['validate_rules'=> '{"max_text_length":255,"min_text_length":1,"validate-alphanum":true}'],
                ['attribute_id IN(?)' => $connection->select()
                    ->from(
                        ['EA' => $connection->getTableName('eav_attribute')],
                        ['EA.attribute_id']
                    )->where('attribute_code IN("firstname","lastname")')]
                );

            $connection->update(
                $connection->getTableName('customer_eav_attribute'),
                ['validate_rules'=> '{"max_text_length":255,"min_text_length":1,"validate-phone":true}'],
                ['attribute_id = ?' => $connection->select()
                    ->from(
                        ['EA' => $connection->getTableName('eav_attribute')],
                        ['EA.attribute_id']
                    )->where('attribute_code = "telephone"')]
                );
        }
    }
}