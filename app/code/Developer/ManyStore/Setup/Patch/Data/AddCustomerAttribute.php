<?php

declare(strict_types=1);

namespace Developer\ManyStore\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * Add new custom layout related attributes.
 */
class AddCustomerAttribute implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;

    /**
     * PatchInitial constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CustomerSetupFactory $customerSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerSetupFactory = $customerSetupFactory;
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function apply()
    {
        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $customerSetup->addAttribute(
            Customer::ENTITY,
            'store_language',
            [
                'type' => 'int', // <-- also you should add column
                'input' => 'select',
                'label' => 'Language Store',
                'required' => false,
                'user_defined' => true,
                'source' => 'Developer\ManyStore\Model\Config\Source\Language',
                'system' => 0, // <-- important
                'position' => 500,
                'default' => '1',
                'visible' => true,
                'is_used_in_grid' => 1,
                'is_visible_in_grid' => 1,
                'is_filterable_in_grid' => 1,
                'is_searchable_in_grid' => 1,
                'group' => 'General' // <-- must be if 'user_defined' exists
            ]
        );

        $attributeId = $customerSetup->getAttributeId(Customer::ENTITY, 'store_language');
        $data = [
            ['form_code' => 'adminhtml_customer', 'attribute_id' => $attributeId],
            ['form_code' => 'customer_account_create', 'attribute_id' => $attributeId],
            ['form_code' => 'customer_account_edit', 'attribute_id' => $attributeId],
        ];
        $this->moduleDataSetup->getConnection()->insertMultiple(
            $this->moduleDataSetup->getTable('customer_form_attribute'),
            $data
        );
    }
}
