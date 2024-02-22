<?php

declare(strict_types=1);

namespace Aligent\Prerender\Test\Unit\Helper;

use Aligent\Prerender\Helper\Config;
use Magento\Framework\App\Config\ScopeConfigInterface;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    /**
     * Helper
     *
     * @var Config
     */
    private Config $helper;

    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfigMock;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->scopeConfigMock = $this->getMockForAbstractClass(ScopeConfigInterface::class);
        $this->helper = new Config($this->scopeConfigMock);
    }

    /**
     * Test isRecacheEnabled()
     */
    public function testIsRecacheEnabled(): void
    {
        $this->scopeConfigMock->expects($this->any())
            ->method('isSetFlag')
            ->willReturn(true);

        $this->assertIsBool($this->helper->isRecacheEnabled());
    }

    /**
     * Test if is not recache Enabled
     */
    public function testIsNotRecacheEnabled(): void
    {
        $this->scopeConfigMock->expects($this->any())
            ->method('isSetFlag')
            ->willReturn(false);

        $this->assertIsBool($this->helper->isRecacheEnabled());
    }

    /**
     * Test getToken()
     */
    public function testGetToken(): void
    {
        $this->scopeConfigMock->expects($this->any())
            ->method('getValue')
            ->with(Config::XML_PATH_PRERENDER_TOKEN)
            ->willReturn('Pi7g7R7pNtDfgsDy1');

        $this->assertIsString($this->helper->getToken());
    }

    /**
     * Test getPrerenderServiceUrl()
     */
    public function testGetPrerenderServiceUrl(): void
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('getValue')
            ->with(Config::XML_PATH_RECACHE_SERVICE_URL)
            ->willReturn('https://api.prerender.io/recache');

        $this->assertIsString($this->helper->getPrerenderServiceUrl());
    }
}
