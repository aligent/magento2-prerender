<?php
/*
 * Copyright (c) Aligent. All rights reserved.
 */

namespace Aligent\Prerender\Model\Filter;

use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;

class DisabledEntityFilter
{
    /** @var ProductCollectionFactory */
    protected $productCollectionFactory;
    /** @var CategoryCollectionFactory */
    protected $categoryCollectionFactory;

    /**
     * @param ProductCollectionFactory $productCollectionFactory
     * @param CategoryCollectionFactory $categoryCollectionFactory
     */
    public function __construct(
        ProductCollectionFactory $productCollectionFactory,
        CategoryCollectionFactory $categoryCollectionFactory
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
    }

    /**
     * Filter disabled product ids
     *
     * @param array $productIds
     * @return array
     */
    public function filterDisabledProducts(array $productIds): array
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addFieldToFilter('entity_id', ['in' => $productIds])
            ->addFieldToFilter('status', ['neq' => Status::STATUS_DISABLED]);

        return $collection->getAllIds();
    }

    /**
     * Filter Disabled Category ids
     *
     * @param array $categoryIds
     * @return array
     */
    public function filterDisabledCategories(array $categoryIds): array
    {
        $collection = $this->categoryCollectionFactory->create();
        $collection->addFieldToFilter('entity_id', ['in' => $categoryIds])
            ->addFieldToFilter('is_active', ['neq' => 0]);

        return $collection->getAllIds();
    }
}
