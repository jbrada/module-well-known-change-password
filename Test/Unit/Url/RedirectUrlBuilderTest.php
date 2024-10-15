<?php

declare(strict_types=1);

namespace JBrada\WellKnownChangePassword\Test\Unit\Url;

use JBrada\WellKnownChangePassword\Config\Url;
use JBrada\WellKnownChangePassword\Exception\GeneralException;
use JBrada\WellKnownChangePassword\Url\RedirectUrlBuilder;
use Magento\Framework\UrlInterface;
use PHPUnit\Framework\TestCase;

class RedirectUrlBuilderTest extends TestCase
{
    /**
     * @var Url&\PHPUnit\Framework\MockObject\MockObject
     */
    private $urlConfigMock;

    /**
     * @var UrlInterface&\PHPUnit\Framework\MockObject\MockObject
     */
    private $urlMock;

    /**
     * @var RedirectUrlBuilder
     */
    private $redirectUrlBuilder;

    protected function setUp(): void
    {
        $this->urlConfigMock = $this->createMock(Url::class);
        $this->urlMock = $this->createMock(UrlInterface::class);

        $this->redirectUrlBuilder = new RedirectUrlBuilder(
            $this->urlConfigMock,
            $this->urlMock
        );
    }

    public function testBuildReturnsRedirectUrl(): void
    {
        $path = 'customer/account/pass-change';
        $this->urlConfigMock->method('getPath')
            ->willReturn($path);

        $expectedUrl = 'https://example.com/customer/account/pass-change';
        $this->urlMock->method('getUrl')
            ->with($path)
            ->willReturn($expectedUrl);

        $this->assertEquals($expectedUrl, $this->redirectUrlBuilder->build());
    }

    public function testBuildThrowsGeneralExceptionWhenPathIsNull(): void
    {
        $this->urlConfigMock->method('getPath')
            ->willReturn(null);

        $this->expectException(GeneralException::class);
        $this->expectExceptionMessage('Path for customer change password page is not set.');

        $this->redirectUrlBuilder->build();
    }
}
