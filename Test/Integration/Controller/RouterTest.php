<?php

declare(strict_types=1);

namespace JBrada\WellKnownChangePassword\Test\Integration\Controller;

use JBrada\WellKnownChangePassword\Config\Url;
use JBrada\WellKnownChangePassword\Controller\Router;
use Laminas\Http\Header\HeaderInterface;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\App\Response\Http as HttpResponse;
use Magento\TestFramework\Fixture\Config;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    protected function setUp(): void
    {
        $this->objectManager = Bootstrap::getObjectManager();
        $this->router = $this->objectManager->create(Router::class);
    }

    #[Config(Url::CONFIG_KEY_PATH, 'customer/account/edit/changepass/1')]
    public function testWellKnownChangePasswordRouteRedirects(): void
    {
        /** @var HttpRequest $request */
        $request =$this->objectManager->create(HttpRequest::class);
        $request->setPathInfo('/.well-known/change-password');

        $action = $this->router->match($request);

        $this->assertInstanceOf(\Magento\Framework\App\Action\Redirect::class, $action);

        /** @var HttpResponse $response */
        $response = $this->objectManager->get(HttpResponse::class);

        $this->assertTrue($response->isRedirect());

        $headerLocation = $response->getHeader('Location');
        $this->assertInstanceOf(HeaderInterface::class, $headerLocation);

        $this->assertStringContainsString(
            'customer/account/edit/changepass/1',
            $headerLocation->getFieldValue()
        );
    }
}
