<?php
/**
 * Aligent Consulting
 * Copyright (c) Aligent Consulting (https://www.aligent.com.au)
 */

declare(strict_types=1);

namespace Aligent\Prerender\Test\Unit\Api;

use Aligent\Prerender\Model\Api\PrerenderClient;
use Aligent\Prerender\Helper\Config;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\HTTP\ClientInterface;
use Magento\Framework\Serialize\SerializerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class PrerenderClientTest extends TestCase
{
    /**
     * @var PrerenderClient
     */
    private PrerenderClient $prerenderClient;

    private $prerenderConfigHelperMock;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->scopeConfigMock = $this->getMockForAbstractClass(ScopeConfigInterface::class);
        $this->prerenderConfigHelperMock = $this->getMockBuilder(Config::class)
            ->setMethods(['isRecacheEnabled','getToken','getPrerenderServiceUrl'])
            ->disableOriginalConstructor()
            ->getMock();

        $clientMock = $this->getMockForAbstractClass(ClientInterface::class);
        $clientMock->expects($this->any())
            ->method('post')
            ->willReturnSelf();

        $jsonSerializerMock = $this->getMockForAbstractClass(SerializerInterface::class);
        $jsonSerializerMock->expects($this->any())
            ->method('serialize')
            ->willReturn(
                '{"prerenderToken":"Pi7g7R7pNtDfgsDy1","urls":["abc.html","cde.html"]}'
            );

        $loggerMock = $this->getMockForAbstractClass(LoggerInterface::class);
        $this->prerenderClient = new PrerenderClient(
            $this->prerenderConfigHelperMock,
            $clientMock,
            $jsonSerializerMock,
            $loggerMock
        );
    }

    /**
     * test for recacheUrls method
     *
     * @return void
     */
    public function testRecacheUrls(): void
    {
        $this->prerenderConfigHelperMock->expects($this->any())
            ->method('isRecacheEnabled')
            ->willReturn(true);

        $this->prerenderConfigHelperMock->expects($this->any())
            ->method('getToken')
            ->willReturn('Pi7g7R7pNtDfgsDy1');

        $this->prerenderConfigHelperMock->expects($this->any())
            ->method('getPrerenderServiceUrl')
            ->willReturn('https://api.prerender.io/recache');

        $this->prerenderClient->recacheUrls(
            [
                'abc.html',
                'cde.html',
            ],
            1
        );
    }

    /**
     * test empty token
     *
     * @return void
     */
    public function testEmptyToken(): void
    {
        $this->prerenderConfigHelperMock->expects($this->any())
            ->method('isRecacheEnabled')
            ->willReturn(true);
        $this->prerenderConfigHelperMock->expects($this->any())
            ->method('getToken')
            ->willReturn('');

        $this->prerenderClient->recacheUrls(
            [
                'abc.html',
                'cde.html',
            ],
            1
        );
    }

    /**
     * test empty PrerenderServiceUrl
     *
     * @return void
     */
    public function testEmptyPrerenderServiceUrl(): void
    {
        $this->prerenderConfigHelperMock->expects($this->any())
            ->method('isRecacheEnabled')
            ->willReturn(true);
        $this->prerenderConfigHelperMock->expects($this->any())
            ->method('getToken')
            ->willReturn('Pi7g7R7pNtDfgsDy1');

        $this->prerenderConfigHelperMock->expects($this->any())
            ->method('getPrerenderServiceUrl')
            ->willReturn('');

        $this->prerenderClient->recacheUrls(
            [
                'abc.html',
                'cde.html',
            ],
            1
        );
    }
}
