<?php

/**
 * Copyright © __Vender__. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace CodingDays\Dashboard\Shared\Service;

use OxidEsales\GraphQL\Base\Framework\NamespaceMapperInterface;

final class NamespaceMapper implements NamespaceMapperInterface
{
    public function getControllerNamespaceMapping(): array
    {
        return [
            '\\CodingDays\\Dashboard\\Report\\Controller' => __DIR__ . '/../../Report/Controller/',
        ];
    }

    public function getTypeNamespaceMapping(): array
    {
        return [
            '\\CodingDays\\Dashboard\\Report\\DataType' => __DIR__ . '/../../Report/DataType/',
        ];
    }
}
