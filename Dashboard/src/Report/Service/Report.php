<?php

declare(strict_types=1);

namespace CodingDays\Dashboard\Report\Service;

use CodingDays\Dashboard\Report\Infrastructure\ReportRepository;
use Doctrine\DBAL\Exception;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use CodingDays\Dashboard\Report\DataType\Report as ReportDataType;
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

    public function report(?string $date): ReportDataType
    {
        $qbfi = ContainerFactory::getInstance()
            ->getContainer()
            ->get(QueryBuilderFactoryInterface::class)
        ;

        return new ReportDataType($qbfi);
    }

    /**
     * @param DateFilter $dateBetween
     *
     * @return int
     * @throws Exception
     */
    public function getReportCountByDateDiff(DateFilter $dateBetween): int
    {
        return $this->reportRepository->getReportCountByDateDiff($dateBetween);
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

    /**
     * @param DateFilter $dateBetween
     * @param int        $limit
     *
     * @return array
     * @throws Exception
     */
    public function getReportTopProductsByDateDiff(DateFilter $dateBetween, int $limit): array
    {
        return $this->reportRepository->getReportTopProductsByDateDiff($dateBetween, $limit);
    }
}
