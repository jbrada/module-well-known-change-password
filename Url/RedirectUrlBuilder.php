<?php

declare(strict_types=1);

namespace JBrada\WellKnownChangePassword\Url;

use JBrada\WellKnownChangePassword\Config\Url;
use JBrada\WellKnownChangePassword\Exception\ConfigException;
use Magento\Framework\UrlInterface;

class RedirectUrlBuilder
{
    /**
     * @param Url $urlConfig
     * @param UrlInterface $url
     */
    public function __construct(
        private readonly Url $urlConfig,
        private readonly UrlInterface $url
    ) {
    }

    /**
     * Provides URL for customer change password action
     *
     * @return string
     * @throws ConfigException
     */
    public function build(): string
    {
        if ($this->urlConfig->getPath() === null) {
            throw new ConfigException(__('Path for customer change password page is not set.'));
        }

        return $this->url->getUrl($this->urlConfig->getPath());
    }
}
