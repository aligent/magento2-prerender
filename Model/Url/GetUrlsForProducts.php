<?php
/*
 * Copyright (c) Aligent Consulting. All rights reserved.
 */

declare(strict_types=1);

namespace Aligent\Prerender\Model\Url;

use Aligent\Prerender\Helper\Config;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\App\Emulation;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Magento\UrlRewrite\Controller\Adminhtml\Url\Rewrite;
use Magento\UrlRewrite\Model\UrlFinderInterface;
use Magento\UrlRewrite\Service\V1\Data\UrlRewrite;

class GetUrlsForProducts
{
    private const DELIMETER = "?";

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Emulation
     */
    private $emulation;

    /**
     * @var UrlFinderInterface
     */
    private $urlFinder;

    /**
     * @var Config
     */
    private $prerenderConfigHelper;

    /**
     * @param StoreManagerInterface $storeManager
     * @param Emulation $emulation
     * @param UrlFinderInterface $urlFinder
     * @param Config $prerenderConfigHelper
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        Emulation $emulation,
        UrlFinderInterface $urlFinder,
        Config $prerenderConfigHelper
    ) {
        $this->storeManager = $storeManager;
        $this->emulation = $emulation;
        $this->urlFinder = $urlFinder;
        $this->prerenderConfigHelper = $prerenderConfigHelper;
    }

    /**
     * Generate product URLs based on URL_REWRITE entries
     *
     * @param array $productIds
     * @param int $storeId
     * @return array
     */
    public function execute(array $productIds, int $storeId): array
    {
        try {
            /** @var Store $store */
            $store = $this->storeManager->getStore($storeId);
        } catch (NoSuchEntityException $e) {
            return [];
        }

        $useProductCanonical = $this->prerenderConfigHelper->isUseProductCanonicalUrlEnabled($storeId);

        $findByData = [
            UrlRewrite::ENTITY_TYPE => Rewrite::ENTITY_TYPE_PRODUCT,
            UrlRewrite::STORE_ID => $storeId,
            UrlRewrite::ENTITY_ID =>  $productIds
        ];

        $urlRewrites = $this->urlFinder->findAllByData($findByData);
        $this->emulation->startEnvironmentEmulation($storeId);
        $urls = [];
        /** @var Product $product */
        foreach ($urlRewrites as $urlRewrite) {
            if (empty($urlRewrite->getRequestPath())) {
                continue;
            }
            // Ignore the product URL with category path.
            if ($useProductCanonical && $urlRewrite->getMetadata()) {
                continue;
            }

            try {
                // Retrieve URL using store configuration
                $url = $store->getUrl('', ['_direct' => $urlRewrite->getRequestPath()]);

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
