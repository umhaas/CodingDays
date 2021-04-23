<?php

declare(strict_types=1);

namespace CodingDays\Dashboard\Report\Infrastructure;

use CodingDays\Dashboard\Report\DataType\Sales;
use Doctrine\DBAL\Exception;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\GraphQL\Base\DataType\DateFilter;

final class ReportRepository
{
    const INTVAL_DAY = 'day';
    const INTVAL_WEEK = 'week';
    const INTVAL_MONTH = 'month';
    const INTVAL_YEAR = 'year';
    const INTVAL_QUARTER = 'quarter';

    /**
     * @var QueryBuilderFactoryInterface
     */
    private QueryBuilderFactoryInterface $queryBuilderFactory;

    public function __construct(
        QueryBuilderFactoryInterface $queryBuilderFactory
    ) {
        $this->queryBuilderFactory = $queryBuilderFactory;
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
        $queryBuilder = $this->queryBuilderFactory->create();
        $queryBuilder
            ->select('COUNT(*) as orderCount')
            ->from('oxorder')
        ;

        switch (strtolower($interval)) {
            case self::INTVAL_DAY:
                $queryBuilder
                    ->addSelect('DATE(oxorderdate) as date')
                    ->groupBy('DATE(OXORDERDATE)')
                ;
                break;
            case self::INTVAL_WEEK:
                $queryBuilder
                    ->addSelect('CONCAT(WEEK(oxorderdate), " " ,YEAR(oxorderdate)) as date')
                    ->groupBy('WEEK(OXORDERDATE)')
                ;
                break;
            case self::INTVAL_MONTH:
                $queryBuilder
                    ->addSelect('CONCAT(MONTH(oxorderdate), " " ,YEAR(oxorderdate)) as date')
                    ->groupBy('MONTH(OXORDERDATE)')
                ;
                break;
            case self::INTVAL_YEAR:
                $queryBuilder
                    ->addSelect('YEAR(oxorderdate) as date')
                    ->groupBy('YEAR(OXORDERDATE)')
                ;
                break;
            case self::INTVAL_QUARTER:
                $queryBuilder
                    ->addSelect('CONCAT(QUARTER(oxorderdate), " " ,YEAR(oxorderdate)) as date')
                    ->groupBy('QUARTER(OXORDERDATE)')
                ;
                break;
        }

        $dateBetween->addToQuery($queryBuilder, 'oxorderdate');

        $sales = [];
        $result = $queryBuilder->execute()->fetchAllAssociative();
        foreach ($result as $row) {
            $sales[] = new Sales(
                $row['date'],
                $interval,
                (int)$row['orderCount']
            );
        }

        return $sales;
    }

    /**
     * @param int $days
     *
     * @return int
     * @throws Exception
     */
    public function reportCountLastDays(int $days): int
    {
        $queryBuilder = $this->queryBuilderFactory->create();
        $queryBuilder
            ->select('COUNT(*)')
            ->from('oxorder')
            ->where('oxorderdate >= DATE(NOW()) - INTERVAL :days DAY')
            ->setParameter('days', $days)
        ;

        return (int)$queryBuilder->execute()->fetchOne();
    }
}
