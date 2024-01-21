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

    /**
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig
    ) {
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
            ScopeInterface::SCOPE_STORE,
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
}
