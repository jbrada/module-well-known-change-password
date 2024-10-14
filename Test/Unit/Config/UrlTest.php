<?php

declare(strict_types=1);

namespace JBrada\WellKnownChangePassword\Test\Unit\Config;

use JBrada\WellKnownChangePassword\Config\Url;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    /**
     * @var ScopeConfigInterface&\PHPUnit\Framework\MockObject\MockObject
     */
    private $scopeConfigMock;

    /**
     * @var Url
     */
    private $url;

    protected function setUp(): void
    {
        $this->scopeConfigMock = $this->createMock(ScopeConfigInterface::class);

        $this->url = new Url($this->scopeConfigMock);
    }

    public function testGetPathReturnsNullWhenConfigIsEmpty(): void
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('getValue')
            ->with(Url::CONFIG_KEY_PATH, ScopeInterface::SCOPE_WEBSITE, null)
            ->willReturn(null);

        $this->assertNull($this->url->getPath());
    }

    public function testGetPathReturnsConfigValue(): void
    {
        $pathValue = 'change-password-url';

        $this->scopeConfigMock->expects($this->once())
            ->method('getValue')
            ->with(Url::CONFIG_KEY_PATH, ScopeInterface::SCOPE_WEBSITE, null)
            ->willReturn($pathValue);

        $this->assertEquals($pathValue, $this->url->getPath());
    }

    public function testGetPathReturnsNullWhenConfigValueIsEmptyString(): void
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('getValue')
            ->with(Url::CONFIG_KEY_PATH, ScopeInterface::SCOPE_WEBSITE, null)
            ->willReturn('');

        $this->assertNull($this->url->getPath());
    }

    public function testGetPathUsesProvidedScopeCode(): void
    {
        $scopeCode = 'specific_store';
        $pathValue = 'change-password-url';

        $this->scopeConfigMock->expects($this->once())
            ->method('getValue')
            ->with(Url::CONFIG_KEY_PATH, ScopeInterface::SCOPE_WEBSITE, $scopeCode)
            ->willReturn($pathValue);

        $this->assertEquals($pathValue, $this->url->getPath(ScopeInterface::SCOPE_WEBSITE, $scopeCode));
    }
}
