<?php

/**
 * Copyright © __Vender__. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace CodingDays\Dashboard\Report\Service;

use \OxidEsales\GraphQL\Base\Exception\NotFound;
use CodingDays\Dashboard\Report\DataType\Report as ReportDataType;
use CodingDays\Dashboard\Report\Exception\ReportNotFound;
use CodingDays\Dashboard\Report\Infrastructure\ReportRepository;

final class Report
{
    /** @var ReportRepository */
    private $Repository;

    public function __construct(
        ReportRepository $Repository
    ) {
        $this->Repository = $Repository;
    }

    /**
     * @throws ReportNotFound
     */
    public function report(?string $date): ReportDataType
    {
        try {
            $report = $this->Repository->report($date);
        } catch (NotFound $e) {
            throw ReportNotFound::byId($date);
        }

        return $report;
    }
}
