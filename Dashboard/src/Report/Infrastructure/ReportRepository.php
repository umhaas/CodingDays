<?php

/**
 * Copyright © __Vender__. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace CodingDays\Dashboard\Report\Infrastructure;

use OxidEsales\Eshop\Core\DatabaseProvider;
use CodingDays\Dashboard\Report\DataType\Report as ReportDataType;

final class ReportRepository
{
    public function report(string $id): ReportDataType
    {
        return new ReportDataType(
            $this->getC
        );
    }
}
