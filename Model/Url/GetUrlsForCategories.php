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

    /** @var CollectionFactory  */
    private CollectionFactory $categoryCollectionFactory;
    /** @var StoreManagerInterface */
    private StoreManagerInterface $storeManager;
    /** @var Emulation */
    private Emulation $emulation;

    /** @var Url */
    private Url $url;

    /**
     *
     * @param CollectionFactory $categoryCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param Emulation $emulation
     */
    public function __construct(
        CollectionFactory $categoryCollectionFactory,
        StoreManagerInterface $storeManager,
        Emulation $emulation,
        Url $url
    ) {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->storeManager = $storeManager;
        $this->emulation = $emulation;
        $this->url = $url;
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
                // Retrieve URL using store configuration
                $url = $store->getUrl('', ['_direct' => $urlPath]);

                // Remove trailing slashes from urls
                $urls[] = rtrim($url, '/');
            } catch (NoSuchEntityException $e) {
                continue;
            }
        }
        $this->emulation->stopEnvironmentEmulation();
        return $urls;
    }
}
