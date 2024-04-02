<?php
/**
 * Aligent Consulting
 * Copyright (c) Aligent Consulting (https://www.aligent.com.au)
 */

declare(strict_types=1);

namespace Aligent\Prerender\Model\Api;

use Magento\Framework\Serialize\Serializer\Json;
use Aligent\Prerender\Api\PrerenderRecachingManagementInterface;
use Aligent\Prerender\Api\Data\PrerenderRecachingManagementRequestInterface;
use Aligent\Prerender\Api\PrerenderClientInterface;
use Exception;

class PrerenderRecachingManagement implements PrerenderRecachingManagementInterface
{

    /**
     * @param PrerenderClientInterface $prerenderClient
     * @param Json $json
     */
    public function __construct(
        private readonly PrerenderClientInterface $prerenderClient,
        private readonly Json $json,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function recacheUrls(
        PrerenderRecachingManagementRequestInterface $prerenderRecachingManagementRequest
    ): string {
        $message = "";
        try {
            $this->prerenderClient->recacheUrls(
                $this->json->unserialize($prerenderRecachingManagementRequest->getBatchUrls()),
                $prerenderRecachingManagementRequest->getStoreId()
            );
            $message = 'INFO: Recaching Urls successfully synced for ' .
                $prerenderRecachingManagementRequest->getIndexerId();
        } catch (Exception $exception) {
            $message = 'ERROR: There was an error syncing the Recaching Urls for ' .
                $prerenderRecachingManagementRequest->getIndexerId() . $exception->getMessage();
        }
        return $message;
    }
}
