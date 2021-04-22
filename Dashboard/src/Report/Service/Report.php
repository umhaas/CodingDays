<?php

declare(strict_types=1);

namespace CodingDays\Dashboard\Report\Service;

use CodingDays\Dashboard\Report\Infrastructure\ReportRepository;
use Doctrine\DBAL\Exception;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use CodingDays\Dashboard\Report\DataType\Report as ReportDataType;
use CodingDays\Dashboard\Report\Exception\ReportNotFound;
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
     * @throws ReportNotFound
     */
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
}
