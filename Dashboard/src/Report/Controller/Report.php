<?php

/**
 * Copyright © __Vender__. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace CodingDays\Dashboard\Report\Controller;


use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use TheCodingMachine\GraphQLite\Annotations\Query;
use CodingDays\Dashboard\Report\DataType\Report as ReportDataType;
use CodingDays\Dashboard\Report\Service\Report as ReportService;

final class Report
{
    /** @var ReportService */
    private $Service;

    public function __construct(
        ReportService $service
    ) {
        $this->Service = $service;
    }

    /**
     * @Query()
     */
    public function report(?string $date): ReportDataType
    {
        return $this->Service->report($date);
    }
}
