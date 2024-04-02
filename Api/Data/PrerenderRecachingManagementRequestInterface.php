<?php
/**
 * Aligent Consulting
 * Copyright (c) Aligent Consulting (https://www.aligent.com.au)
 */

declare(strict_types=1);

namespace Aligent\Prerender\Api\Data;

interface PrerenderRecachingManagementRequestInterface
{
    public const BATCH_URLS = "batch_urls";
    public const STORE_ID = "store_id";
    public const INDEXER_ID = "indexer_id";

    /**
     * Get Batch Urls
     *
     * @return string
     */
    public function getBatchUrls(): string;

    /**
     * Set Batch Urls
     *
     * @param string $batchUrls
     * @return void
     */
    public function setBatchUrls(string $batchUrls): void;

    /**
     * Get Store Id
     *
     * @return int
     */
    public function getStoreId(): int;

    /**
     * Set Store Id
     *
     * @param int $storeId
     * @return void
     */
    public function setStoreId(int $storeId): void;

    /**
     * Get Indexer Id
     *
     * @return string
     */
    public function getIndexerId(): string;

    /**
     * Set Indexer Id
     *
     * @param string $indexerId
     * @return void
     */
    public function setIndexerId(string $indexerId): void;
}
