<?php

declare(strict_types=1);

namespace CodingDays\Dashboard\Report\Controller;

use Doctrine\DBAL\Exception;
use OxidEsales\GraphQL\Base\DataType\DateFilter;
use TheCodingMachine\GraphQLite\Annotations\Logged;
use TheCodingMachine\GraphQLite\Annotations\Query;
use CodingDays\Dashboard\Report\Service\Report as ReportService;
use TheCodingMachine\GraphQLite\Annotations\Right;

final class Report
{
    /** @var ReportService */
    private ReportService $service;

    /**
     * Report constructor.
     *
     * @param ReportService $service
     */
    public function __construct(
        ReportService $service
    ) {
        $this->service = $service;
    }

    /**
     * @Query()
     * @Logged()
     *
     * @param DateFilter $dateBetween
     *
     * @return int
     * @throws Exception
     */
    public function reportCountByDateDiff(DateFilter $dateBetween): int
    {
        return $this->service->getReportCountByDateDiff($dateBetween);
    }
}
