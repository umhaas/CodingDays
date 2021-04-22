<?php

/**
 * Copyright © __Vender__. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace CodingDays\Dashboard\Report\Service;

use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use CodingDays\Dashboard\Report\DataType\Report as ReportDataType;

final class Report
{
    public function __construct()
    {
    }

    public function report(?string $date): ReportDataType
    {
        $qbfi = ContainerFactory::getInstance()
            ->getContainer()
            ->get(QueryBuilderFactoryInterface::class);

        return new ReportDataType($qbfi);
    }
}
