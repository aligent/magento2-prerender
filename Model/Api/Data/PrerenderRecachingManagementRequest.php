<?php
/**
 * Aligent Consulting
 * Copyright (c) 2023 Aligent Consulting. (https://www.aligent.com.au)
 */

declare(strict_types=1);

namespace Aligent\Prerender\Model\Api\Data;

use Aligent\Prerender\Api\Data\PrerenderRecachingManagementRequestInterface;
use Magento\Framework\DataObject;

class PrerenderRecachingManagementRequest extends DataObject implements PrerenderRecachingManagementRequestInterface
{
    /**
     * @inheritDoc
     */
    public function getBatchUrls(): string
    {
        return $this->getData(self::BATCH_URLS);
    }

    /**
     * @inheritDoc
     */
    public function setBatchUrls(string $batchUrls): void
    {
        $this->setData(self::BATCH_URLS, $batchUrls);
    }

    /**
     * @inheritDoc
     */
    public function getStoreId(): int
    {
        return $this->getData(self::STORE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setStoreId(int $storeId): void
    {
        $this->setData(self::STORE_ID, $storeId);
    }

    /**
     * @inheritDoc
     */
    public function getIndexerId(): string
    {
        return $this->getData(self::INDEXER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setIndexerId(string $indexerId): void
    {
        $this->setData(self::INDEXER_ID, $indexerId);
    }
}
