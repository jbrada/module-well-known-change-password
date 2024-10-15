<?php

declare(strict_types=1);

namespace JBrada\WellKnownChangePassword\Test\Unit\Controller;

use JBrada\WellKnownChangePassword\Controller\Router;
use JBrada\WellKnownChangePassword\Exception\ConfigException;
use JBrada\WellKnownChangePassword\Url\RedirectUrlBuilder;
use Magento\Framework\App\Action\Redirect;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\App\Response\Http as HttpResponse;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class RouterTest extends TestCase
{
    /**
     * @var ActionFactory&\PHPUnit\Framework\MockObject\MockObject
     */
    private $actionFactoryMock;

    /**
     * @var HttpResponse&\PHPUnit\Framework\MockObject\MockObject
     */
    private $responseMock;

    /**
     * @var RedirectUrlBuilder&\PHPUnit\Framework\MockObject\MockObject
     */
    private $redirectUrlBuilderMock;

    /**
     * @var LoggerInterface&\PHPUnit\Framework\MockObject\MockObject
     */
    private $loggerMock;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var HttpRequest&\PHPUnit\Framework\MockObject\MockObject
     */
    private $requestMock;

    protected function setUp(): void
    {
        $this->actionFactoryMock = $this->createMock(ActionFactory::class);
        $this->responseMock = $this->createMock(HttpResponse::class);
        $this->redirectUrlBuilderMock = $this->createMock(RedirectUrlBuilder::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);
        $this->requestMock = $this->createMock(HttpRequest::class);

        $this->router = new Router(
            $this->actionFactoryMock,
            $this->responseMock,
            $this->redirectUrlBuilderMock,
            $this->loggerMock
        );
    }

    public function testMatchReturnsRedirectActionWhenRouteMatches(): void
    {
        $this->requestMock->method('getPathInfo')
            ->willReturn('/.well-known/change-password');

        $redirectUrl = 'https://example.com/customer/account/change-password';
        $this->redirectUrlBuilderMock->method('build')
            ->willReturn($redirectUrl);

        $this->responseMock->expects($this->once())
            ->method('setRedirect')
            ->with($redirectUrl);

        $redirectActionMock = $this->createMock(ActionInterface::class);
        $this->actionFactoryMock->method('create')
            ->with(Redirect::class)
            ->willReturn($redirectActionMock);

        $result = $this->router->match($this->requestMock);

        $this->assertSame($redirectActionMock, $result);
    }

    public function testMatchLogsErrorWhenExceptionThrown(): void
    {
        $this->requestMock->method('getPathInfo')
            ->willReturn('/.well-known/change-password');

        $exceptionMessage = __('Error building password change URL');
        $this->redirectUrlBuilderMock->method('build')
            ->willThrowException(new ConfigException($exceptionMessage));

        $this->loggerMock->expects($this->once())
            ->method('error')
            ->with($exceptionMessage);

        $result = $this->router->match($this->requestMock);
        $this->assertNull($result);
    }

    public function testMatchReturnsNullWhenRouteDoesNotMatch(): void
    {
        $this->requestMock->method('getPathInfo')
            ->willReturn('/some/other/path');

        $result = $this->router->match($this->requestMock);

        $this->assertNull($result);
    }
}
