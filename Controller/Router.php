<?php

declare(strict_types=1);

namespace JBrada\WellKnownChangePassword\Controller;

use JBrada\WellKnownChangePassword\Exception\ConfigException;
use JBrada\WellKnownChangePassword\Url\CustomerLoginUrlBuilder;
use Magento\Framework\App\Action\Redirect;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Response\Http as HttpResponse;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RouterInterface;
use Psr\Log\LoggerInterface;

class Router implements RouterInterface
{
    private const ROUTE_NAME = '.well-known/change-password';

    /**
     * @param ActionFactory $actionFactory
     * @param ResponseInterface&HttpResponse $response
     * @param CustomerLoginUrlBuilder $customerLoginUrlBuilder
     * @param LoggerInterface $logger
     * @param string $routeName
     */
    public function __construct(
        private readonly ActionFactory           $actionFactory,
        private readonly ResponseInterface       $response,
        private readonly CustomerLoginUrlBuilder $customerLoginUrlBuilder,
        private readonly LoggerInterface         $logger,
        private readonly string                  $routeName = self::ROUTE_NAME
    ) {
    }

    /**
     * Matches the request path with a specific route and redirects to the customer login URL if matched.
     *
     * @param RequestInterface&HttpRequest $request
     * @return ActionInterface|null
     */
    public function match(RequestInterface $request)
    {
        $identifier = trim((string)$request->getPathInfo(), '/');

        if ($identifier !== $this->routeName) {
            return null;
        }

        try {
            $customerLoginUrl = $this->customerLoginUrlBuilder->build();
        } catch (ConfigException $e) {
            $this->logger->error($e->getMessage());

            return null;
        }

        $this->response->setRedirect($customerLoginUrl);

        return $this->actionFactory->create(Redirect::class);
    }
}
