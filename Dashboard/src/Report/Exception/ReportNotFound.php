<?php

/**
 * Copyright © __Vender__. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace CodingDays\Dashboard\Report\Exception;

use OxidEsales\GraphQL\Base\Exception\NotFound;

use function sprintf;

final class ReportNotFound extends NotFound
{
    public static function byId(string $date): self
    {
        return new self(sprintf('no data was not found for date: %s', $date));
    }
}
