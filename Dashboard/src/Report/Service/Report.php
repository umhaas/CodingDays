<?php

declare(strict_types=1);

namespace CodingDays\Dashboard\Report\Service;

use CodingDays\Dashboard\Report\Infrastructure\ReportRepository;
use Doctrine\DBAL\Exception;
use OxidEsales\GraphQL\Base\DataType\DateFilter;

final class Report
{
    private ReportRepository $reportRepository;

    /**
     * Report constructor.
     *
     * @param ReportRepository $reportRepository
     */
    public function __construct(
        ReportRepository $reportRepository
    ) {
        $this->reportRepository = $reportRepository;
    }

    /**
     * @param DateFilter $dateBetween
     * @param string $interval
     *
     * @return array
     * @throws Exception
     */
    public function getReportCountByDateDiff(DateFilter $dateBetween, string $interval): array
    {
        return $this->reportRepository->getReportCountByDateDiff($dateBetween, $interval);
    }

    /**
     * @param int $days
     *
     * @return int
     * @throws Exception
     */
    public function reportCountLastDays(int $days): int
    {
        return $this->reportRepository->reportCountLastDays($days);
    }
}
