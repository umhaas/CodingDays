<?php /** @noinspection PhpUnused */

declare(strict_types=1);

namespace CodingDays\Dashboard\Report\Controller;

use CodingDays\Dashboard\Report\DataType\Sales;
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
     * @Right("SEE_REPORTS")
     *
     * @param DateFilter $dateBetween
     * @param string $interval
     *
     * @return Sales[]
     * @throws Exception
     */
    public function reportCountByDateDiff(DateFilter $dateBetween, string $interval): array
    {
        return $this->service->getReportCountByDateDiff($dateBetween, $interval);
    }

    /**
     * @Query()
     * @Logged()
     * @Right("SEE_REPORTS")
     *
     * @param int $days
     *
     * @return int
     * @throws Exception
     */
    public function reportCountLastDays(int $days): int
    {
        return $this->service->reportCountLastDays($days);
    }

    /**
     * @Query()
     * @Logged()
     * @Right("SEE_REPORTS")
     *
     * @param DateFilter $dateBetween
     * @param int        $limit
     *
     * @return Report[]
     * @throws Exception
     */
    public function reportTopProductsByDateDiff(DateFilter $dateBetween, int $limit = 50): array
    {
        return $this->service->getReportTopProductsByDateDiff($dateBetween, $limit);
    }
}
