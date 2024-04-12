<?php
/*
 * Copyright (c) Aligent Consulting. All rights reserved.
 */

declare(strict_types=1);
namespace Aligent\Prerender\Api;

interface PrerenderClientInterface
{
    /**
     * Call Prerender service API to recache list of URLs
     *
     * @param array $urls
     * @param int $storeId
     * @return void
     */
    public function recacheUrls(array $urls, int $storeId): void;
}
