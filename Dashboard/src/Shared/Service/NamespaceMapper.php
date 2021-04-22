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
            '\\CodingDays\\Dashboard\\Revenue\\Controller' => __DIR__ . '/../../Revenue/Controller/',
        ];
    }

    public function getTypeNamespaceMapping(): array
    {
        return [
            '\\CodingDays\\Dashboard\\Report\\DataType' => __DIR__ . '/../../Report/DataType/',
            '\\CodingDays\\Dashboard\\Revenue\\DataType' => __DIR__ . '/../../Revenue/DataType/',
        ];
    }
}
