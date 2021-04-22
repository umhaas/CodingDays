<?php

declare(strict_types=1);

namespace CodingDays\Dashboard\Shared\Service;

use OxidEsales\GraphQL\Base\Framework\PermissionProviderInterface;

final class PermissionProvider implements PermissionProviderInterface
{

    public function getPermissions(): array
    {
        return [
            'oxidadmin' => [
                'SEE_REPORTS',
            ],
        ];
    }
}
