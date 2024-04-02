<?php
/*
 * Copyright (c) Aligent Consulting. All rights reserved.
 */

declare(strict_types=1);

namespace Aligent\Prerender\Model\Indexer\DataProvider;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;

class ProductCategories
{
    /**
     * @param ProductCollectionFactory $productCollectionFactory
     * @param CategoryCollectionFactory $categoryCollectionFactory
     */
    public function __construct(
        private readonly ProductCollectionFactory $productCollectionFactory,
        private readonly CategoryCollectionFactory $categoryCollectionFactory
    ) {
    }

    /**
     * Get complete list of categories containing one or more of the given products
     *
     * @param array $productIds
     * @param int $storeId
     * @return array
     */
    public function getCategoryIdsForProducts(array $productIds, int $storeId): array
    {
        // if array of product ids is empty, just load all categories
        if (empty($productIds)) {
            $categoryCollection = $this->categoryCollectionFactory->create();
            $categoryCollection->setStoreId($storeId);
            return $categoryCollection->getAllIds();
        }

        $productCollection = $this->productCollectionFactory->create();
        $productCollection->addIdFilter($productIds);
        $productCollection->setStoreId($storeId);
        // add category information
        $productCollection->addCategoryIds();

        $categoryIds = [];
        /** @var Product $product */
        foreach ($productCollection->getItems() as $product) {
            $categoryIds[] = $product->getCategoryIds();
        }
        return array_unique(array_merge(...$categoryIds));
    }
}
