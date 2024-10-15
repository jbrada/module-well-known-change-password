<?php

declare(strict_types=1);

namespace JBrada\WellKnownChangePassword\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Url
{
    public const CONFIG_KEY_PATH = 'jbrada/well-known-change-password/path';

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig
    ) {
    }

    /**
     * Retrieves the configured path for the change password feature based on scope.
     *
     * @param string $scopeType
     * @param string|null $scopeCode
     * @return string|null
     */
    public function getPath(
        string  $scopeType = ScopeInterface::SCOPE_WEBSITE,
        ?string $scopeCode = null
    ): ?string {
        $value = $this->scopeConfig->getValue(self::CONFIG_KEY_PATH, $scopeType, $scopeCode);

        if ($value === null || $value === '' || is_scalar($value) === false) {
            return null;
        }

        return (string)$value;
    }
}
