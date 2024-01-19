<?php
/**
 * Aligent Consulting
 * Copyright (c) 2023 Aligent Consulting. (https://www.aligent.com.au)
 */

declare(strict_types=1);

namespace Aligent\Prerender\Model\Api;

use Magento\Framework\Exception\BulkException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Aligent\Prerender\Api\PrerenderRecachingManagementInterface;
use Aligent\Prerender\Api\Data\PrerenderRecachingManagementRequestInterface;
use Aligent\Prerender\Api\PrerenderClientInterface;
use Magento\Sales\Model\Order;
use Exception;
use DOMDocument;
use DOMException;
use Magento\Store\Model\App\Emulation;
use Magento\Framework\Escaper;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Directory\Model\CountryFactory;
use Magento\Framework\Exception\CouldNotSaveException;

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
