<?php

declare(strict_types=1);

namespace JBrada\WellKnownChangePassword\Test\Unit\Url;

use JBrada\WellKnownChangePassword\Config\Url;
use JBrada\WellKnownChangePassword\Exception\GeneralException;
use JBrada\WellKnownChangePassword\Url\CustomerLoginUrlBuilder;
use Magento\Framework\UrlInterface;
use PHPUnit\Framework\TestCase;

class CustomerLoginUrlBuilderTest extends TestCase
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
     * @var CustomerLoginUrlBuilder
     */
    private $customerLoginUrlBuilder;

    protected function setUp(): void
    {
        $this->urlConfigMock = $this->createMock(Url::class);
        $this->urlMock = $this->createMock(UrlInterface::class);

        $this->customerLoginUrlBuilder = new CustomerLoginUrlBuilder(
            $this->urlConfigMock,
            $this->urlMock
        );
    }

    public function testBuildReturnsCustomerLoginUrl(): void
    {
        $path = 'customer/account/login';
        $this->urlConfigMock->method('getPath')
            ->willReturn($path);

        $expectedUrl = 'https://example.com/customer/account/login';
        $this->urlMock->method('getUrl')
            ->with($path)
            ->willReturn($expectedUrl);

        $this->assertEquals($expectedUrl, $this->customerLoginUrlBuilder->build());
    }

    public function testBuildThrowsGeneralExceptionWhenPathIsNull(): void
    {
        $this->urlConfigMock->method('getPath')
            ->willReturn(null);

        $this->expectException(GeneralException::class);
        $this->expectExceptionMessage('Path for customer change password is not set.');

        $this->customerLoginUrlBuilder->build();
    }
}
