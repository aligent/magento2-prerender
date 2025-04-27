<?php
/*
 * Copyright (c) Aligent Consulting. All rights reserved.
 */

declare(strict_types=1);

namespace Aligent\Prerender\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    private const XML_PATH_RECACHE_ENABLED = 'system/prerender/enabled';
    private const XML_PATH_PRERENDER_TOKEN = 'system/prerender/token';
    private const XML_PATH_RECACHE_SERVICE_URL = 'system/prerender/service_url';
    private const XML_PATH_PRERENDER_USE_PRODUCT_CANONICAL_URL = 'system/prerender/use_product_canonical_url';
    private const XML_PATH_RECACHE_PRODUCT_ENABLED = 'system/prerender/enable_product_indexing';
    private const XML_PATH_RECACHE_PRODUCT_CATEGORY_ENABLED = 'system/prerender/enable_product_category_indexing';
    private const XML_PATH_RECACHE_CATEGORY_ENABLED = 'system/prerender/enable_category_indexing';

    /** @var ScopeConfigInterface  */
    private ScopeConfigInterface $scopeConfig;

    /**
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Return if recaching functionality is enabled or not
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isRecacheEnabled(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_RECACHE_ENABLED,
            ScopeInterface::SCOPE_STORES,
            $storeId
        );
    }

    /**
     * Return configured Prerender service token for API calls
     *
     * @param int|null $storeId
     * @return string|null
     */
    public function getToken(?int $storeId = null): ?string
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_PRERENDER_TOKEN,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get prerender service url
     *
     * @param int|null $storeId
     * @return string|null
     */
    public function getPrerenderServiceUrl(?int $storeId = null): ?string
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_RECACHE_SERVICE_URL,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Return if product canonical url configuration is enabled or not
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isUseProductCanonicalUrlEnabled(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_PRERENDER_USE_PRODUCT_CANONICAL_URL,
            ScopeInterface::SCOPE_STORES,
            $storeId
        );
    }

    /**
     * Return if re-caching functionality is enabled for product only indexer
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isProductRecacheEnabled(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_RECACHE_PRODUCT_ENABLED,
            ScopeInterface::SCOPE_STORES,
            $storeId
        );
    }

    /**
     * Return if re-caching functionality is enabled for product-category mapping indexer
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isProductCategoryRecacheEnabled(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_RECACHE_PRODUCT_CATEGORY_ENABLED,
            ScopeInterface::SCOPE_STORES,
            $storeId
        );
    }

    /**
     * Return if re-caching functionality is enabled for category only indexer
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isCategoryRecacheEnabled(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_RECACHE_CATEGORY_ENABLED,
            ScopeInterface::SCOPE_STORES,
            $storeId
        );
    }
}
