<?php
/**
 * Aligent Consulting
 * Copyright (c) Aligent Consulting (https://www.aligent.com.au)
 */

declare(strict_types=1);

namespace Aligent\Prerender\Api;

use Aligent\Prerender\Api\Data\PrerenderRecachingManagementRequestInterface;
use DOMException;

interface PrerenderRecachingManagementInterface
{

    /**
     * Recache Urls
     *
     * @param PrerenderRecachingManagementRequestInterface $prerenderRecachingManagementRequest
     * @return string
     */
    public function recacheUrls(PrerenderRecachingManagementRequestInterface $prerenderRecachingManagementRequest): string;
}
