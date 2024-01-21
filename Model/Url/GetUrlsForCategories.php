<?php
/*
 * Copyright (c) Aligent Consulting. All rights reserved.
 */

declare(strict_types=1);
namespace Aligent\Prerender\Model\Url;

use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Url;
use Magento\Store\Model\App\Emulation;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;

class GetUrlsForCategories
{
    private const DELIMETER = "?";

    /**
     *
     * @param CollectionFactory $categoryCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param Emulation $emulation
     */
    public function __construct(
        private readonly CollectionFactory $categoryCollectionFactory,
        private readonly StoreManagerInterface $storeManager,
        private readonly Emulation $emulation,
        private readonly Url $url
    ) {
    }

    /**
     * Generate category URLs based on URL_REWRITE entries
     *
     * @param array $categoryIds
     * @param int $storeId
     * @return array
     */
    public function execute(array $categoryIds, int $storeId): array
    {
        $categoryCollection = $this->categoryCollectionFactory->create();
        // if array of category ids is empty, just load all categories
        if (!empty($categoryIds)) {
            $categoryCollection->addIdFilter($categoryIds);
        }
        $categoryCollection->setStoreId($storeId);
        $categoryCollection->addUrlRewriteToResult();

        try {
            /** @var Store $store */
            $store = $this->storeManager->getStore($storeId);
        } catch (NoSuchEntityException $e) {
            return [];
        }

        $this->emulation->startEnvironmentEmulation($storeId);
        $urls = [];
        /** @var Category $category */
        foreach ($categoryCollection as $category) {
            $urlPath = $category->getData('request_path');
            if (empty($urlPath)) {
                continue;
            }
            try {
                $url = $this->url->getUrl($urlPath, ['_scope_to_url' => true]);

                // remove trailing slashes and parameters from the url
                $urls[] = substr($url, 0, strrpos($url, '/'));
            } catch (NoSuchEntityException $e) {
                continue;
            }
        }
        $this->emulation->stopEnvironmentEmulation();
        return $urls;
    }
}
